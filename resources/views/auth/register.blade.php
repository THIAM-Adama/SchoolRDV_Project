<x-guest-layout>
    <!-- En-tête du formulaire -->
    <div class="text-center lg:text-left space-y-2">
        <div class="lg:hidden flex justify-center mb-4">
            <a href="/">
                <img src="{{ asset('images/logo.png') }}" alt="SchoolRDV Logo" class="h-12 w-auto">
            </a>
        </div>
        <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Créer un compte</h2>
        <p class="text-sm text-slate-500">
            Vous avez déjà un compte ? 
            <a href="{{ route('login') }}" class="font-bold text-blue-600 hover:text-blue-700 transition">Se connecter</a>
        </p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Nom -->
        <div>
            <label for="name" class="block text-sm font-bold text-slate-700 mb-1">Nom complet</label>
            <input id="name" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-600 focus:border-transparent transition outline-none text-slate-800" 
                   type="text" name="name" value="{{ old('name') }}" required autofocus placeholder="Prénom Nom" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-bold text-slate-700 mb-1">Adresse Email</label>
            <input id="email" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-600 focus:border-transparent transition outline-none text-slate-800" 
                   type="email" name="email" value="{{ old('email') }}" required placeholder="nom@exemple.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-bold text-slate-700 mb-1">Mot de passe</label>
            <input id="password" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-600 focus:border-transparent transition outline-none text-slate-800"
                   type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-bold text-slate-700 mb-1">Confirmer le mot de passe</label>
            <input id="password_confirmation" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-600 focus:border-transparent transition outline-none text-slate-800"
                   type="password" name="password_confirmation" required placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <button type="submit" class="w-full py-3.5 px-6 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg shadow-blue-500/25 transition duration-150">
                S'inscrire
            </button>
        </div>
    </form>
</x-guest-layout>