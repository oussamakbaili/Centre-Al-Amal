<div class="container-fluid py-4">
    <div class="row">
        <!-- Colonne de gauche - Profil -->
        <div class="col-lg-3">
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    <img src="{{ $etudiant->photo ? asset('storage/'.$etudiant->photo) : asset('img/default-avatar.png') }}" 
                         class="rounded-circle mb-3 shadow" width="150" height="150" alt="{{ $etudiant->nom }}">
                    
                    <h3 class="h5 fw-bold">{{ $etudiant->nom }} {{ $etudiant->prenom }}</h3>
                    <span class="badge bg-primary bg-gradient mb-3">
                        {{ $etudiant->groupe->nom ?? 'Aucun groupe' }}
                    </span>
                    
                    <div class="d-grid gap-2">
                        <a href="mailto:{{ $etudiant->email }}" class="btn btn-primary btn-sm rounded-pill">
                            <i class="fas fa-envelope me-2"></i> Envoyer un email
                        </a>
                        @if($etudiant->telephone)
                        <a href="tel:{{ $etudiant->telephone }}" class="btn btn-outline-secondary btn-sm rounded-pill">
                            <i class="fas fa-phone me-2"></i> Appeler
                        </a>
                        @endif
                        <a href="{{ route('enseignant.etudiants.absences', $etudiant->id) }}" 
                           class="btn btn-outline-warning mt-2">
                           <i class="fas fa-calendar-times me-2"></i> Voir les absences
                        </a>    
                    </div>
                </div>
            </div>
        </div>

        <!-- Colonne de droite - Contenu principal -->
        <div class="col-lg-9">
            <!-- Section Informations -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <h4 class="mb-0"><i class="fas fa-info-circle text-primary me-2"></i> Informations personnelles</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted small mb-1">CIN</label>
                                <p class="mb-0 fw-bold">{{ $etudiant->cin ?? 'Non renseigné' }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label text-muted small mb-1">Date de naissance</label>
                                <p class="mb-0 fw-bold">
                                    @if($etudiant->date_naissance)
                                        {{ \Carbon\Carbon::parse($etudiant->date_naissance)->format('d/m/Y') }} 
                                        ({{ \Carbon\Carbon::parse($etudiant->date_naissance)->age }} ans)
                                    @else
                                        Non renseignée
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted small mb-1">Adresse</label>
                                <p class="mb-0 fw-bold">{{ $etudiant->adresse ?? 'Non renseignée' }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label text-muted small mb-1">Email</label>
                                <p class="mb-0 fw-bold">{{ $etudiant->email }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section Statistiques -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card bg-gradient-success text-white shadow">
                        <div class="card-body py-3">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="fas fa-chart-line fa-2x"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Moyenne générale</h6>
                                    <h3 class="mb-0">{{ number_format($etudiant->moyenne_generale, 2) }}/20</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card bg-gradient-warning text-white shadow">
                        <div class="card-body py-3">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="fas fa-calendar-times fa-2x"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Absences</h6>
                                    <h3 class="mb-0">{{ $etudiant->absences_count }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card bg-gradient-info text-white shadow">
                        <div class="card-body py-3">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="fas fa-clock fa-2x"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Dernière connexion</h6>
                                    <h5 class="mb-0">
                                        @if($etudiant->last_login_at)
                                            {{ $etudiant->last_login_at->diffForHumans() }}
                                        @else
                                            Jamais connecté
                                        @endif
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section Modules -->
            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h4 class="mb-0"><i class="fas fa-book text-primary me-2"></i> Modules suivis</h4>
                </div>
                <div class="card-body">
                    @forelse($etudiant->modules as $module)
                    <div class="d-inline-block me-2 mb-2">
                        <span class="badge bg-primary bg-opacity-10 text-primary p-2">
                            <i class="fas fa-bookmark me-1"></i> {{ $module->nom }}
                        </span>
                    </div>
                    @empty
                    <div class="alert alert-light">
                        Aucun module suivi
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        border-radius: 0.75rem;
        border: none;
    }
    .card-header {
        border-radius: 0.75rem 0.75rem 0 0 !important;
    }
    .bg-gradient-success {
        background: linear-gradient(135deg, #2dce89 0%, #2dcecc 100%);
    }
    .bg-gradient-warning {
        background: linear-gradient(135deg, #fb6340 0%, #fbb140 100%);
    }
    .bg-gradient-info {
        background: linear-gradient(135deg, #11cdef 0%, #1171ef 100%);
    }
</style>