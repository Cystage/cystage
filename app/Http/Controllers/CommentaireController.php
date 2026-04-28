<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Link;
use Inertia\Inertia;
use App\Models\Commentaire_Stage;

class CommentaireController extends Controller
{
    public function index() {
    return Inertia::render('Welcome', [
        'stage' => \App\Models\Stage::latest()->first() 
    ]);
    }
    public function poste(Request $request) {
        $validated = $request->validate([
            'poster' => 'required|string|min:3',
            'comment' =>'required|integer',
            'stage_id' => 'required|integer',
        ]);

        \App\Models\Commentaire::create([
            'poster' => $request->poster,
            'comment' => $request->comment
        ]);

        $latestcomment = \App\Models\Commentaire::latest()->first();
        \App\Models\Commentaire_Stage::create([
            'comm_id' => $latestcomment->id,
            'stage_id' => $request->stage_id,
        ]);

        return back()->with('success','Code partagé avec succès');
    }
}