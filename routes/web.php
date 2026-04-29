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
use App\Http\Controllers\AdminController;

Route::get('/', function (Request $request) {
    if ($request->user()) {
        $user = $request->user();
        if($user->role_id==3){
            $etu = Etudiant::where('user_id',$user->id)->first();
            return Inertia::render('Welcome', [
                'offres' => Offre::latest()->get(),
                'competences' => Competence::latest()->get(),
                'domaines' => Domaine::latest()->get(),
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

Route::post('/offre', [OffreController::class, 'poste'])->middleware(['auth', 'role:2'])->name('links.offre');

Route::post('/domaine', [DomaineController::class, 'poste'])->middleware(['auth', 'role:1'])->name('links.domaine');

Route::post('/competence', [CompetenceController::class, 'poste'])->middleware(['auth', 'role:1'])->name('links.competence');

Route::post('/offre_domaine', [Offre_DomaineController::class, 'poste'])->middleware(['auth', 'role:2'])->name('links.offre_domaine');

Route::post('/offre_competence', [Offre_CompetenceController::class, 'poste'])->middleware(['auth', 'role:2'])->name('links.offre_competence');

Route::get('/profil', function (Request $request) {
    $user = $request->user();
    if($user->role_id==3){
        $etud = Etudiant::where('user_id',$user->id)->first();
        $postulations = Postulation::whereIn('etu_id',[$etud->id])
            ->with(['etudiant', 'offre']) 
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
            ],
            'postulations' => $postulations,
        ]);
    }
    if($user->role_id==2){
        $ent = Entreprise::where('user_id',$user->id)->first();
        $offreIds = $ent->offres->pluck('id');
        $postulations = Postulation::whereIn('offre_id',$offreIds)
        ->with(['etudiant', 'offre']) 
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
            ->with(['etudiant', 'offre']) 
            ->latest()
            ->get();

        return Inertia::render('EntreprisePostulation', [
            'postulations' => $postulations
        ]);
    }
    
    return redirect('/');
})->middleware('auth')->name('postulation');

Route::delete('/postulation/{id}', function ($id) {
    $postulation = Postulation::findOrFail($id);
    if ($postulation->path && Storage::disk('public')->exists($postulation->path)) {
        Storage::disk('public')->delete($postulation->path);
    }
    $postulation->delete();
    return back()->with('success', 'delete');
})->middleware('auth');


Route::post('/accepte/{id}', [PostulationController::class, 'accepte'])->middleware(['auth', 'role:2'])->name('accepte');

Route::post('/profil', [AuthController::class, 'updateProfil'])->middleware('auth')->name('profil.update');

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

Route::get('/getNomOffre/{id}',function ($id) {
    $offre = Offre::find($id);
    
    return response()->json([
        'nom' => $offre->nom
    ]);
})->middleware('auth');