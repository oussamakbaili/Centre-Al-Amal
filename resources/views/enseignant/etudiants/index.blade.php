@extends('layouts.enseignant')

@section('content')

<div class="container py-4">
    <h2 class="h4 fw-bold mb-4">
        <i class="fas fa-user-graduate me-2 text-primary"></i>Mes Étudiants
    </h2>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="ps-4">Nom</th>
                            <th scope="col">Email</th>
                            <th scope="col">Groupe</th>
                            <th scope="col">Modules</th>
                            <th scope="col" class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($etudiants as $etudiant)
                            <tr>
                                <td class="fw-semibold ps-4">
                                    <a href="{{ route('enseignant.etudiants.profile', $etudiant->id) }}"
                                       class="text-decoration-none text-dark">
                                        {{ $etudiant->nom }}
                                    </a>
                                </td>
                                <td>{{ $etudiant->email }}</td>
                                <td>{{ $etudiant->groupe }}</td>
                                <td>
                                    @foreach($etudiant->modules as $module)
                                        @if(auth()->user()->enseignant->modules->contains($module))
                                            <span class="badge bg-primary">{{ $module->nom }}</span>
                                        @endif
                                    @endforeach
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('enseignant.etudiants.profile', $etudiant->id) }}" 
                                           class="btn btn-outline-info px-3" title="Voir le profil">
                                            <i class="far fa-user"></i>
                                        </a>
                                        <a href="{{ route('enseignant.etudiants.absences', $etudiant->id) }}" 
                                           class="btn btn-outline-warning px-3" title="Consulter les absences">
                                            <i class="far fa-calendar-alt"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .badge {
        font-size: 0.75rem;
        padding: 0.35em 0.5em;
    }
    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
    }
    a.text-decoration-none:hover {
        text-decoration: underline;
    }
</style>
@endpush
