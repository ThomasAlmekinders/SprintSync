<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactFormSubmission;
use Illuminate\Support\Facades\Auth;

class FormController extends Controller
{
    public function storeContactFormData(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email',
            'phone'      => 'nullable|string|max:20',
            'subject'    => 'nullable|string|max:255',
            'message'    => 'required|string|min:10',
            'website'    => 'nullable',
        ]);

        ContactFormSubmission::create([
            'first_name' => $validatedData['first_name'],
            'last_name'  => $validatedData['last_name'],
            'email'      => $validatedData['email'],
            'phone_number' => $validatedData['phone'] ?? null,
            'subject'    => $validatedData['subject'] ?? null,
            'message'    => $validatedData['message'],
            'logged_in_user_id' => Auth::check() ? Auth::id() : null,
            'ip_address' => $request->ip(),
        ]);

        return redirect()->back()->with('success', 'Uw bericht is succesvol verzonden.');
    }
}
