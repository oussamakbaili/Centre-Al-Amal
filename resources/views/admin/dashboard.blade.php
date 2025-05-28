<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="flex">
        <!-- Sidebar -->
        <div class="bg-blue-800 text-white w-64 min-h-screen p-4">
            <h1 class="text-2xl font-bold mb-6">Menu</h1>
            <ul>
                <li class="mb-4">
                    <a href="{{ route('admin.etudiants.index') }}" class="block py-2 px-4 hover:bg-blue-700">étudiants</a>
                </li>
                <li class="mb-4">
                    <a href="{{ route('admin.enseignants.index') }}" class="block py-2 px-4 hover:bg-blue-700">enseignants</a>
                </li>
                <li class="mb-4">
                    <a href="{{ route('admin.absences.index') }}" class="block py-2 px-4 hover:bg-blue-700">absences</a>
                </li>
                <li class="mb-4">
                    <a href="{{ route('admin.emplois.index') }}" class="block py-2 px-4 hover:bg-blue-700">emploi du temps</a>
                </li>
                <li class="mb-4">
                    <a href="{{ route('admin.notes.index') }}" class="block py-2 px-4 hover:bg-blue-700">notes</a>
                </li>
                <li class="mb-4">
                    <a href="{{ route('admin.modules.index') }}" class="block py-2 px-4 hover:bg-blue-700">modules</a>
                </li>
                <li class="mb-4">
                    <a href="{{ route('admin.preinscriptions.index') }}" class="block py-2 px-4 hover:bg-blue-700">préinscriptions</a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-8">
            <h1 class="text-3xl font-bold mb-6">Bienvenue, Admin</h1>
            <p class="text-lg mb-6">Vous êtes connecté en tant qu'Admin.</p>
            <div class="flex space-x-4">
                    <!-- Bouton Modifier le profil -->
                    <a href="{{ route('admin.profile.edit') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Modifier le profil
                    </a>
                    <!-- Bouton Déconnexion -->
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700">
                            Déconnexion
                        </button>
                    </form>
                </div>

            <!-- Statistiques -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-semibold mb-4">Nombre d'étudiants</h2>
                    <p class="text-3xl font-bold">{{ $nombreEtudiants }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-semibold mb-4">Nombre d'enseignants</h2>
                    <p class="text-3xl font-bold">{{ $nombreEnseignants }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-semibold mb-4">Nombre d'absences</h2>
                    <p class="text-3xl font-bold">{{ $nombreAbsences }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-semibold mb-4">Nombre de modules</h2>
                    <p class="text-3xl font-bold">{{ $nombreModules }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-semibold mb-4">Nombre de préinscriptions</h2>
                    <p class="text-3xl font-bold"></p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-semibold mb-4">Nombre de notes</h2>
                    <p class="text-3xl font-bold">{{ $nombreNotes }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-semibold mb-4">Nombre d'emplois du temps</h2>
                    <p class="text-3xl font-bold"></p>
                </div>
            </div>
            <!-- Section Scan QR Code -->
<div class="bg-white p-6 rounded-lg shadow-md mt-6">
    <h2 class="text-xl font-semibold mb-4">Scanner QR Code</h2>
    <div id="scanner-section">
        <video id="qr-video" width="300" height="200" class="mb-4"></video>
        <button id="start-scanner" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">
            Démarrer le scanner
        </button>
        <div id="scan-result" class="mt-4 hidden">
            <p class="font-semibold">Résultat du scan:</p>
            <p id="result-text"></p>
        </div>
    </div>
</div>

<!-- Script pour le scanner -->
<script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
<script>
    document.getElementById('start-scanner').addEventListener('click', function() {
        let scanner = new Instascan.Scanner({ video: document.getElementById('qr-video') });

        scanner.addListener('scan', function (content) {
            fetch(content, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('result-text').textContent = data.message;
                document.getElementById('scan-result').classList.remove('hidden');
            });
        });

        Instascan.Camera.getCameras().then(function (cameras) {
            if (cameras.length > 0) {
                scanner.start(cameras[0]);
            } else {
                alert('Aucune caméra trouvée');
            }
        });
    });
</script>
        </div>
    </div>
</body>
</html>
