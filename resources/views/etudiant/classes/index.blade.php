@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-4">
    <h1 class="text-2xl font-bold mb-6">Mes Classes</h1>

    @if($classes->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($classes as $classe)
                <a href="{{ route('etudiant.class.show', $classe->id) }}"
                   class="border rounded-lg p-6 shadow hover:shadow-lg transition-shadow block">
                    <h2 class="text-xl font-semibold mb-2">{{ $classe->nom }}</h2>
                    <p class="text-gray-600 mb-3">Enseignant: {{ $classe->enseignant->name }}</p>
                    <p class="text-sm text-gray-500">
                        {{ $classe->documents_count }} document(s)
                    </p>
                </a>
            @endforeach
        </div>
    @else
        <p class="text-gray-500">Vous n'êtes inscrit dans aucune classe pour le moment.</p>
    @endif
</div>
@endsection
