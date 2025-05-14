<!-- resources/views/admin/etudiants/index.blade.php -->

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Étudiants</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="flex">
        <!-- Sidebar -->
        <div class="bg-blue-800 text-white w-64 min-h-screen p-4">
            <h1 class="text-2xl font-bold mb-6">Menu</h1>
            <ul>
                <li class="mb-4">
                    <a href="{{ route('admin.etudiants.index') }}" class="block py-2 px-4 hover:bg-blue-700">Étudiants</a>
                </li>
                <li class="mb-4">
                    <a href="{{ route('admin.enseignants.index') }}" class="block py-2 px-4 hover:bg-blue-700">Enseignants</a>
                </li>
                <li class="mb-4">
                    <a href="{{ route('admin.absences.index') }}" class="block py-2 px-4 hover:bg-blue-700">Absences</a>
                </li>
                <li class="mb-4">
                    <a href="{{ route('admin.emplois.index') }}" class="block py-2 px-4 hover:bg-blue-700">Emploi du temps</a>
                </li>
                <li class="mb-4">
                    <a href="{{ route('admin.notes.index') }}" class="block py-2 px-4 hover:bg-blue-700">Notes</a>
                </li>
                <li class="mb-4">
                    <a href="{{ route('admin.modules.index') }}" class="block py-2 px-4 hover:bg-blue-700">Modules</a>
                </li>
                <li class="mb-4">
                    <a href="{{ route('admin.preinscriptions.index') }}" class="block py-2 px-4 hover:bg-blue-700">Préinscriptions</a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-8">
            <h1 class="text-3xl font-bold mb-6">Gestion des Étudiants</h1>

            <!-- Barre de recherche et tri -->
            <div class="flex space-x-4 mb-6">
                <form action="{{ route('admin.etudiants.index') }}" method="GET" class="flex-1">
                    <input type="text" name="search" class="w-full p-2 border rounded" placeholder="Rechercher par nom ou téléphone..." value="{{ request('search') }}">
                </form>
                <form action="{{ route('admin.etudiants.index') }}" method="GET" class="flex-1">
                    <select name="sort" class="w-full p-2 border rounded" onchange="this.form.submit()">
                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Trier par nom (A-Z)</option>
                        <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Trier par nom (Z-A)</option>
                    </select>
                </form>
            </div>

            <!-- Tableau des étudiants -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <table class="min-w-full">
                    <thead class="bg-blue-800 text-white">
                        <tr>
                            <th class="p-4">Photo</th>
                            <th class="p-4">Nom</th>
                            <th class="p-4">Email</th>
                            <th class="p-4">CIN</th>
                            <th class="p-4">Date de Naissance</th>
                            <th class="p-4">Adresse</th>
                            <th class="p-4">Téléphone</th>
                            <th class="p-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($etudiants as $etudiant)
                        <tr class="border-b">
                            <td class="p-4">
                                <img src="{{ asset($etudiant->photo) }}" alt="Photo" width="50" height="50" class="rounded-full">
                            </td>
                            <td class="p-4">{{ $etudiant->nom }}</td>
                            <td class="p-4">{{ $etudiant->email }}</td>
                            <td class="p-4">{{ $etudiant->cin }}</td>
                            <td class="p-4">{{ $etudiant->date_naissance }}</td>
                            <td class="p-4">{{ $etudiant->adresse }}</td>
                            <td class="p-4">{{ $etudiant->telephone }}</td>
                            <td>
                                <!-- Bouton Modifier -->
                                <a href="{{ route('admin.etudiants.edit', $etudiant->id) }}" class="btn btn-warning btn-sm">Modifier</a>

                                <!-- Bouton Supprimer -->
                                <form action="{{ route('admin.etudiants.destroy', $etudiant->id) }}" method="POST" class="inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 ml-2 btn-delete">Supprimer</button>
                                </form>


                                <!-- Bouton Les absences -->
                                <a href="{{ route('admin.etudiants.absences', $etudiant->id) }}" class="btn btn-sm btn-info">Les absences</a>

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>