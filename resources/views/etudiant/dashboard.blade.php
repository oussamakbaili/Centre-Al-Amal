@extends('layouts.etudiant')

@section('title', $title)

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Card Absences -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Mes Absences</h3>
            <a href="{{ route('etudiant.absences') }}" class="text-blue-600 hover:text-blue-800 text-sm">Voir tout</a>
        </div>
        @php
            $recentAbsences = Auth::user()->absences()->with('module')->latest()->take(3)->get();
        @endphp
        @if($recentAbsences->count() > 0)
            <ul class="space-y-3">
                @foreach($recentAbsences as $absence)
                <li class="flex justify-between items-center">
                    <div>
                        <p class="font-medium">{{ $absence->module->nom }}</p>
                        <p class="text-sm text-gray-500">{{ $absence->date_absence->format('d/m/Y') }}</p>
                    </div>
                    <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">{{ $absence->justifie ? 'Justifiée' : 'Non justifiée' }}</span>
                </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500">Aucune absence récente</p>
        @endif
    </div>

    <!-- Card Emploi du temps -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Emploi du temps</h3>
            <a href="{{ route('etudiant.emploi') }}" class="text-blue-600 hover:text-blue-800 text-sm">Voir tout</a>
        </div>
        @php
            $today = now()->format('l');
            $todaySchedule = Auth::user()->groupe->emplois()
                ->where('jour_semaine', $today)
                ->orderBy('heure_debut')
                ->with('module')
                ->get();
        @endphp
        @if($todaySchedule->count() > 0)
            <ul class="space-y-3">
                @foreach($todaySchedule as $emploi)
                <li class="flex justify-between items-center">
                    <div>
                        <p class="font-medium">{{ $emploi->module->nom }}</p>
                        <p class="text-sm text-gray-500">
                            {{ date('H:i', strtotime($emploi->heure_debut)) }} - {{ date('H:i', strtotime($emploi->heure_fin)) }}
                        </p>
                    </div>
                    <span class="text-sm text-gray-500">{{ $emploi->salle }}</span>
                </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500">Aucun cours aujourd'hui</p>
        @endif
    </div>

    <!-- Card Notes récentes -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Mes Notes</h3>
            <a href="{{ route('etudiant.notes') }}" class="text-blue-600 hover:text-blue-800 text-sm">Voir tout</a>
        </div>
        @php
            $recentNotes = Auth::user()->notes()->with('module')->latest()->take(3)->get();
        @endphp
        @if($recentNotes->count() > 0)
            <ul class="space-y-3">
                @foreach($recentNotes as $note)
                <li class="flex justify-between items-center">
                    <div>
                        <p class="font-medium">{{ $note->module->nom }}</p>
                        <p class="text-sm text-gray-500">{{ $note->type_note }}</p>
                    </div>
                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">{{ $note->valeur }}/20</span>
                </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500">Aucune note récente</p>
        @endif
    </div>
</div>
@endsection