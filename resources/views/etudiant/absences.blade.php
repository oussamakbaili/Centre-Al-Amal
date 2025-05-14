@extends('layouts.etudiant')

@section('title', $title)

@section('content')
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-6 border-b border-gray-200">
        <h2 class="text-xl font-semibold text-gray-800">Mes Absences</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Module</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Commentaire</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($absences as $absence)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $absence->date_absence->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $absence->module->nom }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 rounded-full text-xs {{ $absence->justifie ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $absence->justifie ? 'Justifiée' : 'Non justifiée' }}
                        </span>
                    </td>
                    <td class="px-6 py-4">{{ $absence->commentaire ?? 'Aucun commentaire' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">Aucune absence enregistrée</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($absences->hasPages())
    <div class="p-4 border-t border-gray-200">
        {{ $absences->links() }}
    </div>
    @endif
</div>
@endsection