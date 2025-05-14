@extends('layouts.etudiant')

@section('title', $title)

@section('content')
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-6 border-b border-gray-200">
        <h2 class="text-xl font-semibold text-gray-800">Mon Emploi du temps</h2>
    </div>
    <div class="p-6">
        @foreach(['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'] as $jour)
            @if(isset($emplois[$jour]))
            <h3 class="mt-6 mb-3 text-lg font-medium text-gray-800">{{ $jour }}</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Heure</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Module</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Enseignant</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Salle</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($emplois[$jour] as $emploi)
                        <tr>
                            <td class="px-4 py-2 whitespace-nowrap">
                                {{ date('H:i', strtotime($emploi->heure_debut)) }} - {{ date('H:i', strtotime($emploi->heure_fin)) }}
                            </td>
                            <td class="px-4 py-2 whitespace-nowrap">{{ $emploi->module->nom }}</td>
                            <td class="px-4 py-2 whitespace-nowrap">{{ $emploi->enseignant->name }}</td>
                            <td class="px-4 py-2 whitespace-nowrap">{{ $emploi->salle }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        @endforeach
    </div>
</div>
@endsection