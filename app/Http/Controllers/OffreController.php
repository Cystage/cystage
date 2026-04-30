<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Offre_Competence;
use App\Models\Offre_Domaine;

class OffreController extends Controller
{
    public function poste(Request $request)
    {
        $request->validate([
            'nom'         => 'required|string|min:3',
            'ent_id'      => 'required|integer',
            'nb_week'     => 'required|integer',
            'week_hour'   => 'required|integer',
            'paye_hour'   => 'required|decimal:0,2',
            'teletrav'    => 'required|boolean',
            'poste_desc'  => 'required|string',
            'profil_desc' => 'required|string',
            'domaines'    => 'required|array|min:1',
            'competences' => 'required|array|min:1',
        ]);

        $offre = \App\Models\Offre::create([
            'nom'         => $request->nom,
            'ent_id'      => $request->ent_id,
            'nb_week'     => $request->nb_week,
            'week_hour'   => $request->week_hour,
            'paye_hour'   => $request->paye_hour,
            'teletrav'    => $request->teletrav,
            'poste_desc'  => $request->poste_desc,
            'profil_desc' => $request->profil_desc,
        ]);

        foreach ($request->domaines as $d) {
            Offre_Domaine::create(['offre_id' => $offre->id, 'dom_id' => $d]);
        }
        foreach ($request->competences as $c) {
            Offre_Competence::create(['offre_id' => $offre->id, 'skill_id' => $c]);
        }

        return back()->with('success', 'Offre publiée avec succès !');
    }

    public function update(Request $request, $id)
    {
        $user = $request->user();
        $offre = \App\Models\Offre::findOrFail($id);

        if ($user->role_id === 2) {
            $ent = \App\Models\Entreprise::where('user_id', $user->id)->firstOrFail();
            abort_if($offre->ent_id !== $ent->id, 403);
        } elseif ($user->role_id !== 1) {
            abort(403);
        }

        $request->validate([
            'nom'         => 'required|string|min:3',
            'nb_week'     => 'required|integer',
            'week_hour'   => 'required|integer',
            'paye_hour'   => 'required|decimal:0,2',
            'teletrav'    => 'required|boolean',
            'poste_desc'  => 'required|string',
            'profil_desc' => 'required|string',
            'domaines'    => 'required|array|min:1',
            'competences' => 'required|array|min:1',
        ]);

        $offre->update([
            'nom'         => $request->nom,
            'nb_week'     => $request->nb_week,
            'week_hour'   => $request->week_hour,
            'paye_hour'   => $request->paye_hour,
            'teletrav'    => $request->teletrav,
            'poste_desc'  => $request->poste_desc,
            'profil_desc' => $request->profil_desc,
        ]);

        Offre_Domaine::where('offre_id', $id)->delete();
        foreach ($request->domaines as $d) {
            Offre_Domaine::create(['offre_id' => $id, 'dom_id' => $d]);
        }

        Offre_Competence::where('offre_id', $id)->delete();
        foreach ($request->competences as $c) {
            Offre_Competence::create(['offre_id' => $id, 'skill_id' => $c]);
        }

        return back()->with('success', 'Offre mise à jour !');
    }

    public function destroy(Request $request, $id)
    {
        $user = $request->user();
        $offre = \App\Models\Offre::findOrFail($id);

        if ($user->role_id === 2) {
            $ent = \App\Models\Entreprise::where('user_id', $user->id)->firstOrFail();
            abort_if($offre->ent_id !== $ent->id, 403);
        } elseif ($user->role_id !== 1) {
            abort(403);
        }

        foreach (\App\Models\Postulation::where('offre_id', $id)->get() as $p) {
            if ($p->path && \Illuminate\Support\Facades\Storage::disk('public')->exists($p->path)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($p->path);
            }
            $p->delete();
        }

        Offre_Domaine::where('offre_id', $id)->delete();
        Offre_Competence::where('offre_id', $id)->delete();
        $offre->delete();

        return back()->with('success', 'Offre supprimée.');
    }
}
