<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #f8fafc; color: #334155; margin: 0; padding: 20px; }
        .card { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden; }
        .header { background-color: #059669; padding: 24px; text-align: center; color: #ffffff; }
        .content { padding: 30px; }
        .field { margin-bottom: 16px; }
        .label { font-size: 12px; font-weight: bold; color: #64748b; text-transform: uppercase; }
        .value { font-size: 15px; color: #0f172a; font-weight: 500; margin-top: 4px; }
        .message-box { background: #f8fafc; border-left: 4px solid #059669; padding: 16px; margin-top: 20px; border-radius: 4px; }
    </style>
</head>
<body>
    <div class="card">
        <div class="header">
            <h2 style="margin:0; font-size: 20px;">SchoolRDV - Nouveau Message</h2>
        </div>
        <div class="content">
            <div class="field">
                <div class="label">Nom complet</div>
                <div class="value">{{ $data['nom'] }}</div>
            </div>
            <div class="field">
                <div class="label">Adresse Email</div>
                <div class="value">{{ $data['email'] }}</div>
            </div>
            <div class="field">
                <div class="label">Sujet</div>
                <div class="value">{{ $data['sujet'] }}</div>
            </div>
            <div class="field">
                <div class="label">Message</div>
                <div class="message-box">
                    {!! nl2br(e($data['message'])) !!}
                </div>
            </div>
        </div>
    </div>
</body>
</html>