<!-- Sidebar -->
<aside class="w-64 bg-gray-800 text-white min-h-screen fixed">
    <div class="p-4">
        <h2 class="text-xl font-semibold">Tableau de bord étudiant</h2>
    </div>
    <nav class="mt-6">
        <div>
            <a href="{{ route('etudiant.dashboard') }}" class="block py-2 px-4 hover:bg-gray-700 {{ request()->routeIs('etudiant.dashboard') ? 'bg-gray-700' : '' }}">
                Tableau de bord
            </a>
            <a href="{{ route('etudiant.emploi') }}" class="block py-2 px-4 hover:bg-gray-700 {{ request()->routeIs('etudiant.emploi') ? 'bg-gray-700' : '' }}">
                Emploi du temps
            </a>
            <a href="{{ route('etudiant.notes') }}" class="block py-2 px-4 hover:bg-gray-700 {{ request()->routeIs('etudiant.notes') ? 'bg-gray-700' : '' }}">
                Notes
            </a>
            <a href="{{ route('etudiant.absences.index') }}" class="block py-2 px-4 hover:bg-gray-700 {{ request()->routeIs('etudiant.absences.*') ? 'bg-gray-700' : '' }}">
                Absences
            </a>
            <a href="{{ route('etudiant.documents') }}" class="block py-2 px-4 hover:bg-gray-700 {{ request()->routeIs('etudiant.documents') ? 'bg-gray-700' : '' }}">
                Documents
            </a>
            <a href="{{ route('etudiant.profile.edit') }}" class="block py-2 px-4 hover:bg-gray-700 {{ request()->routeIs('etudiant.profile.*') ? 'bg-gray-700' : '' }}">
                Mon Profil
            </a>
        </div>
    </nav>
</aside>
