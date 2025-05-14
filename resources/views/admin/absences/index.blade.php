<div class="container mt-4">
    <h2>Gestion des absences</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.absences.create') }}" class="btn btn-success mb-3">Ajouter une absence</a>

    <form method="GET" action="{{ route('admin.absences.index') }}" class="mb-3">
        <label for="type">Afficher les absences pour :</label>
        <select name="type" id="type" class="form-select" onchange="this.form.submit()">
            <option value="Étudiant" {{ $type == 'Étudiant' ? 'selected' : '' }}>Étudiants</option>
            <option value="Enseignant" {{ $type == 'Enseignant' ? 'selected' : '' }}>Enseignants</option>
        </select>
    </form>

    <h4>Absences des {{ $type == 'Enseignant' ? 'enseignants' : 'étudiants' }}</h4>

    <table class="table">
        <thead>
            <tr>
                <th>{{ $type == 'Enseignant' ? "Nom de l'enseignant" : "Nom de l'étudiant" }}</th>
                <th>Date d'absence</th>
                <th>État</th>
                <th>Motif</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($absences as $absence)
                <tr>
                <td>
    @if ($type == 'Enseignant')
        {{ $absence->enseignant ? $absence->enseignant->nom : 'Sans enseignant' }}
    @else
        {{ $absence->etudiant ? $absence->etudiant->nom : 'Sans étudiant' }}
    @endif
</td>

                    <td>{{ $absence->date_absence }}</td>
                    <td>{{ $absence->etat }}</td>
                    <td>{{ $absence->motif }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">Aucune absence trouvée.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

