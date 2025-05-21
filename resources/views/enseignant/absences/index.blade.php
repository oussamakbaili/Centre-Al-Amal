<div class="container">
    <h2 class="my-4">Mes Absences</h2>

    @if($absences->isEmpty())
        <div class="alert alert-info">Aucune absence enregistrée pour vous.</div>
    @else
        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Module</th>
                        <th>Enseignant</th>
                        <th>Date</th>
                        <th>Statut</th>
                        <th>Motif</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($absences as $absence)
                    <tr>
                        <td>{{ $absence->module->nom ?? 'Sans module' }}</td>
                        <td>{{ $absence->enseignant->nom ?? 'Admin' }} {{ $absence->enseignant->prenom ?? '' }}</td>
                        <td>{{ $absence->date_absence }}</td>
                        <td>
                            <span class="badge bg-{{ $absence->etat === 'Justifié' ? 'success' : 'danger' }}">
                                {{ $absence->etat }}
                            </span>
                        </td>
                        <td>{{ $absence->motif ?: 'Non spécifié' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
