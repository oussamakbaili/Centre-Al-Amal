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
                <th>Module</th>
                <th>Date d'absence</th>
                <th>État</th>
                <th>Motif</th>
                <th>Actions</th>
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
                    <td>
                        {{ $absence->module ? $absence->module->nom : 'Sans module' }}
                    </td>
                    <td>{{ $absence->date_absence }}</td>
                    <td>
                        <span class="badge bg-{{ $absence->etat == 'Justifié' ? 'success' : 'danger' }}">
                            {{ $absence->etat }}
                        </span>
                    </td>
                    <td>{{ $absence->motif }}</td>
                    <td>
                        <a href="{{ route('admin.absences.edit', $absence->id) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i> Modifier
                        </a>
                        <form action="{{ route('admin.absences.destroy', $absence->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette absence ?')">
                                <i class="bi bi-trash"></i> Supprimer
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Aucune absence trouvée.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
