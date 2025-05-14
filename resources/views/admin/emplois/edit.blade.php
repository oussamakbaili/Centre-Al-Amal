@extends('layouts.admin')

@section('content')
<h2>Modifier l'emploi du temps</h2>

<form action="{{ route('admin.emplois.update', $emploi->id) }}" method="POST">
    @csrf
    @method('PUT')
    
    <!-- Les mêmes champs que create.blade.php -->
    <!-- Pré-remplir les valeurs existantes -->
    
    <div class="form-group">
        <label>Enseignant</label>
        <select name="enseignant_id" id="enseignant_id" class="form-control" required>
            <option value="">Sélectionner un enseignant</option>
            @foreach($enseignants as $enseignant)
                <option value="{{ $enseignant->id }}" {{ $emploi->enseignant_id == $enseignant->id ? 'selected' : '' }}>
                    {{ $enseignant->nom }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label>Module</label>
        <select name="module_id" id="module_id" class="form-control" required>
            <option value="">Chargement...</option>
            @if($emploi->module)
                <option value="{{ $emploi->module_id }}" selected>{{ $emploi->module->nom }}</option>
            @endif
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Mettre à jour</button>
</form>

<script>
// Le même script que dans create.blade.php
// Avec en plus la pré-sélection du module
document.addEventListener('DOMContentLoaded', function() {
    var enseignantId = document.getElementById('enseignant_id').value;
    if (enseignantId) {
        // Charger les modules pour l'enseignant sélectionné
        fetch(`/admin/enseignants/${enseignantId}/modules`)
            .then(response => response.json())
            .then(data => {
                var moduleSelect = document.getElementById('module_id');
                var currentModuleId = "{{ $emploi->module_id }}";
                
                moduleSelect.innerHTML = '<option value="">Sélectionner un module</option>';
                data.forEach(module => {
                    var selected = module.id == currentModuleId ? 'selected' : '';
                    moduleSelect.innerHTML += `<option value="${module.id}" ${selected}>${module.nom}</option>`;
                });
            });
    }
});
</script>
@endsection