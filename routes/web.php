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
use App\Models\Domaine;
use Illuminate\Http\Request;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'offres' => Offre::latest()->get(),
        'competences' => Competence::latest()->get(),
        'domaines' => Domaine::latest()->get(),
        'links_offres_competences' => Offre_Competence::latest()->get(),
        'links_offres_domaines' => Offre_Domaine::latest()->get(),
        'entreprises' => Entreprise::latest()->get()
    ]);
})->name('home');

Route::post('/offre', [OffreController::class, 'poste'])->name('links.offre');

Route::post('/entreprise', [EntrepriseController::class, 'poste'])->name('links.entreprise');

Route::post('/domaine', [DomaineController::class, 'poste'])->name('links.domaine');

Route::post('/competence', [CompetenceController::class, 'poste'])->name('links.competence');

Route::post('/offre_domaine', [Offre_DomaineController::class, 'poste'])->name('links.offre_domaine');

Route::post('/offre_competence', [Offre_CompetenceController::class, 'poste'])->name('links.offre_competence');

Route::get('/profil', function (Request $request) {
    $user = $request->user();
    $fullName = trim((string) ($user?->name ?? ''));
    $parts = $fullName !== '' ? preg_split('/\s+/', $fullName) : [];

    return Inertia::render('Profile', [
        'profile' => [
            'nom' => isset($parts[1]) ? implode(' ', array_slice($parts, 1)) : null,
            'prenom' => $parts[0] ?? null,
            'date_naissance' => $user?->date_naissance,
            'numero_tel' => $user?->numero_tel ?? $user?->telephone ?? $user?->phone,
            'adresse' => $user?->adresse,
            'email' => $user?->email,
            'num_etudiant' => $user?->num_etudiant,
            'annee_etude' => $user?->annee_etude,
        ],
    ]);
})->middleware('auth')->name('profile');

Route::redirect('/progil', '/profil');

Route::get('/register', fn() => inertia('Register'))->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');