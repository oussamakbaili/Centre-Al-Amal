@extends('layouts.admin')

@section('content')
    <h2>Absences de l'enseignant : {{ $enseignant->nom }}</h2>

    <a href="{{ route('admin.enseignants.index') }}" class="btn btn-secondary">Retour</a>

    <table class="table">
        <thead>
            <tr>
                <th>Date d'absence</th>
                <th>État</th>
                <th>Motif</th>
            </tr>
        </thead>
        <tbody>
            @forelse($absences as $absence)
            <tr>
                <td>
                    {{ $absence->date_absence ? \Carbon\Carbon::parse($absence->date_absence)->format('d/m/Y') : 'Date non disponible' }}
                </td>
                <td>{{ $absence->etat }}</td>
                <td>
                    {{ $absence->motif ? $absence->motif : "Aucun motif renseigné" }}
                </td>
        </tr>
            @empty
                <tr>
                    <td colspan="3">Aucune absence trouvée.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
