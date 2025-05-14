
<div class="container">
    <h1>Modifier l'enseignant</h1>

    <form action="{{ route('admin.enseignants.update', $enseignant->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nom">Nom</label>
            <input type="text" name="nom" id="nom" class="form-control" value="{{ old('nom', $enseignant->nom) }}" required>
        </div>

        <div class="form-group">
            <label for="prenom">Prénom</label>
            <input type="text" name="prenom" id="prenom" class="form-control" value="{{ old('prenom', $enseignant->prenom) }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $enseignant->email) }}" required>
        </div>

        <div class="form-group">
            <label for="module">Module</label>
            <select name="module_id" id="module_id" class="form-control" required>
    @foreach($modules as $module)
        <option value="{{ $module->id }}" {{ $enseignant->module_id == $module->id ? 'selected' : '' }}>
            {{ $module->nom }}
        </option>
    @endforeach
</select>

        </div>

        <div class="form-group">
            <label for="photo">Photo</label>
            <input type="file" name="photo" id="photo" class="form-control-file">
            @if($enseignant->photo)
                <img src="{{ asset('storage/' . $enseignant->photo) }}" alt="Photo actuelle" class="img-thumbnail mt-2" width="100">
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
        <a href="{{ route('admin.enseignants.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
