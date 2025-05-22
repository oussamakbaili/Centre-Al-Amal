
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Absences de {{ $etudiant->nom }} {{ $etudiant->prenom }}</h2>

    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            @if($etudiant->absences->count() > 0)
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Module</th>
                            <th>Justifiée</th>
                            <th>Commentaire</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($etudiant->absences as $absence)
                        <tr>
                            <td>
                                @if($absence->date_absence)
                                    {{ \Carbon\Carbon::parse($absence->date_absence)->format('d/m/Y') }}
                                @else
                                    Date non renseignée
                                @endif
                            </td>                            <td>{{ $absence->module->nom ?? '-' }}</td>
                            <td>
                                @if($absence->justifiee)
                                    <span class="badge bg-success">Oui</span>
                                @else
                                    <span class="badge bg-danger">Non</span>
                                @endif
                            </td>
                            <td>{{ $absence->commentaire ?? 'Aucun commentaire' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="alert alert-info">
                    Cet étudiant n'a aucune absence enregistrée.
                </div>
            @endif
        </div>
    </div>
</div>

