<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Etudiant;
use App\Models\Entreprise;
use App\Models\AppLog;
use App\Mail\TwoFactorCode;
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

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            AppLog::log(null, 'login_failed', "Tentative de connexion échouée pour {$credentials['email']}");
            return back()->withErrors(['email' => 'Email ou mot de passe incorrect.'])->onlyInput('email');
        }

        if ($user->two_factor_enabled) {
            $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            $user->update([
                'two_factor_code'       => $code,
                'two_factor_expires_at' => now()->addMinutes(5),
            ]);
            Mail::to($user->email)->send(new TwoFactorCode($user));
            $request->session()->put('2fa_user_id', $user->id);
            AppLog::log($user->id, 'login_2fa', "Code 2FA envoyé à {$user->email}");
            return redirect('/two-factor');
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();
        AppLog::log($user->id, 'login', "Connexion de {$user->email}");
        return redirect()->intended('/');
    }

    public function twoFactorShow(Request $request)
    {
        if (!$request->session()->has('2fa_user_id')) return redirect('/login');
        return inertia('TwoFactorVerify');
    }

    public function twoFactorVerify(Request $request)
    {
        $request->validate(['code' => 'required|string|size:6']);
        $userId = $request->session()->get('2fa_user_id');
        $user   = User::findOrFail($userId);

        if ($user->two_factor_code !== $request->code || now()->isAfter($user->two_factor_expires_at)) {
            return back()->withErrors(['code' => 'Code invalide ou expiré.']);
        }

        $user->update(['two_factor_code' => null, 'two_factor_expires_at' => null]);
        $request->session()->forget('2fa_user_id');
        Auth::login($user);
        $request->session()->regenerate();
        AppLog::log($user->id, 'login', "Connexion 2FA validée pour {$user->email}");
        return redirect('/');
    }

    public function twoFactorResend(Request $request)
    {
        $userId = $request->session()->get('2fa_user_id');
        if (!$userId) return redirect('/login');
        $user = User::findOrFail($userId);
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $user->update(['two_factor_code' => $code, 'two_factor_expires_at' => now()->addMinutes(5)]);
        Mail::to($user->email)->send(new TwoFactorCode($user));
        return back()->with('success', 'Nouveau code envoyé.');
    }

    public function toggleTwoFactor(Request $request)
    {
        $user = $request->user();
        $user->update(['two_factor_enabled' => !$user->two_factor_enabled]);
        AppLog::log($user->id, 'settings', "2FA " . ($user->two_factor_enabled ? 'activée' : 'désactivée') . " pour {$user->email}");
        return back()->with('success', $user->two_factor_enabled ? 'Double authentification activée.' : 'Double authentification désactivée.');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'nom'          => 'required|string|max:255',
            'prenom'       => 'required|string|max:255',
            'num_etudiant' => 'required|min:8|max:8',
        ]);

        $prenom = strtolower($validated['prenom']);
        $nom    = strtolower($validated['nom']);
        $email  = $prenom . '.' . $nom . '@etu.cyu.fr';

        if (User::where('email', $email)->exists()) {
            return back()->withErrors(['nom' => 'Un compte existe déjà pour ' . $email . '.'])->withInput();
        }

        $user = User::create([
            'name'     => 'e-' . $prenom[0] . $nom,
            'email'    => $email,
            'password' => Hash::make(\Illuminate\Support\Str::random(32)),
            'role_id'  => 3,
        ]);

        Etudiant::create([
            'nom'          => $validated['nom'],
            'prenom'       => $validated['prenom'],
            'user_id'      => $user->id,
            'num_etudiant' => $validated['num_etudiant'],
        ]);

        \Illuminate\Support\Facades\Password::sendResetLink(['email' => $user->email]);
        AppLog::log($request->user()->id, 'register', "Nouvel étudiant créé par l'admin : {$user->email}");
        return back()->with('success', "Compte créé avec succès. L'utilisateur a reçu un mail pour définir son mot de passe.");
    }

    public function newent(Request $request)
    {
        $validated = $request->validate([
            'nom'         => 'required|string|max:255',
            'siret'       => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email',
            'adresse'     => 'required|string|max:255',
            'code_postal' => 'required|string|max:255',
            'ville'       => 'required|string|max:255',
            'pays'        => 'required|string|max:255',
            'num_tel'     => 'required|digits:10',
        ]);
        
        $domain = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $validated['nom'])) . '.com';
        $logo = "https://img.logo.dev/{$domain}?token=pk_FrA0KHUJRGyvwsX08nZ1ow";

        $user = User::create([
            'name'     => 'ent-' . $validated['nom'],
            'email'    => $validated['email'],
            'password' => Hash::make(\Illuminate\Support\Str::random(32)),
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

        \Illuminate\Support\Facades\Password::sendResetLink(['email' => $user->email]);
        AppLog::log($request->user()->id, 'register', "Nouvelle entreprise créée par l'admin : {$validated['nom']} ({$validated['email']})");
        return back()->with('success', "Compte créé avec succès. L'utilisateur a reçu un mail pour définir son mot de passe.");
    }

    public function logout(Request $request)
    {
        AppLog::log($request->user()?->id, 'logout', "Déconnexion de " . ($request->user()?->email ?? '?'));
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

            $user->update([
                'name' => 'e-' . strtolower($validated['prenom'][0]) . strtolower($validated['nom']),
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

    public function updateNotifMail(Request $request)
    {
        $request->user()->update(['notif_mail' => $request->boolean('notif_mail')]);
        return back()->with('success', 'Préférences mises à jour.');
    }

    public function deleteAccount(Request $request)
    {
        $user = $request->user();

        if ($user->role_id === 3) {
            $etu = \App\Models\Etudiant::where('user_id', $user->id)->first();
            if ($etu) {
                \App\Models\Postulation::where('etu_id', $etu->id)->each(function ($p) {
                    if ($p->path) \Storage::disk('public')->delete($p->path);
                    $p->delete();
                });
                $etu->delete();
            }
        }

        if ($user->role_id === 2) {
            $ent = \App\Models\Entreprise::where('user_id', $user->id)->first();
            if ($ent) {
                \App\Models\Offre::where('ent_id', $ent->id)->each(function ($offre) {
                    \App\Models\Offre_Competence::where('offre_id', $offre->id)->delete();
                    \App\Models\Offre_Domaine::where('offre_id', $offre->id)->delete();
                    \App\Models\Postulation::where('offre_id', $offre->id)->delete();
                    $offre->delete();
                });
                if ($ent->logo && !\Str::startsWith($ent->logo, 'http')) {
                    \Storage::disk('public')->delete($ent->logo);
                }
                $ent->delete();
            }
        }

        AppLog::log($user->id, 'delete_account', "Suppression du compte {$user->email} (rôle {$user->role_id})");
        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}