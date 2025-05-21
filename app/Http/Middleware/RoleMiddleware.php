<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->role !== $role) {
            // Rediriger en fonction du rôle de l'utilisateur connecté
            switch (Auth::user()->role) {
                case 'superadmin':
                    return redirect()->route('superadmin.dashboard');
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'enseignant':
                    return redirect()->route('enseignant.dashboard'); // removed '1'
                case 'etudiant':
                    return redirect()->route('etudiant.dashboard');
                default:
                    return redirect()->route('login');
            }
        }

        return $next($request);
    }
}