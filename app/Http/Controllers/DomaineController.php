<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Link;
use Inertia\Inertia;

class DomaineController extends Controller
{
    public function index() {
    return Inertia::render('Welcome', [
        'domaine' => \App\Models\Domaine::latest()->first() 
    ]);
    }
    public function poste(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string',
        ]);

        \App\Models\Domaine::create([
            'name' => $request->name
        ]);

        return back()->with('success','Code partagé avec succès');
    }
}