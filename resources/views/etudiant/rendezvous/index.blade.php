<x-app-layout>
    <div class="py-8 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- En-tête de la page -->
            <div class="mb-6">
                <h1 class="text-3xl font-extrabold text-slate-900">Prendre un rendez-vous</h1>
                <p class="text-slate-600 mt-1">Sélectionnez un service puis choisissez un créneau disponible.</p>
            </div>

            <!-- MESSAGES DE NOTIFICATION (Succès / Erreur) -->
            @if (session('success'))
                <div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-800 p-4 mb-6 rounded-r-xl shadow-sm">
                    <p class="font-bold">Succès</p>
                    <p class="text-sm">{{ session('success') }}</p>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-amber-50 border-l-4 border-amber-500 text-amber-900 p-4 mb-6 rounded-r-xl shadow-sm">
                    <div class="flex items-center gap-2 font-bold text-amber-800">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <span>Information importante</span>
                    </div>
                    <p class="text-sm mt-1 leading-relaxed">{{ session('error') }}</p>
                </div>
            @endif

            <!-- FILTRE PAR SERVICE -->
            <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-200 mb-8">
                <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-500 mb-3">
                    Filtrer par service :
                </label>

                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('etudiant.rendezvous.index') }}" 
                       class="px-4 py-2 rounded-xl text-sm font-semibold transition {{ empty($selectedServiceId ?? null) ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                        Tous les services
                    </a>

                    @foreach($services as $service)
                        <a href="{{ route('etudiant.rendezvous.index', ['service_id' => $service->id]) }}" 
                           class="px-4 py-2 rounded-xl text-sm font-semibold transition {{ ($selectedServiceId ?? null) == $service->id ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                            {{ $service->nom }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- LISTE DES CRÉNEAUX -->
            @if($disponibilites->isEmpty())
                <div class="bg-white rounded-2xl p-12 text-center border border-slate-200 shadow-sm">
                    <div class="text-4xl mb-3">📅</div>
                    <h3 class="text-lg font-bold text-slate-800">Aucun créneau disponible</h3>
                    <p class="text-slate-500 text-sm mt-1">
                        @if(!empty($selectedServiceId ?? null))
                            Aucun créneau disponible pour ce service pour le moment.
                        @else
                            Aucun créneau libre pour le moment. Veuillez réessayer ultérieurement.
                        @endif
                    </p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($disponibilites as $dispo)
                        @php
                            $agentServiceId = $dispo->agent->service_id ?? null;
                            $existingRdvForService = $mesRendezvous->first(function($rdv) use ($agentServiceId) {
                                return in_array($rdv->statut, ['confirme', 'en_attente']) && optional($rdv->agent)->service_id == $agentServiceId;
                            });
                        @endphp

                        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition p-6 flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between mb-4">
                                    <span class="px-3 py-1 bg-blue-50 border border-blue-100 text-blue-700 text-xs font-bold rounded-lg">
                                        {{ $dispo->agent->service->nom ?? 'Service Général' }}
                                    </span>
                                    <span class="text-xs font-semibold text-slate-500 flex items-center gap-1">
                                        👤 Agent : <strong class="text-slate-800">{{ $dispo->agent->nom ?? $dispo->agent->name }}</strong>
                                    </span>
                                </div>

                                <div class="space-y-1 mb-4">
                                    <div class="text-lg font-extrabold text-slate-900 flex items-center gap-2">
                                        📅 {{ \Carbon\Carbon::parse($dispo->date_disponibilite ?? $dispo->date)->format('d/m/Y') }}
                                    </div>
                                    <div class="text-sm font-semibold text-blue-600 flex items-center gap-2">
                                        ⏰ {{ \Carbon\Carbon::parse($dispo->heure_debut)->format('H:i') }} - {{ \Carbon\Carbon::parse($dispo->heure_fin)->format('H:i') }}
                                    </div>
                                </div>

                                @if($existingRdvForService)
                                    <!-- Si l'étudiant a déjà un RDV actif sur ce service : Option Déplacer -->
                                    <form action="{{ route('etudiant.rendezvous.deplacer', $existingRdvForService->id) }}" method="POST" class="space-y-3" onsubmit="return confirm('Souhaitez-vous vraiment déplacer votre rendez-vous existant vers ce nouveau créneau ?');">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="nouvelle_disponibilite_id" value="{{ $dispo->id }}">

                                        <button type="submit" 
                                                class="w-full py-2.5 bg-amber-600 hover:bg-amber-700 text-white font-bold text-sm rounded-xl shadow-md shadow-amber-500/20 transition">
                                            🔄 Déplacer mon RDV vers ce créneau
                                        </button>
                                    </form>
                                @else
                                    <!-- Réservation classique -->
                                    <form action="{{ route('etudiant.rendezvous.store') }}" method="POST" class="space-y-3">
                                        @csrf
                                        <input type="hidden" name="disponibilite_id" value="{{ $dispo->id }}">
                                        
                                        <div>
                                            <textarea name="motif" rows="2" required 
                                                      placeholder="Précisez le motif de votre rendez-vous..."
                                                      class="w-full text-xs rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 p-3 bg-slate-50/50"></textarea>
                                        </div>

                                        <button type="submit" 
                                                class="w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm rounded-xl shadow-md shadow-blue-500/20 transition">
                                            Réserver ce créneau
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</x-app-layout>