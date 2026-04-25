<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Etudiant;
use App\Models\Entreprise;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

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
            'email' => $validated['prenom'].'.'.$validated['nom'].'@etu.cyu.fr',
            'password' => Hash::make($validated['password']),
            'role_id' => 3
        ]);

        Etudiant::create([
            'nom' => $validated['nom'],
            'prenom' => $validated['prenom'],
            'user_id' => $user->id,
            'num_etudiant' => $validated['num_etudiant']
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect('/');
    }

    public function newent(Request $request)
    {
        $validated = $request->validate([
            'nom'         => 'required|string|max:255',
            'siret'       => 'required|string|max:255',
            'adresse'     => 'required|string|max:255',
            'code_postal' => 'required|string|max:255',
            'ville'       => 'required|string|max:255',
            'pays'        => 'required|string|max:255',
            'password'    => 'required|min:8|confirmed',
            'num_tel'     => 'required|digits:10',
        ]);

        $domain = explode('@', $validated['nom'] . '.com')[0];
        $logo = "https://img.logo.dev/{$domain}.com?token=TON_TOKEN_ICI";

        $user = User::create([
            'name'     => 'ent-' . $validated['nom'],
            'email'    => $validated['nom'] . '@ent.test',
            'password' => Hash::make($validated['password']),
            'role_id'  => 2,
        ]);

        Entreprise::create([
            'nom'         => $validated['nom'],
            'siret'       => $validated['siret'],
            'adresse'     => $validated['adresse'],
            'code_postal' => $validated['code_postal'],
            'ville'       => $validated['ville'],
            'pays'        => $validated['pays'],
            'user_id'     => $user->id,
            'num_tel'     => $validated['num_tel'],
            'logo'        => $logo,
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

    public function updateProfil(Request $request)
    {
        $user = $request->user();

        if ($user->role_id == 3) {
            $validated = $request->validate([
                'nom'          => 'required|string|max:255',
                'prenom'       => 'required|string|max:255',
                'num_etudiant' => 'required|min:8|max:8',
            ]);

            $etud = Etudiant::where('user_id', $user->id)->first();
            $etud->update([
                'nom'          => $validated['nom'],
                'prenom'       => $validated['prenom'],
                'num_etudiant' => $validated['num_etudiant'],
            ]);

            // Met à jour le name du user aussi
            $user->update([
                'name' => 'e-' . $validated['prenom'][0] . $validated['nom'],
            ]);
        }

        if ($user->role_id == 2) {
            $validated = $request->validate([
                'nom'         => 'required|string|max:255',
                'siret'       => 'required|string|max:255',
                'adresse'     => 'required|string|max:255',
                'code_postal' => 'required|string|max:255',
                'ville'       => 'required|string|max:255',
                'pays'        => 'required|string|max:255',
                'num_tel'     => 'required|digits:10',
                'logo'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            ]);

            $ent = Entreprise::where('user_id', $user->id)->first();
            $data = collect($validated)->except('logo')->toArray();
            
            if ($request->hasFile('logo')) {
                if ($ent->logo) {
                    \Storage::disk('public')->delete($ent->logo);
                }
                $data['logo'] = $request->file('logo')->store('logos', 'public');
            }
            $ent->update($data);
        }

        return redirect('/profil')->with('success', 'Profil mis à jour !');
    }

    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $status = Password::sendResetLink($request->only('email'));
        if ($status === Password::RESET_LINK_SENT) {
           return back()->with('success', 'Un lien de réinitialisation a été envoyé à votre adresse email.');
        }
        return back()->withErrors(['email' => __($status)]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill(['password' => Hash::make($password)])
                    ->setRememberToken(Str::random(60));
                $user->save();
                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect('/login')->with('success', 'Mot de passe réinitialisé avec succès !');
        }

        return back()->withErrors(['email' => __($status)]);
    }


}