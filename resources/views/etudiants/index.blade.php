@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3>Liste des étudiants</h3>
                    <a href="{{ route('etudiants.create') }}" class="btn btn-primary">Ajouter un étudiant</a>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Email</th>
                                <th>CIN</th>
                                <th>Date de naissance</th>
                                <th>Adresse</th>
                                <th>Téléphone</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($etudiants as $etudiant)
                                <tr>
                                    <td>
                                        @if($etudiant->image)
                                            <img src="{{ asset('storage/'.$etudiant->image) }}" alt="Image de {{ $etudiant->nom }}" width="50" height="50" class="rounded-circle">
                                        @else
                                            <img src="{{ asset('images/default-avatar.png') }}" alt="Avatar" width="50" height="50" class="rounded-circle">
                                        @endif
                                    </td>
                                    <td>{{ $etudiant->nom }}</td>
                                    <td>{{ $etudiant->prenom }}</td>
                                    <td>{{ $etudiant->email }}</td>
                                    <td>{{ $etudiant->cin }}</td>
                                    <td>{{ $etudiant->date_naissance }}</td>
                                    <td>{{ $etudiant->adresse }}</td>
                                    <td>{{ $etudiant->telephone }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('etudiants.edit', $etudiant->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                                            <form action="{{ route('etudiants.destroy', $etudiant->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet étudiant?')">Supprimer</button>
                                            </form>
                                        </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">Aucun étudiant enregistré</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-center mt-3">
                        {{ $etudiants->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
