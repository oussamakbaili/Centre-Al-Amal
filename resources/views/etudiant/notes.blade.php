
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">Mes Notes</h2>
                @if(isset($moyenneGenerale))
                <div class="text-lg font-medium">
                    Moyenne générale:
                    <span class="{{ $moyenneGenerale >= 10 ? 'text-green-600' : 'text-red-600' }}">
                        {{ number_format($moyenneGenerale, 2) }}/20
                    </span>
                </div>
                @endif
            </div>
        </div>
        <div class="px-6 py-4">
            @if($notes->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Module</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Note</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($notes as $note)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-medium text-gray-900">{{ $note->module->nom ?? 'Non spécifié' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-gray-900">{{ $note->note_type ?? 'Non spécifié' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 rounded-full text-sm font-semibold {{ $note->note >= 10 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $note->note }}/20
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500">{{ $note->created_at->format('d/m/Y') }}</div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $notes->links() }} <!-- Pagination -->
                </div>
            @else
                <p class="text-gray-500">Aucune note enregistrée</p>
            @endif
        </div>
    </div>
</div>
