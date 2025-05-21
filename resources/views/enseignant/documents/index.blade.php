<div class="max-w-6xl mx-auto p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Mes contenus pédagogiques</h1>
        <a href="{{ route('enseignant.documents.create') }}"
           class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            + Ajouter du contenu
        </a>
    </div>

    @forelse($classes as $classe)
    <div class="mb-8 bg-white rounded-lg shadow overflow-hidden">
        <!-- En-tête de la classe -->
        <div class="bg-gray-50 px-6 py-4 border-b flex justify-between items-center">
            <h2 class="text-xl font-semibold">{{ $classe->nom }}</h2>
            <span class="text-sm text-gray-500">
                {{ $classe->documents->count() }} contenu(s)
            </span>
        </div>

        <!-- Liste des contenus -->
        <div class="divide-y">
            @forelse($classe->documents as $document)
            <div class="p-6 hover:bg-gray-50">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <h3 class="font-semibold text-lg">{{ $document->titre }}</h3>
                        <p class="text-sm text-gray-500 mb-2">
                            Ajouté le {{ $document->created_at->format('d/m/Y à H:i') }}
                        </p>

                        @if($document->contenu)
                        <div class="prose max-w-none mt-2">
                            {!! Str::markdown($document->contenu) !!}
                        </div>
                        @endif
                    </div>

                    @if($document->fichier)
                    <div class="ml-4 flex-shrink-0">
                        <a href="{{ asset('storage/' . $document->fichier) }}"
                           target="_blank"
                           class="inline-flex items-center px-3 py-1 bg-blue-50 text-blue-600 rounded-full">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                            Télécharger
                        </a>
                        <p class="text-xs text-gray-500 mt-1 text-center">
                            {{ Str::upper(pathinfo($document->fichier, PATHINFO_EXTENSION)) }}
                        </p>
                    </div>
                    @endif
                </div>
            </div>
            @empty
            <div class="p-6 text-center text-gray-500">
                Aucun contenu pour cette classe
            </div>
            @endforelse
        </div>
    </div>
    @empty
    <div class="bg-blue-50 p-6 rounded-lg text-center">
        <p class="text-blue-800 mb-4">Vous n'avez aucune classe attribuée.</p>
        <a href="#" class="text-blue-600 hover:underline">Demander une classe</a>
    </div>
    @endforelse
</div>
