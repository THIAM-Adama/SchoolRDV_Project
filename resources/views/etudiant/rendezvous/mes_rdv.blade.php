<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Mes rendez-vous</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Message de succès --}}
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 font-bold">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Message d'erreur --}}
            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 font-bold">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Horaires</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Agent</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Motif</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($rendezVous as $rdv)
                            <tr>
                                {{-- Date --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $dateVal = $rdv->disponibilite->date_disponibilite ?? $rdv->disponibilite->date ?? null;
                                    @endphp
                                    {{ $dateVal ? \Carbon\Carbon::parse($dateVal)->format('d/m/Y') : 'N/A' }}
                                </td>

                                {{-- Horaires --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if(isset($rdv->disponibilite->heure_debut) && isset($rdv->disponibilite->heure_fin))
                                        {{ \Carbon\Carbon::parse($rdv->disponibilite->heure_debut)->format('H:i') }} - {{ \Carbon\Carbon::parse($rdv->disponibilite->heure_fin)->format('H:i') }}
                                    @else
                                        N/A
                                    @endif
                                </td>

                                {{-- Agent --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $rdv->agent->name ?? 'Agent' }}
                                </td>

                                {{-- Motif --}}
                                <td class="px-6 py-4">
                                    {{ $rdv->motif ?? '-' }}
                                </td>

                                {{-- Statut --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($rdv->statut === 'confirme')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Confirmé
                                        </span>
                                    @elseif($rdv->statut === 'en_attente')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            En attente
                                        </span>
                                    @elseif($rdv->statut === 'annule')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Annulé
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                            {{ ucfirst($rdv->statut) }}
                                        </span>
                                    @endif
                                </td>

                                {{-- Action d'annulation --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if(in_array($rdv->statut, ['en_attente', 'confirme']))
                                        <form action="{{ route('etudiant.rendezvous.annuler', $rdv) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment annuler ce rendez-vous ?');">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white text-xs font-semibold rounded-md shadow transition">
                                                Annuler
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-xs text-gray-400 italic font-medium">Aucune action possible</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                    Vous n'avez aucun rendez-vous réservé.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>