    <div class="container">
        <h1>Liste des préinscriptions en attente</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table">
    <thead>
        <tr>
            <th>Image</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Email</th>
            <th>Adresse</th>
            <th>Téléphone</th>
            <th>Niveau</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($preinscriptions as $preinscription)
            <tr>
                <td>
                    @if($preinscription->image)
                        <img src="{{ asset('storage/' . $preinscription->image) }}" alt="Image" width="50">
                    @else
                        Pas d'image
                    @endif
                </td>
                <td>{{ $preinscription->nom }}</td>
                <td>{{ $preinscription->prenom }}</td>
                <td>{{ $preinscription->email }}</td>
                <td>{{ $preinscription->adresse }}</td>
                <td>{{ $preinscription->telephone }}</td>
                <td>{{ $preinscription->niveau }}</td>
                <td>
                <form action="{{ route('admin.preinscriptions.accept', $preinscription->id) }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-success">Accepter</button>
                </form>                   
                <form action="{{ route('admin.preinscriptions.reject', $preinscription->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Refuser</button>
                </form>

                </form>                
            </td>
            </tr>
        @endforeach
    </tbody>
</table>
    </div>
