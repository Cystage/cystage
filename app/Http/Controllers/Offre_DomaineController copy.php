<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Link;
use Inertia\Inertia;

class Offre_DomaineController extends Controller
{
    public function index() {
    return Inertia::render('Welcome', [
        'offre_domaine' => \App\Models\Offre_Domaine::latest()->first() 
    ]);
    }
    public function poste(Request $request) {
        $validated = $request->validate([
            'offre_id' => 'required|integer',
            'dom_id' => 'required|integer',
        ]);

        \App\Models\Offre_Domaine::create([
            'offre_id' => $request->offre_id,
            'dom_id' => $request->dom_id
        ]);

        return back()->with('success','Code partagé avec succès');
    }
}