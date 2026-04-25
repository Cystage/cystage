<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Link;
use Inertia\Inertia;

class PostulationController extends Controller
{
    public function index() {
    return Inertia::render('Welcome', [
        'postulation' => \App\Models\Postulation::latest()->first() 
    ]);
    }
    public function poste(Request $request) {
        $validated = $request->validate([
            'offre_id' => 'required|integer',
            'etu_id' => 'required|integer',
            'state' => 'required|integer',
            'motiv' => 'required|string',
            'path' => 'required|file|mimes:pdf',
        ]);

        $path = $request->file('path')->store('cvs', 'public');
        
        \App\Models\Postulation::create([
            'offre_id' => $request->offre_id,
            'etu_id' => $request->etu_id,
            'state' => $request->state,
            'motiv' => $request->motiv,
            'path' => $path
        ]);

        return back()->with('success','Code partagé avec succès');
    }
}
