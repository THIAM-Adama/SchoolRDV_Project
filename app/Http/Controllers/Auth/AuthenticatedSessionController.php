<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = $request->user();

        // 1. Redirection si c'est un agent
        if ($user->role === 'agent') {
            return redirect()->route('agent.dashboard');
        }

        // 2. Redirection si c'est un admin
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // 3. Redirection si c'est un étudiant et qu'un service a été sélectionné
        if ($request->has('service_id')) {
            return redirect()->route('etudiant.rendezvous.index', ['service_id' => $request->input('service_id')]);
        }

        // 4. Sinon, par défaut redirection vers la liste de ses rendez-vous
        return redirect()->route('etudiant.rendezvous.index');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}