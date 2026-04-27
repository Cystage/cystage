<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Link;
use Inertia\Inertia;
use App\Models\Offre_Competence;
use App\Models\Offre_Domaine;

class OffreController extends Controller
{
    public function index() {
    return Inertia::render('Welcome', [
        'offre' => \App\Models\Offre::latest()->first() 
    ]);
    }
    public function poste(Request $request) {
        $validated = $request->validate([
            'nom' => 'required|string|min:3',
            'ent_id' =>'required|integer',
            'etu_id' =>'required|integer',
            'nb_week' => 'required|integer',
            'week_hour' => 'required|integer',
            'paye_hour' => 'required|decimal:0,2',
            'teletrav' => 'required|boolean',
            'poste_desc' => 'required|string',
            'profil_desc' => 'required|string',
            'domaines' => 'required|array|min:1',
            'competences' => 'required|array|min:1',
            'state' => 'required|integer',
        ]);

        $doms = "";
        foreach ($request->domaines as $d){
            $doms = $doms . "#" . $d . " ";         
        }

        $skills = "";
        foreach ($request->competences as $c){
            $skills = $skills . "#" . $c . " ";
        }
        
        \App\Models\Stage::create([
            'nom' => $request->nom,
            'ent_id' => $request->ent_id,
            'etu_id' => $request->etu_id,
            'nb_week' => $request->nb_week,
            'week_hour' => $request->week_hour,
            'paye_hour' => $request->paye_hour,
            'teletrav' => $request->teletrav,
            'poste_desc' => $request->poste_desc,
            'profil_desc' => $request->profil_desc,
            'domaines' => $doms,
            'competences' => $skills,
            'state' => $request->state,
        ]);

        return back()->with('success','Code partagé avec succès');
    }
}