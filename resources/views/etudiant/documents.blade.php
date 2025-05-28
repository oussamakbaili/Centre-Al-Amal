@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Documents par module</h1>

    @foreach($modules as $module)
        <div class="bg-white shadow-md rounded-lg p-4 mb-6">
            <h2 class="text-xl font-semibold mb-2 text-blue-600">{{ $module->nom }}</h2>

            @if($module->documents->count() > 0)
                <ul class="space-y-2">
                    @foreach($module->documents as $document)
                        <li class="flex items-center justify-between bg-gray-100 p-3 rounded">
                            <div>
                                📄 <span class="font-medium">{{ $document->titre }}</span>
                            </div>
                            <a href="{{ asset('storage/documents/' . $document->fichier) }}"
                               class="text-white bg-blue-600 hover:bg-blue-700 px-3 py-1 rounded"
                               target="_blank">
                                Télécharger
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-500">Aucun document disponible pour ce module.</p>
            @endif
        </div>
    @endforeach
</div>
