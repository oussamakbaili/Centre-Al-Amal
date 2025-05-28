@props(['user' => null])

@php
    $currentUser = $user ?? auth()->user();
    $etudiant = $currentUser ? $currentUser->etudiant : null;
@endphp

<div class="sidebar-gradient w-80 h-screen fixed left-0 top-0 border-r border-gray-200/50 shadow-lg flex flex-col overflow-hidden">
    <!-- Logo Section -->
    <div class="p-8 border-b border-gray-200/30 bg-white/20">
        <div class="flex items-center space-x-3">
            <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                <i class="fas fa-graduation-cap text-white text-xl"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-900 tracking-tight">Centre Al-Amal</h1>
                <p class="text-sm text-gray-600 font-medium">Espace Étudiant</p>
            </div>
        </div>
    </div>
    
    <!-- Navigation -->
    <nav class="p-6 space-y-6 flex-1 overflow-y-auto">
        <!-- Dashboard -->
        <div>
            <a href="{{ route('etudiant.dashboard') }}" class="nav-item group flex items-center px-4 py-3.5 text-gray-700 rounded-xl {{ request()->routeIs('etudiant.dashboard') ? 'bg-blue-50 text-blue-600 shadow-sm' : 'hover:bg-white/60 hover:text-blue-600' }} transition-all duration-300 ease-out">
                <div class="w-5 h-5 mr-4 flex items-center justify-center">
                    <i class="fas fa-tachometer-alt text-sm {{ request()->routeIs('etudiant.dashboard') ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500' }} transition-colors"></i>
                </div>
                <span class="font-medium text-sm">Tableau de bord</span>
            </a>
        </div>

        <!-- Academic Section -->
        <div>
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3 px-4">Académique</p>
            <div class="space-y-1">
                <a href="{{ route('etudiant.emploi') }}" class="nav-item group flex items-center px-4 py-3.5 text-gray-700 rounded-xl {{ request()->routeIs('etudiant.emploi*') ? 'bg-blue-50 text-blue-600 shadow-sm' : 'hover:bg-white/60 hover:text-blue-600' }} transition-all duration-300 ease-out">
                    <div class="w-5 h-5 mr-4 flex items-center justify-center">
                        <i class="fas fa-calendar-alt text-sm {{ request()->routeIs('etudiant.emploi*') ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500' }} transition-colors"></i>
                    </div>
                    <span class="font-medium text-sm">Emploi du temps</span>
                </a>
                
                <a href="{{ route('etudiant.notes') }}" class="nav-item group flex items-center px-4 py-3.5 text-gray-700 rounded-xl {{ request()->routeIs('etudiant.notes*') ? 'bg-blue-50 text-blue-600 shadow-sm' : 'hover:bg-white/60 hover:text-blue-600' }} transition-all duration-300 ease-out">
                    <div class="w-5 h-5 mr-4 flex items-center justify-center">
                        <i class="fas fa-clipboard-list text-sm {{ request()->routeIs('etudiant.notes*') ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500' }} transition-colors"></i>
                    </div>
                    <span class="font-medium text-sm">Mes Notes</span>
                    @if($etudiant)
                        @php $recentNotes = $etudiant->notes()->whereDate('created_at', '>=', now()->subDays(7))->count(); @endphp
                        @if($recentNotes > 0)
                            <div class="ml-auto">
                                <span class="bg-green-100 text-green-600 text-xs px-2 py-1 rounded-full font-medium">{{ $recentNotes }}</span>
                            </div>
                        @endif
                    @endif
                </a>
                
                <a href="{{ route('etudiant.absences.index') }}" class="nav-item group flex items-center px-4 py-3.5 text-gray-700 rounded-xl {{ request()->routeIs('etudiant.absences.*') ? 'bg-blue-50 text-blue-600 shadow-sm' : 'hover:bg-white/60 hover:text-blue-600' }} transition-all duration-300 ease-out">
                    <div class="w-5 h-5 mr-4 flex items-center justify-center">
                        <i class="fas fa-calendar-times text-sm {{ request()->routeIs('etudiant.absences.*') ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500' }} transition-colors"></i>
                    </div>
                    <span class="font-medium text-sm">Mes Absences</span>
                    @if($etudiant)
                        @php $recentAbsences = $etudiant->absences()->whereDate('created_at', '>=', now()->subDays(30))->count(); @endphp
                        @if($recentAbsences > 0)
                            <div class="ml-auto">
                                <span class="bg-red-100 text-red-600 text-xs px-2 py-1 rounded-full font-medium">{{ $recentAbsences }}</span>
                            </div>
                        @endif
                    @endif
                </a>
                
                <a href="{{ route('etudiant.modules') }}" class="nav-item group flex items-center px-4 py-3.5 text-gray-700 rounded-xl {{ request()->routeIs('etudiant.modules*') ? 'bg-blue-50 text-blue-600 shadow-sm' : 'hover:bg-white/60 hover:text-blue-600' }} transition-all duration-300 ease-out">
                    <div class="w-5 h-5 mr-4 flex items-center justify-center">
                        <i class="fas fa-book text-sm {{ request()->routeIs('etudiant.modules*') ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500' }} transition-colors"></i>
                    </div>
                    <span class="font-medium text-sm">Mes Modules</span>
                </a>
            </div>
        </div>

        <!-- Resources Section -->
        <div>
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3 px-4">Ressources</p>
            <div class="space-y-1">
                <a href="{{ route('etudiant.documents') }}" class="nav-item group flex items-center px-4 py-3.5 text-gray-700 rounded-xl {{ request()->routeIs('etudiant.documents*') ? 'bg-blue-50 text-blue-600 shadow-sm' : 'hover:bg-white/60 hover:text-blue-600' }} transition-all duration-300 ease-out">
                    <div class="w-5 h-5 mr-4 flex items-center justify-center">
                        <i class="fas fa-file-alt text-sm {{ request()->routeIs('etudiant.documents*') ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500' }} transition-colors"></i>
                    </div>
                    <span class="font-medium text-sm">Documents</span>
                    @if($etudiant)
                        @php $documentsCount = $etudiant->documents()->count(); @endphp
                        @if($documentsCount > 0)
                            <div class="ml-auto">
                                <span class="bg-purple-100 text-purple-600 text-xs px-2 py-1 rounded-full font-medium">{{ $documentsCount }}</span>
                            </div>
                        @endif
                    @endif
                </a>
            </div>
        </div>
    </nav>

    <!-- Profile Section -->
    <div class="p-6 border-t border-gray-200/30 space-y-2 bg-white/10">
        <div class="flex items-center space-x-3 mb-4">
            <div class="w-10 h-10 bg-gradient-to-r from-blue-400 to-blue-600 rounded-full flex items-center justify-center">
                <i class="fas fa-user-graduate text-white text-sm"></i>
            </div>
            <div class="flex-1">
                <p class="text-sm font-semibold text-gray-900">{{ $etudiant ? $etudiant->nom . ' ' . $etudiant->prenom : 'Étudiant' }}</p>
                <p class="text-xs text-gray-500">{{ $etudiant ? $etudiant->niveau : 'Niveau' }}</p>
            </div>
        </div>
        
        <a href="{{ route('etudiant.profile.edit') }}" class="nav-item group flex items-center px-4 py-3 text-gray-700 rounded-xl hover:bg-white/60 hover:text-blue-600 transition-all duration-300 ease-out">
            <div class="w-5 h-5 mr-3 flex items-center justify-center">
                <i class="fas fa-user-edit text-sm text-gray-400 group-hover:text-blue-500 transition-colors"></i>
            </div>
            <span class="font-medium text-sm">Mon Profil</span>
        </a>
        
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="nav-item group flex items-center px-4 py-3 text-gray-700 rounded-xl hover:bg-white/60 hover:text-red-600 transition-all duration-300 ease-out w-full text-left">
                <div class="w-5 h-5 mr-3 flex items-center justify-center">
                    <i class="fas fa-sign-out-alt text-sm text-gray-400 group-hover:text-red-500 transition-colors"></i>
                </div>
                <span class="font-medium text-sm">Déconnexion</span>
            </button>
        </form>
    </div>
</div>

<style>
    .sidebar-gradient { 
        background: linear-gradient(180deg, #fafafa 0%, #f5f5f5 100%);
        backdrop-filter: blur(10px);
    }
    .nav-item:hover { 
        transform: translateX(2px); 
    }
    .nav-item.active {
        background: rgba(59, 130, 246, 0.1);
        color: rgb(59, 130, 246);
    }
</style> 