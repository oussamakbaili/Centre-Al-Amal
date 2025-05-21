<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Préinscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Barre de navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="/">Centre Al Amal</a>
            <div class="navbar-nav ms-auto">
                <!-- Bouton LOGIN -->
                <a href="{{ route('login') }}" class="btn btn-primary">LOGIN</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1>Préinscription</h1>
        <!-- Afficher les erreurs de validation -->
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('preinscription.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="nom">Nom</label>
        <input type="text" name="nom" id="nom" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="prenom">Prénom</label>
        <input type="text" name="prenom" id="prenom" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="adresse">Adresse</label>
        <input type="text" name="adresse" id="adresse" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="telephone">Téléphone</label>
        <input type="text" name="telephone" id="telephone" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="date_naissance">Date de naissance</label>
        <input type="date" name="date_naissance" id="date_naissance" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="cin">CIN</label>
        <input type="text" name="cin" id="cin" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="image">Image</label>
        <input type="file" name="image" id="image" class="form-control">
    </div>
    <div class="form-group">
    <label for="niveau">Niveau</label>
    <select name="niveau" id="niveau" class="form-control" required>
        <option value="">Sélectionnez un niveau</option>
        <option value="Bac">Bac</option>
        <option value="Licence">Licence</option>
        <option value="Master">Master</option>
        <option value="Doctorat">Doctorat</option>
    </select>
</div>
    <button type="submit" class="btn btn-primary">Enregistrer</button>
</form>
    </div>
</body>
</html>
