<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SchoolRDV - Plateforme officielle de prise de rendez-vous</title>

    <!-- Google Fonts & Tailwind CSS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html {
            scroll-behavior: smooth;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 font-sans antialiased min-h-screen flex flex-col justify-between">

    <!-- En-tête / Navigation -->
    <header class="bg-white/90 backdrop-blur-md border-b border-slate-200/80 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">

            <!-- Logo + Nom de la plateforme (Gauche) -->
            <a href="/" class="flex items-center space-x-3 group">
                <img src="{{ asset('images/logo.png') }}" alt="Logo SchoolRDV" class="h-11 w-auto object-contain">
                <span class="text-2xl font-extrabold tracking-tight text-slate-900 group-hover:text-blue-600 transition">
                    School<span class="text-blue-600">RDV</span>
                </span>
            </a>

            <!-- Bloc regroupé à droite (Nos Services, À propos, Connexion, S'inscrire) -->
            <div class="flex items-center space-x-6 sm:space-x-8">

                <!-- Liens de navigation -->
                <nav class="hidden md:flex items-center space-x-6 font-semibold text-slate-600">
                    <a href="#services" class="hover:text-blue-600 transition">Nos Services</a>
                    <a href="#a-propos" class="hover:text-blue-600 transition">À propos</a>
                </nav>

                <!-- Boutons d'authentification -->
                <div class="flex items-center space-x-3">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ auth()->user()->role === 'agent' ? route('agent.dashboard') : (auth()->user()->role === 'admin' ? route('admin.dashboard') : route('etudiant.rendezvous.index')) }}"
                               class="px-6 py-2.5 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 shadow-md shadow-blue-500/20 transition">
                                Mon Espace
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="px-5 py-2.5 text-slate-700 font-semibold hover:text-blue-600 transition">
                                Connexion
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-6 py-2.5 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 shadow-md shadow-blue-500/20 transition">
                                    S'inscrire
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>

            </div>

        </div>
    </header>

    <!-- Contenu Principal -->
    <main class="flex-grow">

        <!-- Hero Section -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
            <div class="grid lg:grid-cols-12 gap-12 items-center">

                <!-- Textes de présentation (Gauche) -->
                <div class="lg:col-span-6 space-y-6">
                    <div class="inline-flex items-center space-x-2 px-4 py-1.5 rounded-full bg-blue-50 border border-blue-100 text-blue-700 text-xs font-extrabold uppercase tracking-wider">
                        <span>Plateforme officielle de prise de rendez-vous</span>
                    </div>

                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 leading-[1.15] tracking-tight">
                        Prenez rendez-vous avec vos services scolaires
                        <span class="text-slate-900">en quelques clics.</span>
                    </h1>

                    <p class="text-base sm:text-lg text-slate-600 leading-relaxed max-w-xl">
                        Fini les files d'attente interminables. Réservez un créneau avec le secrétariat, la comptabilité ou la scolarité directement depuis votre espace personnel.
                    </p>

                    <div class="flex flex-wrap items-center gap-4 pt-4">
                        @auth
                            <a href="{{ route('etudiant.rendezvous.index') }}"
                               class="px-8 py-3.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg shadow-blue-500/20 transition">
                                Accéder à mes rendez-vous
                            </a>
                        @else
                            <a href="{{ route('register') }}"
                               class="px-8 py-3.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg shadow-blue-500/20 transition">
                                Créer un compte
                            </a>

                            <a href="{{ route('login') }}"
                               class="px-8 py-3.5 bg-white border border-slate-900 text-slate-900 font-bold rounded-xl hover:bg-slate-50 transition">
                                Se connecter
                            </a>
                        @endauth
                    </div>
                </div>

                <!-- Carte d'Aperçu / Visualisation (Droite) -->
                <div class="lg:col-span-6 flex justify-center">
                    <div class="w-full max-w-lg bg-white rounded-3xl shadow-xl shadow-slate-200/60 border border-slate-100 p-8 sm:p-10 flex flex-col items-center text-center">
                        <div class="mb-6 p-4 bg-slate-50 rounded-2xl w-full flex justify-center items-center">
                            <img src="{{ asset('images/logo.png') }}" alt="SchoolRDV Logo" class="max-h-48 w-auto object-contain">
                        </div>

                        <h2 class="text-2xl font-extrabold text-slate-900 mb-2">
                            Simplifiez vos démarches
                        </h2>

                        <p class="text-slate-500 text-sm leading-relaxed max-w-xs mb-8">
                            Une gestion fluide de votre emploi du temps et une prise de rendez-vous en temps réel.
                        </p>

                        <!-- Étapes du processus -->
                        <div class="grid grid-cols-3 gap-2 w-full pt-2">
                            <div class="bg-blue-50/70 text-blue-700 font-semibold text-xs py-3 px-2 rounded-xl text-center border border-blue-100/60">
                                1. Choisir le service
                            </div>

                            <div class="bg-blue-50/70 text-blue-700 font-semibold text-xs py-3 px-2 rounded-xl text-center border border-blue-100/60">
                                2. Choisir l'heure
                            </div>

                            <div class="bg-blue-50/70 text-blue-700 font-semibold text-xs py-3 px-2 rounded-xl text-center border border-blue-100/60">
                                3. Confirmation
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- SECTION À PROPOS -->
        <section id="a-propos" class="py-16 bg-white border-t border-slate-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl font-extrabold text-slate-900 mb-4">À propos de SchoolRDV</h2>
                <p class="text-slate-600 max-w-3xl mx-auto leading-relaxed">
                    SchoolRDV est la solution numérique conçue pour simplifier l'organisation des rendez-vous au sein de l'établissement. Elle permet aux étudiants de réserver un créneau avec les différents services administratifs et pédagogiques en toute autonomie.
                </p>
            </div>
        </section>

        <!-- SECTION SERVICES -->
        <section id="services" class="py-16 bg-slate-50 border-t border-slate-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-extrabold text-center text-slate-900 mb-8">
                    Nos Services Disponibles
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @php
                        $servicesList = [
                            ['id' => 1, 'titre' => 'Service Pédagogique', 'icon' => '📚', 'desc' => 'Questions sur les cours, inscriptions et examens.'],
                            ['id' => 2, 'titre' => 'Support Technique', 'icon' => '💻', 'desc' => 'Problèmes d\'accès aux plateformes et identifiants.'],
                            ['id' => 3, 'titre' => 'Service Administratif', 'icon' => '📄', 'desc' => 'Attestations, certificats de scolarité et dossiers.'],
                            ['id' => 4, 'titre' => 'Service Commercial', 'icon' => '💳', 'desc' => 'Informations sur les frais de scolarité et règlements.']
                        ];
                    @endphp

                    @foreach($servicesList as $service)
                        <a href="{{ auth()->check() ? route('etudiant.rendezvous.index', ['service_id' => $service['id']]) : route('login', ['service_id' => $service['id']]) }}"
                           class="block p-6 bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all transform hover:-translate-y-1 border border-slate-100">
                            <div class="text-4xl mb-4">{{ $service['icon'] }}</div>
                            <h3 class="text-xl font-bold text-slate-800 mb-2">{{ $service['titre'] }}</h3>
                            <p class="text-slate-600 text-sm mb-4">{{ $service['desc'] }}</p>
                            <span class="inline-flex items-center text-sm font-semibold text-blue-600">
                                Réserver un créneau &rarr;
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>

    </main>

    <!-- FOOTER -->
    <footer class="bg-slate-900 text-slate-400 py-16 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid md:grid-cols-3 gap-12">
            <div class="space-y-4">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo SchoolRDV" class="h-10 w-auto object-contain">
                    <span class="text-2xl font-extrabold text-white tracking-tight">
                        School<span class="text-blue-500">RDV</span>
                    </span>
                </div>
                <p class="text-sm leading-relaxed text-slate-400">
                    Solution officielle de prise de rendez-vous pour optimiser la gestion du temps et l'accueil des usagers au sein de l'établissement.
                </p>
                <p class="text-xs text-slate-500 pt-2">
                    © {{ date('Y') }} SchoolRDV. Tous droits réservés.
                </p>
            </div>

            <div>
                <h4 class="text-white font-bold text-sm uppercase tracking-wider mb-4">
                    Navigation
                </h4>
                <ul class="space-y-3 text-sm">
                    <li><a href="{{ route('login') }}" class="hover:text-white transition">Connexion</a></li>
                    <li><a href="{{ route('register') }}" class="hover:text-white transition">Créer un compte</a></li>
                    <li><a href="#services" class="hover:text-white transition">Nos 4 Services</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-white font-bold text-sm uppercase tracking-wider mb-4">
                    Protection des Données (RGPD)
                </h4>
                <p class="text-xs leading-relaxed text-slate-400 mb-4">
                    Conformément au Règlement Général sur la Protection des Données (RGPD), vos données sont traitées uniquement pour l'organisation de vos rendez-vous.
                </p>
                <a href="{{ route('politique.confidentialite') }}" class="inline-flex items-center text-blue-400 hover:text-blue-300 text-xs font-bold transition">
                    <span>Consulter la Politique de Confidentialité & RGPD</span>
                    <span class="ml-1">&rarr;</span>
                </a>
            </div>
        </div>
    </footer>

    <!-- Script JavaScript Natif pour confirmation -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const confirmButtons = document.querySelectorAll('.btn-confirm-action');
            confirmButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    if (!confirm('Êtes-vous sûr de vouloir effectuer cette action ?')) {
                        e.preventDefault();
                    }
                });
            });
        });
    </script>

</body>
</html>