@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Modifier l'absence</h2>
    <form action="{{ route('admin.absences.update', $absence->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="date_absence" class="form-label">Date d'absence</label>
            <input type="date" name="date_absence" id="date_absence" class="form-control" value="{{ $absence->date_absence }}" required>
        </div>

        <div class="mb-3">
            <label for="etat" class="form-label">État</label>
            <select name="etat" id="etat" class="form-control" required>
                <option value="Justifié" {{ $absence->etat == 'Justifié' ? 'selected' : '' }}>Justifié</option>
                <option value="Non justifié" {{ $absence->etat == 'Non justifié' ? 'selected' : '' }}>Non justifié</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="motif" class="form-label">Motif</label>
            <textarea name="motif" id="motif" class="form-control">{{ $absence->motif }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
        <a href="{{ route('admin.absences.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
