@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Gestion des absences pour {{ $etudiant->nom }} {{ $etudiant->prenom }}</h2>

    <!-- Tableau des absences -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Date d'absence</th>
                <th>État</th>
            </tr>
        </thead>
        <tbody>
            @foreach($etudiant->absences as $absence)
                <tr>
                    <td>{{ $absence->date_absence }}</td>
                    <td>{{ $absence->etat }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Nombre total d'absences -->
    <div class="mt-3">
        <strong>Nombre total d'absences :</strong> {{ $etudiant->absences->count() }}
    </div>

    <!-- Bouton Retour -->
    <div class="mt-3">
        <a href="{{ route('admin.etudiants.index') }}" class="btn btn-secondary">Retour</a>
    </div>
</div>
@endsection