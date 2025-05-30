<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 bg-white sidebar">
            <div class="sidebar-sticky">
                <!-- Navigation principale -->
                <ul class="nav flex-column mb-4">
                    <li class="nav-item">
                        <a class="nav-link {{ !request()->route('module') ? 'active' : '' }}"
                           href="{{ route('etudiant.dashboard') }}">
                            <i class="fas fa-home me-2"></i> Accueil
                        </a>
                    </li>
                </ul>

                <!-- Section Inscrit -->
                <div class="sidebar-section">
                    <div class="d-flex align-items-center justify-content-between px-3 mb-2">
                        <h6 class="sidebar-heading text-muted mb-0">
                            <i class="fas fa-graduation-cap me-2"></i> Inscrit
                        </h6>
                        <i class="fas fa-chevron-down text-muted"></i>
                    </div>

                    <ul class="nav flex-column">
                        @foreach($modules as $module)
                        <li class="nav-item">
                            <a class="nav-link module-link {{ request()->route('module') && request()->route('module')->id == $module->id ? 'active' : '' }}"
                               href="{{ route('etudiant.documents.show', $module) }}">
                                <div class="d-flex align-items-center">
                                    <div class="module-avatar me-3"
                                         style="width: 32px; height: 32px; background-color: {{ $module->couleur ?? '#4285f4' }}; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 14px;">
                                        {{ strtoupper(substr($module->nom, 0, 1)) }}
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="module-name">{{ $module->nom }}</div>
                                        <div class="module-teacher">{{ $module->enseignant->nom ?? 'Enseignant' }}</div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
            @if(!request()->route('module'))
                <!-- Page d'accueil - Liste des modules -->
                <div class="content-header">
                    <h1 class="page-title">Mes Modules</h1>
                </div>

                @if($modules->isEmpty())
                    <div class="empty-state">
                        <i class="fas fa-book fa-3x text-muted mb-3"></i>
                        <h3 class="text-muted">Aucun module trouvé</h3>
                        <p class="text-muted">Vous n'êtes inscrit à aucun module pour le moment.</p>
                    </div>
                @else
                    <div class="modules-grid">
                        @foreach($modules as $module)
                        <div class="module-card" onclick="window.location.href='{{ route('etudiant.documents.show', $module) }}'">
                            <div class="module-card-header" style="background: linear-gradient(135deg, {{ $module->couleur ?? '#4285f4' }}, {{ $module->couleur ?? '#1a73e8' }});">
                                <div class="module-info">
                                    <h3 class="module-title">{{ $module->nom }}</h3>
                                    <p class="module-subtitle">{{ $module->code ?? 'Code module' }}</p>
                                    <p class="module-teacher">{{ $module->enseignant->nom ?? 'Enseignant' }}</p>
                                </div>
                                <div class="module-avatar-large">
                                    @if($module->enseignant && $module->enseignant->avatar)
                                        <img src="{{ $module->enseignant->avatar }}" alt="Enseignant" class="teacher-avatar">
                                    @else
                                        <div class="teacher-avatar-placeholder">
                                            {{ strtoupper(substr($module->enseignant->nom ?? 'E', 0, 1)) }}
                                        </div>
                                    @endif
                                </div>
                                <div class="module-menu">
                                    <button class="btn-menu" onclick="event.stopPropagation();">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="module-card-footer">
                                <div class="module-stats">
                                    <i class="fas fa-users me-1"></i>
                                    <i class="fas fa-folder me-1"></i>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            @else
                <!-- Page spécifique du module -->
                <div class="module-header" style="background: linear-gradient(135deg, {{ $currentModule->couleur ?? '#4285f4' }}, {{ $currentModule->couleur ?? '#1a73e8' }});">
                    <div class="module-header-content">
                        <div class="module-header-info">
                            <h1 class="module-header-title">{{ $currentModule->nom }}</h1>
                            <p class="module-header-subtitle">{{ $currentModule->code ?? 'Code module' }}</p>
                        </div>
                        <div class="module-header-avatar">
                            @if($currentModule->enseignant && $currentModule->enseignant->avatar)
                                <img src="{{ $currentModule->enseignant->avatar }}" alt="Enseignant" class="teacher-avatar-large">
                            @else
                                <div class="teacher-avatar-large-placeholder">
                                    {{ strtoupper(substr($currentModule->enseignant->nom ?? 'E', 0, 1)) }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Navigation tabs -->
                <div class="module-tabs">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">Stream</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Classwork</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">People</a>
                        </li>
                    </ul>
                </div>

                <!-- Documents section -->
                <div class="documents-section">
                    @if($documents && $documents->count() > 0)
                        @foreach($documents as $document)
                        <div class="document-item">
                            <div class="document-icon">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <div class="document-info">
                                <div class="document-author">{{ $currentModule->enseignant->nom ?? 'Enseignant' }} posted a new material: {{ $document->titre }}</div>
                                <div class="document-date">{{ $document->created_at->format('d M') }}</div>
                            </div>
                            <div class="document-menu">
                                <div class="dropdown">
                                    <button class="btn-document-menu" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('etudiant.documents.download', $document) }}">
                                                <i class="fas fa-download me-2"></i>Télécharger
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="no-documents">
                            <p>Aucun document disponible pour ce module.</p>
                        </div>
                    @endif
                </div>
            @endif
        </main>
    </div>
</div>

