@extends('layouts.admin')

@section('title', 'Gestion des Modules')
@section('page-title', 'Gestion des Modules')
@section('page-description', 'Gérez les modules d\'enseignement du Centre Al-Amal')

@section('header-actions')
    <a href="{{ route('admin.modules.create') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center">
        <i class="fas fa-plus mr-2"></i>
        Nouveau Module
    </a>
@endsection

@section('content')
    <div class="space-y-6">
        <!-- Summary Bar -->
        <div class="notion-card rounded-xl p-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-6 text-sm">
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-book text-purple-600"></i>
                        <span class="font-medium text-gray-900">{{ $modules->count() }}</span>
                        <span class="text-gray-500">modules</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-chalkboard-teacher text-emerald-600"></i>
                        <span class="font-medium text-gray-900">{{ $modules->filter(function($module) { return $module->enseignant; })->count() }}</span>
                        <span class="text-gray-500">avec enseignants</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-users text-blue-600"></i>
                        <span class="font-medium text-gray-900">{{ $modules->filter(function($module) { return $module->etudiants->count() > 0; })->count() }}</span>
                        <span class="text-gray-500">avec étudiants</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search Section -->
        <div class="notion-card rounded-xl p-4">
            <form action="{{ route('admin.modules.index') }}" method="GET" class="flex items-center space-x-3">
                <div class="flex-1">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" name="search" 
                               class="form-input block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-purple-500 focus:border-purple-500" 
                               placeholder="Rechercher un module..." 
                               value="{{ request('search') }}">
                    </div>
                </div>
                
                <select name="sort" class="form-input border border-gray-300 rounded-lg px-3 py-2 focus:ring-1 focus:ring-purple-500 focus:border-purple-500" onchange="this.form.submit()">
                    <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>A-Z</option>
                    <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Z-A</option>
                    <option value="students" {{ request('sort') == 'students' ? 'selected' : '' }}>Étudiants</option>
                    <option value="recent" {{ request('sort') == 'recent' ? 'selected' : '' }}>Récents</option>
                </select>
            </form>
        </div>

        <!-- Modules List -->
        <div class="space-y-4">
        @forelse($modules as $module)
            <div class="notion-card rounded-xl p-5 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4 flex-1">
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-book text-purple-600"></i>
                        </div>
                        
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900">{{ $module->nom }}</h3>
                            <div class="flex items-center space-x-4 text-sm text-gray-500 mt-1">
                                @if($module->enseignant)
                                    <span>{{ $module->enseignant->nom }} {{ $module->enseignant->prenom }}</span>
                                @else
                                    <span class="text-yellow-600">Aucun enseignant</span>
                                @endif
                                
                                <span>•</span>
                                
                                <span>{{ $module->etudiants->count() }} étudiants</span>
                                
                                @php
                                    $averageGrade = $module->notes()->avg('note');
                                @endphp
                                @if($averageGrade)
                                    <span>•</span>
                                    <span>Moyenne: {{ number_format($averageGrade, 1) }}/20</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('admin.modules.students', $module->id) }}" 
                           class="text-gray-600 hover:text-blue-600 transition-colors p-2"
                           title="Voir étudiants">
                            <i class="fas fa-users"></i>
                        </a>
                        <a href="{{ route('admin.modules.edit', $module->id) }}" 
                           class="text-gray-600 hover:text-indigo-600 transition-colors p-2"
                           title="Modifier">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="{{ route('admin.modules.show', $module->id) }}" 
                           class="text-gray-600 hover:text-purple-600 transition-colors p-2"
                           title="Voir détails">
                            <i class="fas fa-eye"></i>
                        </a>
                        
                        <form action="{{ route('admin.modules.destroy', $module->id) }}" 
                              method="POST" 
                              class="inline delete-form"
                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce module ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="text-gray-600 hover:text-red-600 transition-colors p-2"
                                    title="Supprimer">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="notion-card rounded-xl p-8 text-center">
                <i class="fas fa-book text-gray-300 text-3xl mb-3"></i>
                <h3 class="font-medium text-gray-900 mb-2">Aucun module trouvé</h3>
                <p class="text-gray-500 mb-4">Commencez par créer votre premier module.</p>
                <a href="{{ route('admin.modules.create') }}" 
                   class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg font-medium transition-colors inline-flex items-center">
                    <i class="fas fa-plus mr-2"></i>
                    Créer un module
                </a>
            </div>
        @endforelse
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Auto-submit search form on input
    document.querySelector('input[name="search"]').addEventListener('input', function() {
        clearTimeout(this.searchTimeout);
        this.searchTimeout = setTimeout(() => {
            this.form.submit();
        }, 500);
    });
</script>
@endpush
