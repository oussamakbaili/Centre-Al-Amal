@extends('layouts.etudiant')

@section('title', $title)

@section('content')
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-6 border-b border-gray-200">
        <h2 class="text-xl font-semibold text-gray-800">Modules & Ressources</h2>
    </div>
    <div class="p-6">
        @forelse($modules as $module)
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">{{ $module->nom }}</h3>
            
            @if($module->ressources->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($module->ressources as $ressource)
                <div class="border rounded-lg overflow-hidden hover:shadow-md transition-shadow">
                    <div class="p-4">
                        <div class="flex items-center mb-3">
                            @if($ressource->type === 'document')
                            <i class="fas fa-file-pdf text-red-500 text-xl mr-3"></i>
                            @elseif($ressource->type === 'video')
                            <i class="fas fa-video text-blue-500 text-xl mr-3"></i>
                            @elseif($ressource->type === 'image')
                            <i class="fas fa-image text-green-500 text-xl mr-3"></i>
                            @else
                            <i class="fas fa-file text-gray-500 text-xl mr-3"></i>
                            @endif
                            <h4 class="font-medium">{{ $ressource->titre }}</h4>
                        </div>
                        <p class="text-sm text-gray-600 mb-3">{{ Str::limit($ressource->description, 100) }}</p>
                        <div class="flex justify-between items-center text-sm text-gray-500">
                            <span>Posté le {{ $ressource->created_at->format('d/m/Y') }}</span>
                            <a href="{{ asset('storage/'.$ressource->fichier) }}" download class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-download"></i> Télécharger
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-gray-500">Aucune ressource disponible pour ce module</p>
            @endif
        </div>
        @empty
        <p class="text-gray-500">Aucun module assigné</p>
        @endforelse
    </div>
</div>
@endsection