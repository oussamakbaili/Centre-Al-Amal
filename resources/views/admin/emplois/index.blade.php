
<h2>Emplois du temps</h2>
<a href="{{ route('admin.emplois.create') }}" class="btn btn-primary">Ajouter</a>
<table class="table">
    <thead>
        <tr>
            <th>Jour</th>
            <th>Heure début</th>
            <th>Heure fin</th>
            <th>Salle</th>
            <th>Module</th>
            <th>Enseignant</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($emplois as $emploi)
        <tr>
            <td>{{ $emploi->jour }}</td>
            <td>{{ $emploi->heure_debut }}</td>
            <td>{{ $emploi->heure_fin }}</td>
            <td>{{ $emploi->salle }}</td>
            <td>{{ $emploi->module->nom }}</td>
            <td>{{ $emploi->enseignant->nom }}</td>
            <td>
                <a href="{{ route('admin.emplois.edit', $emploi->id) }}" class="btn btn-sm btn-primary">Modifier</a>
                <form action="{{ route('admin.emplois.destroy', $emploi->id) }}" method="POST" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

