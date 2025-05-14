@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto p-8">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Modifier les Notes</h1>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <form method="POST" action="{{ route('admin.notes.update', ['etudiant_id' => $etudiant->id, 'module_id' => $module->id]) }}">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label for="note1" class="block text-sm font-medium text-gray-700 mb-2">Note 1:</label>
                <input type="number" name="note1" id="note1" step="0.01" min="0" max="20"
                    value="{{ $notes['note1']->note ?? '' }}"
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
            
            <div class="mb-6">
                <label for="note2" class="block text-sm font-medium text-gray-700 mb-2">Note 2:</label>
                <input type="number" name="note2" id="note2" step="0.01" min="0" max="20"
                    value="{{ $notes['note2']->note ?? '' }}"
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