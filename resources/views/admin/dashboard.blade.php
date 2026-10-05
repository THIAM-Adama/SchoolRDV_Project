<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight">
            {{ __('Tableau de bord Administrateur') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Banner Bienvenue -->
            <div class="bg-gradient-to-r from-indigo-600 to-violet-700 rounded-2xl shadow-lg p-6 text-white flex justify-between items-center">
                <div>
                    <h3 class="text-2xl font-bold">Bienvenue, {{ auth()->user()->name }} !</h3>
                    <p class="text-indigo-100 text-sm mt-1">Supervision globale et gestion de la plateforme SchoolRDV.</p>
                </div>
                <span class="px-4 py-2 bg-white/20 rounded-lg text-xs font-semibold uppercase tracking-wider backdrop-blur-md">Administrateur</span>
            </div>

            <!-- Grille des Statistiques -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200/80 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase">Étudiants</p>
                        <p class="text-3xl font-extrabold text-slate-900 mt-2">{{ $stats['etudiants'] }}</p>
                    </div>
                    <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 01-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200/80 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase">Agents</p>
                        <p class="text-3xl font-extrabold text-slate-900 mt-2">{{ $stats['agents'] }}</p>
                    </div>
                    <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200/80 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase">Services</p>
                        <p class="text-3xl font-extrabold text-slate-900 mt-2">{{ $stats['services'] }}</p>
                    </div>
                    <div class="p-3 bg-violet-50 text-violet-600 rounded-xl">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200/80 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase">Rendez-vous</p>
                        <p class="text-3xl font-extrabold text-slate-900 mt-2">{{ $stats['rendezvous'] }}</p>
                    </div>
                    <div class="p-3 bg-violet-50 text-violet-600 rounded-xl">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                </div>
            </div>

            <!-- Raccourcis d'action -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6">
                <h4 class="text-base font-bold text-slate-900 mb-4">Actions Rapides</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a href="{{ route('admin.users.index') }}" class="p-4 border rounded-xl hover:border-indigo-500 hover:shadow-md transition flex items-center space-x-4">
                        <div class="p-3 bg-indigo-50 text-indigo-600 rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        </div>
                        <div>
                            <p class="font-bold text-slate-900">Gérer les Utilisateurs</p>
                            <p class="text-xs text-slate-500">Ajouter, modifier ou supprimer des comptes étudiants et agents.</p>
                        </div>
                    </a>
                    <a href="{{ route('admin.services.index') }}" class="p-4 border rounded-xl hover:border-indigo-500 hover:shadow-md transition flex items-center space-x-4">
                        <div class="p-3 bg-indigo-50 text-indigo-600 rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        </div>
                        <div>
                            <p class="font-bold text-slate-900">Gérer les Services</p>
                            <p class="text-xs text-slate-500">Configurer les départements et bureaux administratifs.</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>