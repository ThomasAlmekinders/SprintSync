<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

use App\Models\User;
use App\Models\Address;

class AccountController extends Controller
{
    public function updateProfileUser(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . auth()->id(),
            'profile_bio' => 'nullable|string|max:500',
        ]);

        $user = auth()->user();
        $user->username = $validatedData['username'];
        $user->profile_bio = $request->input('profile_bio');
        $user->save();

        return redirect()->back()->with('success', 'Uw profiel is succesvol bijgewerkt.');
    }


    public function updateProfilePicture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

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

}
