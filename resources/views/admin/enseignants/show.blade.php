@extends('layouts.admin')

@section('title', 'Détails de l\'Enseignant')
@section('page-title', 'Détails de l\'Enseignant')
@section('page-description', 'Informations détaillées de l\'enseignant')

@section('header-actions')
    <div class="flex space-x-3">
        <a href="{{ route('admin.enseignants.edit', $enseignant->id) }}" 
           class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-xl font-medium transition-all duration-200 flex items-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
            <i class="fas fa-edit mr-2"></i>
            Modifier
        </a>
        <a href="{{ route('admin.enseignants.index') }}" 
           class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-xl font-medium transition-all duration-200 flex items-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
            <i class="fas fa-arrow-left mr-2"></i>
            Retour
        </a>
    </div>
@endsection

@section('content')
    <div class="space-y-8">
        <!-- Enseignant Profile Card -->
        <div class="notion-card rounded-xl p-8">
            <div class="flex flex-col lg:flex-row lg:items-start lg:space-x-8">
                <!-- Photo -->
                <div class="flex-shrink-0 mb-6 lg:mb-0">
                    <div class="w-32 h-32 mx-auto lg:mx-0">
                        @if($enseignant->photo)
                            <img class="w-full h-full rounded-full object-cover border-4 border-emerald-200 shadow-lg" 
                                 src="{{ asset('storage/' . $enseignant->photo) }}" 
                                 alt="{{ $enseignant->nom }}">
                        @else
                            <div class="w-full h-full rounded-full bg-emerald-100 flex items-center justify-center border-4 border-emerald-200 shadow-lg">
                                <i class="fas fa-user-tie text-emerald-600 text-4xl"></i>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Info -->
                <div class="flex-1 text-center lg:text-left">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">
                        {{ $enseignant->nom }} {{ $enseignant->prenom }}
                    </h1>
                    <p class="text-lg text-gray-600 mb-4">Enseignant</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex items-center">
                                <i class="fas fa-envelope text-gray-400 mr-3"></i>
                                <div>
                                    <p class="text-sm text-gray-500">Email</p>
                                    <p class="font-medium text-gray-900">{{ $enseignant->email }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex items-center">
                                <i class="fas fa-phone text-gray-400 mr-3"></i>
                                <div>
                                    <p class="text-sm text-gray-500">Téléphone</p>
                                    <p class="font-medium text-gray-900">
                                        @if(isset($enseignant->telephone) && $enseignant->telephone)
                                            {{ $enseignant->telephone }}
                                        @else
                                            <span class="text-gray-400">Non renseigné</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex items-center">
                                <i class="fas fa-book text-gray-400 mr-3"></i>
                                <div>
                                    <p class="text-sm text-gray-500">Module Assigné</p>
                                    @if($enseignant->module)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                                            {{ $enseignant->module->nom }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                            Aucun module
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex items-center">
                                <i class="fas fa-calendar text-gray-400 mr-3"></i>
                                <div>
                                    <p class="text-sm text-gray-500">Date d'inscription</p>
                                    <p class="font-medium text-gray-900">
                                        {{ $enseignant->created_at ? $enseignant->created_at->format('d/m/Y') : 'Non disponible' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="notion-card rounded-xl p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Étudiants</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalStudents }}</p>
                        <p class="text-xs text-gray-500">dans son module</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-users text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="notion-card rounded-xl p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Cours cette semaine</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $recentClasses }}</p>
                        <p class="text-xs text-gray-500">derniers 7 jours</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-chalkboard text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="notion-card rounded-xl p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Statut</p>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <i class="fas fa-check mr-1"></i>
                            Actif
                        </span>
                    </div>
                    <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-check-circle text-emerald-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Module Details (if assigned) -->
        @if($enseignant->module)
            <div class="notion-card rounded-xl p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-book text-purple-600 mr-2"></i>
                    Détails du Module
                </h3>
                
                <div class="bg-purple-50 rounded-lg p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="font-semibold text-purple-900 mb-2">{{ $enseignant->module->nom }}</h4>
                            <p class="text-purple-700 text-sm mb-3">
                                @if(isset($enseignant->module->description))
                                    {{ $enseignant->module->description }}
                                @else
                                    Description non disponible
                                @endif
                            </p>
                            
                            @if(isset($enseignant->module->coefficient))
                                <div class="flex items-center text-sm text-purple-600">
                                    <i class="fas fa-star mr-2"></i>
                                    <span>Coefficient: {{ $enseignant->module->coefficient }}</span>
                                </div>
                            @endif
                        </div>
                        
                        <div>
                            @if(isset($enseignant->module->heures_cours))
                                <div class="flex items-center text-sm text-purple-600 mb-2">
                                    <i class="fas fa-clock mr-2"></i>
                                    <span>{{ $enseignant->module->heures_cours }} heures de cours</span>
                                </div>
                            @endif
                            
                            <div class="flex items-center text-sm text-purple-600">
                                <i class="fas fa-users mr-2"></i>
                                <span>{{ $totalStudents }} étudiant(s) inscrit(s)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Actions -->
        <div class="notion-card rounded-xl p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-cogs text-gray-600 mr-2"></i>
                Actions Rapides
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('admin.enseignants.edit', $enseignant->id) }}" 
                   class="flex items-center justify-center p-4 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition-colors duration-200">
                    <i class="fas fa-edit text-indigo-600 mr-3"></i>
                    <span class="font-medium text-indigo-700">Modifier les informations</span>
                </a>
                
                @if(isset($enseignant->id))
                    <a href="{{ route('admin.enseignants.absences', $enseignant->id) }}" 
                       class="flex items-center justify-center p-4 bg-yellow-50 hover:bg-yellow-100 rounded-lg transition-colors duration-200">
                        <i class="fas fa-calendar-times text-yellow-600 mr-3"></i>
                        <span class="font-medium text-yellow-700">Voir les absences</span>
                    </a>
                @endif
                
                <button type="button" 
                        onclick="if(confirm('Êtes-vous sûr de vouloir supprimer cet enseignant ?')) { document.getElementById('delete-form').submit(); }"
                        class="flex items-center justify-center p-4 bg-red-50 hover:bg-red-100 rounded-lg transition-colors duration-200">
                    <i class="fas fa-trash text-red-600 mr-3"></i>
                    <span class="font-medium text-red-700">Supprimer</span>
                </button>
            </div>
            
            <!-- Hidden delete form -->
            <form id="delete-form" action="{{ route('admin.enseignants.destroy', $enseignant->id) }}" method="POST" class="hidden">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>
@endsection 