<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Link;
use Inertia\Inertia;

class EntrepriseController extends Controller
{
    public function index() {
    return Inertia::render('Welcome', [
        'entreprise' => \App\Models\Entreprise::latest()->first() 
    ]);
    }
    //'user_id','nom','siret','adresse','code_postal','ville','pays','num_tel'
    public function poste(Request $request) {
        $validated = $request->validate([
            'user_id' => 'required|integer',
            'nom' =>'required|string',
            'siret' => 'required|string',
            'adresse' => 'required|string',
            'code_postal' => 'required|string',
            'ville' => 'required|string',
            'pays' => 'required|string',
            'num_tel' => 'required|string',
        ]);

        \App\Models\Entreprise::create([
            'user_id' => $request->user_id,
            'nom' => $request->nom,
            'siret' => $request->siret,
            'adresse' => $request->adresse,
            'code_postal' => $request->code_postal,
            'ville' => $request->ville,
            'pays' => $request->pays,
            'num_tel' => $request->num_tel
        ]);

        return back()->with('success','Code partagé avec succès');
    }
}