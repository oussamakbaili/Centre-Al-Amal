<h2>Ajouter un emploi du temps</h2>

@if($enseignants->isEmpty())
    <div class="alert alert-warning">
        Aucun enseignant avec module attribué trouvé. Veuillez d'abord attribuer un module aux enseignants.
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
                    <option value="{{ $enseignant->id }}" data-module-id="{{ $enseignant->module->id ?? '' }}">
                        {{ $enseignant->nom }} {{ $enseignant->prenom }}
                        @if($enseignant->module)
                            - {{ $enseignant->module->nom }}
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
    document.getElementById('enseignant_id').addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];
        var moduleId = selectedOption.getAttribute('data-module-id');
        var moduleSelect = document.getElementById('module_id');

        if (moduleId) {
            moduleSelect.innerHTML = `
                <option value="${moduleId}" selected>
                    ${selectedOption.text.split('-')[1].trim()}
                </option>
            `;
        } else {
            moduleSelect.innerHTML = '<option value="">Cet enseignant n\'a pas de module</option>';
        }
    });
</script>
