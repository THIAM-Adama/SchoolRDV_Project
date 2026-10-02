<x-mail::message>
# Annulation de votre rendez-vous

Bonjour **{{ $rendezvous->etudiant->name }}**,

Nous vous confirmons que votre rendez-vous a bien été annulé à votre demande.

**Détails du créneau annulé :**
- **Date :** {{ \Carbon\Carbon::parse($rendezvous->disponibilite->date_debut)->format('d/m/Y') }}
- **Horaires :** {{ \Carbon\Carbon::parse($rendezvous->disponibilite->date_debut)->format('H:i') }} - {{ \Carbon\Carbon::parse($rendezvous->disponibilite->date_fin)->format('H:i') }}
- **Agent concerné :** {{ $rendezvous->agent->name ?? 'Agent SchoolRDV' }}

Vous pouvez à tout moment reprendre un nouveau créneau disponible depuis votre espace.

<x-mail::button :url="config('app.url') . '/login'">
Accéder à mon espace SchoolRDV
</x-mail::button>

Cordialement,<br>
L'équipe **{{ config('app.name') }}**
</x-mail::message>