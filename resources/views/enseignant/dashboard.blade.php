<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord Enseignant</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css' rel='stylesheet' />
</head>
<body class="bg-gray-100">
    <div class="flex">
        <!-- Sidebar -->
        <div class="bg-blue-800 text-white w-64 min-h-screen p-4">
            <h1 class="text-2xl font-bold mb-6">Menu</h1>
            <ul>
                <li class="mb-4">
                    <a href="{{ route('enseignant.dashboard') }}" class="block py-2 px-4 hover:bg-blue-700 {{ request()->routeIs('enseignant.dashboard1') ? 'bg-blue-900' : '' }}">
                        Tableau de bord
                    </a>
                </li>
                <li class="mb-4">
                    <a href="{{ route('enseignant.etudiants.index') }}" class="block py-2 px-4 hover:bg-blue-700 {{ request()->routeIs('enseignant.etudiants.*') ? 'bg-blue-900' : '' }}">
                        Étudiants
                    </a>
                </li>
                <li class="mb-4">
                    <a href="{{ route('enseignant.absences.index') }}" class="block py-2 px-4 hover:bg-blue-700 {{ request()->routeIs('enseignant.absences.*') ? 'bg-blue-900' : '' }}">
                        Absences
                    </a>
                </li>
                <li class="mb-4">
                    <a href="{{ route('enseignant.emploi.index') }}" class="block py-2 px-4 hover:bg-blue-700 {{ request()->routeIs('enseignant.emploi.*') ? 'bg-blue-900' : '' }}">
                        Emploi du temps
                    </a>
                </li>
                <li class="mb-4">
                    <a href="{{ route('enseignant.notes.index') }}" class="block py-2 px-4 hover:bg-blue-700 {{ request()->routeIs('enseignant.notes.*') ? 'bg-blue-900' : '' }}">
                        Notes
                    </a>
                </li>
                <li class="mb-4">
                    <a href="{{ route('enseignant.documents.index') }}" class="block py-2 px-4 hover:bg-blue-700 {{ request()->routeIs('enseignant.documents.*') ? 'bg-blue-900' : '' }}">
                        Documents
                    </a>
                </li>
            </ul>
        </div>

        <!-- Contenu principal -->
        <div class="flex-1 p-8">
            <h1 class="text-3xl font-bold mb-6">Bienvenue, {{ $enseignant->nom_complet ?? 'Enseignant' }}</h1>

            <!-- Statistiques -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Nombre d'étudiants -->
                <a href="{{ route('enseignant.etudiants.index', ['enseignantId' => $enseignant->id ?? 0]) }}" class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                    <h3 class="font-semibold text-lg mb-2">Nombre d'étudiants</h3>
                    <p class="text-4xl font-bold text-blue-600">{{ $nombreEtudiants ?? 0 }}</p>
                </a>

                <!-- Nombre d'absences -->
                <a href="{{ route('enseignant.absences.index') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                    <h3 class="font-semibold text-lg mb-2">Nombre d'absences</h3>
                    <p class="text-4xl font-bold text-red-600">{{ $nombreAbsences ?? 0 }}</p>
                </a>

                <!-- Nombre d'emplois du temps -->
                <a href="{{ route('enseignant.emploi.index') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                    <h3 class="font-semibold text-lg mb-2">Nombre d'emplois du temps</h3>
                    <p class="text-4xl font-bold text-green-600">{{ $nombreEmplois ?? 0 }}</p>
                </a>
            </div>

            <!-- Calendrier -->
            <div class="bg-white p-6 rounded-lg shadow mb-8">
                <div id='calendar'></div>
            </div>

            <!-- Actions rapides -->
            <div class="flex space-x-4">
                <a href="{{ route('enseignant.profile.edit') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Modifier le profil
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700">
                        Déconnexion
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: @json($evenementsCalendrier ?? []),
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                locale: 'fr'
            });
            calendar.render();
        });
    </script>
</body>
</html>
