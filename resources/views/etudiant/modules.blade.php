@extends('layouts.etudiant')

@section('title', 'Mes Modules')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($modules as $module)
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">{{ $module->nom }}</h3>
            </div>
            <div class="px-6 py-4">
                <div class="mb-4">
                    <h4 class="text-sm font-medium text-gray-500 mb-1">Enseignant</h4>
                    <p class="text-gray-900">{{ $module->enseignant->name ?? 'Non attribué' }}</p>
                </div>
                <div class="mb-4">
                    <h4 class="text-sm font-medium text-gray-500 mb-1">Description</h4>
                    <p class="text-gray-900">{{ $module->description ?? 'Aucune description disponible' }}</p>
                </div>
                <div>
                    <h4 class="text-sm font-medium text-gray-500 mb-1">Volume horaire</h4>
                    <p class="text-gray-900">{{ $module->volume_horaire }} heures</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection