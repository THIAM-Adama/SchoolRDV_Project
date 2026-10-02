<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force le HTTPS UNIQUEMENT en production (Railway)
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        // Définit les règles de mot de passe fort pour toute l'application
        Password::defaults(function () {
            return Password::min(8)
                ->mixedCase()   // Au moins 1 majuscule
                ->numbers()     // Au moins 1 chiffre
                ->symbols();    // Au moins 1 symbole (!@#$%^&*)
        });
    }
}