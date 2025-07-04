<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Espace Étudiant') - Centre Al-Amal</title>
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
        .data-table {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .grade-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(255, 255, 255, 0.85) 100%);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .schedule-item {
            transition: all 0.2s ease;
        }
        .schedule-item:hover {
            background: rgba(59, 130, 246, 0.05);
            transform: translateX(4px);
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gradient-to-br from-blue-50 via-white to-indigo-50 min-h-screen">
    <!-- Sidebar Component -->
    <x-etudiant-sidebar />

    <!-- Main Content -->
    <div class="min-h-screen">
        <!-- Header -->
        <header class="glass-effect border-b border-gray-200/30 px-8 py-6 sticky top-0 z-10">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 tracking-tight mb-1">@yield('page-title', 'Espace Étudiant')</h1>
                    <p class="text-gray-600 text-sm font-medium">@yield('page-description', 'Votre parcours académique au Centre Al-Amal')</p>
                </div>
                <div class="flex items-center space-x-4">
                    @yield('header-actions')
                    <div class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-medium flex items-center">
                        <div class="w-2 h-2 bg-blue-400 rounded-full mr-2 animate-pulse"></div>
                        Connecté
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="p-8">
            <!-- Flash Messages -->
            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center">
                    <i class="fas fa-check-circle mr-3 text-green-500"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl flex items-center">
                    <i class="fas fa-exclamation-circle mr-3 text-red-500"></i>
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-exclamation-triangle mr-3 text-red-500"></i>
                        <strong>Erreurs de validation :</strong>
                    </div>
                    <ul class="list-disc list-inside ml-6">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
    
    @stack('scripts')
</body>
</html>
