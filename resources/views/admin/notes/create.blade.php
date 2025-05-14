@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto p-8">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Ajouter une Note</h1>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <form method="POST" action="{{ route('admin.notes.store') }}">
            @csrf
            
            <div class="mb-4">
                <label for="etudiant_id" class="block text-sm font-medium text-gray-700 mb-2">Étudiant:</label>
                <select name="etudiant_id" id="etudiant_id" required
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Sélectionner un étudiant</option>
                    @foreach($etudiants as $etudiant)
                        <option value="{{ $etudiant->id }}">
                            {{ $etudiant->nom }} {{ $etudiant->prenom }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="mb-4">
                <label for="module_id" class="block text-sm font-medium text-gray-700 mb-2">Module:</label>
                <select name="module_id" id="module_id" required
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Sélectionner un module</option>
                    @foreach($modules as $module)
                        <option value="{{ $module->id }}">{{ $module->nom }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="mb-4">
                <label for="note_type" class="block text-sm font-medium text-gray-700 mb-2">Type de Note:</label>
                <select name="note_type" id="note_type" required
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="note1">Note 1</option>
                    <option value="note2">Note 2</option>
                </select>
            </div>
            
            <div class="mb-6">
                <label for="note" class="block text-sm font-medium text-gray-700 mb-2">Note (sur 20):</label>
                <input type="number" name="note" id="note" step="0.01" min="0" max="20" required
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
            
            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.notes.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                    Annuler
                </a>
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection