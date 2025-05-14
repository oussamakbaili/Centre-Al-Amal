<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer les administrateurs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Gérer les administrateurs</h1>

        <!-- Bouton pour ajouter un administrateur -->
        <a href="{{ route('superadmin.admins.create') }}" class="btn btn-primary mb-3">Ajouter un administrateur</a>

        <!-- Tableau des administrateurs -->
        <table class="table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($admins as $admin)
                    <tr>
                        <td>{{ $admin->nom }}</td>
                        <td>{{ $admin->email }}</td>
                        <td>
                            <a href="{{ route('superadmin.admins.edit', $admin->id) }}" class="btn btn-warning">Modifier</a>
                            <form action="{{ route('superadmin.admins.destroy', $admin->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Bouton Retour en bas à gauche -->
        <div class="mt-3">
            <a href="{{ route('superadmin.dashboard') }}" class="btn btn-secondary">Retour</a>
        </div>
    </div>
</body>
</html>