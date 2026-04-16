<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Etudiant;
use App\Models\Entreprise;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Email ou mot de passe incorrect.',
        ])->onlyInput('email');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'password' => 'required|min:8|confirmed',
            'num_etudiant' => 'required|min:8|max:8',
        ]);

        $user = User::create([
            'name' => 'e-'.$validated['prenom'][0].$validated['nom'],
            'email' => $validated['prenom'].'.'.$validated['nom'].'@etu.test',
            'password' => Hash::make($validated['password']),
            'role_id' => 3
        ]);

        $latestuser = \App\Models\User::latest()->first();

        Etudiant::create([
            'nom' => $validated['nom'],
            'prenom' => $validated['prenom'],
            'user_id' => $latestuser->id,
            'num_etudiant' => $validated['num_etudiant']
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect('/');
    }

    public function newent(Request $request)
    {

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'siret' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'code_postal' => 'required|string|max:255',
            'ville' => 'required|string|max:255',
            'pays' => 'required|string|max:255',
            'password' => 'required|min:8|confirmed',
            'num_tel' => 'required|digits:10',
        ]);

        $user = User::create([
            'name' => 'ent-'.$validated['nom'],
            'email' => $validated['nom'].'@ent.test',
            'password' => Hash::make($validated['password']),
            'role_id' => 2
        ]);

        $latestuser = \App\Models\User::latest()->first();

        Entreprise::create([
            'nom' => $validated['nom'],
            'siret' => $validated['siret'],
            'adresse' => $validated['adresse'],
            'code_postal' => $validated['code_postal'],
            'ville' => $validated['ville'],
            'pays' => $validated['pays'],
            'user_id' => $latestuser->id,
            'num_tel' => $validated['num_tel']
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect('/');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}