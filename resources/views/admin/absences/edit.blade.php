@extends('layouts.admin')

@section('title', 'Modifier l\'Absence')
@section('page-title', 'Modifier l\'Absence')
@section('page-description', 'Modifier les détails de cette absence')

@section('header-actions')
    <a href="{{ route('admin.absences.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center">
        <i class="fas fa-arrow-left mr-2"></i>
        Retour à la liste
    </a>
@endsection

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="notion-card rounded-xl p-6">
            <!-- Current Info Header -->
            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Absence actuelle</h3>
                <div class="space-y-1 text-sm text-gray-600">
                    <div class="flex items-center">
                        <i class="fas fa-user mr-2"></i>
                        <span>
                            @if($absence->etudiant)
                                <strong>Étudiant:</strong> {{ $absence->etudiant->nom }} {{ $absence->etudiant->prenom }}
                            @elseif($absence->enseignant)
                                <strong>Enseignant:</strong> {{ $absence->enseignant->nom }} {{ $absence->enseignant->prenom }}
                            @endif
                        </span>
                    </div>
                    @if($absence->module)
                        <div class="flex items-center">
                            <i class="fas fa-book mr-2"></i>
                            <span><strong>Module:</strong> {{ $absence->module->nom }}</span>
                        </div>
                    @endif
                    <div class="flex items-center">
                        <i class="fas fa-calendar mr-2"></i>
                        <span><strong>Date actuelle:</strong> {{ \Carbon\Carbon::parse($absence->date_absence)->format('d/m/Y') }}</span>
                    </div>
                </div>
            </div>

            <form action="{{ route('admin.absences.update', $absence->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Date -->
                <div>
                    <label for="date_absence" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-calendar mr-1"></i>
                        Date d'absence
                    </label>
                    <input type="date" name="date_absence" id="date_absence" 
                           class="form-input block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-1 focus:ring-blue-500 focus:border-blue-500" 
                           value="{{ $absence->date_absence }}" 
                           required>
                </div>

                <!-- Status -->
                <div>
                    <label for="etat" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-info-circle mr-1"></i>
                        État
                    </label>
                    <select name="etat" id="etat" class="form-input block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-1 focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="Justifié" {{ $absence->etat == 'Justifié' ? 'selected' : '' }}>Justifié</option>
                        <option value="Non justifié" {{ $absence->etat == 'Non justifié' ? 'selected' : '' }}>Non justifié</option>
                    </select>
                    <p class="mt-1 text-sm text-gray-500">
                        État actuel: 
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $absence->etat == 'Justifié' ? 'emerald' : 'red' }}-100 text-{{ $absence->etat == 'Justifié' ? 'emerald' : 'red' }}-800">
                            {{ $absence->etat }}
                        </span>
                    </p>
                </div>

                <!-- Reason -->
                <div>
                    <label for="motif" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-comment mr-1"></i>
                        Motif (optionnel)
                    </label>
                    <textarea name="motif" id="motif" rows="4" 
                              class="form-input block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-1 focus:ring-blue-500 focus:border-blue-500" 
                              placeholder="Décrivez le motif de l'absence...">{{ $absence->motif }}</textarea>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200">
                    <a href="{{ route('admin.absences.index') }}" 
                       class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium transition-colors">
                        Annuler
                    </a>
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors flex items-center">
                        <i class="fas fa-save mr-2"></i>
                        Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
