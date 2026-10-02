<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SchoolRDV - Authentification</title>

    <!-- Google Fonts & Tailwind -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex">

    <div class="flex flex-col lg:flex-row w-full min-h-screen">
        
        <!-- Panneau de gauche (Branding & Présentation) -->
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-blue-900 via-blue-800 to-indigo-900 text-white p-12 flex-col justify-between relative overflow-hidden">
            <!-- Cercles décoratifs en arrière-plan -->
            <div class="absolute -top-24 -left-24 w-96 h-96 bg-blue-500/20 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-indigo-500/20 rounded-full blur-3xl"></div>

            <!-- Header du panneau -->
            <div class="relative z-10">
                <a href="/" class="flex items-center space-x-3">
                    <img src="{{ asset('images/logo.png') }}" alt="SchoolRDV Logo" class="h-12 w-auto bg-white/10 p-2 rounded-xl backdrop-blur-md">
                    <span class="text-3xl font-extrabold tracking-tight">
                        School<span class="text-blue-400">RDV</span>
                    </span>
                </a>
            </div>

            <!-- Contenu central -->
            <div class="relative z-10 max-w-lg space-y-6 my-auto">
                <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-blue-500/20 border border-blue-400/30 text-blue-200 text-xs font-semibold uppercase tracking-wider">
                    ⚡ Espace Sécurisé
                </div>
                <h1 class="text-4xl font-extrabold leading-tight">
                    Gérez vos rendez-vous scolaires en toute simplicité.
                </h1>
                <p class="text-blue-100/80 text-lg leading-relaxed">
                    Connectez-vous pour accéder à vos créneaux, échanger avec les services administratifs et suivre vos démarches en temps réel.
                </p>
                <div class="pt-4 grid grid-cols-2 gap-4 text-sm font-medium text-blue-100">
                    <div class="flex items-center space-x-2">
                        <span class="text-blue-400">✓</span>
                        <span>Prise de RDV instantanée</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="text-blue-400">✓</span>
                        <span>Notifications & Rappels</span>
                    </div>
                </div>
            </div>

            <!-- Footer du panneau -->
            <div class="relative z-10 text-xs text-blue-300/60">
                © {{ date('Y') }} SchoolRDV. Plateforme officielle de l'établissement.
            </div>
        </div>

        <!-- Panneau de droite (Formulaire) -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12 bg-white">
            <div class="w-full max-w-md space-y-8">
                {{ $slot }}
            </div>
        </div>

    </div>

</body>
</html>