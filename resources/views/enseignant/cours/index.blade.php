@extends('layouts.enseignant')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Documents de Cours</h1>
    
    <div class="card mb-4">
        <div class="card-header bg-dark text-white">
            <i class="fas fa-book me-1"></i>
            Mes Ressources Pédagogiques
        </div>
        <div class="card-body">
            <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3">
                <button class="btn btn-primary me-md-2" type="button" data-bs-toggle="modal" data-bs-target="#ajouterCoursModal">
                    <i class="fas fa-plus me-1"></i> Ajouter un Document
                </button>
            </div>

            <div class="row">
                @foreach($cours as $document)
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-file-pdf fa-3x text-danger mb-3"></i>
                            <h5 class="card-title">{{ $document->titre }}</h5>
                            <p class="card-text text-muted">
                                {{ $document->module->nom }}<br>
                                Ajouté le {{ $document->created_at->format('d/m/Y') }}
                            </p>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="btn-group w-100">
                                <a href="{{ Storage::url($document->chemin) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ Storage::url($document->chemin) }}" download class="btn btn-sm btn-outline-success">
                                    <i class="fas fa-download"></i>
                                </a>
                                <form method="POST" action="{{ route('enseignant.cours.destroy', $document->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Modal Ajout Document -->
<div class="modal fade" id="ajouterCoursModal" tabindex="-1" aria-labelledby="ajouterCoursModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('enseignant.cours.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="ajouterCoursModalLabel">Ajouter un Document</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="titre" class="form-label">Titre du Document</label>
                        <input type="text" class="form-control" id="titre" name="titre" required>
                    </div>
                    <div class="mb-3">
                        <label for="module_id" class="form-label">Module</label>
                        <select class="form-select" id="module_id" name="module_id" required>
                            @foreach($modules as $module)
                            <option value="{{ $module->id }}">{{ $module->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="document" class="form-label">Fichier (PDF, DOC, PPT)</label>
                        <input class="form-control" type="file" id="document" name="document" accept=".pdf,.doc,.docx,.ppt,.pptx" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection