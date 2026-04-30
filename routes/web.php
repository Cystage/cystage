<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OffreController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompetenceController;
use App\Http\Controllers\DomaineController;
use App\Http\Controllers\Offre_CompetenceController;
use App\Http\Controllers\Offre_DomaineController;
use App\Http\Controllers\PostulationController;
use Inertia\Inertia;
use App\Models\Offre_Competence;
use App\Models\Offre_Domaine;
use App\Models\Entreprise;
use App\Models\Offre;
use App\Models\Competence;
use App\Models\Etudiant;
use App\Models\Domaine;
use App\Models\Role;
use App\Models\Postulation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\AdminController;

Route::get('/', function (Request $request) {
    if ($request->user()) {
        $user = $request->user();
        if($user->role_id==3){
            $etu = Etudiant::where('user_id',$user->id)->first();
            return Inertia::render('Welcome', [
                'offres' => Offre::latest()->get(),
                'competences' => Cache::remember('competences', 600, fn() => Competence::latest()->get()),
                'domaines'    => Cache::remember('domaines',    600, fn() => Domaine::latest()->get()),
                'links_offres_competences' => Offre_Competence::latest()->get(),
                'links_offres_domaines' => Offre_Domaine::latest()->get(),
                'entreprises' => Entreprise::latest()->get(),
                'etudiant' => $etu,
                'postulations' => Postulation::where('etu_id', $etu->id)->get(),
            ]);
        }
        if($user->role_id==2){
            $ent = Entreprise::where('user_id',$user->id)->first();
            $offres = Offre::where('ent_id',$ent->id)->latest()->get();
            $offreIds = $offres->pluck('id');
            return Inertia::render('Welcome', [
                'entreprises' => $ent,
                'offres' => $offres,
                'competences' => Competence::latest()->get(),
                'domaines' => Domaine::latest()->get(),
                'links_offres_competences' => Offre_Competence::whereIn('offre_id', $offreIds)->latest()->get(),
                'links_offres_domaines' => Offre_Domaine::whereIn('offre_id', $offreIds)->latest()->get(),
                'postulations' => Postulation::whereIn('offre_id', $offreIds)->latest()->get(),
            ]);
        }
        if($user->role_id==1){
            return Inertia::render('Welcome', [
                'offres' => Offre::latest()->get(),
                'competences' => Competence::latest()->get(),
                'domaines' => Domaine::latest()->get(),
                'links_offres_competences' => Offre_Competence::latest()->get(),
                'links_offres_domaines' => Offre_Domaine::latest()->get(),
                'entreprises' => Entreprise::latest()->get(),
                'postulations' => Postulation::latest()->get(),
            ]);
        }
    }else{
        return Inertia::render('Welcome', [
        ]);
    }
})->name('home');

Route::post('/postulation', [PostulationController::class, 'poste'])->middleware(['auth', 'role:3'])->name('links.postulation');

Route::post('/offre', [OffreController::class, 'poste'])->middleware(['auth', 'role:1,2'])->name('links.offre');

Route::post('/domaine', [DomaineController::class, 'poste'])->middleware(['auth', 'role:1'])->name('links.domaine');

Route::post('/competence', [CompetenceController::class, 'poste'])->middleware(['auth', 'role:1'])->name('links.competence');

Route::post('/offre_domaine', [Offre_DomaineController::class, 'poste'])->middleware(['auth', 'role:2'])->name('links.offre_domaine');

Route::post('/offre_competence', [Offre_CompetenceController::class, 'poste'])->middleware(['auth', 'role:2'])->name('links.offre_competence');

Route::get('/profil', function (Request $request) {
    $user = $request->user();
    if($user->role_id==3){
        $etud = Etudiant::where('user_id',$user->id)->first();
        $postulations = Postulation::whereIn('etu_id',[$etud->id])
            ->with(['etudiant', 'offre', 'commentaires.user'])
            ->latest()
            ->get();

        return Inertia::render('Profile', [
            'profile' => [
                'nom' => $etud->nom,
                'prenom' => $etud->prenom,
                'email' => $user->email,
                'num_etudiant' => $etud->num_etudiant,
                'identifiant' => $user->name,
                'type'=> $user->role_id,
                'notif_mail'         => $user->notif_mail,
                'two_factor_enabled' => $user->two_factor_enabled,
            ],
            'postulations' => $postulations,
        ]);
    }
    if($user->role_id==2){
        $ent = Entreprise::where('user_id',$user->id)->first();
        $offreIds = $ent->offres->pluck('id');
        $postulations = Postulation::whereIn('offre_id',$offreIds)
        ->with(['etudiant', 'offre', 'commentaires.user'])
        ->latest()
        ->get();

        return Inertia::render('Profile', [
            'profile' => [
                'nom' => $ent->nom,
                'identifiant' => $user->name,
                'email' => $user->email,
                'siret' => $ent->siret,
                'adresse' => $ent->adresse,
                'code_postal' => $ent->code_postal,
                'ville' => $ent->ville,
                'pays' => $ent->pays,
                'num_tel' => $ent->num_tel,
                'type'=> $user->role_id,
                'logo' => $ent->logo,
                'notif_mail'         => $user->notif_mail,
                'two_factor_enabled' => $user->two_factor_enabled,
            ],
            'postulations' => $postulations,
        ]);
    }
    if ($user->role_id == 1) {
        return Inertia::render('Profile', [
            'profile' => [
                'nom'        => $user->name,
                'prenom'     => null,
                'email'      => $user->email,
                'identifiant'=> $user->name,
                'type'       => $user->role_id,
                'notif_mail'         => $user->notif_mail,
                'two_factor_enabled' => $user->two_factor_enabled,
            ],
        ]);
    }
})->middleware('auth')->name('profile');

