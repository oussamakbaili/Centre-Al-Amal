@props(['user' => null])

@php
    $currentUser = $user ?? auth()->user();
    $userRole = $currentUser ? $currentUser->role : 'guest';
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
                <p class="text-sm text-gray-600 font-medium capitalize">{{ $userRole === 'admin' ? 'Administration' : ucfirst($userRole) }}</p>
            </div>
        </div>
    </div>
    
    <!-- Navigation -->
    <nav class="p-6 space-y-6 flex-1 overflow-y-auto">
        @if($userRole === 'admin')
            <!-- Dashboard -->
            <div>
                <a href="{{ route('admin.dashboard') }}" class="nav-item group flex items-center px-4 py-3.5 text-gray-700 rounded-xl {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-blue-600 shadow-sm' : 'hover:bg-white/60 hover:text-blue-600' }} transition-all duration-300 ease-out">
                    <div class="w-5 h-5 mr-4 flex items-center justify-center">
                        <i class="fas fa-tachometer-alt text-sm {{ request()->routeIs('admin.dashboard') ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500' }} transition-colors"></i>
                    </div>
                    <span class="font-medium text-sm">Tableau de bord</span>
                </a>
            </div>

            <!-- Management Section -->
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3 px-4">Gestion</p>
                <div class="space-y-1">
                    <a href="{{ route('admin.etudiants.index') }}" class="nav-item group flex items-center px-4 py-3.5 text-gray-700 rounded-xl {{ request()->routeIs('admin.etudiants.*') ? 'bg-blue-50 text-blue-600 shadow-sm' : 'hover:bg-white/60 hover:text-blue-600' }} transition-all duration-300 ease-out">
                        <div class="w-5 h-5 mr-4 flex items-center justify-center">
                            <i class="fas fa-users text-sm {{ request()->routeIs('admin.etudiants.*') ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500' }} transition-colors"></i>
                        </div>
                        <span class="font-medium text-sm">Étudiants</span>
                        <div class="ml-auto">
                            <span class="bg-blue-100 text-blue-600 text-xs px-2 py-1 rounded-full font-medium">{{ \App\Models\Etudiant::count() }}</span>
                        </div>
                    </a>
                    
                    <a href="{{ route('admin.enseignants.index') }}" class="nav-item group flex items-center px-4 py-3.5 text-gray-700 rounded-xl {{ request()->routeIs('admin.enseignants.*') ? 'bg-blue-50 text-blue-600 shadow-sm' : 'hover:bg-white/60 hover:text-blue-600' }} transition-all duration-300 ease-out">
                        <div class="w-5 h-5 mr-4 flex items-center justify-center">
                            <i class="fas fa-chalkboard-teacher text-sm {{ request()->routeIs('admin.enseignants.*') ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500' }} transition-colors"></i>
                        </div>
                        <span class="font-medium text-sm">Enseignants</span>
                        <div class="ml-auto">
                            <span class="bg-emerald-100 text-emerald-600 text-xs px-2 py-1 rounded-full font-medium">{{ \App\Models\Enseignant::count() }}</span>
                        </div>
                    </a>
                    
                    <a href="{{ route('admin.modules.index') }}" class="nav-item group flex items-center px-4 py-3.5 text-gray-700 rounded-xl {{ request()->routeIs('admin.modules.*') ? 'bg-blue-50 text-blue-600 shadow-sm' : 'hover:bg-white/60 hover:text-blue-600' }} transition-all duration-300 ease-out">
                        <div class="w-5 h-5 mr-4 flex items-center justify-center">
                            <i class="fas fa-book text-sm {{ request()->routeIs('admin.modules.*') ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500' }} transition-colors"></i>
                        </div>
                        <span class="font-medium text-sm">Modules</span>
                        <div class="ml-auto">
                            <span class="bg-purple-100 text-purple-600 text-xs px-2 py-1 rounded-full font-medium">{{ \App\Models\Module::count() }}</span>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Academic Section -->
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3 px-4">Académique</p>
                <div class="space-y-1">
                    <a href="{{ route('admin.absences.index') }}" class="nav-item group flex items-center px-4 py-3.5 text-gray-700 rounded-xl {{ request()->routeIs('admin.absences.*') ? 'bg-blue-50 text-blue-600 shadow-sm' : 'hover:bg-white/60 hover:text-blue-600' }} transition-all duration-300 ease-out">
                        <div class="w-5 h-5 mr-4 flex items-center justify-center">
                            <i class="fas fa-calendar-times text-sm {{ request()->routeIs('admin.absences.*') ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500' }} transition-colors"></i>
                        </div>
                        <span class="font-medium text-sm">Absences</span>
                        @php $todayAbsences = \App\Models\Absence::whereDate('created_at', today())->count(); @endphp
                        @if($todayAbsences > 0)
                            <div class="ml-auto">
                                <span class="bg-red-100 text-red-600 text-xs px-2 py-1 rounded-full font-medium">{{ $todayAbsences }}</span>
                            </div>
                        @endif
                    </a>
                    
                    <a href="{{ route('admin.notes.index') }}" class="nav-item group flex items-center px-4 py-3.5 text-gray-700 rounded-xl {{ request()->routeIs('admin.notes.*') ? 'bg-blue-50 text-blue-600 shadow-sm' : 'hover:bg-white/60 hover:text-blue-600' }} transition-all duration-300 ease-out">
                        <div class="w-5 h-5 mr-4 flex items-center justify-center">
                            <i class="fas fa-clipboard-list text-sm {{ request()->routeIs('admin.notes.*') ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500' }} transition-colors"></i>
                        </div>
                        <span class="font-medium text-sm">Notes</span>
                    </a>
                    
                    <a href="{{ route('admin.emplois.index') }}" class="nav-item group flex items-center px-4 py-3.5 text-gray-700 rounded-xl {{ request()->routeIs('admin.emplois.*') ? 'bg-blue-50 text-blue-600 shadow-sm' : 'hover:bg-white/60 hover:text-blue-600' }} transition-all duration-300 ease-out">
                        <div class="w-5 h-5 mr-4 flex items-center justify-center">
                            <i class="fas fa-calendar-alt text-sm {{ request()->routeIs('admin.emplois.*') ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500' }} transition-colors"></i>
                        </div>
                        <span class="font-medium text-sm">Emploi du temps</span>
                    </a>
                </div>
            </div>

            <!-- Administrative Section -->
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3 px-4">Administration</p>
                <div class="space-y-1">
                    <a href="{{ route('admin.preinscriptions.index') }}" class="nav-item group flex items-center px-4 py-3.5 text-gray-700 rounded-xl {{ request()->routeIs('admin.preinscriptions.*') ? 'bg-blue-50 text-blue-600 shadow-sm' : 'hover:bg-white/60 hover:text-blue-600' }} transition-all duration-300 ease-out">
                        <div class="w-5 h-5 mr-4 flex items-center justify-center">
                            <i class="fas fa-user-plus text-sm {{ request()->routeIs('admin.preinscriptions.*') ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500' }} transition-colors"></i>
                        </div>
                        <span class="font-medium text-sm">Préinscriptions</span>
                        @php 
                            try {
                                $pendingPreinscriptions = \App\Models\Preinscription::where('status', 'pending')->count();
                            } catch (\Exception $e) {
                                $pendingPreinscriptions = 0;
                            }
                        @endphp
                        @if($pendingPreinscriptions > 0)
                            <div class="ml-auto">
                                <span class="bg-orange-100 text-orange-600 text-xs px-2 py-1 rounded-full font-medium">{{ $pendingPreinscriptions }}</span>
                            </div>
                        @endif
                    </a>
                </div>
            </div>
        @endif
    </nav>

    <!-- Profile Section -->
    <div class="p-6 border-t border-gray-200/30 space-y-2 bg-white/10">
        <div class="flex items-center space-x-3 mb-4">
            <div class="w-10 h-10 bg-gradient-to-r from-gray-400 to-gray-600 rounded-full flex items-center justify-center">
                <i class="fas fa-user text-white text-sm"></i>
            </div>
            <div class="flex-1">
                <p class="text-sm font-semibold text-gray-900">{{ $currentUser->nom ?? 'Utilisateur' }}</p>
                <p class="text-xs text-gray-500 capitalize">{{ $userRole }}</p>
            </div>
        </div>
        
        @if($userRole === 'admin')
            <a href="{{ route('admin.profile.edit') }}" class="nav-item group flex items-center px-4 py-3 text-gray-700 rounded-xl hover:bg-white/60 hover:text-blue-600 transition-all duration-300 ease-out">
                <div class="w-5 h-5 mr-3 flex items-center justify-center">
                    <i class="fas fa-user-edit text-sm text-gray-400 group-hover:text-blue-500 transition-colors"></i>
                </div>
                <span class="font-medium text-sm">Modifier le profil</span>
            </a>
        @endif
        
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