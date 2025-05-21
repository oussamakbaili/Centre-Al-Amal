<div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-6">Ajouter un nouveau contenu</h1>

    @if($classes->isEmpty())
        <div class="bg-yellow-50 p-4 rounded-lg mb-6 border border-yellow-300">
            <p class="text-yellow-800 font-medium">Vous n'avez aucune classe attribuée.</p>
            <a href="{{ route('enseignant.classes.create') }}" class="text-yellow-600 hover:underline">
                Cliquez ici pour créer une classe
            </a>
        </div>
    @else
    <form action="{{ route('enseignant.documents.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Sélection de la classe -->
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Classe</label>
            <select name="classe_id" class="w-full border rounded p-2" required>
                <option value="">Sélectionnez une classe</option>
                @foreach($classes as $classe)
                    <option value="{{ $classe->id }}">{{ $classe->nom }}</option>
                @endforeach
            </select>
        </div>

        <!-- Titre -->
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Titre du contenu</label>
            <input type="text" name="titre" class="w-full border rounded p-2" required>
        </div>

        <!-- Type de contenu -->
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Type de contenu</label>
            <div class="flex items-center space-x-4">
                <label class="inline-flex items-center">
                    <input type="radio" name="type_contenu" value="texte" checked
                           class="form-radio" onchange="toggleContentType()">
                    <span class="ml-2">Texte</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="type_contenu" value="fichier"
                           class="form-radio" onchange="toggleContentType()">
                    <span class="ml-2">Fichier (PDF/Image/Doc)</span>
                </label>
            </div>
        </div>

        <!-- Champ Texte -->
        <div id="text-content" class="mb-4">
            <label class="block text-gray-700 mb-2">Contenu textuel</label>
            <textarea name="contenu" rows="6" class="w-full border rounded p-2"></textarea>
        </div>

        <!-- Champ Fichier -->
        <div id="file-content" class="mb-4 hidden">
            <label class="block text-gray-700 mb-2">Fichier</label>
            <input type="file" name="fichier" class="w-full border rounded p-2">
            <p class="text-xs text-gray-500 mt-1">Formats acceptés: PDF, JPG, JPEG, PNG, DOC, DOCX, TXT</p>
        </div>

        <!-- Boutons -->
        <div class="flex justify-end space-x-3 mt-6">
            <a href="{{ route('enseignant.documents.index') }}"
               class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">
                Annuler
            </a>
            <button type="submit"
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Publier le contenu
            </button>
        </div>
    </form>
</div>

<script>
function toggleContentType() {
    const type = document.querySelector('input[name="type_contenu"]:checked').value;
    document.getElementById('text-content').style.display = type === 'texte' ? 'block' : 'none';
    document.getElementById('file-content').style.display = type === 'fichier' ? 'block' : 'none';

    // Rendre les champs obligatoires/optionnels dynamiquement
    document.querySelector('textarea[name="contenu"]').required = type === 'texte';
    document.querySelector('input[name="fichier"]').required = type === 'fichier';
}
</script>
