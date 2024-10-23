<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\ContactFormSubmission;

class AdminController extends Controller
{
    public function statistieken()
    {
        return view('account.beheer.statistieken.index');
    }

    public function showFormSubmissions()
    {
        $contactSubmissions = ContactFormSubmission::orderByRaw("
            CASE status
                WHEN 'new' THEN 1
                WHEN 'in_progress' THEN 2
                WHEN 'answered' THEN 3
                WHEN 'closed' THEN 4
            END
        ")
        ->orderBy('created_at', 'desc')
        ->get();

        return view('account.beheer.formulieren.index', compact('contactSubmissions'));
    }
    public function deleteFormSubmissions($id) 
    {
        $submission = ContactFormSubmission::findOrFail($id);
        $submission->delete();

        return redirect()
                ->route('beheer.formulieren')
                ->with('success', 'formulier is verwijderd!');
    }

    public function gebruikers()
    {
        return view('account.beheer.gebruikers.index');
    }

    public function instellingen()
    {
        return view('account.beheer.instellingen.index');
    }
}