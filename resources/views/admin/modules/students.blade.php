@extends('layouts.admin')

@section('title', 'Étudiants du Module')
@section('page-title', 'Étudiants du Module: ' . $module->nom)
@section('page-description', 'Liste des étudiants inscrits dans ce module')

@section('header-actions')
    <div class="flex space-x-2">
        <a href="{{ route('admin.notes.create') }}?module={{ $module->id }}" 
           class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center">
            <i class="fas fa-plus mr-2"></i>
            Ajouter Note
        </a>
        <a href="{{ route('admin.modules.index') }}" 
           class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center">
            <i class="fas fa-arrow-left mr-2"></i>
            Retour
        </a>
    </div>
@endsection

@section('content')
    <div class="space-y-6">
        <!-- Module Header - Simplified -->
        <div class="notion-card rounded-xl p-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-book text-purple-600"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">{{ $module->nom }}</h1>
                        @if($module->enseignant)
                            <p class="text-sm text-gray-500">{{ $module->enseignant->nom }} {{ $module->enseignant->prenom }}</p>
                        @endif
                    </div>
                </div>
                
                @php
                    $averageGrade = $module->notes()->avg('note');
                @endphp
                <div class="flex items-center space-x-6 text-sm">
                    <div class="text-center">
                        <div class="font-semibold text-gray-900">{{ $module->etudiants->count() }}</div>
                        <div class="text-gray-500">Étudiants</div>
                    </div>
                    @if($averageGrade)
                        <div class="text-center">
                            <div class="font-semibold text-gray-900">{{ number_format($averageGrade, 1) }}/20</div>
                            <div class="text-gray-500">Moyenne</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Students List -->
        <div class="notion-card rounded-xl overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Étudiants ({{ $module->etudiants->count() }})</h3>
            </div>

            @if($module->etudiants->count() > 0)
                <div class="divide-y divide-gray-100">
                    @foreach($module->etudiants as $etudiant)
                        @php
                            $studentAverage = $module->notes()->where('etudiant_id', $etudiant->id)->avg('note');
                        @endphp
                        <div class="px-6 py-4 hover:bg-gray-50 transition-colors duration-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        @if(isset($etudiant->photo) && $etudiant->photo)
                                            <img class="h-10 w-10 rounded-full object-cover" 
                                                 src="{{ asset('storage/' . $etudiant->photo) }}" 
                                                 alt="{{ $etudiant->nom }}">
                                        @else
                                            <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                                <i class="fas fa-user-graduate text-blue-600"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900">
                                            {{ $etudiant->nom }} {{ $etudiant->prenom }}
                                        </div>
                                        <div class="text-sm text-gray-500">{{ $etudiant->email }}</div>
                                    </div>
                                </div>
                                
                                <div class="flex items-center space-x-4">
                                    @if($studentAverage)
                                        @php
                                            $gradeColor = $studentAverage >= 16 ? 'text-green-600 bg-green-50' : 
                                                        ($studentAverage >= 12 ? 'text-blue-600 bg-blue-50' : 
                                                        ($studentAverage >= 10 ? 'text-yellow-600 bg-yellow-50' : 'text-red-600 bg-red-50'));
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-sm font-medium {{ $gradeColor }}">
                                            {{ number_format($studentAverage, 1) }}/20
                                        </span>
                                    @else
                                        <span class="text-gray-400 text-sm">Aucune note</span>
                                    @endif
                                    
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.etudiants.show', $etudiant->id) }}" 
                                           class="text-gray-600 hover:text-blue-600 transition-colors"
                                           title="Voir profil">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.notes.create') }}?etudiant={{ $etudiant->id }}&module={{ $module->id }}" 
                                           class="text-gray-600 hover:text-green-600 transition-colors"
                                           title="Ajouter note">
                                            <i class="fas fa-plus"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="px-6 py-12 text-center">
                    <i class="fas fa-user-graduate text-gray-300 text-4xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun étudiant inscrit</h3>
                    <p class="text-gray-500 mb-4">Ce module n'a pas encore d'étudiants inscrits.</p>
                    <a href="{{ route('admin.etudiants.index') }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl font-medium transition-all duration-200">
                        <i class="fas fa-users mr-2"></i>
                        Gérer les Étudiants
                    </a>
                </div>
            @endif
        </div>


    </div>
@endsection 