<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use App\Models\Etudiant;
use App\Models\Entreprise;
use App\Models\Offre;
use App\Models\Postulation;
use App\Models\AppLog;

class AdminController extends Controller
{
    public function index(Request $request)
    {
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

        $logs = AppLog::with('user')->latest('created_at')->take(200)->get()->map(function ($log) {
            return [
                'id'          => $log->id,
                'action'      => $log->action,
                'description' => $log->description,
                'ip'          => $log->ip,
                'email'       => $log->user?->email ?? 'Système',
                'created_at'  => $log->created_at,
            ];
        });

        $stages = Postulation::where('state', 3)
            ->with(['etudiant', 'offre.entreprise'])
            ->latest()
            ->get()
            ->map(function ($p) {
                return [
                    'id'         => $p->id,
                    'etudiant'   => ($p->etudiant->prenom ?? '') . ' ' . ($p->etudiant->nom ?? ''),
                    'offre'      => $p->offre->nom ?? '—',
                    'entreprise' => $p->offre->entreprise->nom ?? '—',
                    'archived'   => (bool) $p->archived,
                    'created_at' => $p->created_at,
                ];
            });

        return Inertia::render('Admin', [
            'etudiants'   => $etudiants,
            'entreprises' => $entreprises,
            'offres'      => $offres,
            'admins'      => $admins,
            'logs'        => $logs,
            'stages'      => $stages,
        ]);
    }

    public function changeRole(Request $request, $id)
    {
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

        if ($oldRole === 1 && $newRole === 3) {
            $cleanName = preg_replace('/^admin-/', '', $user->name);
            Etudiant::create([
                'user_id'      => $user->id,
                'nom'          => $cleanName,
                'prenom'       => 'Prénom',
                'num_etudiant' => '00000000',
            ]);
            $user->update(['name' => 'e-' . strtolower($cleanName[0] ?? 'x') . strtolower($cleanName)]);
        }

        AppLog::log($request->user()->id, 'admin_role', "Rôle de {$user->email} changé de {$oldRole} à {$newRole}");
        return back()->with('success', 'Rôle modifié.');
    }

    public function deleteOffre(Request $request, $id)
    {
        $offre = Offre::findOrFail($id);
        
        \App\Models\Offre_Competence::where('offre_id', $id)->delete();
        \App\Models\Offre_Domaine::where('offre_id', $id)->delete();
        \App\Models\Postulation::where('offre_id', $id)->delete();
        
        AppLog::log($request->user()->id, 'admin_delete_offre', "Offre supprimée : {$offre->nom}");
        $offre->delete();
        return back()->with('success', 'Offre supprimée.');
    }

    public function deleteUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($user->role_id === 3) {
            $etu = Etudiant::where('user_id', $id)->first();
            if ($etu) {
                \App\Models\Postulation::where('etu_id', $etu->id)->delete();
                $etu->delete();
            }
        }

        if ($user->role_id === 2) {
            $ent = Entreprise::where('user_id', $id)->first();
            if ($ent) {
                $offres = Offre::where('ent_id', $ent->id)->get();
                foreach ($offres as $offre) {
                    \App\Models\Offre_Competence::where('offre_id', $offre->id)->delete();
                    \App\Models\Offre_Domaine::where('offre_id', $offre->id)->delete();
                    \App\Models\Postulation::where('offre_id', $offre->id)->delete();
                    $offre->delete();
                }
                $ent->delete();
            }
        }

        $user->delete();

        return back()->with('success', 'Utilisateur supprimé.');
    }
}