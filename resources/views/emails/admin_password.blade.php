<!DOCTYPE html>
<html>
<head>
    <title>Vos accès administrateur</title>
</head>
<body>
    <h1>Bonjour {{ $name }},</h1>
    <p>Votre compte administrateur a été créé avec succès.</p>
    <p>Voici vos informations de connexion :</p>
    <ul>
        <li><strong>Email :</strong> {{ $email }}</li>
        <li><strong>Mot de passe :</strong> {{ $password }}</li>
    </ul>
    <p>Merci de changer votre mot de passe après votre première connexion.</p>
</body>
</html>