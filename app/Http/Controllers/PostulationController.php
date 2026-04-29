<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Link;
use Inertia\Inertia;
use Illuminate\Support\Facades\Mail;
use App\Mail\NouvelleCandiature;
use App\Mail\CandidatureAcceptee;
use App\Mail\StageConfirme;
use App\Models\AppNotif;
use App\Models\AppLog;
use App\Models\PostulationCommentaire;

class PostulationController extends Controller
{
    public function index() {
    return Inertia::render('Welcome', [
        'postulation' => \App\Models\Postulation::latest()->first() 
    ]);
    }
    public function poste(Request $request) {
        $validated = $request->validate([
            'offre_id' => 'required|integer',
            'etu_id' => 'required|integer',
            'state' => 'required|integer',
            'motiv' => 'required|string',
            'path' => 'required|file|mimes:pdf',
        ]);

        $path = $request->file('path')->store('cvs', 'public');

        $postulation = \App\Models\Postulation::create([
            'offre_id' => $request->offre_id,
            'etu_id' => $request->etu_id,
            'state' => $request->state,
            'motiv' => $request->motiv,
            'path' => $path
        ]);

        $postulation->load('offre.entreprise.user', 'etudiant');
        $entrepriseUser = $postulation->offre->entreprise->user;

        AppNotif::create([
            'user_id' => $entrepriseUser->id,
            'type'    => 'nouvelle_candidature',
            'message' => "Nouvelle candidature de {$postulation->etudiant->prenom} {$postulation->etudiant->nom} pour « {$postulation->offre->nom} »",
            'link'    => '/profil?tab=candidatures',
        ]);

        if ($entrepriseUser->notif_mail) {
            Mail::to($entrepriseUser->email)->send(new NouvelleCandiature($postulation));
        }
        AppLog::log($request->user()->id, 'postulation', "{$postulation->etudiant->prenom} {$postulation->etudiant->nom} a postulé à « {$postulation->offre->nom} »");

        return back()->with('success', 'Candidature envoyée avec succès');
    }

    public function accepte(int $id) {
        $postulation = \App\Models\Postulation::findOrFail($id);
        $postulation->update(['state' => 2]);

        $postulation->load('offre.entreprise', 'etudiant.user');
        $etudiantUser = $postulation->etudiant->user;

        AppNotif::create([
            'user_id' => $etudiantUser->id,
            'type'    => 'candidature_acceptee',
            'message' => "Votre candidature pour « {$postulation->offre->nom} » a été acceptée !",
            'link'    => '/profil?tab=candidatures',
        ]);

        if ($etudiantUser->notif_mail) {
            Mail::to($etudiantUser->email)->send(new CandidatureAcceptee($postulation));
        }
        AppLog::log(null, 'acceptation', "Candidature de {$postulation->etudiant->prenom} {$postulation->etudiant->nom} acceptée pour « {$postulation->offre->nom} »");

        return back()->with('success', 'Candidature acceptée.');
    }

    public function confirmer(Request $request, int $id) {
        $postulation = \App\Models\Postulation::findOrFail($id);
        $etudiant = \App\Models\Etudiant::where('user_id', $request->user()->id)->firstOrFail();

        abort_if($postulation->etu_id !== $etudiant->id, 403);
        abort_if($postulation->state !== 2, 403);

        $postulation->update(['state' => 3]);

        $postulation->load('offre.entreprise.user', 'etudiant');
        $entrepriseUser = $postulation->offre->entreprise->user;

        AppNotif::create([
            'user_id' => $entrepriseUser->id,
            'type'    => 'stage_confirme',
            'message' => "{$postulation->etudiant->prenom} {$postulation->etudiant->nom} a confirmé le stage pour « {$postulation->offre->nom} »",
            'link'    => '/profil?tab=candidatures',
        ]);

        if ($entrepriseUser->notif_mail) {
            Mail::to($entrepriseUser->email)->send(new StageConfirme($postulation));
        }
        AppLog::log($request->user()->id, 'confirmation', "{$postulation->etudiant->prenom} {$postulation->etudiant->nom} a confirmé le stage pour « {$postulation->offre->nom} »");

        return back()->with('success', 'Stage confirmé.');
    }
}
