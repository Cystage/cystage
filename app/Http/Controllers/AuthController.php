<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

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
            'nom'                  => 'required|string|max:255',
            'prenom'               => 'required|string|max:255',
            'email'                => 'required|email|unique:users,email',
            'password'             => 'required|min:8|confirmed',
            'num_tel'              => 'required|string',
            'adresse'              => 'required|string',
            'date_de_naissance'    => 'required|date',
        ]);

        $user = User::create([
            'name'           => $validated['prenom'] . ' ' . $validated['nom'],
            'email'          => $validated['email'],
            'password'       => Hash::make($validated['password']),
            'numero_tel'     => $validated['num_tel'], 
            'adresse'        => $validated['adresse'],
            'date_naissance' => $validated['date_de_naissance'], 
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