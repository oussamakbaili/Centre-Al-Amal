@extends('layouts.enseignant')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Marquer les Absences</h1>
    
    <div class="card mb-4">
        <div class="card-header bg-dark text-white">
            <i class="fas fa-calendar-times me-1"></i>
            Nouvelle Séance - {{ now()->format('d/m/Y') }}
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('enseignant.absences.store') }}">
                @csrf
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="module_id" class="form-label">Module</label>
                        <select class="form-select" id="module_id" name="module_id" required>
                            @foreach($modules as $module)
                            <option value="{{ $module->id }}">{{ $module->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="seance_id" class="form-label">Séance</label>
                        <select class="form-select" id="seance_id" name="seance_id" required>
                            <!-- Options chargées via AJAX -->
                        </select>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>Étudiant</th>
                                <th>Présent</th>
                                <th>Absent</th>
                                <th>Justifié</th>
                                <th>Commentaire</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($etudiants as $etudiant)
                            <tr>
                                <td>{{ $etudiant->nom_complet }}</td>
                                <td class="text-center">
                                    <input type="radio" name="statut[{{ $etudiant->id }}]" value="present" checked>
                                </td>
                                <td class="text-center">
                                    <input type="radio" name="statut[{{ $etudiant->id }}]" value="absent">
                                </td>
                                <td class="text-center">
                                    <input type="radio" name="statut[{{ $etudiant->id }}]" value="justifie">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="commentaire[{{ $etudiant->id }}]">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Chargement dynamique des séances selon le module sélectionné
    $('#module_id').change(function() {
        $.get('/enseignant/get-seances/' + $(this).val(), function(data) {
            $('#seance_id').empty();
            $.each(data, function(key, value) {
                $('#seance_id').append(`<option value="${key}">${value}</option>`);
            });
        });
    });
</script>
@endpush