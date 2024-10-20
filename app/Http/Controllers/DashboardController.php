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
        $createdScrumboards = Scrumboard::where('creator_id', Auth::id())->get();

        $addedScrumboards = Auth::user()->scrumboards;

        $scrumboards = $createdScrumboards->merge($addedScrumboards);

        return view('dashboard.index', compact('scrumboards'));
    }

    public function createScrumbord(Request $request)
    {
        $request->validate([
            'titel' => 'required|string|max:255',
            'beschrijving' => 'nullable|string',
        ]);

        $scrumbord = new Scrumboard();
        $scrumbord->title = $request->titel;
        $scrumbord->description = $request->beschrijving;
        $scrumbord->creator_id = auth()->id();

        $scrumbord->save();

        return redirect()->back()->with('success', 'Het scrumbord is aangemaakt!');
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'titel' => 'required|string|max:255',
            'beschrijving' => 'nullable|string',
            'actief' => 'nullable|boolean',
        ]);

        $scrumbord = Scrumboard::findOrFail($request->scrumboard_id);
        $scrumbord->creator_id = auth()->id(); 
        $scrumbord->title = $request->titel;
        $scrumbord->description = $request->beschrijving;
        $scrumbord->active = $request->actief;

        $scrumbord->save();

        return redirect()->back()->with('success', 'De scrumbord instelling zijn bijgewerkt!');
    }
}