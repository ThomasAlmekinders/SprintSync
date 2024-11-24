<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Testing\MimeType;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

use App\Models\User;
use App\Models\Address;
use App\Models\ActivityLog;
use App\Models\UserVisibilitySettings;

class AccountController extends Controller
{
    public function updateProfileUser(Request $request)
    {
        $validatedData = $request->validate([
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'username')->ignore(auth()->id()),
            ],
            'profile_bio' => 'nullable|string|max:500',
        ]);

        \Log::info('Validation passed', $validatedData);

        $user = auth()->user();
        $user->username = $validatedData['username'];
        $user->profile_bio = $request->input('profile_bio');
        $user->save();

        return redirect()->back()->with('success', 'Uw profiel is succesvol bijgewerkt.');
    }


    public function updateProfilePicture(Request $request)
    {
        $allowedExtensions = ['jpeg', 'png', 'jpg', 'gif', 'svg', 'webp'];

        $request->validate([
            'profile_picture' => 'required|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $extension = $request->file('profile_picture')->getClientOriginalExtension();
        if (!in_array(strtolower($extension), $allowedExtensions)) {
            return back()->withErrors(['profile_picture' => 'Het bestandstype wordt niet ondersteund.']);
        }

        $user = Auth::user();

        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture && basename($user->profile_picture) !== 'default_profile.svg') {
                $oldFilePath = public_path('images/profile_pictures/' . $user->profile_picture);
                if (File::exists($oldFilePath)) {
                    File::delete($oldFilePath);
                }
            }

            $image = $request->file('profile_picture');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/profile_pictures'), $filename);

            $user->profile_picture = $filename;
            $user->save();

            $this->logActivity($user, "Profiel foto", "Jouw profielfoto is succesvol aangepast.");

            return redirect()->back()->with('success', 'Uw profielfoto is succesvol bijgewerkt.');
        }

        return redirect()->back()->withErrors(['profile_picture' => 'Er is geen afbeelding geüpload.']);
    }


    public function updatePersonalData(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'phone_number' => 'nullable|string|max:15|unique:users,phone_number,' . Auth::id(),
            'street' => 'nullable|string|max:255',
            'house_number' => 'nullable|string|max:10',
            'city' => 'nullable|string|max:255',
            'postcode' => 'nullable|string|max:10',
            'country' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();

        $user->update($request->only(['first_name', 'last_name', 'email', 'phone_number']));

        $address = $user->address; 

        if ($address) {
            $address->update($request->only(['street', 'house_number', 'city', 'postcode', 'country']));
        } else {
            $address = new Address();
            $address->fill($request->only(['street', 'house_number', 'city', 'postcode', 'country']));
            $address->user_id = $user->id;
            $address->save();
        }

        \Log::info('Address data:', $address->toArray());

        return redirect()->route('mijn-account.persoonlijke-gegevens')->with('success', 'Persoonlijke gegevens zijn succesvol bijgewerkt!');
    }


    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[\W_]/',
            ],
        ], [
            'new_password.min' => 'Het nieuwe wachtwoord moet minimaal 8 tekens bevatten.',
            'new_password.regex' => 'Het nieuwe wachtwoord moet een hoofdletter, een cijfer en een speciaal teken bevatten.',
            'new_password.confirmed' => 'De bevestiging van het nieuwe wachtwoord komt niet overeen.',
        ]);

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Het huidige wachtwoord is onjuist.']);
        }

        Auth::user()->update([
            'password' => Hash::make($request->new_password),
        ]);

        $this->logActivity($user, "Wachtwoord aangepast", "Het wachtwoord is succesvol aangepast naar iets nieuws.");

        return back()->with('success', 'Wachtwoord is succesvol gewijzigd!');
    }

    public function updateVisibility(Request $request)
    {
        $request->validate([
            'show_email' => 'boolean',
            'show_phone' => 'boolean',
            'show_address' => 'boolean',
        ]);
    
        $user = auth()->user();
    
        $visibilitySettings = $user->visibilitySettings ?? new VisibilitySettings();
        $visibilitySettings->update($request->only([
            'show_email',
            'show_phone',
            'show_address',
        ]));
        
        $this->logActivity($user, "Zichtbaarheids instellingen", "De zichtbaarheidsinstellingen zijn bijgewerkt.");

        return back()->with('success', 'Instellingen succesvol bijgewerkt!');
    }    

    private function logActivity($user, $name, $beschrijving)
    {
        ActivityLog::create([
            'user_id' => $user->id,
            'log_name' => $name,
            'log_description' => $beschrijving,
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
            'created_at' => now(),
        ]);
    }
}
