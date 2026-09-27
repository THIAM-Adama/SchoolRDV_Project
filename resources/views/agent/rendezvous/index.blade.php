<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Gestion des Rendez-vous du Service') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="p-4 bg-emerald-100 border-l-4 border-emerald-500 text-emerald-800 rounded-r-xl shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-slate-200/80">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                    <h3 class="text-lg font-bold text-slate-900">Demandes de rendez-vous récents</h3>
                    
                    <!-- Filtre par statut -->
                    <form method="GET" action="{{ route('agent.rendezvous.index') }}" class="flex items-center space-x-2">
                        <select name="statut" onchange="this.form.submit()" class="text-xs rounded-xl border-slate-200 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Tous les statuts</option>
                            <option value="confirme" {{ request('statut') === 'confirme' ? 'selected' : '' }}>Confirmé (en attente)</option>
                            <option value="termine" {{ request('statut') === 'termine' ? 'selected' : '' }}>Terminé</option>
                            <option value="absent" {{ request('statut') === 'absent' ? 'selected' : '' }}>Absent</option>
                            <option value="annule" {{ request('statut') === 'annule' ? 'selected' : '' }}>Annulé</option>
                        </select>
                    </form>
                </div>

                @if($rendezvous->isEmpty())
                    <p class="text-slate-500 text-sm py-4">Aucun rendez-vous trouvé pour votre service.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-slate-600">
                            <thead class="bg-slate-50 text-slate-700 font-semibold border-b border-slate-200">
                                <tr>
                                    <th class="p-3">Étudiant</th>
                                    <th class="p-3">Date & Heure</th>
                                    <th class="p-3">Motif</th>
                                    <th class="p-3">Statut actuel</th>
                                    <th class="p-3 text-right">Changer le statut</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($rendezvous as $rdv)
                                    <tr class="hover:bg-slate-50/50">
                                        <td class="p-3 font-bold text-slate-900">
                                            {{ $rdv->etudiant->name ?? 'Étudiant' }}
                                            <div class="text-xs font-normal text-slate-500">{{ $rdv->etudiant->email ?? '' }}</div>
                                        </td>
                                        
                                        {{-- Date & Heure du créneau réservé --}}
                                        <td class="p-3 font-medium text-slate-800">
                                            @php
                                                $dateRdv = $rdv->disponibilite->date_disponibilite ?? $rdv->disponibilite->date ?? null;
                                            @endphp
                                            @if($rdv->disponibilite && $dateRdv)
                                                {{ \Carbon\Carbon::parse($dateRdv)->format('d/m/Y') }} à 
                                                {{ \Carbon\Carbon::parse($rdv->disponibilite->heure_debut)->format('H:i') }}
                                            @else
                                                N/A
                                            @endif
                                        </td>

                                        <td class="p-3 text-xs">{{ $rdv->motif ?? '-' }}</td>
                                        <td class="p-3">
                                            @if($rdv->statut === 'confirme')
                                                <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 text-xs font-bold rounded-full border border-emerald-200">Confirmé</span>
                                            @elseif($rdv->statut === 'annule')
                                                <span class="px-2.5 py-1 bg-rose-50 text-rose-700 text-xs font-bold rounded-full border border-rose-200">Annulé</span>
                                            @elseif($rdv->statut === 'termine')
                                                <span class="px-2.5 py-1 bg-slate-100 text-slate-700 text-xs font-bold rounded-full border border-slate-200">Terminé</span>
                                            @elseif($rdv->statut === 'absent')
                                                <span class="px-2.5 py-1 bg-amber-50 text-amber-700 text-xs font-bold rounded-full border border-amber-200">Absent</span>
                                            @endif
                                        </td>
                                        <td class="p-3 text-right">
                                            @if($rdv->statut === 'confirme')
                                                <form action="{{ route('agent.rendezvous.update_statut', $rdv->id) }}" method="POST" class="inline-flex items-center space-x-2">
                                                    @csrf
                                                    @method('PATCH')
                                                    <select name="statut" class="text-xs rounded-lg border-slate-200 focus:ring-blue-500 focus:border-blue-500 py-1">
                                                        <option value="termine">Marquer Terminé</option>
                                                        <option value="absent">Marquer Absent</option>
                                                        <option value="annule">Annuler le RDV</option>
                                                    </select>
                                                    <button type="submit" class="px-3 py-1 bg-slate-900 text-white rounded-lg text-xs font-bold hover:bg-slate-800 transition">
                                                        Valider
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-xs text-slate-400 font-medium">Clôturé</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $rendezvous->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>