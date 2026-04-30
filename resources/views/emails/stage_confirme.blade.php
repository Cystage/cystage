@component('mail::message')
# Stage confirmé par l'étudiant

L'étudiant a confirmé sa participation pour votre offre **{{ $postulation->offre->nom }}**.

**Stagiaire :** {{ $postulation->etudiant->prenom }} {{ $postulation->etudiant->nom }}
**N° étudiant :** {{ $postulation->etudiant->num_etudiant }}

Vous pouvez le contacter pour préparer son arrivée.

@component('mail::button', ['url' => config('app.url') . '/postulation'])
Voir les candidatures
@endcomponent

@endcomponent
