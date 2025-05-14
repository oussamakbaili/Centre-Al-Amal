@props(['emplois'])

@foreach(['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'] as $jour)
    @if(isset($emplois[$jour]))
    <h3 class="mt-4">{{ $jour }}</h3>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>Heure</th>
                    <th>Module</th>
                    @if(!isset($hideGroupe))<th>Groupe</th>@endif
                    @if(!isset($hideEnseignant))<th>Enseignant</th>@endif
                    <th>Salle</th>
                </tr>
            </thead>
            <tbody>
                @foreach($emplois[$jour] as $emploi)
                <tr>
                    <td>{{ date('H:i', strtotime($emploi->heure_debut)) }} - {{ date('H:i', strtotime($emploi->heure_fin)) }}</td>
                    <td>{{ $emploi->module->nom }}</td>
                    @if(!isset($hideGroupe))<td>{{ $emploi->groupe->nom }}</td>@endif
                    @if(!isset($hideEnseignant))<td>{{ $emploi->enseignant->name }}</td>@endif
                    <td>{{ $emploi->salle }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
@endforeach