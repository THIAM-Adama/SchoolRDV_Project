<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Éditer l'utilisateur : {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <form action="{{ route('admin.users.update', $user) }}" method="POST" x-data="{ role: '{{ old('role', $user->role) }}' }">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Nom complet</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Adresse Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Mot de passe <span class="text-xs text-gray-500">(laisser vide pour ne pas modifier)</span></label>
                        <input type="password" name="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Rôle</label>
                        <select name="role" x-model="role" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="etudiant">Étudiant</option>
                            <option value="agent">Agent</option>
                            <option value="admin">Administrateur</option>
                        </select>
                        @error('role') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <!-- Champ affiché uniquement si le rôle sélectionné est agent -->
                    <div class="mb-4" x-show="role === 'agent'">
                        <label class="block text-sm font-medium text-gray-700">Service rattaché <span class="text-red-500">*</span></label>
                        <select name="service_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">-- Sélectionner un service --</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}" {{ old('service_id', $user->service_id) == $service->id ? 'selected' : '' }}>
                                    {{ $service->nom }}
                                </option>
                            @endforeach
                        </select>
                        @error('service_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-end gap-3">
                        <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-gray-200 rounded-md text-sm text-gray-700">Annuler</a>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm hover:bg-indigo-700">
                            Mettre à jour
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>