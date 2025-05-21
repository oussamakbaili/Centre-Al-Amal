
<div class="container">
    <h2 class="my-4">Ajouter des Notes</h2>

    <form action="{{ route('enseignant.notes.store') }}" method="POST">
        @csrf

        @foreach($modules as $module)
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h4>{{ $module->nom }}</h4>
                </div>
                <div class="card-body">
                    @if($module->etudiants->count() > 0)
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Étudiant</th>
                                    <th>Note (/20)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($module->etudiants as $etudiant)
                                    <tr>
                                        <td>{{ $etudiant->nom }} {{ $etudiant->prenom }}</td>
                                        <td>
                                            <input type="number"
                                                   name="notes[{{ $module->id }}_{{ $etudiant->id }}][valeur]"
                                                   class="form-control"
                                                   min="0"
                                                   max="20"
                                                   step="0.01"
                                                   required>
                                            <input type="hidden"
                                                   name="notes[{{ $module->id }}_{{ $etudiant->id }}][module_id]"
                                                   value="{{ $module->id }}">
                                            <input type="hidden"
                                                   name="notes[{{ $module->id }}_{{ $etudiant->id }}][etudiant_id]"
                                                   value="{{ $etudiant->id }}">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="alert alert-warning">
                            Aucun étudiant inscrit à ce module.
                        </div>
                    @endif
                </div>
            </div>
        @endforeach

        <button type="submit" class="btn btn-success">Enregistrer les notes</button>
        <a href="{{ route('enseignant.notes.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>

