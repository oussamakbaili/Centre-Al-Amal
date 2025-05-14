@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Gestion des Absences</h2>
    
    @if($absences->count() > 0)
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>Étudiant</th>
                    <th>Enseignant</th>
                    <th>Date</th>
                    <th>Statut</th>
                    <th>Motif</th>
                </tr>
            </thead>
            <tbody>
                @foreach($absences as $absence)
                <tr>
                    <td>{{ $absence->etudiant->nom ?? 'N/A' }}</td>
                    <td>{{ $absence->enseignant->name ?? 'Non assigné' }}</td>
                    <td>{{ \Carbon\Carbon::parse($absence->date_absence)->format('d/m/Y') }}</td>
                    <td>
                        <span class="badge badge-{{ $absence->stat === 'Justifié' ? 'success' : 'danger' }}">
                            {{ $absence->stat }}
                        </span>
                    </td>
                    <td>{{ $absence->motif ?? 'Aucun motif' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-info">
            Aucune absence enregistrée.
        </div>
    @endif
</div>
@endsection