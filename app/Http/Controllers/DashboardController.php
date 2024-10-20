<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Scrumboard;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Haal alle scrumboards op die door de huidige gebruiker zijn gemaakt
        $createdScrumboards = Scrumboard::where('creator_id', Auth::id())->get();

        // Haal alle scrumboards op waar de gebruiker aan is toegevoegd
        $addedScrumboards = Auth::user()->scrumboards;

        // Combineer de twee collecties
        $scrumboards = $createdScrumboards->merge($addedScrumboards);

        return view('dashboard.index', compact('scrumboards'));
    }
}