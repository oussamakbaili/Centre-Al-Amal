<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord Etudiant</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="flex">
    <!-- Sidebar -->
    <div class="bg-blue-800 text-white w-64 min-h-screen p-4">
        <h1 class="text-2xl font-bold mb-6">Menu</h1>
        <ul>
            <a href="{{ route('etudiant.dashboard') }}" class="block py-3 px-6 hover:bg-blue-800 {{ request()->routeIs('etudiant.dashboard') ? 'bg-blue-800' : '' }}">
                Tableau de bord
            </a>
            <a href="{{ route('etudiant.profile.edit') }}" class="block py-3 px-6 hover:bg-blue-800 {{ request()->routeIs('etudiant.profile.*') ? 'bg-blue-800' : '' }}">
                Profil
            </a>
            <a href="{{ route('etudiant.emploi') }}" class="block py-3 px-6 hover:bg-blue-800 {{ request()->routeIs('etudiant.emploi') ? 'bg-blue-800' : '' }}">
                Emploi du temps
            </a>
            <a href="{{ route('etudiant.notes') }}" class="block py-3 px-6 hover:bg-blue-800 {{ request()->routeIs('etudiant.notes') ? 'bg-blue-800' : '' }}">
                Notes
            </a>
            <a href="{{ route('etudiant.absences.index') }}" class="block py-3 px-6 hover:bg-blue-800 {{ request()->routeIs('etudiant.absences.*') ? 'bg-blue-800' : '' }}">
                Absences
            </a>
            <li class="mb-4">
                <a href="{{ route('etudiant.documents.index') }}" class="block py-2 px-4 hover:bg-blue-700">Documents</a>
            </li>
        </ul>
    </div>

    <!-- Content -->
    <div class="flex-1 overflow-y-auto">
        <!-- Header -->
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-800">Bienvenue, {{ $etudiant->prenom }} {{ $etudiant->nom }}</h1>
                <div class="flex items-center space-x-4">
                    @include('etudiant.partials.security-section')
                </div>
            </div>
        </header>

        <!-- Informations personnelles -->
        <div class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-xl font-bold mb-4">Données personnelles administratives</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex flex-col md:flex-row">
                        <!-- Photo de profil -->
                        <div class="w-32 h-32 rounded-lg overflow-hidden bg-gray-200 flex items-center justify-center">
                            @if($etudiant->photo)
                                <img src="{{ asset('storage/'.$etudiant->photo) }}" alt="Photo profil" class="w-full h-full object-cover">
                            @else
                                <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                            @endif
                        </div>

                        <!-- Informations personnelles - Colonne 1 -->
                        <div class="md:ml-6 mt-4 md:mt-0 flex-1">
                            <div class="grid grid-cols-1 gap-y-2">
                                <div class="flex flex-col">
                                    <span class="text-sm text-gray-500">Nom et Prénom</span>
                                    <span class="font-medium">{{ $etudiant->nom }} {{ $etudiant->prenom }}</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm text-gray-500">Classe</span>
                                    <span class="font-medium">{{ $etudiant->niveau ?? 'Non spécifié' }}</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm text-gray-500">E-mail</span>
                                    <span class="font-medium">{{ $etudiant->email }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informations personnelles - Colonne 2 -->
                    <div class="grid grid-cols-1 gap-y-2">
                        <div class="flex flex-col">
                            <span class="text-sm text-gray-500">N° CIN</span>
                            <span class="font-medium">{{ $etudiant->cin ?? 'Non spécifié' }}</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-sm text-gray-500">Date de naissance</span>
                            <span class="font-medium">{{ $etudiant->date_naissance ? $etudiant->date_naissance->format('d/m/Y') : 'Non spécifié' }}</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-sm text-gray-500">Téléphone</span>
                            <span class="font-medium">{{ $etudiant->telephone ?? 'Non spécifié' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Trois cartes du haut -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Carte Emploi du temps -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="px-6 py-4 bg-blue-600 text-white">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold">Emploi du temps</h3>
                            <a href="{{ route('etudiant.emploi') }}" class="text-sm font-medium hover:text-blue-200">Voir tout</a>
                        </div>
                    </div>
                    <div class="p-6">
                        @if($emplois->count() > 0)
                            <h4 class="font-medium text-gray-700 mb-3">Aujourd'hui ({{ now()->format('d/m/Y') }})</h4>
                            @php
                                $todayEmplois = $emplois->where('jour_semaine', now()->format('l'));
                            @endphp

                            @if($todayEmplois->count() > 0)
                                <ul class="space-y-3">
                                    @foreach($todayEmplois as $emploi)
                                    <li class="p-3 border rounded-lg">
                                        <div class="flex justify-between">
                                            <span class="font-medium">{{ $emploi->module->nom ?? 'Module non spécifié' }}</span>
                                            <span class="text-sm text-gray-500">{{ $emploi->salle ?? 'Salle non spécifiée' }}</span>
                                        </div>
                                        <div class="text-sm text-gray-600">
                                            {{ date('H:i', strtotime($emploi->heure_debut)) }} - {{ date('H:i', strtotime($emploi->heure_fin)) }}
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-gray-500">Aucun cours aujourd'hui</p>
                            @endif
                        @else
                            <p class="text-gray-500">Aucun emploi du temps disponible</p>
                        @endif
                    </div>
                </div>

                <!-- Carte Notes -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="px-6 py-4 bg-blue-600 text-white">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold">Mes Notes</h3>
                            <a href="{{ route('etudiant.notes') }}" class="text-sm font-medium hover:text-blue-200">Voir tout</a>
                        </div>
                    </div>
                    <div class="p-6">
                        @if($notes->count() > 0)
                            <ul class="space-y-3">
                                @foreach($notes->take(3) as $note)
                                <li class="flex justify-between items-center p-2 border-b">
                                    <div>
                                        <p class="font-medium">{{ $note->module->nom ?? 'Module non spécifié' }}</p>
                                        <p class="text-sm text-gray-500">{{ $note->type_note }}</p>
                                    </div>
                                    <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $note->valeur >= 10 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $note->valeur }}/20
                                    </span>
                                </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-500">Aucune note disponible</p>
                        @endif
                    </div>
                </div>

                <!-- Carte Absences -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="px-6 py-4 bg-blue-600 text-white">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold">Mes Absences</h3>
                            <a href="{{ route('etudiant.absences.index') }}" class="text-sm font-medium hover:text-blue-200">Voir tout</a>
                        </div>
                    </div>
                    <div class="p-6">
                        @if($absences->count() > 0)
                            <ul class="space-y-3">
                                @foreach($absences->take(3) as $absence)
                                <li class="flex justify-between items-center p-2 border-b">
                                    <div>
                                        <p class="font-medium">{{ $absence->module->nom ?? 'Module non spécifié' }}</p>
                                        <p class="text-sm text-gray-500">
                                            @if(is_object($absence->date_absence))
                                                {{ $absence->date_absence->format('d/m/Y') }}
                                            @else
                                                {{ \Carbon\Carbon::parse($absence->date_absence)->format('d/m/Y') }}
                                            @endif
                                        </p>
                                    </div>
                                    <span class="px-3 py-1 rounded-full text-xs {{ $absence->justifie ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $absence->justifie ? 'Justifiée' : 'Non justifiée' }}
                                    </span>
                                </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-500">Aucune absence récente</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Deux cartes du bas -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Carte Profil -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="px-6 py-4 bg-blue-600 text-white">
                        <h3 class="text-lg font-semibold">Mon Profil</h3>
                    </div>
                    <div class="p-6">
                        <div class="flex flex-col space-y-4">
                            <div>
                                <span class="text-sm text-gray-500">Adresse</span>
                                <p class="font-medium">{{ $etudiant->adresse ?? 'Non spécifié' }}</p>
                            </div>
                            <div>
                                <span class="text-sm text-gray-500">Email</span>
                                <p class="font-medium">{{ $etudiant->email ?? 'Non spécifié' }}</p>
                            </div>
                            <div>
                                <span class="text-sm text-gray-500">Téléphone</span>
                                <p class="font-medium">{{ $etudiant->telephone ?? 'Non spécifié' }}</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('etudiant.profile.edit') }}" class="text-blue-600 hover:text-blue-800 font-medium">Modifier le profil</a>
                        </div>
                    </div>
                </div>

                <!-- Carte Documents -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="px-6 py-4 bg-blue-600 text-white">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold">Mes Documents</h3>
                            <a href="{{ route('etudiant.documents.index') }}" class="text-sm font-medium hover:text-blue-200">Voir tout</a>
                        </div>
                    </div>
                    <div class="p-6">
                        @if($documents->count() > 0)
                            <ul class="space-y-3">
                                @foreach($documents->take(3) as $document)
                                <li class="flex justify-between items-center p-2 border-b">
                                    <div>
                                        <p class="font-medium">{{ $document->titre }}</p>
                                        <p class="text-sm text-gray-500">{{ $document->module->nom ?? 'Général' }}</p>
                                    </div>
                                    <a href="{{ asset('storage/'.$document->fichier) }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm">
                                        Télécharger
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-500">Aucun document disponible</p>
                        @endif
                    </div>
                </div>
            </div>
            <!-- Après la section "Deux cartes du bas" -->
<div class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 bg-blue-600 text-white">
            <h3 class="text-lg font-semibold">Mon QR Code de Présence</h3>
        </div>
        <div class="p-6 text-center">
            <div class="flex justify-center mb-4">
                {!! $qrCode !!}
            </div>
            <p class="text-gray-600 mb-2">
                Présentez ce QR Code à votre admin pour enregistrer votre présence
            </p>
            <p class="text-sm text-gray-500">
                Valable pour aujourd'hui seulement - {{ now()->format('d/m/Y') }}
            </p>
            <input type="hidden" id="qrData" value="{{ $qrData }}">
        </div>
    </div>
</div>
        </div>
    </div>
</div>
