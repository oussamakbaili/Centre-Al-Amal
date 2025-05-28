@extends('layouts.admin')

@section('title', 'Gestion des Enseignants')
@section('page-title', 'Gestion des Enseignants')
@section('page-description', 'Gérez le corps enseignant du Centre Al-Amal')

@section('header-actions')
    <a href="{{ route('admin.enseignants.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-xl font-medium transition-all duration-200 flex items-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
        <i class="fas fa-plus mr-2"></i>
        Nouvel Enseignant
    </a>
@endsection

@section('content')
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="notion-card rounded-xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Enseignants</p>
                    <p class="text-2xl font-bold text-gray-900">
                        @if(method_exists($enseignants, 'total'))
                            {{ $enseignants->total() }}
                        @else
                            {{ $enseignants->count() }}
                        @endif
                    </p>
                </div>
                <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-chalkboard-teacher text-emerald-600 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="notion-card rounded-xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Actifs</p>
                    <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Enseignant::count() }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="notion-card rounded-xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Modules Couverts</p>
                    <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Module::count() }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-book text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="notion-card rounded-xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Nouveaux ce mois</p>
                    <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Enseignant::whereMonth('created_at', now()->month)->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-user-plus text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="notion-card rounded-xl p-6 mb-8">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0 lg:space-x-4">
            <div class="flex-1">
                <form action="{{ route('admin.enseignants.index') }}" method="GET" class="flex space-x-4">
                    <div class="flex-1">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" name="search" 
                                   class="form-input block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500" 
                                   placeholder="Rechercher par nom, prénom, email..." 
                                   value="{{ request('search') }}">
                        </div>
                    </div>
                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-xl font-medium transition-all duration-200">
                        <i class="fas fa-search mr-2"></i>
                        Rechercher
                    </button>
                </form>
            </div>
            
            <div class="flex space-x-4">
                <form action="{{ route('admin.enseignants.index') }}" method="GET" class="flex items-center space-x-2">
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    <select name="sort" class="form-input border border-gray-300 rounded-xl px-4 py-3 focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500" onchange="this.form.submit()">
                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nom (A-Z)</option>
                        <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Nom (Z-A)</option>
                        <option value="recent" {{ request('sort') == 'recent' ? 'selected' : '' }}>Plus récents</option>
                        <option value="module" {{ request('sort') == 'module' ? 'selected' : '' }}>Par module</option>
                    </select>
                </form>
                
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-600">
                        @if(method_exists($enseignants, 'total'))
                            {{ $enseignants->total() }} résultats
                        @else
                            {{ $enseignants->count() }} résultats
                        @endif
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Teachers Table -->
    <div class="notion-card rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Enseignant
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Contact
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Module Assigné
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Statut
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Activité
                        </th>
                        <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($enseignants as $enseignant)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-12 w-12">
                                        @if(isset($enseignant->photo) && $enseignant->photo)
                                            <img class="h-12 w-12 rounded-full object-cover border-2 border-gray-200" 
                                                 src="{{ asset('storage/' . $enseignant->photo) }}" 
                                                 alt="{{ $enseignant->nom }}">
                                        @else
                                            <div class="h-12 w-12 rounded-full bg-emerald-100 flex items-center justify-center border-2 border-gray-200">
                                                <i class="fas fa-user-tie text-emerald-600"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-semibold text-gray-900">
                                            {{ $enseignant->nom }} {{ $enseignant->prenom }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            Enseignant
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $enseignant->email }}</div>
                                <div class="text-sm text-gray-500">
                                    @if(isset($enseignant->telephone) && $enseignant->telephone)
                                        {{ $enseignant->telephone }}
                                    @else
                                        <span class="text-gray-400">Non renseigné</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if(method_exists($enseignant, 'module') && $enseignant->module)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                        <i class="fas fa-book mr-1"></i>
                                        {{ $enseignant->module->nom }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        Aucun module
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check mr-1"></i>
                                    Actif
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $recentClasses = 0;
                                    $totalStudents = 0;
                                    if(method_exists($enseignant, 'emplois')) {
                                        $recentClasses = $enseignant->emplois()->whereDate('created_at', '>=', now()->subDays(7))->count();
                                    }
                                    if(method_exists($enseignant, 'module') && $enseignant->module && method_exists($enseignant->module, 'etudiants')) {
                                        $totalStudents = $enseignant->module->etudiants()->count();
                                    }
                                @endphp
                                <div class="text-sm text-gray-900">{{ $totalStudents }} étudiants</div>
                                <div class="text-sm text-gray-500">{{ $recentClasses }} cours cette semaine</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('admin.enseignants.show', $enseignant->id) }}" 
                                       class="text-emerald-600 hover:text-emerald-900 p-2 rounded-lg hover:bg-emerald-50 transition-colors"
                                       title="Voir détails">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.enseignants.edit', $enseignant->id) }}" 
                                       class="text-indigo-600 hover:text-indigo-900 p-2 rounded-lg hover:bg-indigo-50 transition-colors"
                                       title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.enseignants.destroy', $enseignant->id) }}" 
                                          method="POST" 
                                          class="inline delete-form"
                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet enseignant ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-red-600 hover:text-red-900 p-2 rounded-lg hover:bg-red-50 transition-colors"
                                                title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-chalkboard-teacher text-gray-300 text-4xl mb-4"></i>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun enseignant trouvé</h3>
                                    <p class="text-gray-500 mb-4">Commencez par ajouter votre premier enseignant.</p>
                                    <a href="{{ route('admin.enseignants.create') }}" 
                                       class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-xl font-medium transition-all duration-200">
                                        <i class="fas fa-plus mr-2"></i>
                                        Ajouter un enseignant
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if(method_exists($enseignants, 'hasPages') && $enseignants->hasPages())
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Affichage de {{ $enseignants->firstItem() }} à {{ $enseignants->lastItem() }} sur {{ $enseignants->total() }} résultats
                    </div>
                    <div>
                        {{ $enseignants->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        @endif
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
