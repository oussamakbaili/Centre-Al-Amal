
<div class="container mt-5">
    @auth
        @if(request()->is('enseignant/dashboard1'))
            <h1>Gérer les enseignants</h1>
            <a href="{{ route('enseignants.create') }}" class="btn btn-primary">Ajouter un enseignant</a>
            <table class="table mt-3">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($enseignants as $enseignant)
                        <tr>
                            <td>{{ $enseignant->nom }}</td>
                            <td>{{ $enseignant->email }}</td>
                            <td>
                                <a href="{{ route('enseignants.edit', $enseignant->id) }}" class="btn btn-warning">Modifier</a>
                                <form action="{{ route('enseignants.destroy', $enseignant->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet enseignant ?')">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            {{-- Redirection vers la bonne route côté serveur --}}
            @php
                header("Location: " . route('enseignant.dashboard1'));
                exit;
            @endphp
        @endif
    @else
        <div class="alert alert-warning">
            Vous devez être connecté pour accéder à cette page.
            <a href="{{ route('login') }}" class="btn btn-primary ms-2">Se connecter</a>
        </div>
    @endauth
</div>

