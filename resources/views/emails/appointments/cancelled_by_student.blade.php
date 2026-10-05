<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Annulation de votre rendez-vous</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333; line-height: 1.6; background-color: #f8fafc; padding: 20px 0;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 30px; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
        
        <h2 style="color: #dc2626; margin-top: 0;">Annulation de votre rendez-vous</h2>

        <p>Bonjour <strong>{{ $rendezvous->etudiant->name ?? 'Étudiant' }}</strong>,</p>

        <p>Nous vous confirmons que votre rendez-vous sur <strong>SchoolRDV</strong> a bien été annulé à votre demande.</p>

        <div style="background-color: #fef2f2; padding: 18px; border-radius: 8px; margin: 25px 0; border-left: 4px solid #ef4444;">
            <p style="margin: 6px 0;">
                <strong>Date & Heure :</strong> 
                {{ \Carbon\Carbon::parse($rendezvous->disponibilite->date ?? $rendezvous->disponibilite->date_disponibilite)->format('d/m/Y') }} 
                à {{ \Carbon\Carbon::parse($rendezvous->disponibilite->heure_debut)->format('H:i') }}
            </p>
            @if($rendezvous->agent)
                <p style="margin: 6px 0;"><strong>Agent / Service :</strong> {{ $rendezvous->agent->name }}</p>
            @endif
        </div>

        <p>Vous pouvez à tout moment reprendre un nouveau créneau disponible depuis votre espace étudiant.</p>

    </div>
</body>
</html>