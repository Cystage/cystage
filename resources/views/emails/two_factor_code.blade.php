@component('mail::message')
# Votre code de vérification

Utilisez ce code pour finaliser votre connexion à CyStage.

@component('mail::panel')
# {{ $user->two_factor_code }}
@endcomponent

Ce code expire dans **5 minutes**. Ne le partagez avec personne.

Si vous n'avez pas tenté de vous connecter, ignorez cet email.

@endcomponent