Route::redirect('/progil', '/profil');

Route::get('/register', fn() => inertia('Register'))->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::get('/login', fn() => inertia('Login'))->name('login');

Route::post('/newent', [AuthController::class, 'newent'])->name('newent.post');

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::get('/postulation', function (Request $request) {
    $user = $request->user();
    
    if ($user && $user->role_id == 2) {
        $ent = Entreprise::where('user_id', $user->id)->first();
        if (!$ent || $ent->offres->isEmpty()) {
            return Inertia::render('EntreprisePostulation', [
                'postulations' => []
            ]);
        }

        $offreIds = $ent->offres->pluck('id');
        $postulations = Postulation::whereIn('offre_id', $offreIds)
            ->with(['etudiant', 'offre', 'commentaires.user'])
            ->latest()
            ->get();

        return Inertia::render('EntreprisePostulation', [
            'postulations' => $postulations
        ]);
    }
    
    return redirect('/');
})->middleware('auth')->name('postulation');

Route::delete('/postulation/{id}', function ($id, Request $request) {
    $postulation = Postulation::findOrFail($id);
    $user = $request->user();

    if ($user->role_id === 3) {
        $etudiant = \App\Models\Etudiant::where('user_id', $user->id)->firstOrFail();
        abort_if($postulation->etu_id !== $etudiant->id, 403);
    } elseif ($user->role_id === 2) {
        $ent = \App\Models\Entreprise::where('user_id', $user->id)->firstOrFail();
        $offreIds = $ent->offres->pluck('id');
        abort_if(!$offreIds->contains($postulation->offre_id), 403);
    } else {
        abort(403);
    }

    if ($postulation->path && \Illuminate\Support\Facades\Storage::disk('public')->exists($postulation->path)) {
        \Illuminate\Support\Facades\Storage::disk('public')->delete($postulation->path);
    }
    $postulation->delete();
    return back()->with('success', 'Candidature supprimée.');
})->middleware('auth');

Route::post('/postulation/{id}/confirmer', [PostulationController::class, 'confirmer'])->middleware(['auth', 'role:3'])->name('postulation.confirmer');


Route::post('/accepte/{id}', [PostulationController::class, 'accepte'])->middleware(['auth', 'role:2'])->name('accepte');

Route::post('/profil', [AuthController::class, 'updateProfil'])->middleware('auth')->name('profil.update');
Route::patch('/settings/notif-mail', [AuthController::class, 'updateNotifMail'])->middleware('auth')->name('settings.notif');
Route::delete('/account', [AuthController::class, 'deleteAccount'])->middleware('auth')->name('account.delete');

Route::middleware('auth')->group(function () {
    Route::post('/notifs/{id}/lire', function ($id, Request $request) {
        \App\Models\AppNotif::where('id', $id)->where('user_id', $request->user()->id)->update(['read_at' => now()]);
        return back();
    })->name('notifs.lire');

    Route::post('/notifs/tout-lire', function (Request $request) {
        \App\Models\AppNotif::where('user_id', $request->user()->id)->whereNull('read_at')->update(['read_at' => now()]);
        return back();
    })->name('notifs.tout-lire');

    Route::delete('/notifs/lues', function (Request $request) {
        \App\Models\AppNotif::where('user_id', $request->user()->id)->whereNotNull('read_at')->delete();
        return back();
    })->name('notifs.delete-lues');

    Route::delete('/notifs', function (Request $request) {
        \App\Models\AppNotif::where('user_id', $request->user()->id)->delete();
        return back();
    })->name('notifs.delete-all');

    Route::delete('/notifs/{id}', function ($id, Request $request) {
        \App\Models\AppNotif::where('id', $id)->where('user_id', $request->user()->id)->delete();
        return back();
    })->name('notifs.delete');

    Route::post('/postulation/{id}/archiver', function ($id, Request $request) {
        $postulation = Postulation::findOrFail($id);
        $user = $request->user();
        if ($user->role_id === 3) {
            $etu = \App\Models\Etudiant::where('user_id', $user->id)->firstOrFail();
            abort_if($postulation->etu_id !== $etu->id, 403);
        } elseif ($user->role_id === 2) {
            $ent = Entreprise::where('user_id', $user->id)->firstOrFail();
            abort_if(!$ent->offres->pluck('id')->contains($postulation->offre_id), 403);
        } else {
            abort(403);
        }
        $postulation->update(['archived' => !$postulation->archived]);
        return back()->with('success', $postulation->archived ? 'Candidature archivée.' : 'Candidature désarchivée.');
    })->name('postulation.archiver');
});

