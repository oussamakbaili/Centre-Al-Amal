<div class="container mt-4">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.absences.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="type">Type</label>
            <select name="type" id="type" class="form-control" onchange="toggleSelects()">
                <option value="Étudiant">Étudiant</option>
                <option value="Enseignant">Enseignant</option>
            </select>
        </div>

        <div class="mb-3" id="etudiantSelect">
            <label for="etudiant_id">Étudiant</label>
            <select name="etudiant_id" class="form-control">
                <option value="">Sélectionnez un étudiant</option>
                @foreach ($etudiants as $etudiant)
                    <option value="{{ $etudiant->id }}">{{ $etudiant->nom }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3" id="enseignantSelect" style="display: none;">
            <label for="enseignant_id">Enseignant</label>
            <select name="enseignant_id" class="form-control">
                <option value="">Sélectionnez un enseignant</option>
                @foreach ($enseignants as $enseignant)
                    <option value="{{ $enseignant->id }}">{{ $enseignant->nom }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3" id="moduleSelect">
            <label for="module_id">Module</label>
            <select name="module_id" class="form-control">
                <option value="">Sélectionnez un module</option>
                @foreach ($modules as $module)
                    <option value="{{ $module->id }}">{{ $module->nom }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="date_absence">Date d'absence</label>
            <input type="date" name="date_absence" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="etat">État</label>
            <select name="etat" class="form-control" required>
                <option value="Justifié">Justifié</option>
                <option value="Non justifié">Non justifié</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="motif">Motif</label>
            <textarea name="motif" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer</button>
        <a href="{{ route('admin.absences.index') }}" class="btn btn-secondary">Retour à la liste</a>
    </form>
</div>

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
