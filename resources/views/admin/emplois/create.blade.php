@extends('layouts.admin')

@section('content')
    <h2>Ajouter un emploi du temps</h2>

    @if($enseignants->isEmpty())
        <div class="alert alert-warning">
            Aucun enseignant avec modules attribués trouvé. Veuillez d'abord attribuer des modules aux enseignants.
        </div>
    @else
        <form action="{{ route('admin.emplois.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Jour</label>
                <select name="jour" class="form-control" required>
                    <option value="Lundi">Lundi</option>
                    <option value="Mardi">Mardi</option>
                    <option value="Mercredi">Mercredi</option>
                    <option value="Jeudi">Jeudi</option>
                    <option value="Vendredi">Vendredi</option>
                    <option value="Samedi">Samedi</option>
                </select>
            </div>

            <div class="form-group">
                <label>Heure début</label>
                <input type="time" name="heure_debut" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Heure fin</label>
                <input type="time" name="heure_fin" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Salle</label>
                <input type="text" name="salle" class="form-control">
            </div>

            <div class="form-group">
                <label>Enseignant</label>
                <select name="enseignant_id" id="enseignant_id" class="form-control" required>
                    <option value="">Sélectionner un enseignant</option>
                    @foreach($enseignants as $enseignant)
                        <option value="{{ $enseignant->id }}" @if($enseignant->modules->isEmpty()) disabled @endif>
                            {{ $enseignant->nom }} {{ $enseignant->prenom }}
                            @if($enseignant->modules->isEmpty())
                                (Aucun module attribué)
                            @endif
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Module</label>
                <select name="module_id" id="module_id" class="form-control" required>
                    <option value="">Sélectionnez d'abord un enseignant</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Enregistrer</button>
        </form>
    @endif

    <script>
        document.getElementById('enseignant_id').addEventListener('change', function () {
            var enseignantId = this.value;
            var moduleSelect = document.getElementById('module_id');

            moduleSelect.innerHTML = '<option value="">Chargement...</option>';

            if (enseignantId) {
                fetch(`/admin/enseignants/${enseignantId}/modules`)
                    .then(response => {
                        if (!response.ok) throw new Error('Erreur réseau');
                        return response.json();
                    })
                    .then(data => {
                        if (data.length === 0) {
                            moduleSelect.innerHTML = '<option value="">Cet enseignant n\'a aucun module</option>';
                        } else {
                            moduleSelect.innerHTML = '<option value="">Sélectionner un module</option>';
                            data.forEach(module => {
                                moduleSelect.innerHTML += `<option value="${module.id}">${module.nom}</option>`;
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Erreur:', error);
                        moduleSelect.innerHTML = '<option value="">Erreur de chargement</option>';
                    });
            } else {
                moduleSelect.innerHTML = '<option value="">Sélectionnez d\'abord un enseignant</option>';
            }
        });
    </script>
@endsection