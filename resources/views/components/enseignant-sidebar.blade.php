@props(['user' => null])

@php
    $currentUser = $user ?? auth()->user();
    $enseignant = $currentUser ? $currentUser->enseignant : null;
@endphp

<div class="sidebar-gradient w-80 h-screen fixed left-0 top-0 border-r border-gray-200/50 shadow-lg flex flex-col overflow-hidden">
    <!-- Logo Section -->
    <div class="p-8 border-b border-gray-200/30 bg-white/20">
        <div class="flex items-center space-x-3">
            <div class="w-12 h-12 bg-gradient-to-r from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center shadow-lg">
                <i class="fas fa-chalkboard-teacher text-white text-xl"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-900 tracking-tight">Centre Al-Amal</h1>
                <p class="text-sm text-gray-600 font-medium">Espace Enseignant</p>
            </div>
        </div>
    </div>
    
    <!-- Navigation -->
    <nav class="p-6 space-y-6 flex-1 overflow-y-auto">
        <!-- Dashboard -->
        <div>
            <a href="{{ route('enseignant.dashboard') }}" class="nav-item group flex items-center px-4 py-3.5 text-gray-700 rounded-xl {{ request()->routeIs('enseignant.dashboard') ? 'bg-emerald-50 text-emerald-600 shadow-sm' : 'hover:bg-white/60 hover:text-emerald-600' }} transition-all duration-300 ease-out">
                <div class="w-5 h-5 mr-4 flex items-center justify-center">
                    <i class="fas fa-tachometer-alt text-sm {{ request()->routeIs('enseignant.dashboard') ? 'text-emerald-500' : 'text-gray-400 group-hover:text-emerald-500' }} transition-colors"></i>
                </div>
                <span class="font-medium text-sm">Tableau de bord</span>
            </a>
        </div>

        <!-- Teaching Section -->
        <div>
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3 px-4">Enseignement</p>
            <div class="space-y-1">
                <a href="{{ route('enseignant.etudiants.index') }}" class="nav-item group flex items-center px-4 py-3.5 text-gray-700 rounded-xl {{ request()->routeIs('enseignant.etudiants.*') ? 'bg-emerald-50 text-emerald-600 shadow-sm' : 'hover:bg-white/60 hover:text-emerald-600' }} transition-all duration-300 ease-out">
                    <div class="w-5 h-5 mr-4 flex items-center justify-center">
                        <i class="fas fa-users text-sm {{ request()->routeIs('enseignant.etudiants.*') ? 'text-emerald-500' : 'text-gray-400 group-hover:text-emerald-500' }} transition-colors"></i>
                    </div>
                    <span class="font-medium text-sm">Mes Étudiants</span>
                </a>
                
                <a href="{{ route('enseignant.classes.index') }}" class="nav-item group flex items-center px-4 py-3.5 text-gray-700 rounded-xl {{ request()->routeIs('enseignant.classes.*') ? 'bg-emerald-50 text-emerald-600 shadow-sm' : 'hover:bg-white/60 hover:text-emerald-600' }} transition-all duration-300 ease-out">
                    <div class="w-5 h-5 mr-4 flex items-center justify-center">
                        <i class="fas fa-door-open text-sm {{ request()->routeIs('enseignant.classes.*') ? 'text-emerald-500' : 'text-gray-400 group-hover:text-emerald-500' }} transition-colors"></i>
                    </div>
                    <span class="font-medium text-sm">Mes Classes</span>
                    @if($enseignant)
                        @php $classesCount = $enseignant->classes()->count(); @endphp
                        @if($classesCount > 0)
                            <div class="ml-auto">
                                <span class="bg-emerald-100 text-emerald-600 text-xs px-2 py-1 rounded-full font-medium">{{ $classesCount }}</span>
                            </div>
                        @endif
                    @endif
                </a>
                
                <a href="{{ route('enseignant.modules.index') }}" class="nav-item group flex items-center px-4 py-3.5 text-gray-700 rounded-xl {{ request()->routeIs('enseignant.modules.*') ? 'bg-emerald-50 text-emerald-600 shadow-sm' : 'hover:bg-white/60 hover:text-emerald-600' }} transition-all duration-300 ease-out">
                    <div class="w-5 h-5 mr-4 flex items-center justify-center">
                        <i class="fas fa-book text-sm {{ request()->routeIs('enseignant.modules.*') ? 'text-emerald-500' : 'text-gray-400 group-hover:text-emerald-500' }} transition-colors"></i>
                    </div>
                    <span class="font-medium text-sm">Mon Module</span>
                    @if($enseignant && $enseignant->module)
                        <div class="ml-auto">
                            <span class="bg-purple-100 text-purple-600 text-xs px-2 py-1 rounded-full font-medium">{{ $enseignant->module->nom }}</span>
                        </div>
                    @endif
                </a>
            </div>
        </div>

        <!-- Academic Management -->
        <div>
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3 px-4">Gestion Académique</p>
            <div class="space-y-1">
                <a href="{{ route('enseignant.notes.index') }}" class="nav-item group flex items-center px-4 py-3.5 text-gray-700 rounded-xl {{ request()->routeIs('enseignant.notes.*') ? 'bg-emerald-50 text-emerald-600 shadow-sm' : 'hover:bg-white/60 hover:text-emerald-600' }} transition-all duration-300 ease-out">
                    <div class="w-5 h-5 mr-4 flex items-center justify-center">
                        <i class="fas fa-clipboard-list text-sm {{ request()->routeIs('enseignant.notes.*') ? 'text-emerald-500' : 'text-gray-400 group-hover:text-emerald-500' }} transition-colors"></i>
                    </div>
                    <span class="font-medium text-sm">Gestion Notes</span>
                </a>
                
                <a href="{{ route('enseignant.absences.index') }}" class="nav-item group flex items-center px-4 py-3.5 text-gray-700 rounded-xl {{ request()->routeIs('enseignant.absences.*') ? 'bg-emerald-50 text-emerald-600 shadow-sm' : 'hover:bg-white/60 hover:text-emerald-600' }} transition-all duration-300 ease-out">
                    <div class="w-5 h-5 mr-4 flex items-center justify-center">
                        <i class="fas fa-calendar-times text-sm {{ request()->routeIs('enseignant.absences.*') ? 'text-emerald-500' : 'text-gray-400 group-hover:text-emerald-500' }} transition-colors"></i>
                    </div>
                    <span class="font-medium text-sm">Gestion Absences</span>
                    @if($enseignant)
                        @php $todayAbsences = $enseignant->absences()->whereDate('created_at', today())->count(); @endphp
                        @if($todayAbsences > 0)
                            <div class="ml-auto">
                                <span class="bg-red-100 text-red-600 text-xs px-2 py-1 rounded-full font-medium">{{ $todayAbsences }}</span>
                            </div>
                        @endif
                    @endif
                </a>
                
                <a href="{{ route('enseignant.emploi.index') }}" class="nav-item group flex items-center px-4 py-3.5 text-gray-700 rounded-xl {{ request()->routeIs('enseignant.emploi.*') ? 'bg-emerald-50 text-emerald-600 shadow-sm' : 'hover:bg-white/60 hover:text-emerald-600' }} transition-all duration-300 ease-out">
                    <div class="w-5 h-5 mr-4 flex items-center justify-center">
                        <i class="fas fa-calendar-alt text-sm {{ request()->routeIs('enseignant.emploi.*') ? 'text-emerald-500' : 'text-gray-400 group-hover:text-emerald-500' }} transition-colors"></i>
                    </div>
                    <span class="font-medium text-sm">Mon Planning</span>
                </a>
            </div>
        </div>

        <!-- Resources Section -->
        <div>
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3 px-4">Ressources</p>
            <div class="space-y-1">
                <a href="{{ route('enseignant.cours.index') }}" class="nav-item group flex items-center px-4 py-3.5 text-gray-700 rounded-xl {{ request()->routeIs('enseignant.cours.*') ? 'bg-emerald-50 text-emerald-600 shadow-sm' : 'hover:bg-white/60 hover:text-emerald-600' }} transition-all duration-300 ease-out">
                    <div class="w-5 h-5 mr-4 flex items-center justify-center">
                        <i class="fas fa-chalkboard text-sm {{ request()->routeIs('enseignant.cours.*') ? 'text-emerald-500' : 'text-gray-400 group-hover:text-emerald-500' }} transition-colors"></i>
                    </div>
                    <span class="font-medium text-sm">Mes Cours</span>
                </a>
                
                <a href="{{ route('enseignant.documents.index') }}" class="nav-item group flex items-center px-4 py-3.5 text-gray-700 rounded-xl {{ request()->routeIs('enseignant.documents.*') ? 'bg-emerald-50 text-emerald-600 shadow-sm' : 'hover:bg-white/60 hover:text-emerald-600' }} transition-all duration-300 ease-out">
                    <div class="w-5 h-5 mr-4 flex items-center justify-center">
                        <i class="fas fa-file-alt text-sm {{ request()->routeIs('enseignant.documents.*') ? 'text-emerald-500' : 'text-gray-400 group-hover:text-emerald-500' }} transition-colors"></i>
                    </div>
                    <span class="font-medium text-sm">Documents</span>
                    @if($enseignant)
                        @php $documentsCount = $enseignant->documents()->count(); @endphp
                        @if($documentsCount > 0)
                            <div class="ml-auto">
                                <span class="bg-blue-100 text-blue-600 text-xs px-2 py-1 rounded-full font-medium">{{ $documentsCount }}</span>
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
            <div class="w-10 h-10 bg-gradient-to-r from-emerald-400 to-emerald-600 rounded-full flex items-center justify-center">
                <i class="fas fa-user-tie text-white text-sm"></i>
            </div>
            <div class="flex-1">
                <p class="text-sm font-semibold text-gray-900">{{ $enseignant ? $enseignant->nom . ' ' . $enseignant->prenom : 'Enseignant' }}</p>
                <p class="text-xs text-gray-500">{{ $enseignant && $enseignant->module ? $enseignant->module->nom : 'Module' }}</p>
            </div>
        </div>
        
        <a href="{{ route('enseignant.profile.edit') }}" class="nav-item group flex items-center px-4 py-3 text-gray-700 rounded-xl hover:bg-white/60 hover:text-emerald-600 transition-all duration-300 ease-out">
            <div class="w-5 h-5 mr-3 flex items-center justify-center">
                <i class="fas fa-user-edit text-sm text-gray-400 group-hover:text-emerald-500 transition-colors"></i>
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
        background: rgba(16, 185, 129, 0.1);
        color: rgb(16, 185, 129);
    }
</style> 