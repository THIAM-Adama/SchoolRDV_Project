<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight">
            {{ __('Espace Étudiant') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-gradient-to-r from-blue-600 to-cyan-600 rounded-2xl shadow-lg p-6 text-white flex justify-between items-center">
                <div>
                    <h3 class="text-2xl font-bold">Ravi de vous voir, {{ auth()->user()->name }} !</h3>
                    <p class="text-blue-100 text-sm mt-1">Prenez rendez-vous avec un agent de votre établissement en quelques clics.</p>
                </div>
                <span class="px-4 py-2 bg-white/20 rounded-lg text-xs font-semibold uppercase tracking-wider backdrop-blur-md">Étudiant</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Lien vers la prise de RDV --}}
                <a href="{{ route('etudiant.rendezvous.index') }}" class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200/80 hover:border-blue-500 transition group">
                    <div class="p-4 bg-blue-50 text-blue-600 rounded-xl w-fit group-hover:bg-blue-600 group-hover:text-white transition">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    </div>
                    <h4 class="text-xl font-bold text-slate-900 mt-4">Prendre un Rendez-vous</h4>
                    <p class="text-sm text-slate-500 mt-1">Choisissez un service, un agent et sélectionnez un créneau horaire libre.</p>
                </a>

                {{-- Lien vers la liste de mes RDV --}}
                <a href="{{ route('etudiant.rendezvous.mes_rdv') }}" class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200/80 hover:border-blue-500 transition group">
                    <div class="p-4 bg-sky-50 text-sky-600 rounded-xl w-fit group-hover:bg-sky-600 group-hover:text-white transition">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <h4 class="text-xl font-bold text-slate-900 mt-4">Mes Rendez-vous</h4>
                    <p class="text-sm text-slate-500 mt-1">Suivez l'état de vos demandes et consultez l'historique complet.</p>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>