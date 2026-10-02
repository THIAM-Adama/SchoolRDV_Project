<x-guest-layout>
    <!-- En-tête du formulaire -->
    <div class="text-center lg:text-left space-y-2">
        <div class="lg:hidden flex justify-center mb-4">
            <a href="/">
                <img src="{{ asset('images/logo.png') }}" alt="SchoolRDV Logo" class="h-12 w-auto">
            </a>
        </div>
        <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Connexion</h2>
        <p class="text-sm text-slate-500">
            Vous n'avez pas de compte ? 
            <a href="{{ route('register') }}" class="font-bold text-blue-600 hover:text-blue-700 transition">Inscrivez-vous ici</a>
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-bold text-slate-700 mb-2">Adresse Email</label>
            <input id="email" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-600 focus:border-transparent transition outline-none text-slate-800" 
                   type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="nom@exemple.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-2">
                <label for="password" class="block text-sm font-bold text-slate-700">Mot de passe</label>
                @if (Route::has('password.request'))
                    <a class="text-xs font-semibold text-blue-600 hover:text-blue-700 transition" href="{{ route('password.request') }}">
                        Mot de passe oublié ?
                    </a>
                @endif
            </div>
            <input id="password" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-600 focus:border-transparent transition outline-none text-slate-800"
                   type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-blue-600 shadow-sm focus:ring-blue-500 w-4 h-4" name="remember">
                <span class="ml-2 text-sm text-slate-600 font-medium">Se souvenir de moi</span>
            </label>
        </div>

        <!-- Submit Button -->
        <div>
            <button type="submit" class="w-full py-3.5 px-6 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg shadow-blue-500/25 transition duration-150">
                Se connecter
            </button>
        </div>
    </form>
</x-guest-layout>