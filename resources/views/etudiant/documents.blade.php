
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Mes Documents</h1>
        <p class="text-gray-600">Tous les documents partagés par vos enseignants</p>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 bg-blue-600 text-white">
            <h3 class="text-lg font-semibold">Documents partagés</h3>
        </div>
        <div class="p-6">
            @if($documentsParModule->count() > 0)
                @foreach($documentsParModule as $moduleNom => $documents)
                <div class="mb-8">
                    <h4 class="font-semibold text-lg text-gray-800 mb-4">{{ $moduleNom }}</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($documents as $document)
                        <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                            <div class="flex items-start">
                                <div class="mr-4 text-blue-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h5 class="font-medium text-gray-900 mb-1">{{ $document->titre }}</h5>
                                    <p class="text-sm text-gray-500 mb-2">{{ $document->created_at->format('d/m/Y H:i') }}</p>
                                    <div class="flex justify-between items-center">
                                        <span class="text-xs px-2 py-1 bg-gray-100 rounded">{{ strtoupper(pathinfo($document->fichier, PATHINFO_EXTENSION)) }}</span>
                                        <a href="{{ asset('storage/'.$document->fichier) }}" download class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                            </svg>
                                            Télécharger
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            @else
                <p class="text-gray-500">Aucun document disponible pour le moment.</p>
            @endif
        </div>
    </div>
</div>

