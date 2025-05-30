@extends('layouts.admin')

@section('title', 'Statistiques des Notes')
@section('page-title', 'Statistiques des Notes')
@section('page-description', 'Analysez les performances académiques des étudiants')

@section('header-actions')
    <div class="flex space-x-3">
        <a href="{{ route('admin.notes.export') }}" 
           class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-xl font-medium transition-all duration-200 flex items-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
            <i class="fas fa-download mr-2"></i>
            Exporter
        </a>
        <a href="{{ route('admin.notes.index') }}" 
           class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-xl font-medium transition-all duration-200 flex items-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
            <i class="fas fa-arrow-left mr-2"></i>
            Retour
        </a>
    </div>
@endsection

@section('content')
    <!-- Overview Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="notion-card rounded-xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Notes</p>
                    <p class="text-3xl font-bold text-gray-900">{{ number_format($totalNotes) }}</p>
                </div>
                <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-clipboard-list text-indigo-600 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="notion-card rounded-xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Moyenne Générale</p>
                    <p class="text-3xl font-bold text-gray-900">{{ number_format($moyenneGenerale, 1) }}/20</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-chart-line text-green-600 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="notion-card rounded-xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Taux de Réussite</p>
                    <p class="text-3xl font-bold text-gray-900">{{ number_format($tauxReussite, 1) }}%</p>
                </div>
                <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-trophy text-emerald-600 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="notion-card rounded-xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Modules</p>
                    <p class="text-3xl font-bold text-gray-900">{{ number_format($totalModules) }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-book text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Statistics by Module -->
        <div class="notion-card rounded-xl p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                <i class="fas fa-chart-bar mr-3 text-indigo-500"></i>
                Statistiques par Module
            </h3>
            <div class="space-y-4">
                @forelse($notesByModule as $module)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="font-medium text-gray-900">{{ $module->nom }}</h4>
                            <span class="text-sm text-gray-500">{{ $module->notes_count }} notes</span>
                        </div>
                        @if($module->notes->count() > 0)
                            @php
                                $moduleAvg = $module->notes->first()->moyenne ?? 0;
                            @endphp
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Moyenne:</span>
                                <span class="font-semibold 
                                    @if($moduleAvg >= 16) text-green-600
                                    @elseif($moduleAvg >= 14) text-blue-600
                                    @elseif($moduleAvg >= 12) text-yellow-600
                                    @elseif($moduleAvg >= 10) text-orange-600
                                    @else text-red-600
                                    @endif">
                                    {{ number_format($moduleAvg, 1) }}/20
                                </span>
                            </div>
                            <!-- Progress bar -->
                            <div class="mt-2">
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="h-2 rounded-full 
                                        @if($moduleAvg >= 16) bg-green-500
                                        @elseif($moduleAvg >= 14) bg-blue-500
                                        @elseif($moduleAvg >= 12) bg-yellow-500
                                        @elseif($moduleAvg >= 10) bg-orange-500
                                        @else bg-red-500
                                        @endif" 
                                        style="width: {{ ($moduleAvg / 20) * 100 }}%"></div>
                                </div>
                            </div>
                        @else
                            <p class="text-sm text-gray-500">Aucune note enregistrée</p>
                        @endif
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">Aucun module trouvé</p>
                @endforelse
            </div>
        </div>

        <!-- Top Students -->
        <div class="notion-card rounded-xl p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                <i class="fas fa-medal mr-3 text-yellow-500"></i>
                Top 10 Étudiants
            </h3>
            <div class="space-y-3">
                @forelse($topEtudiants as $index => $etudiant)
                    <div class="flex items-center space-x-4 p-3 bg-gray-50 rounded-lg">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center
                                @if($index < 3) bg-yellow-100 text-yellow-800
                                @else bg-gray-100 text-gray-600
                                @endif font-bold text-sm">
                                @if($index == 0)
                                    <i class="fas fa-crown"></i>
                                @elseif($index == 1)
                                    <i class="fas fa-medal"></i>
                                @elseif($index == 2)
                                    <i class="fas fa-award"></i>
                                @else
                                    {{ $index + 1 }}
                                @endif
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-900 truncate">
                                        {{ $etudiant->nom }} {{ $etudiant->prenom }}
                                    </p>
                                    <p class="text-xs text-gray-500">{{ $etudiant->niveau ?? 'Niveau non défini' }}</p>
                                </div>
                                <div class="text-right">
                                    @if($etudiant->notes_avg_note)
                                        <span class="text-sm font-semibold 
                                            @if($etudiant->notes_avg_note >= 16) text-green-600
                                            @elseif($etudiant->notes_avg_note >= 14) text-blue-600
                                            @elseif($etudiant->notes_avg_note >= 12) text-yellow-600
                                            @elseif($etudiant->notes_avg_note >= 10) text-orange-600
                                            @else text-red-600
                                            @endif">
                                            {{ number_format($etudiant->notes_avg_note, 1) }}/20
                                        </span>
                                    @else
                                        <span class="text-sm text-gray-400">-</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">Aucun étudiant avec des notes</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Grade Distribution -->
    <div class="mt-8">
        <div class="notion-card rounded-xl p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                <i class="fas fa-chart-pie mr-3 text-purple-500"></i>
                Répartition des Appréciations
            </h3>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                @php
                    $excellent = \App\Models\Note::where('note', '>=', 16)->count();
                    $bien = \App\Models\Note::whereBetween('note', [14, 15.99])->count();
                    $assezBien = \App\Models\Note::whereBetween('note', [12, 13.99])->count();
                    $passable = \App\Models\Note::whereBetween('note', [10, 11.99])->count();
                    $insuffisant = \App\Models\Note::where('note', '<', 10)->count();
                @endphp
                
                <div class="text-center p-4 bg-green-50 rounded-xl">
                    <div class="text-2xl font-bold text-green-600">{{ $excellent }}</div>
                    <div class="text-sm text-green-700">Excellent</div>
                    <div class="text-xs text-green-600">(≥16)</div>
                </div>
                
                <div class="text-center p-4 bg-blue-50 rounded-xl">
                    <div class="text-2xl font-bold text-blue-600">{{ $bien }}</div>
                    <div class="text-sm text-blue-700">Bien</div>
                    <div class="text-xs text-blue-600">(14-16)</div>
                </div>
                
                <div class="text-center p-4 bg-yellow-50 rounded-xl">
                    <div class="text-2xl font-bold text-yellow-600">{{ $assezBien }}</div>
                    <div class="text-sm text-yellow-700">Assez bien</div>
                    <div class="text-xs text-yellow-600">(12-14)</div>
                </div>
                
                <div class="text-center p-4 bg-orange-50 rounded-xl">
                    <div class="text-2xl font-bold text-orange-600">{{ $passable }}</div>
                    <div class="text-sm text-orange-700">Passable</div>
                    <div class="text-xs text-orange-600">(10-12)</div>
                </div>
                
                <div class="text-center p-4 bg-red-50 rounded-xl">
                    <div class="text-2xl font-bold text-red-600">{{ $insuffisant }}</div>
                    <div class="text-sm text-red-700">Insuffisant</div>
                    <div class="text-xs text-red-600">(<10)</div>
                </div>
            </div>
        </div>
    </div>
@endsection 