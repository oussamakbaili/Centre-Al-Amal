@extends('layouts.admin')

@section('title', 'Nouvelle Absence')
@section('page-title', 'Nouvelle Absence')
@section('page-description', 'Enregistrer une nouvelle absence pour un étudiant ou un enseignant')

@section('header-actions')
    <a href="{{ route('admin.absences.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center">
        <i class="fas fa-arrow-left mr-2"></i>
        Retour à la liste
    </a>
@endsection

@section('content')
    <div class="max-w-2xl mx-auto">
        @if (session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-lg mb-6">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <div class="notion-card rounded-xl p-6">
            <form action="{{ route('admin.absences.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Type Selection -->
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Type d'absence</label>
                    <select name="type" id="type" class="form-input block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-1 focus:ring-blue-500 focus:border-blue-500" onchange="toggleSelects()">
                        <option value="Étudiant">Étudiant</option>
                        <option value="Enseignant">Enseignant</option>
                    </select>
                </div>

                <!-- Student Selection -->
                <div id="etudiantSelect">
                    <label for="etudiant_id" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-user-graduate mr-1"></i>
                        Étudiant
                    </label>
                    <select name="etudiant_id" class="form-input block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Sélectionnez un étudiant</option>
                        @foreach ($etudiants as $etudiant)
                            <option value="{{ $etudiant->id }}">{{ $etudiant->nom }} {{ $etudiant->prenom }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Teacher Selection -->
                <div id="enseignantSelect" style="display: none;">
                    <label for="enseignant_id" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-chalkboard-teacher mr-1"></i>
                        Enseignant
                    </label>
                    <select name="enseignant_id" class="form-input block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Sélectionnez un enseignant</option>
                        @foreach ($enseignants as $enseignant)
                            <option value="{{ $enseignant->id }}">{{ $enseignant->nom }} {{ $enseignant->prenom }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Module Selection -->
                <div id="moduleSelect">
                    <label for="module_id" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-book mr-1"></i>
                        Module
                    </label>
                    <select name="module_id" class="form-input block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Sélectionnez un module</option>
                        @foreach ($modules as $module)
                            <option value="{{ $module->id }}">{{ $module->nom }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Date -->
                <div>
                    <label for="date_absence" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-calendar mr-1"></i>
                        Date d'absence
                    </label>
                    <input type="date" name="date_absence" id="date_absence" 
                           class="form-input block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-1 focus:ring-blue-500 focus:border-blue-500" 
                           required>
                </div>

                <!-- Status -->
                <div>
                    <label for="etat" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-info-circle mr-1"></i>
                        État
                    </label>
                    <select name="etat" id="etat" class="form-input block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-1 focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="Justifié">Justifié</option>
                        <option value="Non justifié">Non justifié</option>
                    </select>
                </div>

                <!-- Reason -->
                <div>
                    <label for="motif" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-comment mr-1"></i>
                        Motif (optionnel)
                    </label>
                    <textarea name="motif" id="motif" rows="3" 
                              class="form-input block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-1 focus:ring-blue-500 focus:border-blue-500" 
                              placeholder="Décrivez le motif de l'absence..."></textarea>
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
                        Enregistrer l'absence
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function toggleSelects() {
        var type = document.getElementById('type').value;
        // Toggle student/teacher selects
        document.getElementById('etudiantSelect').style.display = (type === 'Étudiant') ? 'block' : 'none';
        document.getElementById('enseignantSelect').style.display = (type === 'Enseignant') ? 'block' : 'none';
        // Toggle module select (only show for students)
        document.getElementById('moduleSelect').style.display = (type === 'Étudiant') ? 'block' : 'none';
        // Make module required only for students
        document.querySelector('[name="module_id"]').required = (type === 'Étudiant');
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        toggleSelects();
    });
</script>
@endpush
