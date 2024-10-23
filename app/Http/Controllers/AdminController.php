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
    public function updateFormSubmissions(Request $request, $id)
    {
        $submission = ContactFormSubmission::findOrFail($id);
        $submission->status = $request->input('status');
        $submission->save();

        return redirect()
                ->route('beheer.formulieren')
                ->with('success', 'formulier is bijgewerkt.');
    }
    public function deleteFormSubmissions($id) 
    {
        $submission = ContactFormSubmission::findOrFail($id);
        $submission->delete();

        return redirect()
                ->route('beheer.formulieren')
                ->with('success', 'formulier is verwijderd!');
    }

    public function showGebruikers(Request $request)
    {
        $perPage = $request->input('per_page', 50);
        
        $query = User::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', '%' . $search . '%')
                ->orWhere('last_name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
                ->orWhere('id', 'like', '%' . $search . '%');
            });
        }

        $sortField = $request->input('sort_by', 'first_name');
        $sortOrder = $request->input('sort_order', 'asc');

        $query->orderBy($sortField, $sortOrder);

        $users = $query->paginate($perPage);

        return view('account.beheer.gebruikers.index', [
            'users' => $users,
            'sort_by' => $sortField,
            'sort_order' => $sortOrder,
            'per_page' => $perPage,
            'search' => $request->input('search')
        ]);
    }
    public function destroyGebruikers($id)
    {
        $user = User::findOrFail($id);

        if (auth()->user()->is_administrator && !$user->is_administrator && auth()->id() !== $user->id) {
            $user->delete();
            return redirect()->route('beheer.gebruikers')->with('success', 'Gebruiker succesvol verwijderd.');
        }

        return redirect()->route('beheer.gebruikers')->with('error', 'Je hebt geen toestemming om deze gebruiker te verwijderen.');
    }


    public function instellingen()
    {
        return view('account.beheer.instellingen.index');
    }
}