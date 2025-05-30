@extends('layouts.auth')

@section('title', 'Réinitialisation du mot de passe')
@section('subtitle', 'Nouveau mot de passe')

@section('content')
<div class="space-y-6">
    <!-- Page Title -->
    <div class="text-center">
        <div class="w-16 h-16 bg-gradient-to-r from-green-400 to-emerald-500 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-lock-open text-white text-xl"></i>
        </div>
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Nouveau mot de passe</h2>
        <p class="text-gray-600 text-sm">Veuillez créer un nouveau mot de passe sécurisé pour votre compte.</p>
    </div>

    <!-- Reset Password Form -->
    <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

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
                value="{{ old('email', $request->email) }}" 
                required 
                autofocus 
                autocomplete="username"
                class="input-field w-full px-4 py-3 rounded-xl border focus:ring-0 focus:outline-none placeholder-gray-400 bg-gray-50"
                placeholder="votre@email.com"
                readonly
            />
            @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="space-y-2">
            <label for="password" class="block text-sm font-semibold text-gray-700">
                <i class="fas fa-lock mr-2 text-gray-400"></i>
                Nouveau mot de passe
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
                Confirmer le nouveau mot de passe
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

        <!-- Password Guidelines -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <h3 class="text-sm font-semibold text-blue-800 mb-2">
                <i class="fas fa-info-circle mr-2"></i>
                Conseils pour un mot de passe sécurisé :
            </h3>
            <ul class="text-xs text-blue-700 space-y-1">
                <li>• Au moins 8 caractères</li>
                <li>• Mélangez lettres, chiffres et symboles</li>
                <li>• Évitez les informations personnelles</li>
            </ul>
        </div>

        <!-- Reset Button -->
        <button 
            type="submit" 
            class="btn-primary w-full py-3 px-4 rounded-xl text-white font-semibold text-sm focus:outline-none focus:ring-4 focus:ring-blue-300"
        >
            <i class="fas fa-check mr-2"></i>
            Réinitialiser le mot de passe
        </button>
    </form>

    <!-- Back to Login -->
    <div class="text-center pt-4 border-t border-gray-200">
        <p class="text-gray-600 text-sm">
            <a 
                href="{{ route('login') }}" 
                class="text-blue-600 hover:text-blue-800 font-semibold transition-colors"
            >
                <i class="fas fa-arrow-left mr-1"></i>
                Retour à la connexion
            </a>
        </p>
    </div>
</div>
@endsection
