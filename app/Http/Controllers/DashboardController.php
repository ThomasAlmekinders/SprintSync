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



    public function bekijkScrumboard($slug, $id)
    {
        $scrumboard = Scrumboard::findOrFail($id);
        if ($slug !== \Str::slug($scrumboard->title)) {
            abort(404);
        }
    
        return view('dashboard.view-scrumboard.beschrijving.index', compact('scrumboard'));
    }    

    public function bekijkScrumboardInstellingen($slug, $id)
    {
        $currentUser = auth()->user();

        if (!$currentUser) {
            return redirect()->route('login')->with('error', 'Je moet ingelogd zijn om deze pagina te bekijken.');
        }

        $scrumboard = Scrumboard::findOrFail($id);
        if ($slug !== \Str::slug($scrumboard->title)) {
            abort(404);
        }

        $connections = $currentUser->connections()
        ->orderBy('last_name', 'asc')
        ->orderBy('first_name', 'asc')
        ->get();

        $selectedConnections = $scrumboard->users()->pluck('users.id')->toArray();

        return view('dashboard.view-scrumboard.instellingen.index', compact('scrumboard', 'connections', 'selectedConnections'));
    }

    public function bekijkScrumboardBeschrijving($slug, $id)
    {
        $scrumboard = Scrumboard::findOrFail($id);
        if ($slug !== \Str::slug($scrumboard->title)) {
            abort(404);
        }

        return view('dashboard.view-scrumboard.beschrijving.index', compact('scrumboard'));
    }

    public function bekijkScrumboardTakenlijst($slug, $id)
    {
        $scrumboard = Scrumboard::findOrFail($id);
        if ($slug !== \Str::slug($scrumboard->title)) {
            abort(404);
        }

        return view('dashboard.view-scrumboard.takenlijst.index', compact('scrumboard'));
    }

    public function bekijkScrumboardTijdlijn($slug, $id)
    {
        $scrumboard = Scrumboard::findOrFail($id);
        if ($slug !== \Str::slug($scrumboard->title)) {
            abort(404);
        }

        return view('dashboard.view-scrumboard.tijdlijn.index', compact('scrumboard'));
    }

}