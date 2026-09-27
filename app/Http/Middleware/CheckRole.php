<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Vérifie si l'utilisateur connecté possède le rôle requis.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. Vérifier si l'utilisateur est connecté
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // 2. Vérifier si le rôle de l'utilisateur correspond au rôle exigé par la route
        if (auth()->user()->role !== $role) {
            // Si c'est un agent qui tente d'aller chez l'étudiant, on le redirige vers son propre dashboard
            if (auth()->user()->role === 'agent') {
                return redirect()->route('agent.dashboard')->with('error', 'Accès refusé : espace réservé aux étudiants.');
            }

            if (auth()->user()->role === 'etudiant') {
                return redirect()->route('dashboard')->with('error', 'Accès refusé : espace réservé aux agents.');
            }

            if (auth()->user()->role === 'admin') {
                return redirect()->route('admin.dashboard')->with('error', 'Accès refusé.');
            }

            abort(403, 'Accès non autorisé.');
        }

        return $next($request);
    }
}