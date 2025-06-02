
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Ajouter un nouvel étudiant</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.etudiants.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="form-group">
        <label for="nom">Nom</label>
        <input type="text" name="nom" id="nom" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="prenom">Prénom</label>
        <input type="text" name="prenom" id="prenom" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="adresse">Adresse</label>
        <input type="text" name="adresse" id="adresse" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="telephone">Téléphone</label>
        <input type="text" name="telephone" id="telephone" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="date_naissance">Date de naissance</label>
        <input type="date" name="date_naissance" id="date_naissance" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="cin">CIN</label>
        <input type="text" name="cin" id="cin" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="image">Image</label>
        <input type="file" name="image" id="image" class="form-control">
    </div>
    <div class="form-group">
    <label for="niveau">Niveau</label>
    <select name="niveau" id="niveau" class="form-control" required>
        <option value="">Sélectionnez un niveau</option>
        <option value="Bac">Bac</option>
        <option value="Licence">Licence</option>
        <option value="Master">Master</option>
        <option value="Doctorat">Doctorat</option>
    </select>
</div>



                        <div class="form-group text-center mt-4">
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                            <a href="{{ route('admin.etudiants.index') }}" class="btn btn-secondary">Annuler</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

