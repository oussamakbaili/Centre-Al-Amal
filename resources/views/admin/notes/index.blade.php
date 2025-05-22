<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Notes</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .dropdown:hover .dropdown-menu {
            display: block;
        }
        .note-input {
            width: 80px;
        }
    </style>
</head>

<body class="bg-gray-50 p-8">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Liste des Notes</h1>

        <!-- Filtre par module -->
        <form id="filterForm" method="GET" action="{{ route('admin.notes.index') }}"
            class="mb-6 bg-white p-4 rounded-lg shadow">
            <label for="module_id" class="block text-sm font-medium text-gray-700 mb-2">Filtrer par Module:</label>
            <div class="flex space-x-4">
                <select name="module_id" id="module_id" onchange="this.form.submit()"
                    class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Tous les modules</option>
                    @foreach($modules as $module)
                        <option value="{{ $module->id }}" {{ $selectedModule == $module->id ? 'selected' : '' }}>
                            {{ $module->nom }}
                        </option>
                    @endforeach
                </select>
                <a href="{{ route('admin.notes.create') }}"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md flex items-center">
                    <i class="fas fa-plus mr-2"></i> Nouvelle Note
                </a>
            </div>
        </form>

        <!-- Tableau des notes -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Étudiant</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Module</th>
                        @if($selectedModule)
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Note 1</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Note 2</th>
                        @endif
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @php
                        // Group notes by student and module
                        $groupedNotes = [];
                        foreach ($notes as $note) {
                            $key = $note->etudiant_id . '-' . $note->module_id;
                            if (!isset($groupedNotes[$key])) {
                                $groupedNotes[$key] = [
                                    'etudiant' => $note->etudiant,
                                    'module' => $note->module,
                                    'note1' => null,
                                    'note2' => null,
                                    'note1_id' => null,
                                    'note2_id' => null
                                ];
                            }
                            if ($note->note_type == 'note1') {
                                $groupedNotes[$key]['note1'] = $note->note;
                                $groupedNotes[$key]['note1_id'] = $note->id;
                            } elseif ($note->note_type == 'note2') {
                                $groupedNotes[$key]['note2'] = $note->note;
                                $groupedNotes[$key]['note2_id'] = $note->id;
                            }
                        }
                    @endphp

                    @forelse ($groupedNotes as $key => $group)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $group['etudiant']->nom }} {{ $group['etudiant']->prenom }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $group['module']->nom }}</td>

                            @if($selectedModule)
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $group['note1'] !== null ? $group['note1'] : 'No note yet' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $group['note2'] !== null ? $group['note2'] : 'No note yet' }}
                                </td>
                            @endif

                            <td class="px-6 py-4 whitespace-nowrap space-x-2">
                                <button
                                    onclick="openEditModal({{ $group['etudiant']->id }}, {{ $group['module']->id }},
                                            '{{ $group['etudiant']->nom }} {{ $group['etudiant']->prenom }}',
                                            '{{ $group['module']->nom }}',
                                            '{{ $group['note1'] ?? '' }}',
                                            '{{ $group['note2'] ?? '' }}',
                                            {{ $group['note1_id'] ?? 'null' }},
                                            {{ $group['note2_id'] ?? 'null' }})"
                                    class="text-blue-600 hover:text-blue-900">
                                    <i class="fas fa-edit"></i> Modifier
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ $selectedModule ? 5 : 3 }}" class="px-6 py-4 text-center text-gray-500">
                                Aucune note trouvée
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Modal de modification -->
        <div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-md">
                <div class="p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Modifier les informations</h2>
                    <form id="editForm" method="POST">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="note1_id" id="note1_id">
                        <input type="hidden" name="note2_id" id="note2_id">

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Étudiant</label>
                            <select name="etudiant_id" id="etudiant_id"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @foreach($etudiants as $etudiant)
                                    <option value="{{ $etudiant->id }}">{{ $etudiant->nom }} {{ $etudiant->prenom }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Module</label>
                            <select name="module_id" id="module_id"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @foreach($modules as $module)
                                    <option value="{{ $module->id }}">{{ $module->nom }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Note 1</label>
                            <input type="number" name="note1" id="note1" step="0.01" min="0" max="20"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Note 2</label>
                            <input type="number" name="note2" id="note2" step="0.01" min="0" max="20"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div class="flex justify-end space-x-4">
                            <button type="button" onclick="closeEditModal()"
                                class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                                Annuler
                            </button>
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Script modal -->
    <script>
        function openEditModal(etudiantId, moduleId, etudiantName, moduleName, note1, note2, note1Id, note2Id) {
            const modal = document.getElementById('editModal');
            const form = document.getElementById('editForm');

            // Set student and module
            document.getElementById('etudiant_id').value = etudiantId;
            document.getElementById('module_id').value = moduleId;

            // Set notes
            document.getElementById('note1').value = note1 || '';
            document.getElementById('note2').value = note2 || '';
            document.getElementById('note1_id').value = note1Id || '';
            document.getElementById('note2_id').value = note2Id || '';

            // Set form action
            form.action = `/admin/notes/${etudiantId}/${moduleId}`;

            modal.classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        window.onclick = function (event) {
            const modal = document.getElementById('editModal');
            if (event.target === modal) {
                closeEditModal();
            }
        };
    </script>
</body>

</html>
