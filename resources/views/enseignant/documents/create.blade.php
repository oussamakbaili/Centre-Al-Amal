<div class="container">
    <h2>Ajouter un nouveau document</h2>



    <form action="{{ route('enseignant.documents.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="titre" class="form-label">Titre du cours :</label>
            <input type="text" class="form-control" name="titre" id="titre" required value="{{ old('titre') }}">
            @error('titre')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="contenu" class="form-label">Description (optionnel) :</label>
            <textarea class="form-control" name="contenu" id="contenu" rows="4">{{ old('contenu') }}</textarea>
            @error('contenu')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="fichier" class="form-label">Fichier (PDF ou Image) :</label>
            <input type="file" class="form-control" name="fichier" id="fichier" accept=".pdf,image/*">
            @error('fichier')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Ajouter</button>
            <a href="{{ route('enseignant.documents.index') }}" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</div>
