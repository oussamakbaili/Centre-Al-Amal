@extends('layouts.admin')

@section('title', 'Gestion des Absences')
@section('page-title', 'Gestion des Absences')
@section('page-description', 'Gérez les absences des étudiants et enseignants du Centre Al-Amal')

@section('header-actions')
    <a href="{{ route('admin.absences.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center">
        <i class="fas fa-plus mr-2"></i>
        Nouvelle Absence
    </a>
@endsection

@section('content')
    <div class="space-y-6">
        @if (session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <!-- Filter Section -->
        <div class="notion-card rounded-xl p-4">
            <form method="GET" action="{{ route('admin.absences.index') }}" class="flex items-center space-x-4">
                <div class="flex items-center space-x-2">
                    <label for="type" class="text-sm font-medium text-gray-700">Afficher les absences pour :</label>
                    <select name="type" id="type" class="form-input border border-gray-300 rounded-lg px-3 py-2 focus:ring-1 focus:ring-blue-500 focus:border-blue-500" onchange="this.form.submit()">
                        <option value="Étudiant" {{ $type == 'Étudiant' ? 'selected' : '' }}>Étudiants</option>
                        <option value="Enseignant" {{ $type == 'Enseignant' ? 'selected' : '' }}>Enseignants</option>
                    </select>
                </div>
            </form>
        </div>

        <!-- Results Header -->
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-900">
                Absences des {{ $type == 'Enseignant' ? 'enseignants' : 'étudiants' }}
            </h3>
            <span class="text-sm text-gray-500">{{ count($absences) }} absence(s) trouvée(s)</span>
        </div>

        <!-- Absences List -->
        <div class="space-y-4">
            @forelse ($absences as $absence)
                <div class="notion-card rounded-xl p-5 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4 flex-1">
                            <div class="w-10 h-10 bg-{{ $absence->etat == 'Justifié' ? 'emerald' : 'red' }}-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-{{ $absence->etat == 'Justifié' ? 'check' : 'times' }} text-{{ $absence->etat == 'Justifié' ? 'emerald' : 'red' }}-600"></i>
                            </div>
                            
                            <div class="flex-1">
                                <div class="flex items-center space-x-3">
                                    <h4 class="font-semibold text-gray-900">
                                        @if ($type == 'Enseignant')
                                            {{ $absence->enseignant ? $absence->enseignant->nom . ' ' . $absence->enseignant->prenom : 'Sans enseignant' }}
                                        @else
                                            {{ $absence->etudiant ? $absence->etudiant->nom . ' ' . $absence->etudiant->prenom : 'Sans étudiant' }}
                                        @endif
                                    </h4>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $absence->etat == 'Justifié' ? 'emerald' : 'red' }}-100 text-{{ $absence->etat == 'Justifié' ? 'emerald' : 'red' }}-800">
                                        {{ $absence->etat }}
                                    </span>
                                </div>
                                <div class="flex items-center space-x-4 text-sm text-gray-500 mt-1">
                                    <span>
                                        <i class="fas fa-calendar mr-1"></i>
                                        {{ \Carbon\Carbon::parse($absence->date_absence)->format('d/m/Y') }}
                                    </span>
                                    @if($absence->module)
                                        <span>•</span>
                                        <span>
                                            <i class="fas fa-book mr-1"></i>
                                            {{ $absence->module->nom }}
                                        </span>
                                    @endif
                                    @if($absence->motif)
                                        <span>•</span>
                                        <span class="truncate max-w-xs" title="{{ $absence->motif }}">{{ $absence->motif }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('admin.absences.edit', $absence->id) }}" 
                               class="text-gray-600 hover:text-blue-600 transition-colors p-2"
                               title="Modifier">
                                <i class="fas fa-edit"></i>
                            </a>
                            
                            <form action="{{ route('admin.absences.destroy', $absence->id) }}" 
                                  method="POST" 
                                  class="inline"
                                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette absence ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="text-gray-600 hover:text-red-600 transition-colors p-2"
                                        title="Supprimer">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="notion-card rounded-xl p-8 text-center">
                    <i class="fas fa-calendar-times text-gray-300 text-3xl mb-3"></i>
                    <h3 class="font-medium text-gray-900 mb-2">Aucune absence trouvée</h3>
                    <p class="text-gray-500 mb-4">Aucune absence n'a été enregistrée pour les {{ $type == 'Enseignant' ? 'enseignants' : 'étudiants' }}.</p>
                    <a href="{{ route('admin.absences.create') }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors inline-flex items-center">
                        <i class="fas fa-plus mr-2"></i>
                        Ajouter une absence
                    </a>
                </div>
            @endforelse
        </div>
    </div>
@endsection
