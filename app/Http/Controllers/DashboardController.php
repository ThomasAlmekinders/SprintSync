<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Livewire\Component;
use Carbon\Carbon;

use App\Models\User;
use App\Models\ActivityLog;
use App\Models\Scrumboard;
use App\Models\ScrumboardSprint;
use App\Models\ScrumboardTask;
use App\Models\ScrumboardChat;

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
        $user = auth()->user();
        
        $request->validate([
            'titel' => 'required|string|max:255',
            'beschrijving' => 'nullable|string',
        ]);

        $scrumbord = new Scrumboard();
        $scrumbord->title = $request->titel;
        $scrumbord->description = $request->beschrijving;
        $scrumbord->creator_id = auth()->id();

        $scrumbord->save();
        
        $scrumbord->users()->attach($user->id);

        $this->logActivity($user, "Scrumbord", "Je hebt een nieuw scrumbord aangemaakt.");

        return redirect()->back()->with('success', 'Het scrumbord is aangemaakt!');
    }

    public function updateSettings(Request $request)
    {
        $user = auth()->user();

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

        $this->logActivity($user, "Scrumbord", "De scrumbord instellingen zijn aangepast.");

        return redirect()->back()->with('success', 'De scrumbord instelling zijn bijgewerkt!');
    }



    public function bekijkScrumboard($slug, $id)
    {
        $scrumboard = Scrumboard::findOrFail($id);
        $sprints = ScrumboardSprint::where('scrumboard_id', $id)->get();

        return view('dashboard.view-scrumboard.scrumboard.index', compact('scrumboard', 'sprints'));
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


    public function bekijkScrumboardBeschrijving(Request $request, $slug, $id)
    {
        $scrumboard = Scrumboard::findOrFail($id);
        $chats = ScrumboardChat::where('scrumboard_id', $id)
                                ->orderBy('created_at', 'desc')
                                ->take(5)
                                ->get();

        return view('dashboard.view-scrumboard.beschrijving.index', compact('scrumboard', 'chats'));
    }
    public function storeChatMessage(Request $request, $slug, $scrumboardId) {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);
    
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Je moet ingelogd zijn om een bericht te sturen.');
        }
    
        $userId = auth()->id();
    
        $scrumboard = Scrumboard::findOrFail($scrumboardId);

        ScrumboardChat::create([
            'user_id' => $userId,
            'scrumboard_id' => $scrumboardId,
            'message' => $request->message,
        ]);
    
        return redirect()
                ->route('scrumboard.beschrijving', ['slug' => $scrumboard->title, 'id' => $scrumboard->id])
                ->with('success', 'Bericht succesvol verzonden!');
    }
    public function editChatMessage(Request $request, $slug, $scrumboardId, $chatID) {
        $request->validate([
            'new_message' => 'required|string|max:255',
        ]);
        
        $scrumboard = Scrumboard::findOrFail($scrumboardId);
        $chat = ScrumboardChat::findOrFail($chatID);
        $chat->message = $request->new_message;
        $chat->save();
    
        return redirect()
            ->route('scrumboard.beschrijving', ['slug' => $slug, 'id' => $scrumboard->id])
            ->with('success', 'Bericht succesvol bijgewerkt!');
    }
    
    public function deleteChatMessage(Request $request, $slug, $scrumboardId, $chatID) {

        $scrumboard = Scrumboard::findOrFail($scrumboardId);
        $chat = ScrumboardChat::findOrFail($chatID);
        $chat->delete();
    
        return redirect()
            ->route('scrumboard.beschrijving', ['slug' => $slug, 'id' => $scrumboard->id])
            ->with('success', 'Bericht succesvol verwijderd!');
    }
    public function loadMoreChats(Request $request, $slug, $id, $offset)
    {
        $limit = 5; // Aantal berichten per aanvraag
        $chats = ScrumboardChat::where('scrumboard_id', $id)
                    ->orderBy('created_at', 'desc')
                    ->skip($offset)
                    ->take($limit)
                    ->with('user')
                    ->get();

        return response()->json($chats);
    }



    public function bekijkScrumboardTakenlijst($slug, $id)
    {
        $scrumboard = Scrumboard::where('id', $id)->firstOrFail();
        
        $sprints = ScrumboardSprint::where('scrumboard_id', $scrumboard->id)
                                    ->with(['tasks' => function ($query) {
                                        $query->orderBy('task_order', 'asc');
                                    }])
                                    ->get();
        
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
    public function deleteSprint(Request $request, $slug, $scrumboardId, $sprintId)
    {
        $scrumboard = Scrumboard::where('id', $scrumboardId)->firstOrFail();
        $sprint = ScrumboardSprint::findOrFail($sprintId);
        $sprint->tasks()->delete();
        $sprint->delete();

        return redirect()
                ->route('scrumboard.takenlijst', ['slug' => \Str::slug($scrumboard->title), 'id' => $scrumboard->id])
                ->with('success', 'Sprint succesvol verwijderd!');
    }

    

    public function createTask(Request $request, $slug, $scrumboardId, $sprintId)
    {
        $request->validate([
            'createTitle' => 'required|string|max:255',
            'createDescription' => 'nullable|string',
            'createStatus' => 'required|in:to_do,in_progress,done',
        ]);
    
        $scrumboardSprint = ScrumboardSprint::findOrFail($sprintId);
        $scrumboard = Scrumboard::findOrFail($scrumboardSprint->scrumboard_id);
        
        ScrumboardTask::create([
            'sprint_id' => $sprintId,
            'title' => $request->createTitle,
            'description' => $request->createDescription,
            'status' => $request->createStatus,
        ]);
    
        return redirect()->route('scrumboard.takenlijst', ['slug' => \Str::slug($scrumboard->title), 'id' => $scrumboard->id])
            ->with('success', 'Taak succesvol aangemaakt!');
    }
    public function editTask(Request $request, $slug, $scrumboardId, $sprintId, $taskId)
    {
        $request->validate([
            'createTitle' => 'required|string|max:255',
            'createDescription' => 'nullable|string',
            'createStatus' => 'required|in:to_do,in_progress,done',
        ]);
        

        $scrumboardSprint = ScrumboardSprint::findOrFail($sprintId);
        $scrumboard = Scrumboard::findOrFail($scrumboardSprint->scrumboard_id);
        $task = ScrumboardTask::findOrFail($taskId);

        $task->update([
            'title' => $request->createTitle,
            'description' => $request->createDescription,
            'status' => $request->createStatus,
        ]);
    
        return redirect()->route('scrumboard.takenlijst', ['slug' => \Str::slug($scrumboard->title), 'id' => $scrumboard->id])
            ->with('success', 'Taak succesvol bijgewerkt!');
    }
    public function appointTask(Request $request, $slug, $scrumboardId, $sprintId, $taskId)
    {
        $request->validate([
            'person_id' => 'nullable|integer|exists:users,id',
        ]);
        
        $scrumboardSprint = ScrumboardSprint::findOrFail($sprintId);
        $scrumboard = Scrumboard::findOrFail($scrumboardSprint->scrumboard_id);
        $task = ScrumboardTask::findOrFail($taskId);

        $task->update([
            'assigned_user_id' => $request->person_id,
        ]);

        return redirect()->route('scrumboard.takenlijst', ['slug' => \Str::slug($scrumboard->title), 'id' => $scrumboard->id])
            ->with('success', 'Taak succesvol bijgewerkt!');
    }

    public function deleteTask(Request $request, $slug, $scrumboardId, $sprintId, $taskId)
    {
        $scrumboard = Scrumboard::findOrFail($scrumboardId);
        $task = ScrumboardTask::findOrFail($taskId);
        $task->delete();

        return redirect()->route('scrumboard.takenlijst', ['slug' => \Str::slug($scrumboard->title), 'id' => $scrumboard->id])
            ->with('success', 'Taak succesvol verwijderd!');
    }
    public function updateTaskOrder(Request $request, $slug, $scrumId, $sprintId)
    {
        $order = $request->input('task_order');

        foreach ($order as $index => $taskId) {
            ScrumboardTask::where('id', $taskId)
                ->where('sprint_id', $sprintId)
                ->update(['task_order' => $index + 1]);
        }

        return response()->json(['message' => 'Taakvolgorde succesvol bijgewerkt']);
    }
    public function updateTaskStatus(Request $request, $slug, $scrumId, $sprintId)
    {
        $validatedData = $request->validate([
            'task_id' => 'required|exists:scrumboard_tasks,id',
            'status' => 'required|string',
        ]);
    
        $task = ScrumboardTask::findOrFail($validatedData['task_id']);
        $task->update(['status' => $validatedData['status']]);
    
        return response()->json(['success' => 'Taakstatus succesvol bijgewerkt']);
    }
    
    
    
    public function bekijkScrumboardTijdlijn(Request $request, $slug, $id)
    {
        $scrumboard = Scrumboard::findOrFail($id);
        
        $view = $request->query('view', 'week');
        
        $startOfView = $request->query('startOfPeriod') 
                        ? Carbon::parse($request->query('startOfPeriod')) 
                        : Carbon::now()->startOfWeek();
        
        if ($view == 'day') {
            $startOfView = $startOfView->startOfDay();
        } elseif ($view == 'week') {
            $startOfView = $startOfView->startOfWeek();
        } elseif ($view == 'month') {
            $startOfView = $startOfView->startOfMonth();
        }
        
        if ($view == 'day') {
            $endOfView = $startOfView->copy()->endOfDay();
        } elseif ($view == 'week') {
            $endOfView = $startOfView->copy()->endOfWeek();
        } elseif ($view == 'month') {
            $endOfView = $startOfView->copy()->endOfMonth();
        }
        
        $sprints = $scrumboard->sprints()
            ->whereBetween('planned_start_date', [$startOfView, $endOfView])
            ->orWhereBetween('planned_end_date', [$startOfView, $endOfView])
            ->orderBy('planned_start_date')
            ->get();
        
        $calendarDays = collect();
        if ($view == 'day') {
            $calendarDays->push($startOfView);
        } elseif ($view == 'week' || $view == 'month') {
            for ($date = $startOfView->copy(); $date->lte($endOfView); $date->addDay()) {
                $calendarDays->push($date->copy());
            }
        }
        
        $sprintsByDate = collect();
        foreach ($sprints as $sprint) {
            $start = Carbon::parse($sprint->planned_start_date);
            $end = Carbon::parse($sprint->planned_end_date);
            
            for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
                $formattedDate = $date->format('Y-m-d');
                
                if (!$sprintsByDate->has($formattedDate)) {
                    $sprintsByDate[$formattedDate] = collect();
                }
                
                $sprintsByDate[$formattedDate]->push($sprint);
            }
        }
        
        if ($view == 'day') {
            $previousPeriodStart = $startOfView->copy()->subDay();
            $nextPeriodStart = $startOfView->copy()->addDay();
        } elseif ($view == 'week') {
            $previousPeriodStart = $startOfView->copy()->subWeek()->startOfWeek();
            $nextPeriodStart = $startOfView->copy()->addWeek()->startOfWeek();
        } elseif ($view == 'month') {
            $previousPeriodStart = $startOfView->copy()->subMonth()->startOfMonth();
            $nextPeriodStart = $startOfView->copy()->addMonth()->startOfMonth();
        }
        
        return view('dashboard.view-scrumboard.tijdlijn.index', 
            compact('scrumboard', 'calendarDays', 'sprintsByDate', 'previousPeriodStart', 'nextPeriodStart', 'view', 'startOfView')
        );
    }
    
    private function getEndOfPeriod($startOfPeriod, $view)
    {
        switch ($view) {
            case 'dag':
                return $startOfPeriod->copy()->endOfDay();
            case 'week':
                return $startOfPeriod->copy()->endOfWeek();
            case 'maand':
                return $startOfPeriod->copy()->endOfMonth();
        }
    }
    
    private function getPreviousPeriod($startOfPeriod, $view)
    {
        switch ($view) {
            case 'dag':
                return $startOfPeriod->copy()->subDay();
            case 'week':
                return $startOfPeriod->copy()->subWeek()->startOfWeek();
            case 'maand':
                return $startOfPeriod->copy()->subMonth()->startOfMonth();
        }
    }
    
    private function getNextPeriod($startOfPeriod, $view)
    {
        switch ($view) {
            case 'dag':
                return $startOfPeriod->copy()->addDay();
            case 'week':
                return $startOfPeriod->copy()->addWeek()->startOfWeek();
            case 'maand':
                return $startOfPeriod->copy()->addMonth()->startOfMonth();
        }
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