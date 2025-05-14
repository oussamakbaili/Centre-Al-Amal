<!-- resources/views/emails/preinscription_notification.blade.php -->

<h1>Nouvelle Préinscription</h1>
<p>Nom: {{ $preinscription->nom }}</p>
<p>Email: {{ $preinscription->email }}</p>
<p>CIN: {{ $preinscription->cin }}</p>
<p>Date de Naissance: {{ $preinscription->date_de_naissance }}</p>
<p>Adresse: {{ $preinscription->adresse }}</p>
<p>Téléphone: {{ $preinscription->telephone }}</p>