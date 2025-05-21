
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Emploi du temps</h1>
        <p class="text-gray-600">Groupe: {{ $etudiant->groupe->nom ?? 'Non attribué' }}</p>
    </div>

    @if(isset($error))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ $error }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 bg-blue-600 text-white">
            <h3 class="text-lg font-semibold">Planning hebdomadaire</h3>
        </div>
        <div class="p-6">
            @if($emplois->count() > 0)
                <div class="space-y-6">
                    @foreach($joursSemaine as $jourKey => $jourNom)
                        @php
                            $emploisDuJour = $emplois->where('jour_semaine', $jourKey);
                        @endphp

                        @if($emploisDuJour->count() > 0)
                            <div class="border rounded-lg overflow-hidden">
                                <div class="bg-gray-100 px-4 py-2 border-b">
                                    <h4 class="font-semibold text-gray-800">{{ $jourNom }}</h4>
                                </div>
                                <div class="divide-y divide-gray-200">
                                    @foreach($emploisDuJour as $emploi)
                                    <div class="p-4">
                                        <div class="flex justify-between items-start">
                                            <div class="flex-1">
                                                <h5 class="font-medium text-gray-900">
                                                    {{ $emploi->module->nom ?? 'Module non spécifié' }}
                                                </h5>
                                                <p class="text-sm text-gray-500 mt-1">
                                                    {{ date('H:i', strtotime($emploi->heure_debut)) }} - {{ date('H:i', strtotime($emploi->heure_fin)) }}
                                                </p>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-sm text-gray-600">
                                                    {{ $emploi->salle ?? 'Salle non spécifiée' }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            <p class="text-sm text-gray-500">
                                                Enseignant: {{ $emploi->enseignant->name ?? 'Non spécifié' }}
                                            </p>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">Aucun emploi du temps disponible pour votre groupe.</p>
            @endif
        </div>
    </div>
</div>
