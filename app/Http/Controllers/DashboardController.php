<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Scrumboard;
use App\Models\ScrumboardSprint;
use App\Models\ScrumboardTask;

class DashboardController extends Controller
{
    public function index()
    {
        $createdScrumboards = Scrumboard::where('creator_id', Auth::id())->get();

        $addedScrumboards = Auth::user()->scrumboards;

        $scrumboards = $createdScrumboards->merge($addedScrumboards);

        $scrumboards = $scrumboards->sortBy(function ($scrumboard) {
            return [$scrumboard->active ? 0 : 1, $scrumboard->created_at];
        });

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
        $scrumboard = Scrumboard::where('id', $id)->firstOrFail();
        
        $sprints = ScrumboardSprint::where('scrumboard_id', $scrumboard->id)->with('tasks')->get();
        
        return view('dashboard.view-scrumboard.takenlijst.index', compact('scrumboard', 'sprints'));
    }

    public function createSprint(Request $request, $slug, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'planned_start_date' => 'required|date',
            'planned_end_date' => 'required|date|after_or_equal:planned_start_date',
        ]);
    
        try {
            $scrumboard = Scrumboard::where('id', $id)->firstOrFail();
            \Log::info("Scrumboard found", ['scrumboard' => $scrumboard]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            \Log::error("Scrumboard not found", ['id' => $id]);
            return redirect()->back()->withErrors(['error' => 'Scrumboard niet gevonden.']);
        }
    
        ScrumboardSprint::create([
            'scrumboard_id' => $scrumboard->id,
            'name' => $request->name,
            'description' => $request->description,
            'planned_start_date' => $request->planned_start_date,
            'planned_end_date' => $request->planned_end_date,
        ]);
    
        return redirect()
                ->route('scrumboard.takenlijst', ['slug' => \Str::slug($scrumboard->title), 'id' => $scrumboard->id])
                ->with('success', 'Sprint succesvol aangemaakt!');
    }

    

    public function createTask(Request $request, $slug, $scrumboardId, $sprintId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:todo,in_progress,done',
        ]);
    
        $scrumboardSprint = ScrumboardSprint::findOrFail($sprintId);
        $scrumboard = Scrumboard::findOrFail($scrumboardSprint->scrumboard_id);
    
        ScrumboardTask::create([
            'sprint_id' => $sprintId,
            'title' => $request->title,
            'description' => $request->description,
        ]);
    
        return redirect()->route('scrumboard.takenlijst', ['slug' => \Str::slug($scrumboard->title), 'id' => $scrumboard->id])
            ->with('success', 'Taak succesvol aangemaakt!');
    }
    



    public function bekijkScrumboardTijdlijn($slug, $id)
    {
        $scrumboard = Scrumboard::findOrFail($id);
        if ($slug !== \Str::slug($scrumboard->title)) {
            abort(404);
        }

        return view('dashboard.view-scrumboard.tijdlijn.index', compact('scrumboard'));
    }



    public function updateSprintOrder(Request $request)
    {
        // Logica voor het bijwerken van de sprintvolgorde
    }

    public function updateTaskOrder(Request $request)
    {
        // Logica voor het bijwerken van de taakvolgorde
    }
}