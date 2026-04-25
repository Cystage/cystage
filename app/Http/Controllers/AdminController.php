<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use App\Models\Etudiant;
use App\Models\Entreprise;
use App\Models\Offre;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user()->role_id !== 1) {
            return redirect('/');
        }

        $etudiants = Etudiant::with('user')->get()->map(function ($etu) {
            return [
                'id'           => $etu->user->id,
                'nom'          => $etu->nom,
                'prenom'       => $etu->prenom,
                'email'        => $etu->user->email,
                'num_etudiant' => $etu->num_etudiant,
                'role_id'      => $etu->user->role_id,
                'created_at'   => $etu->user->created_at,
            ];
        });

        $entreprises = Entreprise::with('user')->get()->map(function ($ent) {
            return [
                'id'         => $ent->user->id,
                'nom'        => $ent->nom,
                'email'      => $ent->user->email,
                'siret'      => $ent->siret,
                'ville'      => $ent->ville,
                'num_tel'    => $ent->num_tel,
                'role_id'    => $ent->user->role_id,
                'created_at' => $ent->user->created_at,
            ];
        });

        $offres = Offre::with('entreprise')->get()->map(function ($offre) {
            return [
                'id'         => $offre->id,
                'nom'        => $offre->nom,
                'entreprise' => $offre->entreprise?->nom ?? 'Inconnue',
                'created_at' => $offre->created_at,
            ];
        });

        $admins = User::where('role_id', 1)->get()->map(function ($user) {
            return [
                'id'         => $user->id,
                'name'       => $user->name,
                'email'      => $user->email,
                'created_at' => $user->created_at,
            ];
        });

        return Inertia::render('Admin', [
            'etudiants'   => $etudiants,
            'entreprises' => $entreprises,
            'offres'      => $offres,
            'admins'      => $admins,
        ]);
    }

    public function changeRole(Request $request, $id)
    {
        if ($request->user()->role_id !== 1) {
            return redirect('/');
        }

        $request->validate(['role_id' => 'required|integer|in:1,2,3']);

        $user = User::findOrFail($id);
        $oldRole = $user->role_id;
        $newRole = $request->role_id;

        $user->update(['role_id' => $newRole]);

        if ($newRole === 1) {
            if ($oldRole === 3) {
                Etudiant::where('user_id', $id)->delete();
            }
            if ($oldRole === 2) {
                Entreprise::where('user_id', $id)->delete();
            }
            $user->update(['name' => 'admin-' . $user->name]);
        }

        return back()->with('success', 'Rôle modifié.');
    }

    public function deleteOffre(Request $request, $id)
{
    if ($request->user()->role_id !== 1) {
        return redirect('/');
    }

    $offre = Offre::findOrFail($id);
    
    \App\Models\Offre_Competence::where('offre_id', $id)->delete();
    \App\Models\Offre_Domaine::where('offre_id', $id)->delete();
    \App\Models\Postulation::where('offre_id', $id)->delete();
    
    $offre->delete();

    return back()->with('success', 'Offre supprimée.');
}

    public function deleteUser(Request $request, $id)
    {
        if ($request->user()->role_id !== 1) {
            return redirect('/');
        }
        $user = User::findOrFail($id);
        
        Etudiant::where('user_id', $id)->delete();
        Entreprise::where('user_id', $id)->delete();
        
        $user->delete();

        return back()->with('success', 'Utilisateur supprimé.');
    }
    
}