<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EtudiantMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'etudiant') {
            return $next($request);
        }

        return redirect('/')->with('error', 'Accès réservé aux étudiants.');
    }
}
