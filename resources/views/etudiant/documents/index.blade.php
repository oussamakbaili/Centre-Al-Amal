<div class="p-6">
    <h2 class="text-xl font-bold mb-4">Mes Modules</h2>

    @foreach($modules as $module)
        <div class="bg-white p-4 rounded-lg shadow-md mb-4">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-semibold">{{ $module->nom }}</h3>
                    <p class="text-gray-600">{{ $module->description }}</p>
                </div>
                <a href="{{ route('etudiant.documents.show', $module->id) }}"
                   class="text-blue-600 hover:underline">
                    Voir les documents
                </a>
            </div>
        </div>
    @endforeach
</div>
