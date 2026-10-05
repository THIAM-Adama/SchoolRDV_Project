<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Confirmation de rendez-vous</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333; line-height: 1.6;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e2e8f0; border-radius: 8px;">
        <h2 style="color: #059669;">Rendez-vous confirmé !</h2>

        <p>Bonjour {{ $rendezvous->etudiant->name ?? 'Étudiant' }},</p>

        <p>Votre réservation sur <strong>SchoolRDV</strong> a bien été enregistrée.</p>

        <div style="background-color: #f0fdf4; padding: 15px; border-radius: 5px; margin: 20px 0; border-left: 4px solid #10b981;">
            <p style="margin: 5px 0;">
                <strong>Date & Heure :</strong> 
                {{ \Carbon\Carbon::parse($rendezvous->disponibilite->date ?? $rendezvous->disponibilite->date_disponibilite)->format('d/m/Y') }} 
                à {{ \Carbon\Carbon::parse($rendezvous->disponibilite->heure_debut)->format('H:i') }}
            </p>
            @if($rendezvous->agent)
                <p style="margin: 5px 0;"><strong>Agent / Service :</strong> {{ $rendezvous->agent->name }}</p>
            @endif
            @if($rendezvous->motif)
                <p style="margin: 5px 0;"><strong>Motif :</strong> {{ $rendezvous->motif }}</p>
            @endif
        </div>

        <p>Vous pouvez consulter vos rendez-vous ou annuler à tout moment depuis votre espace étudiant.</p>

    </div>
</body>
</html>