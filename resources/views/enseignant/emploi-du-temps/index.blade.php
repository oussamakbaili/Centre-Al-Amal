<div class="container">
    <h1 class="mb-4">Mon Emploi du Temps</h1>

    <div class="card shadow">
        <div class="card-body">
            @foreach(['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'] as $jour)
                @if(isset($emplois[$jour]))
                <h3 class="mt-4">{{ $jour }}</h3>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th>Heure</th>
                                <th>Module</th>
                                <th>Groupe</th>
                                <th>Salle</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($emplois[$jour] as $emploi)
                            <tr>
                                <td>{{ date('H:i', strtotime($emploi->heure_debut)) }} - {{ date('H:i', strtotime($emploi->heure_fin)) }}</td>
                                <td>{{ $emploi->module->nom }}</td>
                                <td>{{ $emploi->groupe->nom }}</td>
                                <td>{{ $emploi->salle }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            @endforeach
        </div>
    </div>
</div>
