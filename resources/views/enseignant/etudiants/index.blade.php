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
                            <th scope="col" class="ps-4">Photo</th>
                            <th scope="col">Nom</th>
                            <th scope="col">Email</th>
                            <th scope="col">CIN</th>
                            <th scope="col">Date de Naissance</th>
                            <th scope="col">Adresse</th>
                            <th scope="col">Téléphone</th>
                            <th scope="col" class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($etudiants as $etudiant)
                            <tr>
                                <td class="ps-4">
                                    <img src="{{ asset('storage/' . $etudiant->photo) }}" alt="Photo de profil"
                                         class="rounded-circle" width="40" height="40">
                                </td>
                                <td class="fw-semibold">
                                    {{ $etudiant->nom }}
                                </td>
                                <td>{{ $etudiant->email }}</td>
                                <td>{{ $etudiant->cin }}</td>
                                <td>{{ \Carbon\Carbon::parse($etudiant->date_naissance)->format('d/m/Y') }}</td>
                                <td>{{ $etudiant->adresse }}</td>
                                <td>{{ $etudiant->telephone }}</td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('enseignant.etudiants.absences', $etudiant->id) }}"
                                       class="btn btn-outline-warning btn-sm" title="Consulter les absences">
                                        <i class="far fa-calendar-alt me-1"></i> Absences
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
