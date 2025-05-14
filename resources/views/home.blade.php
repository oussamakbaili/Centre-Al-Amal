<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centre Al Amal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="/">Centre Al Amal</a>
            <div class="navbar-nav ms-auto">
                <a href="{{ route('preinscription.create') }}" class="nav-link">Préinscription</a>
                <a href="{{ route('login') }}" class="nav-link">Se connecter</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1>Bienvenue au Centre Al Amal</h1>
        <p>Nous soutenons les jeunes dans leur développement personnel et professionnel.</p>
    </div>
</body>
</html>