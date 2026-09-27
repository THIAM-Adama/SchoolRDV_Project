<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #f4f6f9; color: #333; margin: 0; padding: 20px; }
        .card { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 12px; border: 1px solid #e5e7eb; overflow: hidden; }
        .header { background-color: #4f46e5; padding: 24px; text-align: center; color: #ffffff; }
        .content { padding: 30px; }
        .field { margin-bottom: 16px; }
        .label { font-size: 12px; font-weight: bold; color: #6b7280; text-transform: uppercase; }
        .value { font-size: 15px; color: #111827; font-weight: 500; margin-top: 4px; }
        .message-box { background: #f9fafb; border-left: 4px solid #4f46e5; padding: 16px; margin-top: 20px; border-radius: 4px; }
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