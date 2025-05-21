<div class="container">
    <h2 class="my-4">Gestion des Notes</h2>

    @foreach($modules as $module)
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h3>{{ $module->nom }}</h3>
            </div>
            <div class="card-body">
                @if($module->notes->count() > 0)
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Étudiant</th>
                                <th>Note (/20)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($module->notes as $note)
                                <tr>
                                    <td>{{ $note->etudiant->nom }} {{ $note->etudiant->prenom }}</td>
                                    <td>{{ $note->note }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="alert alert-info">
                        Aucune note enregistrée pour ce module.
                    </div>
                @endif
            </div>
        </div>
    @endforeach
</div>

