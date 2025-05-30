@extends('layouts.auth')

@section('title', 'Confirmation du mot de passe')
@section('subtitle', 'Zone sécurisée')

@section('content')
<div class="space-y-6">
    <!-- Page Title -->
    <div class="text-center">
        <div class="w-16 h-16 bg-gradient-to-r from-red-400 to-pink-500 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-shield-alt text-white text-xl"></i>
        </div>
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Zone sécurisée</h2>
        <p class="text-gray-600 text-sm">Veuillez confirmer votre mot de passe avant de continuer.</p>
    </div>

    <!-- Security Notice -->
    <div class="bg-amber-50 border border-amber-200 rounded-lg p-4">
        <div class="flex items-start">
            <i class="fas fa-exclamation-triangle text-amber-500 mr-3 mt-0.5"></i>
            <div>
                <h3 class="text-sm font-semibold text-amber-800 mb-1">Sécurité renforcée</h3>
                <p class="text-xs text-amber-700">Cette section de l'application nécessite une authentification supplémentaire pour votre sécurité.</p>
            </div>
        </div>
    </div>

    <!-- Confirm Password Form -->
    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
        @csrf

        <!-- Password -->
        <div class="space-y-2">
            <label for="password" class="block text-sm font-semibold text-gray-700">
                <i class="fas fa-lock mr-2 text-gray-400"></i>
                Mot de passe actuel
            </label>
            <input 
                id="password" 
                type="password" 
                name="password" 
                required 
                autocomplete="current-password"
                class="input-field w-full px-4 py-3 rounded-xl border focus:ring-0 focus:outline-none placeholder-gray-400"
                placeholder="Entrez votre mot de passe"
                autofocus
            />
            @error('password')
                <p class="text-red-500 text-sm mt-1 flex items-center">
                    <i class="fas fa-exclamation-circle mr-1"></i>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Confirm Button -->
        <button 
            type="submit" 
            class="btn-primary w-full py-3 px-4 rounded-xl text-white font-semibold text-sm focus:outline-none focus:ring-4 focus:ring-blue-300"
        >
            <i class="fas fa-check-circle mr-2"></i>
            Confirmer et continuer
        </button>
    </form>

    <!-- Alternative Actions -->
    <div class="text-center pt-4 border-t border-gray-200 space-y-2">
        <p class="text-gray-600 text-sm">
            Mot de passe oublié ?
            <a 
                href="{{ route('password.request') }}" 
                class="text-blue-600 hover:text-blue-800 font-semibold transition-colors"
            >
                Réinitialiser
            </a>
        </p>
        <p class="text-gray-600 text-sm">
            <a 
                href="{{ route('dashboard') }}" 
                class="text-gray-500 hover:text-gray-700 transition-colors"
            >
                <i class="fas fa-arrow-left mr-1"></i>
                Retour au tableau de bord
            </a>
        </p>
    </div>
</div>
@endsection
