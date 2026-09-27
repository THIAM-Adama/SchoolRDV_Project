<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Génération automatique en masse</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow sm:rounded-lg">
                <form method="POST" action="{{ route('agent.disponibilites.store_mass') }}">
                    @csrf

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block font-bold mb-1">Date de début</label>
                            <input type="date" name="date_debut" value="{{ old('date_debut') }}" class="w-full border rounded p-2">
                            @error('date_debut') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block font-bold mb-1">Date de fin</label>
                            <input type="date" name="date_fin" value="{{ old('date_fin') }}" class="w-full border rounded p-2">
                            @error('date_fin') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block font-bold mb-1">Heure de début générale</label>
                            <input type="time" name="heure_debut" value="{{ old('heure_debut', '09:00') }}" class="w-full border rounded p-2">
                            @error('heure_debut') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block font-bold mb-1">Heure de fin générale</label>
                            <input type="time" name="heure_fin" value="{{ old('heure_fin', '17:00') }}" class="w-full border rounded p-2">
                            @error('heure_fin') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold mb-2">Jours travaillés (Du lundi au vendredi uniquement)</label>
                        <div class="grid grid-cols-3 gap-2">
                            <label class="inline-flex items-center"><input type="checkbox" name="jours[]" value="1" checked class="rounded"> <span class="ml-2">Lundi</span></label>
                            <label class="inline-flex items-center"><input type="checkbox" name="jours[]" value="2" checked class="rounded"> <span class="ml-2">Mardi</span></label>
                            <label class="inline-flex items-center"><input type="checkbox" name="jours[]" value="3" checked class="rounded"> <span class="ml-2">Mercredi</span></label>
                            <label class="inline-flex items-center"><input type="checkbox" name="jours[]" value="4" checked class="rounded"> <span class="ml-2">Jeudi</span></label>
                            <label class="inline-flex items-center"><input type="checkbox" name="jours[]" value="5" checked class="rounded"> <span class="ml-2">Vendredi</span></label>
                        </div>
                        @error('jours') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="p-4 bg-gray-50 border rounded text-sm text-gray-600 mb-6">
                        ℹ️ <strong>Règles de génération :</strong> Le système découpera automatiquement la journée en créneaux de 30 minutes. Les week-ends et jours fériés seront automatiquement ignorés.
                    </div>

                    <div class="flex justify-between items-center">
                        <a href="{{ route('agent.disponibilites.index') }}" class="text-gray-600">Annuler</a>
                        <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded shadow font-bold">Générer les créneaux</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>