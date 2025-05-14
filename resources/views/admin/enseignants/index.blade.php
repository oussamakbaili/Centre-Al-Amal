    <div class="container">
        <h2>Gestion des enseignants</h2>
        
        <div class="mb-3">
            <form action="{{ route('admin.enseignants.index') }}" method="GET">
                <input type="text" name="search" placeholder="Rechercher par nom, prénom ou email">
                <button type="submit" class="btn btn-primary">Rechercher</button>
            </form>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Photo</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Modules</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($enseignants as $enseignant)
                <tr>
                    <td>
                        @if($enseignant->photo)
                            <img src="{{ asset('storage/'.$enseignant->photo) }}" width="50">
                        @else
                            <div class="photo-placeholder">Photo</div>
                        @endif
                    </td>
                    <td>{{ $enseignant->nom }}</td>
                    <td>{{ $enseignant->prenom }}</td>
                    <td>{{ $enseignant->email }}</td>
                    <td>
                        
                            <span class="badge bg-primary">{{ $enseignant->module ? $enseignant->module->nom : 'Aucun module' }}</span>
                       
                    </td>
                    <td>
                        <a href="{{ route('admin.enseignants.edit', $enseignant->id) }}" class="btn btn-sm btn-primary">Modifier</a>
                        <form action="{{ route('admin.enseignants.destroy', $enseignant->id) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $enseignants->links() }}

        <a href="{{ route('admin.enseignants.create') }}" class="btn btn-success">Ajouter Enseignant</a>
    </div>
