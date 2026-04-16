<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OffreController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EntrepriseController;
use App\Http\Controllers\CompetenceController;
use App\Http\Controllers\DomaineController;
use App\Http\Controllers\Offre_CompetenceController;
use App\Http\Controllers\Offre_DomaineController;
use Inertia\Inertia;
use App\Models\Offre_Competence;
use App\Models\Offre_Domaine;
use App\Models\Entreprise;
use App\Models\Offre;
use App\Models\Competence;
use App\Models\Etudiant;
use App\Models\Domaine;
use App\Models\Role;
use Illuminate\Http\Request;

Route::get('/', function (Request $request) {
    if ($request->user()) {
        $user = $request->user();
        if($user->role_id==3){
            return Inertia::render('Welcome', [
                'offres' => Offre::latest()->get(),
                'competences' => Competence::latest()->get(),
                'domaines' => Domaine::latest()->get(),
                'links_offres_competences' => Offre_Competence::latest()->get(),
                'links_offres_domaines' => Offre_Domaine::latest()->get(),
                'entreprises' => Entreprise::latest()->get(),
                'etudiant' => Etudiant::where('user_id',$user->id)->get(),
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
            ]);
        }
    }else{
        return Inertia::render('Welcome', [
        ]);
    }
})->name('home');

Route::post('/offre', [OffreController::class, 'poste'])->name('links.offre');

Route::post('/entreprise', [EntrepriseController::class, 'poste'])->name('links.entreprise');

Route::post('/domaine', [DomaineController::class, 'poste'])->name('links.domaine');

Route::post('/competence', [CompetenceController::class, 'poste'])->name('links.competence');

Route::post('/offre_domaine', [Offre_DomaineController::class, 'poste'])->name('links.offre_domaine');

Route::post('/offre_competence', [Offre_CompetenceController::class, 'poste'])->name('links.offre_competence');

Route::get('/profil', function (Request $request) {
    $user = $request->user();
    if($user->role_id==3){
        $etud = Etudiant::where('user_id',$user->id)->first();
        return Inertia::render('Profile', [
            'profile' => [
                'nom' => $etud->nom,
                'prenom' => $etud->prenom,
                'email' => $user->email,
                'num_etudiant' => $etud->num_etudiant,
                'identifiant' => $user->name,
                'type'=> $user->role_id,
            ],
        ]);
    }
    if($user->role_id==2){
        $ent = Entreprise::where('user_id',$user->id)->first();
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
            ],
        ]);
    }
})->middleware('auth')->name('profile');

Route::redirect('/progil', '/profil');

Route::get('/register', fn() => inertia('Register'))->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::get('/newent', fn() => inertia('NewEnt'))->name('newent');
Route::post('/newent', [AuthController::class, 'newent'])->name('newent.post');

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');