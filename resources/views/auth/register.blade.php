@extends('layouts.auth')

@section('title', 'Inscription')
@section('subtitle', 'Créez votre compte')

@section('content')
<div class="space-y-6">
    <!-- Page Title -->
    <div class="text-center">
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Créer un compte</h2>
        <p class="text-gray-600 text-sm">Rejoignez Centre Al-Amal et commencez votre parcours</p>
    </div>

    <!-- Register Form -->
    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Name -->
        <div class="space-y-2">
            <label for="name" class="block text-sm font-semibold text-gray-700">
                <i class="fas fa-user mr-2 text-gray-400"></i>
                Nom complet
            </label>
            <input 
                id="name" 
                type="text" 
                name="name" 
                value="{{ old('name') }}" 
                required 
                autofocus 
                autocomplete="name"
                class="input-field w-full px-4 py-3 rounded-xl border focus:ring-0 focus:outline-none placeholder-gray-400"
                placeholder="Votre nom complet"
            />
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

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
                autocomplete="new-password"
                class="input-field w-full px-4 py-3 rounded-xl border focus:ring-0 focus:outline-none placeholder-gray-400"
                placeholder="••••••••"
            />
            @error('password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="space-y-2">
            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700">
                <i class="fas fa-lock mr-2 text-gray-400"></i>
                Confirmer le mot de passe
            </label>
            <input 
                id="password_confirmation" 
                type="password" 
                name="password_confirmation" 
                required 
                autocomplete="new-password"
                class="input-field w-full px-4 py-3 rounded-xl border focus:ring-0 focus:outline-none placeholder-gray-400"
                placeholder="••••••••"
            />
            @error('password_confirmation')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Register Button -->
        <button 
            type="submit" 
            class="btn-primary w-full py-3 px-4 rounded-xl text-white font-semibold text-sm focus:outline-none focus:ring-4 focus:ring-blue-300"
        >
            <i class="fas fa-user-plus mr-2"></i>
            Créer mon compte
        </button>
    </form>

    <!-- Login Link -->
    <div class="text-center pt-4 border-t border-gray-200">
        <p class="text-gray-600 text-sm">
            Déjà un compte ?
            <a 
                href="{{ route('login') }}" 
                class="text-blue-600 hover:text-blue-800 font-semibold transition-colors"
            >
                Se connecter
            </a>
        </p>
    </div>
</div>
@endsection
