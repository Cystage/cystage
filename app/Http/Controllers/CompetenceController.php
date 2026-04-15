<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Link;
use Inertia\Inertia;

class CompetenceController extends Controller
{
    public function index() {
    return Inertia::render('Welcome', [
        'competence' => \App\Models\Competence::latest()->first() 
    ]);
    }
    public function poste(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string',
        ]);

        \App\Models\Competence::create([
            'name' => $request->name
        ]);

        return back()->with('success','Code partagé avec succès');
    }
}