<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            $user = Auth::guard($guard)->user();

            // Redirection selon le rôle ou le guard
            switch ($guard) {
                case 'enseignant':
                    return redirect()->route('enseignant.dashboard1');
                case 'superadmin':
                    return redirect()->route('superadmin.dashboard');
                case 'web': // Pour les utilisateurs "admin" ou "etudiant"
                    switch ($user->role) {
                        case 'admin':
                            return redirect()->route('admin.dashboard');
                        case 'etudiant':
                            return redirect()->route('etudiant.dashboard');
                    }
                    break;
            }

            // Redirection par défaut si aucun cas ne correspond
            return redirect('/');
        }

        return $next($request);
    }
}
