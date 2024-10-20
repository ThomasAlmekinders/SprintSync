<?php

namespace App\Http\Controllers;

use App\Models\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class ConnectionsController extends Controller
{
    public function index()
    {
        $currentUser = auth()->user();

        if (!$currentUser) {
            return redirect()->route('login')->with('error', 'Je moet ingelogd zijn om deze pagina te bekijken.');
        }

        $connections = $currentUser->connections()
            ->orderBy('last_name', 'asc')
            ->orderBy('first_name', 'asc')
            ->get();

        return view('account.connecties.index', compact('connections'));
    }

    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required|string',
        ]);

        $query = $request->input('query');

        $searchTerms = explode(' ', $query);

        $users = User::where(function ($queryBuilder) use ($searchTerms) {
            foreach ($searchTerms as $term) {
                $queryBuilder->where(function($q) use ($term) {
                    $q->where('first_name', 'LIKE', "%{$term}%")
                      ->orWhere('last_name', 'LIKE', "%{$term}%");
                });
            }
        })->get();

        if ($users->isEmpty()) {
            return response()->json([], 204);
        }

        return response()->json($users);
    }

    public function addConnection($userId)
    {
        $user = User::find($userId);
        $currentUser = auth()->user();

        if ($user && $user->id !== $currentUser->id) {
            $currentUser->connections()->attach($userId);
            return response()->json(['message' => 'Connectie toegevoegd'], 200);
        }

        return response()->json(['message' => 'Kan geen connectie toevoegen'], 400);
    }

    public function viewProfile($first_name, $last_name, $id)
    {
        $user = User::findOrFail($id);

        if ($user->first_name !== $first_name || $user->last_name !== $last_name) {
            return redirect()->route('account.connecties.view-profile.index', [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'id' => $user->id,
            ]);
        }

        return view('account.connecties.view-profile.index', [
            'user' => $user,
            'scrumbords' => $user->scrumbords,
        ]);
    }
}