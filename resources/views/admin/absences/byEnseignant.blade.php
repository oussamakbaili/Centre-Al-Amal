@extends('layouts.admin')

@section('title', 'Absences de l\'Enseignant')
@section('page-title', 'Absences de l\'Enseignant')
@section('page-description', 'Consulter les absences de {{ $enseignant->nom }} {{ $enseignant->prenom }}')

@section('header-actions')
    <a href="{{ route('admin.enseignants.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center">
        <i class="fas fa-arrow-left mr-2"></i>
        Retour aux enseignants
    </a>
@endsection

@section('content')
    <div class="space-y-6">
        <!-- Teacher Info Card -->
        <div class="notion-card rounded-xl p-6">
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 bg-blue-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-chalkboard-teacher text-blue-600 text-xl"></i>
                </div>
                <div class="flex-1">
                    <h2 class="text-xl font-bold text-gray-900">{{ $enseignant->nom }} {{ $enseignant->prenom }}</h2>
                    <p class="text-gray-600">{{ $enseignant->email ?? 'Email non renseigné' }}</p>
                    <div class="flex items-center space-x-4 text-sm text-gray-500 mt-2">
                        <span>
                            <i class="fas fa-calendar-times mr-1"></i>
                            {{ $absences->count() }} absence(s) enregistrée(s)
                        </span>
                        @php
                            $justifiedCount = $absences->where('etat', 'Justifié')->count();
                            $unjustifiedCount = $absences->where('etat', 'Non justifié')->count();
                        @endphp
                        @if($justifiedCount > 0)
                            <span>•</span>
                            <span class="text-emerald-600">{{ $justifiedCount }} justifiée(s)</span>
                        @endif
                        @if($unjustifiedCount > 0)
                            <span>•</span>
                            <span class="text-red-600">{{ $unjustifiedCount }} non justifiée(s)</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Absences List -->
        <div class="space-y-4">
            <h3 class="text-lg font-semibold text-gray-900">Historique des absences</h3>
            
            @forelse($absences as $absence)
                <div class="notion-card rounded-xl p-5 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4 flex-1">
                            <div class="w-10 h-10 bg-{{ $absence->etat == 'Justifié' ? 'emerald' : 'red' }}-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-{{ $absence->etat == 'Justifié' ? 'check' : 'times' }} text-{{ $absence->etat == 'Justifié' ? 'emerald' : 'red' }}-600"></i>
                            </div>
                            
                            <div class="flex-1">
                                <div class="flex items-center space-x-3">
                                    <h4 class="font-semibold text-gray-900">
                                        {{ $absence->date_absence ? \Carbon\Carbon::parse($absence->date_absence)->format('d/m/Y') : 'Date non disponible' }}
                                    </h4>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $absence->etat == 'Justifié' ? 'emerald' : 'red' }}-100 text-{{ $absence->etat == 'Justifié' ? 'emerald' : 'red' }}-800">
                                        {{ $absence->etat }}
                                    </span>
                                </div>
                                @if($absence->motif)
                                    <p class="text-sm text-gray-600 mt-1">
                                        <i class="fas fa-comment mr-1"></i>
                                        {{ $absence->motif }}
                                    </p>
                                @else
                                    <p class="text-sm text-gray-400 mt-1">
                                        <i class="fas fa-comment mr-1"></i>
                                        Aucun motif renseigné
                                    </p>
                                @endif
                            </div>
                        </div>
                        
                        <div class="text-right text-sm text-gray-500">
                            {{ \Carbon\Carbon::parse($absence->date_absence)->diffForHumans() }}
                        </div>
                    </div>
                </div>
            @empty
                <div class="notion-card rounded-xl p-8 text-center">
                    <i class="fas fa-calendar-check text-gray-300 text-3xl mb-3"></i>
                    <h3 class="font-medium text-gray-900 mb-2">Aucune absence enregistrée</h3>
                    <p class="text-gray-500">Cet enseignant n'a aucune absence dans le système.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
