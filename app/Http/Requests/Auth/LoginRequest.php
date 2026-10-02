<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Nombre maximal de tentatives autorisées.
     */
    protected int $maxAttempts = 5;

    /**
     * Durée du blocage en secondes (5 minutes = 300 secondes).
     */
    protected int $decaySeconds = 300;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            // 1. Enregistre l'échec de la tentative
            RateLimiter::hit($this->throttleKey(), $this->decaySeconds);

            // 2. Calcule le nombre de tentatives restantes
            $attemptsLeft = RateLimiter::remaining($this->throttleKey(), $this->maxAttempts);

            // 3. Affiche le message d'erreur avec le nombre de tentatives restantes
            throw ValidationException::withMessages([
                'email' => "L'adresse e-mail ou le mot de passe est incorrect. Il vous reste {$attemptsLeft} tentative(s) avant un blocage de 5 minutes.",
            ]);
        }

        // Réinitialise le compteur si la connexion réussit
        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), $this->maxAttempts)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());
        $minutes = ceil($seconds / 60);

        throw ValidationException::withMessages([
            'email' => "Trop de tentatives de connexion. Votre compte est bloqué temporairement. Veuillez réessayer dans {$minutes} minute(s).",
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')).'|'.$this->ip());
    }
}