@extends('layouts.admin')

@section('title', 'Gestion des Notes')
@section('page-title', 'Gestion des Notes')
@section('page-description', 'Gérez les notes des étudiants du Centre Al-Amal')

@section('header-actions')
    <a href="{{ route('admin.notes.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-xl font-medium transition-all duration-200 flex items-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
        <i class="fas fa-plus mr-2"></i>
        Nouvelle Note
    </a>
@endsection

@section('content')
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="notion-card rounded-xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Notes</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $notes->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-clipboard-list text-indigo-600 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="notion-card rounded-xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Moyenne Générale</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($notes->avg('note') ?? 0, 1) }}/20</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-chart-line text-green-600 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="notion-card rounded-xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Taux de Réussite</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $notes->count() > 0 ? number_format(($notes->where('note', '>=', 10)->count() / $notes->count()) * 100, 1) : 0 }}%</p>
                </div>
                <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-trophy text-emerald-600 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="notion-card rounded-xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Cette Semaine</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $notes->where('created_at', '>=', now()->subDays(7))->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-calendar-week text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="notion-card rounded-xl p-6 mb-8">
        <form method="GET" action="{{ route('admin.notes.index') }}" class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0 lg:space-x-4">
            <div class="flex-1 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="module_id" class="block text-sm font-medium text-gray-700 mb-2">Module:</label>
                    <select name="module_id" id="module_id" class="form-input w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Tous les modules</option>
                        @foreach($modules as $module)
                            <option value="{{ $module->id }}" {{ $selectedModule == $module->id ? 'selected' : '' }}>
                                {{ $module->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label for="etudiant_search" class="block text-sm font-medium text-gray-700 mb-2">Étudiant:</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" name="etudiant_search" id="etudiant_search" 
                               class="form-input block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500" 
                               placeholder="Rechercher un étudiant..." 
                               value="{{ request('etudiant_search') }}">
                    </div>
                </div>
                
                <div>
                    <label for="note_filter" class="block text-sm font-medium text-gray-700 mb-2">Filtre par note:</label>
                    <select name="note_filter" id="note_filter" class="form-input w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Toutes les notes</option>
                        <option value="excellent" {{ request('note_filter') == 'excellent' ? 'selected' : '' }}>Excellent (≥16)</option>
                        <option value="good" {{ request('note_filter') == 'good' ? 'selected' : '' }}>Bien (≥14)</option>
                        <option value="average" {{ request('note_filter') == 'average' ? 'selected' : '' }}>Assez bien (≥12)</option>
                        <option value="pass" {{ request('note_filter') == 'pass' ? 'selected' : '' }}>Passable (≥10)</option>
                        <option value="fail" {{ request('note_filter') == 'fail' ? 'selected' : '' }}>Échec (<10)</option>
                    </select>
                </div>
            </div>
            
            <div class="flex space-x-4">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl font-medium transition-all duration-200">
                    <i class="fas fa-filter mr-2"></i>
                    Filtrer
                </button>
                <a href="{{ route('admin.notes.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-xl font-medium transition-all duration-200">
                    <i class="fas fa-times mr-2"></i>
                    Réinitialiser
                </a>
            </div>
        </form>
    </div>

    <!-- Notes Table -->
    <div class="notion-card rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Étudiant
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Module
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Note
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Type
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Appréciation
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Date
                        </th>
                        <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($notes as $note)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        @if($note->etudiant->image)
                                            <img class="h-10 w-10 rounded-full object-cover border-2 border-gray-200" 
                                                 src="{{ asset('storage/' . $note->etudiant->image) }}" 
                                                 alt="{{ $note->etudiant->nom }}">
                                        @else
                                            <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center border-2 border-gray-200">
                                                <i class="fas fa-user text-blue-600 text-sm"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-semibold text-gray-900">
                                            {{ $note->etudiant->nom }} {{ $note->etudiant->prenom }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $note->etudiant->niveau ?? 'Niveau non défini' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                    <i class="fas fa-book mr-1"></i>
                                    {{ $note->module->nom }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="text-2xl font-bold 
                                        @if($note->note >= 16) text-green-600
                                        @elseif($note->note >= 14) text-blue-600
                                        @elseif($note->note >= 12) text-yellow-600
                                        @elseif($note->note >= 10) text-orange-600
                                        @else text-red-600
                                        @endif">
                                        {{ number_format($note->note, 1) }}
                                    </span>
                                    <span class="text-gray-500 ml-1">/20</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    @if($note->note_type == 'note1') bg-blue-100 text-blue-800
                                    @elseif($note->note_type == 'note2') bg-indigo-100 text-indigo-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ ucfirst($note->note_type ?? 'Note') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($note->note >= 16)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-star mr-1"></i>
                                        Excellent
                                    </span>
                                @elseif($note->note >= 14)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <i class="fas fa-thumbs-up mr-1"></i>
                                        Bien
                                    </span>
                                @elseif($note->note >= 12)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-check mr-1"></i>
                                        Assez bien
                                    </span>
                                @elseif($note->note >= 10)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                        <i class="fas fa-minus mr-1"></i>
                                        Passable
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <i class="fas fa-times mr-1"></i>
                                        Insuffisant
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $note->created_at->format('d/m/Y') }}
                                <div class="text-xs text-gray-400">{{ $note->created_at->format('H:i') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('admin.notes.show', $note->id) }}" 
                                       class="text-indigo-600 hover:text-indigo-900 p-2 rounded-lg hover:bg-indigo-50 transition-colors"
                                       title="Voir détails">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.notes.edit', $note->id) }}" 
                                       class="text-blue-600 hover:text-blue-900 p-2 rounded-lg hover:bg-blue-50 transition-colors"
                                       title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.notes.destroy', $note->id) }}" 
                                          method="POST" 
                                          class="inline delete-form"
                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette note ?')">
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
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-clipboard-list text-gray-300 text-4xl mb-4"></i>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune note trouvée</h3>
                                    <p class="text-gray-500 mb-4">Commencez par ajouter des notes pour vos étudiants.</p>
                                    <a href="{{ route('admin.notes.create') }}" 
                                       class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-xl font-medium transition-all duration-200">
                                        <i class="fas fa-plus mr-2"></i>
                                        Ajouter une note
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($notes instanceof \Illuminate\Pagination\LengthAwarePaginator && $notes->hasPages())
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Affichage de {{ $notes->firstItem() }} à {{ $notes->lastItem() }} sur {{ $notes->total() }} résultats
                    </div>
                    <div>
                        {{ $notes->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Quick Actions -->
    <div class="mt-8">
        <div class="notion-card rounded-xl p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-bolt mr-3 text-yellow-500"></i>
                Actions rapides
            </h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="{{ route('admin.notes.create') }}" 
                   class="flex items-center justify-center p-4 bg-indigo-50 rounded-xl hover:bg-indigo-100 transition-colors group">
                    <div class="text-center">
                        <i class="fas fa-plus text-indigo-600 text-xl mb-2"></i>
                        <div class="text-sm font-medium text-indigo-700">Nouvelle Note</div>
                    </div>
                </a>
                
                <a href="{{ route('admin.notes.export') }}" 
                   class="flex items-center justify-center p-4 bg-green-50 rounded-xl hover:bg-green-100 transition-colors group">
                    <div class="text-center">
                        <i class="fas fa-download text-green-600 text-xl mb-2"></i>
                        <div class="text-sm font-medium text-green-700">Exporter</div>
                    </div>
                </a>
                
                <a href="{{ route('admin.notes.statistics') }}" 
                   class="flex items-center justify-center p-4 bg-purple-50 rounded-xl hover:bg-purple-100 transition-colors group">
                    <div class="text-center">
                        <i class="fas fa-chart-bar text-purple-600 text-xl mb-2"></i>
                        <div class="text-sm font-medium text-purple-700">Statistiques</div>
                    </div>
                </a>
                
                <a href="{{ route('admin.modules.index') }}" 
                   class="flex items-center justify-center p-4 bg-blue-50 rounded-xl hover:bg-blue-100 transition-colors group">
                    <div class="text-center">
                        <i class="fas fa-book text-blue-600 text-xl mb-2"></i>
                        <div class="text-sm font-medium text-blue-700">Gérer Modules</div>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Auto-submit form on filter change
    document.getElementById('module_id').addEventListener('change', function() {
        this.form.submit();
    });
    
    document.getElementById('note_filter').addEventListener('change', function() {
        this.form.submit();
    });
    
    // Auto-submit search form on input
    document.getElementById('etudiant_search').addEventListener('input', function() {
        clearTimeout(this.searchTimeout);
        this.searchTimeout = setTimeout(() => {
            this.form.submit();
        }, 500);
    });
</script>
@endpush
