@component('mail::message')
# Bonne nouvelle !

Votre candidature pour **{{ $postulation->offre->nom }}** a été acceptée par **{{ $postulation->offre->entreprise->nom }}**.

**Durée :** {{ $postulation->offre->nb_week }} semaines

Rendez-vous sur CyStage pour confirmer votre participation et finaliser votre stage.

@component('mail::button', ['url' => config('app.url') . '/profil'])
Confirmer mon stage
@endcomponent

@endcomponent