Route::patch('/settings/two-factor', [AuthController::class, 'toggleTwoFactor'])->middleware('auth')->name('settings.two-factor');

Route::get('/two-factor', [AuthController::class, 'twoFactorShow'])->name('two-factor.show');
Route::post('/two-factor/verify', [AuthController::class, 'twoFactorVerify'])->name('two-factor.verify');
Route::post('/two-factor/resend', [AuthController::class, 'twoFactorResend'])->name('two-factor.resend');

Route::middleware('auth')->group(function () {
    Route::post('/postulation/{id}/commentaire', function ($id, Request $request) {
        $request->validate(['body' => 'required|string|max:1000']);
        $postulation = Postulation::findOrFail($id);
        $user = $request->user();

        if ($user->role_id === 3) {
            $etu = \App\Models\Etudiant::where('user_id', $user->id)->firstOrFail();
            abort_if($postulation->etu_id !== $etu->id, 403);
        } elseif ($user->role_id === 2) {
            $ent = Entreprise::where('user_id', $user->id)->firstOrFail();
            abort_if(!$ent->offres->pluck('id')->contains($postulation->offre_id), 403);
        }
        abort_if($postulation->state !== 3, 403);

        \App\Models\PostulationCommentaire::create([
            'postulation_id' => $id,
            'user_id'        => $user->id,
            'body'           => $request->body,
        ]);
        return back()->with('success', 'Commentaire ajouté.');
    })->name('commentaire.store');

    Route::delete('/commentaire/{id}', function ($id, Request $request) {
        $comment = \App\Models\PostulationCommentaire::findOrFail($id);
        abort_if($comment->user_id !== $request->user()->id, 403);
        $comment->delete();
        return back();
    })->name('commentaire.delete');
});

Route::get('/forgot-password', fn() => inertia('ForgotPassword'))->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
Route::get('/reset-password/{token}', fn($token) => inertia('ResetPassword', ['token' => $token]))->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

Route::middleware(['auth', 'role:1'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin');
    Route::delete('/admin/user/{id}', [AdminController::class, 'deleteUser'])->name('admin.delete');
    Route::patch('/admin/user/{id}/role', [AdminController::class, 'changeRole'])->name('admin.role');
    Route::delete('/admin/offre/{id}', [AdminController::class, 'deleteOffre'])->name('admin.offre.delete');
});

Route::get('/offre/{id}', function ($id, Request $request) {
    $offre = Offre::with('entreprise')->findOrFail($id);
    $competences = \App\Models\Competence::all();
    $domaines = \App\Models\Domaine::all();
    $links_competences = Offre_Competence::where('offre_id', $id)->get();
    $links_domaines = Offre_Domaine::where('offre_id', $id)->get();

    $user = $request->user();
    $etudiant = null;
    $dejaPostule = false;
    if ($user && $user->role_id === 3) {
        $etudiant = \App\Models\Etudiant::where('user_id', $user->id)->first();
        if ($etudiant) {
            $dejaPostule = Postulation::where('offre_id', $id)->where('etu_id', $etudiant->id)->exists();
        }
    }

    return Inertia::render('OffreDetail', [
        'offre'              => $offre,
        'entreprise'         => $offre->entreprise,
        'competences'        => $competences,
        'domaines'           => $domaines,
        'links_competences'  => $links_competences,
        'links_domaines'     => $links_domaines,
        'etudiant'           => $etudiant,
        'dejaPostule'        => $dejaPostule,
    ]);
})->middleware('auth')->name('offre.detail');

Route::get('/getNomOffre/{id}',function ($id) {
    $offre = Offre::find($id);
    
    return response()->json([
        'nom' => $offre->nom
    ]);
})->middleware('auth');