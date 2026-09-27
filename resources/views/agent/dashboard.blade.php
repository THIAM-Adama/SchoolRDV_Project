<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Espace Agent') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-gradient-to-r from-emerald-600 to-teal-700 rounded-2xl shadow-lg p-6 text-white flex justify-between items-center">
                <div>
                    <h3 class="text-2xl font-bold">Espace Agent : {{ auth()->user()->name }}</h3>
                    <p class="text-teal-100 text-sm mt-1">Gérez vos disponibilités et traitez les rendez-vous reçus.</p>
                </div>
                <span class="px-4 py-2 bg-white/20 rounded-lg text-xs font-semibold uppercase tracking-wider backdrop-blur-md">Agent Administratif</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <a href="{{ route('agent.disponibilites.index') }}" class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:border-emerald-500 transition group">
                    <div class="p-4 bg-emerald-50 text-emerald-600 rounded-xl w-fit group-hover:bg-emerald-600 group-hover:text-white transition">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mt-4">Mes Disponibilités</h4>
                    <p class="text-sm text-gray-500 mt-1">Définissez vos créneaux horaires d'accueil pour les étudiants.</p>
                </a>

                <a href="{{ route('agent.rendezvous.index') }}" class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:border-emerald-500 transition group">
                    <div class="p-4 bg-teal-50 text-teal-600 rounded-xl w-fit group-hover:bg-teal-600 group-hover:text-white transition">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mt-4">Mes RDV Reçus</h4>
                    <p class="text-sm text-gray-500 mt-1">Consultez la liste des demandes de RDV et mettez à jour leur statut.</p>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>