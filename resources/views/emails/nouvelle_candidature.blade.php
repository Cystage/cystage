@component('mail::message')
# Nouvelle candidature reçue

Vous avez reçu une nouvelle candidature pour votre offre **{{ $postulation->offre->nom }}**.

**Candidat :** {{ $postulation->etudiant->prenom }} {{ $postulation->etudiant->nom }}
**N° étudiant :** {{ $postulation->etudiant->num_etudiant }}

Connectez-vous à CyStage pour consulter la lettre de motivation et le CV joint.

@component('mail::button', ['url' => config('app.url') . '/postulation'])
Voir la candidature
@endcomponent

@endcomponent
