@extends('layouts.auth')

@section('title', 'Vérification email')
@section('subtitle', 'Vérifiez votre adresse email')

@section('content')
<div class="space-y-6">
    <!-- Page Title -->
    <div class="text-center">
        <div class="w-16 h-16 bg-gradient-to-r from-blue-400 to-cyan-500 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-envelope-open text-white text-xl"></i>
        </div>
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Vérifiez votre email</h2>
        <p class="text-gray-600 text-sm">Nous avons envoyé un lien de vérification à votre adresse email.</p>
    </div>

    <!-- Email Verification Notice -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex items-start">
            <i class="fas fa-info-circle text-blue-500 mr-3 mt-0.5"></i>
            <div>
                <h3 class="text-sm font-semibold text-blue-800 mb-1">Action requise</h3>
                <p class="text-xs text-blue-700">Merci de votre inscription ! Avant de commencer, veuillez vérifier votre adresse email en cliquant sur le lien que nous venons de vous envoyer.</p>
            </div>
        </div>
    </div>

    <!-- Status Message -->
    @if (session('status') == 'verification-link-sent')
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            Un nouveau lien de vérification a été envoyé à votre adresse email.
        </div>
    @endif

    <!-- Action Buttons -->
    <div class="space-y-4">
        <!-- Resend Email Button -->
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button 
                type="submit" 
                class="btn-primary w-full py-3 px-4 rounded-xl text-white font-semibold text-sm focus:outline-none focus:ring-4 focus:ring-blue-300"
            >
                <i class="fas fa-paper-plane mr-2"></i>
                Renvoyer l'email de vérification
            </button>
        </form>

        <!-- Email Not Received Info -->
        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
            <h3 class="text-sm font-semibold text-gray-700 mb-2">
                <i class="fas fa-question-circle mr-2"></i>
                Vous n'avez pas reçu l'email ?
            </h3>
            <ul class="text-xs text-gray-600 space-y-1">
                <li>• Vérifiez votre dossier spam/courrier indésirable</li>
                <li>• Assurez-vous que l'adresse email est correcte</li>
                <li>• Attendez quelques minutes puis cliquez sur "Renvoyer"</li>
            </ul>
        </div>
    </div>

    <!-- Logout Option -->
    <div class="text-center pt-4 border-t border-gray-200">
        <form method="POST" action="{{ route('logout') }}" class="inline">
            @csrf
            <button 
                type="submit" 
                class="text-gray-500 hover:text-gray-700 text-sm transition-colors"
            >
                <i class="fas fa-sign-out-alt mr-1"></i>
                Se déconnecter
            </button>
        </form>
    </div>
</div>
@endsection
