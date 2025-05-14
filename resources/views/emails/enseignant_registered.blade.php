<!DOCTYPE html>
<html>
<head>
    <title>Bienvenue sur notre plateforme</title>
</head>
<body>
    <h1>Bienvenue, {{ $enseignant->nom }} {{ $enseignant->prenom }} !</h1>
    <p>Votre compte a été créé avec succès.</p>
    <p>Voici vos informations de connexion :</p>
    <ul>
        <li><strong>Email :</strong> {{ $enseignant->email }}</li>
        <li><strong>Mot de passe :</strong> {{ $password }}</li>
    </ul>
    <p>Merci de nous rejoindre !</p>
</body>
</html>