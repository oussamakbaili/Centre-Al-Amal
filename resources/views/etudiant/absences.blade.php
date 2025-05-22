<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Mes Absences</h1>
        <p class="text-gray-600">Historique de toutes vos absences</p>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden mb-8">
        <div class="px-6 py-4 bg-blue-600 text-white">
            <h3 class="text-lg font-semibold">Statistiques</h3>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="border rounded-lg p-4 text-center">
                <p class="text-gray-600">Total des absences</p>
                <p class="text-3xl font-bold text-gray-800">{{ $absences->count() }}</p>
            </div>
            <div class="border rounded-lg p-4 text-center">
                <p class="text-gray-600">Absences justifiées</p>
                <p class="text-3xl font-bold text-green-600">{{ $absences->where('justifie', true)->count() }}</p>
            </div>
            <div class="border rounded-lg p-4 text-center">
                <p class="text-gray-600">Absences non justifiées</p>
                <p class="text-3xl font-bold text-red-600">{{ $absences->where('justifie', false)->count() }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 bg-blue-600 text-white">
            <h3 class="text-lg font-semibold">Détail des absences</h3>
        </div>
        <div class="p-6">
            @if($absences->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Module</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Séance</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Commentaire</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($absences as $absence)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $absence->date_absence->format('d/m/Y') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $absence->module->nom ?? 'Non spécifié' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500">{{ $absence->seance ?? 'Non spécifié' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 rounded-full text-xs {{ $absence->justifie ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $absence->justifie ? 'Justifiée' : 'Non justifiée' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-500">{{ $absence->commentaire ?? 'Aucun commentaire' }}</div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500">Vous n'avez aucune absence enregistrée.</p>
            @endif
        </div>
    </div>
</div>
