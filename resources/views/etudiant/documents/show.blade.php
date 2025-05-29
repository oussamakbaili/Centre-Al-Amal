<div class="p-6">
    <!-- En-tête simplifié sans groupe -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">{{ $module->nom }}</h1>
        @if($module->description)
            <p class="text-gray-600 mt-2">{{ $module->description }}</p>
        @endif
    </div>

    <!-- Section Documents -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold flex items-center">
                <i class="fas fa-folder-open text-blue-500 mr-2"></i>
                Documents du module
            </h2>
            <span class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                {{ $module->documents->count() }} document(s)
            </span>
        </div>

        @if($module->documents->count() > 0)
            <div class="space-y-3">
                @foreach($module->documents as $document)
                <div class="border rounded-lg p-4 hover:bg-gray-50 transition-colors duration-200">
                    <div class="flex justify-between items-start">
                        <div class="flex items-start flex-1 min-w-0">
                            <div class="bg-blue-100 p-3 rounded-lg mr-4 flex-shrink-0">
                                <i class="fas fa-file-alt text-blue-600"></i>
                            </div>
                            <div class="min-w-0">
                                <h3 class="font-medium text-lg truncate">{{ $document->titre }}</h3>
                                <div class="flex flex-wrap items-center text-sm text-gray-500 mt-1">
                                    @if($document->auteur)
                                        <span class="flex items-center mr-3">
                                            <i class="far fa-user mr-1"></i>
                                            <span class="truncate">{{ $document->auteur }}</span>
                                        </span>
                                    @endif
                                    <span class="flex items-center">
                                        <i class="far fa-clock mr-1"></i>
                                        {{ $document->created_at->format('d/m/Y') }}
                                    </span>
                                </div>
                                @if($document->description)
                                    <p class="text-gray-600 mt-2 text-sm">
                                        {{ Str::limit($document->description, 150) }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <a href="{{ asset('storage/documents/' . $document->fichier) }}"
                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center ml-4 flex-shrink-0"
                           download
                           title="Télécharger le document">
                            <i class="fas fa-download mr-2"></i> Télécharger
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8 bg-gray-50 rounded-lg">
                <i class="far fa-folder-open text-4xl text-gray-300 mb-3"></i>
                <p class="text-gray-500">Aucun document disponible pour ce module</p>
                <p class="text-sm text-gray-400 mt-1">Les documents apparaîtront ici une fois ajoutés</p>
            </div>
        @endif
    </div>

    <!-- Activités récentes -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-semibold mb-4 flex items-center">
            <i class="fas fa-bell text-yellow-500 mr-2"></i>
            Activités récentes
        </h2>

        @if(count($recentActivities) > 0)
            <div class="space-y-3">
                @foreach($recentActivities as $activity)
                <div class="flex items-start p-3 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                    <div class="bg-gray-100 p-2 rounded-full mr-4 flex-shrink-0">
                        <i class="fas fa-{{ $activity->type === 'document' ? 'file-alt text-blue-500' : 'comment text-green-500' }}"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="font-medium truncate">{{ $activity->titre }}</p>
                        <p class="text-sm text-gray-500 mt-1">
                            <span class="mr-2">{{ $activity->auteur }}</span>
                            <span>• {{ $activity->created_at->diffForHumans() }}</span>
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-center py-4">Aucune activité récente</p>
        @endif
    </div>
</div>
