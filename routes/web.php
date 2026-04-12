<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OffreController;
use App\Http\Controllers\AuthController;
use Inertia\Inertia;
use App\Models\Offre;
use Illuminate\Http\Request;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'offres' => Offre::latest()->get() 
    ]);
})->name('home');

Route::post('/offre', [OffreController::class, 'poste'])->name('links.offre');

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