<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Link;
use Inertia\Inertia;

class Offre_CompetenceController extends Controller
{
    public function index() {
    return Inertia::render('Welcome', [
        'offre_competence' => \App\Models\Offre_Competence::latest()->first() 
    ]);
    }
    public function poste(Request $request) {
        $validated = $request->validate([
            'offre_id' => 'required|integer',
            'skill_id' => 'required|integer',
        ]);

        \App\Models\Offre_Competence::create([
            'offre_id' => $request->offre_id,
            'skill_id' => $request->skill_id
        ]);

        return back()->with('success','Code partagé avec succès');
    }
}