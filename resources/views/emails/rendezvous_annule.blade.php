<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rendez-vous annulé</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333; line-height: 1.6;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e2e8f0; border-radius: 8px;">
        <h2>Bonjour {{ $rendezvous->etudiant->name ?? 'Étudiant' }},</h2>

        <p>Nous vous informons que votre rendez-vous sur <strong>SchoolRDV</strong> a été annulé par l'administration.</p>

        <div style="background-color: #f7fafc; padding: 15px; border-radius: 5px; margin: 20px 0;">
            <p style="margin: 5px 0;">
                <strong>Date & Heure :</strong> 
                {{ \Carbon\Carbon::parse($rendezvous->disponibilite->date ?? $rendezvous->disponibilite->date_disponibilite)->format('d/m/Y') }} 
                à {{ \Carbon\Carbon::parse($rendezvous->disponibilite->heure_debut)->format('H:i') }}
            </p>
            @if($rendezvous->motif)
                <p style="margin: 5px 0;"><strong>Motif :</strong> {{ $rendezvous->motif }}</p>
            @endif
        </div>

        <p>Vous pouvez vous connecter à votre espace pour reprendre un autre créneau.</p>

    </div>
</body>
</html>