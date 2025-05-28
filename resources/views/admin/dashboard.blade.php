<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord Admin - Centre Al-Amal</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { 
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; 
            margin-left: 320px; /* Account for fixed sidebar */
        }
        .glass-effect { 
            backdrop-filter: blur(10px); 
            background: rgba(255, 255, 255, 0.8); 
        }
        .notion-card { 
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .notion-card:hover { 
            background: rgba(255, 255, 255, 0.95);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -3px rgba(0, 0, 0, 0.1);
        }
        .metric-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(255, 255, 255, 0.85) 100%);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .activity-item {
            transition: all 0.2s ease;
        }
        .activity-item:hover {
            background: rgba(59, 130, 246, 0.05);
            transform: translateX(4px);
        }
        .stat-trend {
            font-size: 0.75rem;
            font-weight: 600;
        }
        .quick-action-card {
            transition: all 0.2s ease;
        }
        .quick-action-card:hover {
            transform: translateY(-4px) scale(1.02);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 via-white to-gray-100 min-h-screen">
    <!-- Sidebar Component -->
    <x-admin-sidebar />

    <!-- Main Content -->
    <div class="min-h-screen">
        <!-- Header -->
        <header class="glass-effect border-b border-gray-200/30 px-8 py-6 sticky top-0 z-10">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 tracking-tight mb-1">Tableau de bord</h1>
                    <p class="text-gray-600 text-sm font-medium flex items-center">
                        <i class="fas fa-calendar-day mr-2 text-blue-500"></i>
                        Bonne journée, Admin 👋 • {{ date('l d F Y') }}
                    </p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-medium flex items-center">
                        <div class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></div>
                        Système opérationnel
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="p-8">
            <!-- Key Metrics Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Students Metric -->
                <div class="metric-card rounded-2xl p-6 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-blue-500/10 rounded-full -mr-10 -mt-10"></div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-users text-blue-600 text-xl"></i>
                        </div>
                        @if($studentGrowth > 0)
                            <span class="stat-trend text-green-600 bg-green-100 px-2 py-1 rounded-full">+{{ $studentGrowth }}%</span>
                        @elseif($studentGrowth < 0)
                            <span class="stat-trend text-red-600 bg-red-100 px-2 py-1 rounded-full">{{ $studentGrowth }}%</span>
                        @else
                            <span class="stat-trend text-gray-600 bg-gray-100 px-2 py-1 rounded-full">Stable</span>
                        @endif
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-gray-900 mb-1">{{ number_format($nombreEtudiants) }}</p>
                        <p class="text-sm text-gray-600 mb-2">Étudiants inscrits</p>
                        <p class="text-xs text-blue-600 font-medium">+{{ $recentStudents }} cette semaine</p>
                    </div>
                </div>
                
                <!-- Teachers Metric -->
                <div class="metric-card rounded-2xl p-6 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-emerald-500/10 rounded-full -mr-10 -mt-10"></div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-chalkboard-teacher text-emerald-600 text-xl"></i>
                        </div>
                        <span class="stat-trend text-emerald-600 bg-emerald-100 px-2 py-1 rounded-full">Actifs</span>
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-gray-900 mb-1">{{ number_format($nombreEnseignants) }}</p>
                        <p class="text-sm text-gray-600 mb-2">Enseignants</p>
                        <p class="text-xs text-emerald-600 font-medium">{{ $nombreModules }} modules couverts</p>
                    </div>
                </div>
                
                <!-- Performance Metric -->
                <div class="metric-card rounded-2xl p-6 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-purple-500/10 rounded-full -mr-10 -mt-10"></div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-chart-line text-purple-600 text-xl"></i>
                        </div>
                        <span class="stat-trend text-purple-600 bg-purple-100 px-2 py-1 rounded-full">{{ number_format($passRate, 1) }}%</span>
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-gray-900 mb-1">{{ number_format($averageGrade, 1) }}/20</p>
                        <p class="text-sm text-gray-600 mb-2">Moyenne générale</p>
                        <p class="text-xs text-purple-600 font-medium">Taux de réussite {{ number_format($passRate, 1) }}%</p>
                    </div>
                </div>
                
                <!-- Attendance Metric -->
                <div class="metric-card rounded-2xl p-6 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-indigo-500/10 rounded-full -mr-10 -mt-10"></div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-calendar-check text-indigo-600 text-xl"></i>
                        </div>
                        @if($attendanceRate >= 90)
                            <span class="stat-trend text-green-600 bg-green-100 px-2 py-1 rounded-full">Excellent</span>
                        @elseif($attendanceRate >= 80)
                            <span class="stat-trend text-yellow-600 bg-yellow-100 px-2 py-1 rounded-full">Bon</span>
                        @else
                            <span class="stat-trend text-red-600 bg-red-100 px-2 py-1 rounded-full">À améliorer</span>
                        @endif
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-gray-900 mb-1">{{ number_format($attendanceRate, 1) }}%</p>
                        <p class="text-sm text-gray-600 mb-2">Taux de présence</p>
                        <p class="text-xs text-indigo-600 font-medium">{{ $todayAbsences }} absences aujourd'hui</p>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-bolt mr-3 text-yellow-500"></i>
                    Actions rapides
                </h2>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                    <a href="{{ route('admin.etudiants.create') }}" class="quick-action-card notion-card rounded-xl p-4 flex flex-col items-center text-center group">
                        <div class="w-14 h-14 bg-blue-50 rounded-xl flex items-center justify-center mb-3 group-hover:bg-blue-100 transition-colors">
                            <i class="fas fa-user-plus text-blue-600 text-lg"></i>
                        </div>
                        <span class="text-sm font-semibold text-gray-900">Nouvel étudiant</span>
                        <span class="text-xs text-gray-500 mt-1">Inscription</span>
                    </a>
                    
                    <a href="{{ route('admin.enseignants.create') }}" class="quick-action-card notion-card rounded-xl p-4 flex flex-col items-center text-center group">
                        <div class="w-14 h-14 bg-emerald-50 rounded-xl flex items-center justify-center mb-3 group-hover:bg-emerald-100 transition-colors">
                            <i class="fas fa-chalkboard-teacher text-emerald-600 text-lg"></i>
                        </div>
                        <span class="text-sm font-semibold text-gray-900">Enseignant</span>
                        <span class="text-xs text-gray-500 mt-1">Ajouter</span>
                    </a>
                    
                    <a href="{{ route('admin.modules.create') }}" class="quick-action-card notion-card rounded-xl p-4 flex flex-col items-center text-center group">
                        <div class="w-14 h-14 bg-purple-50 rounded-xl flex items-center justify-center mb-3 group-hover:bg-purple-100 transition-colors">
                            <i class="fas fa-book text-purple-600 text-lg"></i>
                        </div>
                        <span class="text-sm font-semibold text-gray-900">Module</span>
                        <span class="text-xs text-gray-500 mt-1">Créer</span>
                    </a>
                    
                    <a href="{{ route('admin.notes.create') }}" class="quick-action-card notion-card rounded-xl p-4 flex flex-col items-center text-center group">
                        <div class="w-14 h-14 bg-indigo-50 rounded-xl flex items-center justify-center mb-3 group-hover:bg-indigo-100 transition-colors">
                            <i class="fas fa-clipboard-list text-indigo-600 text-lg"></i>
                        </div>
                        <span class="text-sm font-semibold text-gray-900">Notes</span>
                        <span class="text-xs text-gray-500 mt-1">Saisir</span>
                    </a>
                    
                    <a href="{{ route('admin.absences.create') }}" class="quick-action-card notion-card rounded-xl p-4 flex flex-col items-center text-center group">
                        <div class="w-14 h-14 bg-red-50 rounded-xl flex items-center justify-center mb-3 group-hover:bg-red-100 transition-colors">
                            <i class="fas fa-calendar-times text-red-600 text-lg"></i>
                        </div>
                        <span class="text-sm font-semibold text-gray-900">Absence</span>
                        <span class="text-xs text-gray-500 mt-1">Signaler</span>
                    </a>
                    
                    <a href="{{ route('admin.emplois.create') }}" class="quick-action-card notion-card rounded-xl p-4 flex flex-col items-center text-center group">
                        <div class="w-14 h-14 bg-teal-50 rounded-xl flex items-center justify-center mb-3 group-hover:bg-teal-100 transition-colors">
                            <i class="fas fa-calendar-alt text-teal-600 text-lg"></i>
                        </div>
                        <span class="text-sm font-semibold text-gray-900">Planning</span>
                        <span class="text-xs text-gray-500 mt-1">Créer</span>
                    </a>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Recent Activity -->
                <div class="lg:col-span-2">
                    <div class="notion-card rounded-2xl p-6 h-full">
                        <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-clock mr-3 text-blue-500"></i>
                            Activité récente
                        </h3>
                        <div class="space-y-4">
                            @forelse($recentActivities as $activity)
                                <div class="activity-item flex items-center space-x-4 p-4 bg-gray-50/50 rounded-xl">
                                    <div class="w-10 h-10 bg-{{ $activity['color'] }}-100 rounded-full flex items-center justify-center flex-shrink-0">
                                        <i class="{{ $activity['icon'] }} text-{{ $activity['color'] }}-600 text-sm"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">{{ $activity['message'] }}</p>
                                        <p class="text-xs text-gray-500">{{ $activity['time']->diffForHumans() }}</p>
                                    </div>
                                    <div class="text-xs text-gray-400">
                                        {{ $activity['time']->format('H:i') }}
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8">
                                    <i class="fas fa-inbox text-gray-300 text-3xl mb-3"></i>
                                    <p class="text-gray-500">Aucune activité récente</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
                
                <!-- Quick Stats & Management -->
                <div class="space-y-6">
                    <!-- Today's Overview -->
                    <div class="notion-card rounded-2xl p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-calendar-day mr-3 text-green-500"></i>
                            Aujourd'hui
                        </h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-3 bg-blue-50/50 rounded-lg">
                                <div class="flex items-center">
                                    <i class="fas fa-calendar-alt text-blue-600 mr-3"></i>
                                    <span class="text-sm font-medium text-gray-900">Cours planifiés</span>
                                </div>
                                <span class="font-bold text-blue-600">{{ $todaySchedules }}</span>
                            </div>
                            
                            <div class="flex items-center justify-between p-3 bg-red-50/50 rounded-lg">
                                <div class="flex items-center">
                                    <i class="fas fa-calendar-times text-red-600 mr-3"></i>
                                    <span class="text-sm font-medium text-gray-900">Absences</span>
                                </div>
                                <span class="font-bold text-red-600">{{ $todayAbsences }}</span>
                            </div>
                            
                            <div class="flex items-center justify-between p-3 bg-green-50/50 rounded-lg">
                                <div class="flex items-center">
                                    <i class="fas fa-clipboard-list text-green-600 mr-3"></i>
                                    <span class="text-sm font-medium text-gray-900">Notes ajoutées</span>
                                </div>
                                <span class="font-bold text-green-600">{{ $recentNotes }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Management -->
                    <div class="notion-card rounded-2xl p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-cog mr-3 text-purple-500"></i>
                            Gestion rapide
                        </h3>
                        <div class="space-y-3">
                            <a href="{{ route('admin.etudiants.index') }}" class="flex items-center justify-between p-3 bg-blue-50/50 rounded-lg hover:bg-blue-50 transition-colors group">
                                <div class="flex items-center">
                                    <i class="fas fa-users text-blue-600 mr-3"></i>
                                    <span class="text-sm font-medium text-gray-900">Gérer les étudiants</span>
                                </div>
                                <i class="fas fa-arrow-right text-gray-400 group-hover:text-blue-600 transition-colors"></i>
                            </a>
                            
                            <a href="{{ route('admin.preinscriptions.index') }}" class="flex items-center justify-between p-3 bg-orange-50/50 rounded-lg hover:bg-orange-50 transition-colors group">
                                <div class="flex items-center">
                                    <i class="fas fa-user-plus text-orange-600 mr-3"></i>
                                    <span class="text-sm font-medium text-gray-900">Préinscriptions</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    @if($nombrePreinscriptions > 0)
                                        <span class="bg-orange-100 text-orange-600 text-xs px-2 py-1 rounded-full font-medium">{{ $nombrePreinscriptions }}</span>
                                    @endif
                                    <i class="fas fa-arrow-right text-gray-400 group-hover:text-orange-600 transition-colors"></i>
                                </div>
                            </a>
                            
                            <a href="{{ route('admin.notes.index') }}" class="flex items-center justify-between p-3 bg-indigo-50/50 rounded-lg hover:bg-indigo-50 transition-colors group">
                                <div class="flex items-center">
                                    <i class="fas fa-clipboard-list text-indigo-600 mr-3"></i>
                                    <span class="text-sm font-medium text-gray-900">Consulter les notes</span>
                                </div>
                                <i class="fas fa-arrow-right text-gray-400 group-hover:text-indigo-600 transition-colors"></i>
                            </a>
                            
                            <a href="{{ route('admin.emplois.index') }}" class="flex items-center justify-between p-3 bg-teal-50/50 rounded-lg hover:bg-teal-50 transition-colors group">
                                <div class="flex items-center">
                                    <i class="fas fa-calendar-alt text-teal-600 mr-3"></i>
                                    <span class="text-sm font-medium text-gray-900">Planning général</span>
                                </div>
                                <i class="fas fa-arrow-right text-gray-400 group-hover:text-teal-600 transition-colors"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>