@extends('layouts.auth')

@section('title', 'Connexion')
@section('subtitle', 'Connectez-vous à votre espace')

@section('content')
<div class="space-y-6">
    <!-- Page Title -->
    <div class="text-center">
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Bienvenue</h2>
        <p class="text-gray-600 text-sm">Connectez-vous à votre compte pour continuer</p>
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm">
            {{ session('status') }}
        </div>
    @endif

    <!-- Login Form -->
    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div class="space-y-2">
            <label for="email" class="block text-sm font-semibold text-gray-700">
                <i class="fas fa-envelope mr-2 text-gray-400"></i>
                Adresse email
            </label>
            <input 
                id="email" 
                type="email" 
                name="email" 
                value="{{ old('email') }}" 
                required 
                autofocus 
                autocomplete="username"
                class="input-field w-full px-4 py-3 rounded-xl border focus:ring-0 focus:outline-none placeholder-gray-400"
                placeholder="votre@email.com"
            />
            @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="space-y-2">
            <label for="password" class="block text-sm font-semibold text-gray-700">
                <i class="fas fa-lock mr-2 text-gray-400"></i>
                Mot de passe
            </label>
            <input 
                id="password" 
                type="password" 
                name="password" 
                required 
                autocomplete="current-password"
                class="input-field w-full px-4 py-3 rounded-xl border focus:ring-0 focus:outline-none placeholder-gray-400"
                placeholder="••••••••"
            />
            @error('password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="flex items-center">
                <input 
                    id="remember_me" 
                    type="checkbox" 
                    name="remember"
                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500"
                />
                <span class="ml-2 text-sm text-gray-600">Se souvenir de moi</span>
            </label>

            @if (Route::has('password.request'))
                <a 
                    href="{{ route('password.request') }}" 
                    class="text-sm text-blue-600 hover:text-blue-800 font-medium transition-colors"
                >
                    Mot de passe oublié ?
                </a>
            @endif
        </div>

        <!-- Login Button -->
        <button 
            type="submit" 
            class="btn-primary w-full py-3 px-4 rounded-xl text-white font-semibold text-sm focus:outline-none focus:ring-4 focus:ring-blue-300"
        >
            <i class="fas fa-sign-in-alt mr-2"></i>
            Se connecter
        </button>
    </form>

    <!-- Register Link -->
    @if (Route::has('register'))
        <div class="text-center pt-4 border-t border-gray-200">
            <p class="text-gray-600 text-sm">
                Pas encore de compte ?
                <a 
                    href="{{ route('register') }}" 
                    class="text-blue-600 hover:text-blue-800 font-semibold transition-colors"
                >
                    Créer un compte
                </a>
            </p>
        </div>
    @endif
</div>
@endsection
