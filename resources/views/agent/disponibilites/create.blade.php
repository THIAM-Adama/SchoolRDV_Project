<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ajouter un créneau unitaire (30 min)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <form action="{{ route('agent.disponibilites.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                        <input type="date" name="date" value="{{ old('date') }}" required class="w-full rounded-md border-gray-300 shadow-sm">
                        @error('date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Heure de début</label>
                        <input type="time" name="heure_debut" value="{{ old('heure_debut', '09:00') }}" required class="w-full rounded-md border-gray-300 shadow-sm">
                        <p class="text-xs text-gray-500 mt-1">Le créneau durera automatiquement 30 minutes.</p>
                        @error('heure_debut') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-between items-center">
                        <a href="{{ route('agent.disponibilites.index') }}" class="text-sm text-gray-600 hover:underline">Annuler</a>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white font-medium text-sm rounded-md hover:bg-blue-700">
                            Créer le créneau
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>