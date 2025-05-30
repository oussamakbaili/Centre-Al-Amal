
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 bg-light sidebar">
            <div class="sidebar-sticky">
                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                </h6>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('etudiant.documents.index') }}">
                            <i class="fas fa-home"></i> Accueil
                        </a>
                    </li>

                </ul>

                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                </h6>
                <ul class="nav flex-column">
                    @foreach($modules as $mod)
                    <li class="nav-item">
                        <a class="nav-link {{ $mod->id == $module->id ? 'active' : '' }}"
                           href="{{ route('etudiant.documents.show', $mod) }}">
                            <div class="d-flex align-items-center">
                                <span class="module-icon rounded-circle d-inline-flex align-items-center justify-content-center me-2"
                                      style="width: 24px; height: 24px; background-color: {{ $mod->couleur ?? '#007bff' }}; color: white; font-size: 12px;">
                                    {{ strtoupper(substr($mod->nom, 0, 1)) }}
                                </span>
                                <div class="flex-grow-1">
                                    <div class="fw-bold text-truncate" style="font-size: 14px;">{{ $mod->nom }}</div>
                                    <div class="text-muted small">{{ $mod->enseignant->nom ?? 'Enseignant' }}</div>
                                </div>
                            </div>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <!-- Header du module -->
            <div class="module-header p-4 mb-4 rounded"
                 style="background: linear-gradient(135deg, {{ $module->couleur ?? '#007bff' }}, {{ $module->couleur ?? '#0056b3' }}); color: white;">
                <div class="d-flex align-items-center">

                    <div class="flex-grow-1">
                        <h1 class="mb-1">{{ $module->nom }}</h1>
                        </div>
                    <div class="dropdown">
                        <button class="btn btn-outline-light" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>

                    </div>
                </div>
            </div>

            <!-- Navigation tabs -->
            <ul class="nav nav-tabs mb-4" id="moduleTab" role="tablist">

            </ul>

            <!-- Tab content -->
            <div class="tab-content" id="moduleTabContent">
                <!-- Stream Tab -->
                <div class="tab-pane fade show active" id="stream" role="tabpanel">
                    <div class="row">
                        <div class="col-md-8">
                            <!-- Zone d'annonce -->
                            <div class="card mb-4">
                                <div class="card-body">

                                </div>
                            </div>

                            <!-- Liste des documents/activités récentes -->
                            @if($recentActivities && $recentActivities->count() > 0)
                                @foreach($recentActivities as $activity)
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="d-flex align-items-start">
                                            <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center me-3"
                                                 style="width: 40px; height: 40px;">
                                                <i class="fas fa-file-alt text-white"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <h6 class="mb-1">{{ $activity->auteur }} a publié un nouveau document: {{ $activity->titre }}</h6>
                                                        <small class="text-muted">{{ $activity->created_at->format('d M') }}</small>
                                                    </div>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item" href="#"><i class="fas fa-download me-2"></i>Télécharger</a></li>
                                                            <li><a class="dropdown-item" href="#"><i class="fas fa-eye me-2"></i>Ouvrir</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <div class="text-center py-5">
                                    <i class="fas fa-stream fa-3x text-muted mb-3"></i>
                                </div>
                            @endif
                        </div>

                        <div class="col-md-4">

                        </div>
                    </div>
                </div>

                <!-- Classwork Tab -->
                <div class="tab-pane fade" id="classwork" role="tabpanel">
                    <div class="row">
                        @if($module->documents && $module->documents->count() > 0)
                            @foreach($module->documents as $document)
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="d-flex align-items-start mb-3">


                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <a href="{{ $document->lien_fichier }}" class="btn btn-sm btn-outline-primary"
                                                   target="_blank">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="col-12 text-center py-5">
                                <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                                <h3 class="text-muted">Aucun document</h3>
                                <p class="text-muted">Les documents du cours apparaîtront ici.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- People Tab -->
                <div class="tab-pane fade" id="people" role="tabpanel">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<style>
.sidebar {
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    z-index: 100;
    padding: 48px 0 0;
    box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
}

.sidebar-sticky {
    position: relative;
    top: 0;
    height: calc(100vh - 48px);
    padding-top: .5rem;
    overflow-x: hidden;
    overflow-y: auto;
}

.nav-link {
    color: #333;
    padding: 0.75rem 1rem;
}

.nav-link:hover {
    color: #007bff;
    background-color: rgba(0,123,255,.1);
}

.nav-link.active {
    color: #007bff;
    background-color: rgba(0,123,255,.1);
    border-right: 3px solid #007bff;
}

.module-header {
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

main {
    margin-left: 16.66667%;
}

@media (max-width: 767.98px) {
    .sidebar {
        position: static;
    }
    main {
        margin-left: 0;
    }
}

.card {
    border: none;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: box-shadow 0.2s;
}

.card:hover {
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}
</style>

