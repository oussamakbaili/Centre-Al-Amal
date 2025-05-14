@extends('layouts.enseignant')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Gestion des Notes</h1>
    
    <div class="card mb-4">
        <div class="card-header bg-dark text-white">
            <i class="fas fa-graduation-cap me-1"></i>
            Notes par Module
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-4">
                    <select class="form-select" id="module-select">
                        <option value="">Sélectionnez un module</option>
                        @foreach($modules as $module)
                        <option value="{{ $module->id }}">{{ $module->nom }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="table-responsive" id="notes-container">
                <!-- Contenu chargé via AJAX -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#module-select').change(function() {
            const moduleId = $(this).val();
            if(moduleId) {
                $.get(`/enseignant/notes/module/${moduleId}`, function(data) {
                    $('#notes-container').html(data);
                });
            } else {
                $('#notes-container').html('');
            }
        });
    });
</script>
@endpush