
<div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-6">Créer une nouvelle classe</h1>

    <form action="{{ route('enseignant.classes.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Nom de la classe</label>
            <input type="text" name="nom" class="w-full border rounded p-2" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Description (optionnel)</label>
            <textarea name="description" rows="3" class="w-full border rounded p-2"></textarea>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Créer la classe
            </button>
        </div>
    </form>
</div>

