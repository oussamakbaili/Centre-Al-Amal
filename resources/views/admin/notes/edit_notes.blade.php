@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-10 bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-4">Modifier les Notes</h2>

    <form action="{{ route('admin.notes.updateNotes', $note->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block font-semibold">Étudiant :</label>
            <p>{{ $note->etudiant->nom }} {{ $note->etudiant->prenom }}</p>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Module :</label>
            <p>{{ $note->module->nom }}</p>
        </div>

        <div class="mb-4">
            <label for="note1" class="block font-semibold">Note 1 :</label>
            <input type="number" name="note1" id="note1" value="{{ $note->note1 }}" class="w-full border rounded px-3 py-2" step="0.01" min="0" max="20">
        </div>

        <div class="mb-4">
            <label for="note2" class="block font-semibold">Note 2 :</label>
            <input type="number" name="note2" id="note2" value="{{ $note->note2 }}" class="w-full border rounded px-3 py-2" step="0.01" min="0" max="20">
        </div>

        <div class="flex justify-end">
            <a href="{{ route('admin.notes.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Annuler</a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Enregistrer</button>
        </div>
    </form>
</div>
@endsection
