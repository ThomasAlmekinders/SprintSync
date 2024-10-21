<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Scrumboard;

use Illuminate\Http\Request;

class ScrumboardController extends Controller
{
    public function updateScrumboardInstellingen(Request $request, $title, $id)
    {
        $currentUser = auth()->user();
        $scrumboard = Scrumboard::findOrFail($id);
    
        if (!$currentUser) {
            return redirect()->route('login')->with('error', 'Je moet ingelogd zijn om deze pagina te bekijken.');
        }
        
        if ($currentUser->id !== $scrumboard->creator_id) {
            return redirect()->route('scrumboard.instellingen', ['slug' => \Str::slug($scrumboard->title), 'id' => $scrumboard->id])
                             ->with('failure', 'Je hebt geen toegang om deze gegevens bij te werken!');
        }
    
        $request->validate([
            'titel' => 'required|string|max:255',
            'beschrijving' => 'required|string',
            'personen' => 'array',
            'personen.*' => 'exists:users,id',
        ]);

        $scrumboard->title = $request->titel;
        $scrumboard->description = $request->beschrijving;
        $scrumboard->save();
    
        // Update de gekoppelde gebruikers
        $scrumboard->users()->sync($request->personen);
    
        // Redirect naar de juiste route met de parameters
        return redirect()->route('scrumboard.instellingen', ['slug' => \Str::slug($scrumboard->title), 'id' => $scrumboard->id])
                         ->with('success', 'De scrumboard-instellingen zijn bijgewerkt!');
    }
      
}
