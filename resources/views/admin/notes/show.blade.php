@extends('layouts.admin')

@section('title', 'Détails des Notes')
@section('page-title', 'Détails des Notes')
@section('page-description', 'Consultez les notes de l\'étudiant pour le module sélectionné')

@section('header-actions')
    <div class="flex space-x-3">
        <a href="{{ route('admin.notes.edit', [$etudiant->id, $module->id]) }}" 
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl font-medium transition-all duration-200 flex items-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
            <i class="fas fa-edit mr-2"></i>
            Modifier
        </a>
        <a href="{{ route('admin.notes.index') }}" 
           class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-xl font-medium transition-all duration-200 flex items-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
            <i class="fas fa-arrow-left mr-2"></i>
            Retour
        </a>
    </div>
@endsection

@section('content')
    <!-- Student Information Card -->
    <div class="notion-card rounded-xl p-6 mb-8">
        <div class="flex items-center space-x-6">
            <div class="flex-shrink-0">
                @if($etudiant->image)
                    <img class="h-20 w-20 rounded-full object-cover border-4 border-gray-200" 
                         src="{{ asset('storage/' . $etudiant->image) }}" 
                         alt="{{ $etudiant->nom }}">
                @else
                    <div class="h-20 w-20 rounded-full bg-blue-100 flex items-center justify-center border-4 border-gray-200">
                        <i class="fas fa-user text-blue-600 text-2xl"></i>
                    </div>
                @endif
            </div>
            <div class="flex-1">
                <h1 class="text-2xl font-bold text-gray-900">{{ $etudiant->nom }} {{ $etudiant->prenom }}</h1>
                <p class="text-gray-600 mt-1">{{ $etudiant->niveau ?? 'Niveau non défini' }}</p>
                <div class="flex items-center mt-2">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                        <i class="fas fa-book mr-2"></i>
                        {{ $module->nom }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Notes Display -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Note 1 -->
        <div class="notion-card rounded-xl p-6">
            <div class="text-center">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Note 1</h3>
                @if($note1)
                    <div class="text-4xl font-bold mb-2 
                        @if($note1->note >= 16) text-green-600
                        @elseif($note1->note >= 14) text-blue-600
                        @elseif($note1->note >= 12) text-yellow-600
                        @elseif($note1->note >= 10) text-orange-600
                        @else text-red-600
                        @endif">
                        {{ number_format($note1->note, 1) }}<span class="text-lg text-gray-500">/20</span>
                    </div>
                    <p class="text-sm text-gray-600">Ajoutée le {{ $note1->created_at->format('d/m/Y à H:i') }}</p>
                @else
                    <div class="text-4xl font-bold text-gray-400 mb-2">-</div>
                    <p class="text-sm text-gray-500">Aucune note</p>
                @endif
            </div>
        </div>

        <!-- Note 2 -->
        <div class="notion-card rounded-xl p-6">
            <div class="text-center">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Note 2</h3>
                @if($note2)
                    <div class="text-4xl font-bold mb-2 
                        @if($note2->note >= 16) text-green-600
                        @elseif($note2->note >= 14) text-blue-600
                        @elseif($note2->note >= 12) text-yellow-600
                        @elseif($note2->note >= 10) text-orange-600
                        @else text-red-600
                        @endif">
                        {{ number_format($note2->note, 1) }}<span class="text-lg text-gray-500">/20</span>
                    </div>
                    <p class="text-sm text-gray-600">Ajoutée le {{ $note2->created_at->format('d/m/Y à H:i') }}</p>
                @else
                    <div class="text-4xl font-bold text-gray-400 mb-2">-</div>
                    <p class="text-sm text-gray-500">Aucune note</p>
                @endif
            </div>
        </div>

        <!-- Average -->
        <div class="notion-card rounded-xl p-6 {{ $moyenne ? 'bg-gradient-to-br from-indigo-50 to-purple-50' : '' }}">
            <div class="text-center">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Moyenne</h3>
                @if($moyenne !== null)
                    <div class="text-4xl font-bold mb-2 
                        @if($moyenne >= 16) text-green-600
                        @elseif($moyenne >= 14) text-blue-600
                        @elseif($moyenne >= 12) text-yellow-600
                        @elseif($moyenne >= 10) text-orange-600
                        @else text-red-600
                        @endif">
                        {{ number_format($moyenne, 1) }}<span class="text-lg text-gray-500">/20</span>
                    </div>
                    @if($moyenne >= 16)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            <i class="fas fa-star mr-1"></i>
                            Excellent
                        </span>
                    @elseif($moyenne >= 14)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            <i class="fas fa-thumbs-up mr-1"></i>
                            Bien
                        </span>
                    @elseif($moyenne >= 12)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                            <i class="fas fa-check mr-1"></i>
                            Assez bien
                        </span>
                    @elseif($moyenne >= 10)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-orange-100 text-orange-800">
                            <i class="fas fa-minus mr-1"></i>
                            Passable
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                            <i class="fas fa-times mr-1"></i>
                            Insuffisant
                        </span>
                    @endif
                @else
                    <div class="text-4xl font-bold text-gray-400 mb-2">-</div>
                    <p class="text-sm text-gray-500">Moyenne non calculable</p>
                    <p class="text-xs text-gray-400 mt-1">Les deux notes sont requises</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="notion-card rounded-xl p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <i class="fas fa-cogs mr-3 text-indigo-500"></i>
            Actions disponibles
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('admin.notes.edit', [$etudiant->id, $module->id]) }}" 
               class="flex items-center justify-center p-4 bg-blue-50 rounded-xl hover:bg-blue-100 transition-colors group">
                <div class="text-center">
                    <i class="fas fa-edit text-blue-600 text-xl mb-2"></i>
                    <div class="text-sm font-medium text-blue-700">Modifier les notes</div>
                </div>
            </a>
            
            <a href="{{ route('admin.notes.index', ['module_id' => $module->id]) }}" 
               class="flex items-center justify-center p-4 bg-purple-50 rounded-xl hover:bg-purple-100 transition-colors group">
                <div class="text-center">
                    <i class="fas fa-list text-purple-600 text-xl mb-2"></i>
                    <div class="text-sm font-medium text-purple-700">Notes du module</div>
                </div>
            </a>
            
            <form action="{{ route('admin.notes.destroyAll', [$etudiant->id, $module->id]) }}" 
                  method="POST" 
                  class="inline"
                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer toutes les notes de cet étudiant pour ce module ?')">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="w-full flex items-center justify-center p-4 bg-red-50 rounded-xl hover:bg-red-100 transition-colors group">
                    <div class="text-center">
                        <i class="fas fa-trash text-red-600 text-xl mb-2"></i>
                        <div class="text-sm font-medium text-red-700">Supprimer tout</div>
                    </div>
                </button>
            </form>
        </div>
    </div>
@endsection 