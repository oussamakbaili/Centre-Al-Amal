<!-- resources/views/admin/etudiants/edit.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Modifier l'étudiant</h2>

    <form action="{{ route('admin.etudiants.update', $etudiant->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" value="{{ $etudiant->nom }}" class="form-control">
        </div>

        <div class="form-group">
            <label for="email">Email :</label>
            <input type="email" id="email" name="email" value="{{ $etudiant->email }}" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>
@endsection
