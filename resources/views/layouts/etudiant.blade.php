<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Étudiant - Centre Al Amal</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-blue-800 text-white shadow-lg">
            <div class="p-4 border-b border-blue-700">
                <h1 class="text-xl font-bold">Centre Al Amal</h1>
                <p class="text-sm text-blue-200">Étudiant Dashboard</p>
            </div>
            <nav class="mt-4">
                <x-etudiant.sidebar-item href="{{ route('etudiant.dashboard') }}" icon="fas fa-home" active="{{ request()->routeIs('etudiant.dashboard') }}">
                    Tableau de bord
                </x-etudiant.sidebar-item>
                <x-etudiant.sidebar-item href="{{ route('etudiant.absences') }}" icon="fas fa-calendar-times" active="{{ request()->routeIs('etudiant.absences') }}">
                    Mes Absences
                </x-etudiant.sidebar-item>
                <x-etudiant.sidebar-item href="{{ route('etudiant.emploi') }}" icon="fas fa-calendar-alt" active="{{ request()->routeIs('etudiant.emploi') }}">
                    Emploi du temps
                </x-etudiant.sidebar-item>
                <x-etudiant.sidebar-item href="{{ route('etudiant.notes') }}" icon="fas fa-graduation-cap" active="{{ request()->routeIs('etudiant.notes') }}">
                    Mes Notes
                </x-etudiant.sidebar-item>
                <x-etudiant.sidebar-item href="{{ route('etudiant.modules') }}" icon="fas fa-book" active="{{ request()->routeIs('etudiant.modules') }}">
                    Modules & Ressources
                </x-etudiant.sidebar-item>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 overflow-y-auto">
            <!-- Top Navigation -->
            <header class="bg-white shadow-sm">
                <div class="flex justify-between items-center p-4">
                    <h2 class="text-xl font-semibold text-gray-800">@yield('title')</h2>
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-700">{{ Auth::user()->name }}</span>
                        <img class="h-8 w-8 rounded-full" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}">
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="p-6">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>