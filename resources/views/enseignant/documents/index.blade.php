<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Mes Documents</h4>
                    <a href="{{ route('enseignant.documents.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Ajouter un document
                    </a>
                </div>

                <div class="card-body">
                    {{-- Messages de succès/erreur --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    {{-- Liste des documents --}}
                    @if($documents->count() > 0)
                        <div class="list-group">
                            @foreach($documents as $document)
                                <div class="list-group-item border-0 mb-3">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <div class="d-flex align-items-center mb-1">
                                                <i class="fas fa-file-alt me-2 text-primary"></i>
                                                <h5 class="mb-0">{{ $document->titre }}</h5>
                                            </div>
                                            @if($document->contenu)
                                                <p class="mb-1 text-muted">{{ $document->contenu }}</p>
                                            @endif
                                            <div class="d-flex align-items-center">
                                                @if($document->fichier)
                                                    <a href="{{ Storage::url($document->fichier) }}"
                                                       target="_blank"
                                                       class="btn btn-sm btn-outline-primary me-2">
                                                        <i class="fas fa-download"></i> Télécharger
                                                    </a>
                                                @endif
                                                <small class="text-muted me-2">
                                                    <i class="fas fa-calendar-alt"></i>
                                                    {{ $document->created_at->format('d M') }}
                                                </small>
                                                @if($document->module)
                                                    <span class="badge bg-primary me-2">
                                                        {{ $document->module->nom }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('enseignant.documents.show', $document->id) }}"
                                               class="btn btn-sm btn-outline-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <form action="{{ route('enseignant.documents.destroy', $document->id) }}"
                                                  method="POST"
                                                  style="display: inline;"
                                                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce document ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @if(!$loop->last)
                                    <hr class="my-2">
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