<style>
/* Base styles */
body {
    background-color: #f8f9fa;
    font-family: 'Google Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

/* Sidebar */
.sidebar {
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    z-index: 100;
    padding: 20px 0;
    box-shadow: 1px 0 3px rgba(60,64,67,.15);
    border-right: 1px solid #e8eaed;
}

.sidebar-sticky {
    position: relative;
    top: 0;
    height: calc(100vh - 40px);
    padding-top: 0;
    overflow-x: hidden;
    overflow-y: auto;
}

.sidebar-section {
    margin-bottom: 20px;
}

.sidebar-heading {
    font-size: 14px;
    font-weight: 500;
    color: #5f6368;
}

.nav-link {
    color: #3c4043;
    padding: 8px 16px;
    border-radius: 0 25px 25px 0;
    margin-right: 8px;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.2s;
}

.nav-link:hover {
    background-color: #f1f3f4;
    color: #1a73e8;
}

.nav-link.active {
    background-color: #e8f0fe;
    color: #1a73e8;
    font-weight: 600;
}

.module-link {
    padding: 8px 16px;
}

.module-name {
    font-size: 14px;
    font-weight: 500;
    color: #3c4043;
    line-height: 1.3;
}

.module-teacher {
    font-size: 12px;
    color: #5f6368;
    line-height: 1.2;
}

/* Main content */
.main-content {
    margin-left: 240px;
    padding-top: 20px;
}

.content-header {
    margin-bottom: 24px;
}

.page-title {
    font-size: 32px;
    font-weight: 400;
    color: #3c4043;
    margin: 0;
}

/* Modules grid */
.modules-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
}

.module-card {
    background: white;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(60,64,67,.3);
    cursor: pointer;
    transition: all 0.2s;
    overflow: hidden;
}

.module-card:hover {
    box-shadow: 0 2px 8px rgba(60,64,67,.3);
    transform: translateY(-1px);
}

.module-card-header {
    padding: 20px;
    color: white;
    position: relative;
    min-height: 100px;
    display: flex;
    align-items: flex-start;
}

.module-info {
    flex: 1;
}

.module-title {
    font-size: 18px;
    font-weight: 500;
    margin: 0 0 4px 0;
    color: white;
}

.module-subtitle {
    font-size: 14px;
    margin: 0 0 4px 0;
    opacity: 0.9;
}

.module-teacher {
    font-size: 14px;
    margin: 0;
    opacity: 0.9;
}

.module-avatar-large {
    width: 60px;
    height: 60px;
    margin-left: 16px;
}

.teacher-avatar,
.teacher-avatar-placeholder {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: rgba(255,255,255,0.2);
    color: white;
    font-weight: 500;
    font-size: 24px;
}

.module-menu {
    position: absolute;
    top: 12px;
    right: 12px;
}

.btn-menu {
    background: none;
    border: none;
    color: white;
    padding: 8px;
    border-radius: 50%;
    transition: background-color 0.2s;
}

.btn-menu:hover {
    background-color: rgba(255,255,255,0.1);
}

.module-card-footer {
    padding: 16px 20px;
    border-top: 1px solid #e8eaed;
}

.module-stats {
    color: #5f6368;
    font-size: 14px;
}

/* Module header */
.module-header {
    margin: -20px -24px 24px -24px;
    padding: 24px;
    color: white;
    position: relative;
    overflow: hidden;
}

.module-header::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 200px;
    height: 200px;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="20" fill="%23ffffff" opacity="0.1"/><circle cx="30" cy="30" r="10" fill="%23ffffff" opacity="0.15"/></svg>');
    background-size: contain;
}

.module-header-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: relative;
    z-index: 1;
}

.module-header-title {
    font-size: 36px;
    font-weight: 400;
    margin: 0 0 8px 0;
    color: white;
}

.module-header-subtitle {
    font-size: 16px;
    margin: 0;
    opacity: 0.9;
}

.teacher-avatar-large,
.teacher-avatar-large-placeholder {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: rgba(255,255,255,0.2);
    color: white;
    font-weight: 500;
    font-size: 32px;
}

/* Tabs */
.module-tabs {
    border-bottom: 1px solid #e8eaed;
    margin-bottom: 24px;
}

.nav-tabs {
    border-bottom: none;
}

.nav-tabs .nav-link {
    border: none;
    color: #5f6368;
    font-weight: 500;
    padding: 12px 24px;
    margin-right: 32px;
    background: none;
    border-radius: 0;
}

.nav-tabs .nav-link.active {
    color: #1a73e8;
    background: none;
    border-bottom: 2px solid #1a73e8;
}

/* Documents */
.documents-section {
    max-width: 800px;
}

.document-item {
    background: white;
    border-radius: 8px;
    padding: 16px 20px;
    margin-bottom: 12px;
    box-shadow: 0 1px 3px rgba(60,64,67,.3);
    display: flex;
    align-items: center;
}

.document-icon {
    width: 40px;
    height: 40px;
    background-color: #f1f3f4;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 16px;
    color: #5f6368;
}

.document-info {
    flex: 1;
}

.document-author {
    font-size: 14px;
    color: #3c4043;
    font-weight: 500;
    margin-bottom: 4px;
}

.document-date {
    font-size: 12px;
    color: #5f6368;
}

.btn-document-menu {
    background: none;
    border: none;
    color: #5f6368;
    padding: 8px;
    border-radius: 50%;
    transition: background-color 0.2s;
}

.btn-document-menu:hover {
    background-color: #f1f3f4;
}

.no-documents {
    text-align: center;
    padding: 40px;
    color: #5f6368;
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
}

/* Responsive */
@media (max-width: 1200px) {
    .modules-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 767.98px) {
    .sidebar {
        position: static;
        height: auto;
    }

    .main-content {
        margin-left: 0;
    }

    .modules-grid {
        grid-template-columns: 1fr;
    }

    .module-header {
        margin: -20px -16px 24px -16px;
        padding: 20px 16px;
    }

    .module-header-title {
        font-size: 28px;
    }
}
</style>
