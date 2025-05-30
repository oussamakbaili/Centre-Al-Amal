@extends('layouts.auth')

@section('title', 'Mot de passe oublié')
@section('subtitle', 'Récupération de mot de passe')

@section('content')
<div class="space-y-6">
    <!-- Page Title -->
    <div class="text-center">
        <div class="w-16 h-16 bg-gradient-to-r from-amber-400 to-orange-500 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-key text-white text-xl"></i>
        </div>
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Mot de passe oublié ?</h2>
        <p class="text-gray-600 text-sm">Pas de problème. Indiquez votre adresse email et nous vous enverrons un lien de réinitialisation.</p>
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('status') }}
        </div>
    @endif

    <!-- Forgot Password Form -->
    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
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
                class="input-field w-full px-4 py-3 rounded-xl border focus:ring-0 focus:outline-none placeholder-gray-400"
                placeholder="votre@email.com"
            />
            @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Reset Button -->
        <button 
            type="submit" 
            class="btn-primary w-full py-3 px-4 rounded-xl text-white font-semibold text-sm focus:outline-none focus:ring-4 focus:ring-blue-300"
        >
            <i class="fas fa-paper-plane mr-2"></i>
            Envoyer le lien de réinitialisation
        </button>
    </form>

    <!-- Back to Login -->
    <div class="text-center pt-4 border-t border-gray-200">
        <p class="text-gray-600 text-sm">
            Vous vous souvenez de votre mot de passe ?
            <a 
                href="{{ route('login') }}" 
                class="text-blue-600 hover:text-blue-800 font-semibold transition-colors"
            >
                Retour à la connexion
            </a>
        </p>
    </div>
</div>
@endsection
