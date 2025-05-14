<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Tester tous les guards configurés
        foreach (array_keys(config('auth.guards')) as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();

                if ($user->role === $role) {
                    // Authentifié avec le bon rôle
                    return $next($request);
                } else {
                    abort(403, 'Accès non autorisé');
                }
            }
        }

        // Aucun utilisateur connecté
        abort(403, 'Non authentifié');
    }

}
