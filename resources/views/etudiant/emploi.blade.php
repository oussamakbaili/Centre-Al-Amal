<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Mon Emploi du Temps</h1>
        <a href="#" class="btn btn-outline-primary" onclick="window.print()">
            <i class="fas fa-print"></i> Imprimer
        </a>
    </div>

    <div class="card shadow">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th style="width: 15%">Jour</th>
                            <th style="width: 20%">Créneau horaire</th>
                            <th style="width: 25%">Module</th>
                            <th style="width: 20%">Salle</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'] as $jour)
                            @if(isset($emplois[$jour]))
                                @foreach($emplois[$jour] as $index => $emploi)
                                    <tr>
                                        @if($index === 0)
                                            <td rowspan="{{ count($emplois[$jour]) }}" class="align-middle">
                                                <strong>{{ $jour }}</strong>
                                            </td>
                                        @endif
                                        <td>
                                            {{ date('H:i', strtotime($emploi->heure_debut)) }} -
                                            {{ date('H:i', strtotime($emploi->heure_fin)) }}
                                        </td>
                                        <td>{{ $emploi->module->nom }}</td>
                                        <td>{{ $emploi->salle }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td><strong>{{ $jour }}</strong></td>
                                    <td colspan="3" class="text-muted">Aucun cours programmé</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        @media print {
            body { padding: 20px; }
            .btn { display: none; }
            table { font-size: 12px; }
        }
    </style>
</div>
