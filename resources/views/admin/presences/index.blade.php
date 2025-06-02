<h2 class="text-xl mb-4">Cours du jour - {{ \Carbon\Carbon::now()->translatedFormat('l d M Y') }}</h2>

@foreach($emplois as $emploi)
    <div class="mb-4 border p-3 rounded">
        <p><strong>Module :</strong> {{ $emploi->module->nom }}</p>
        <p><strong>Heure :</strong> {{ $emploi->heure_debut }} - {{ $emploi->heure_fin }}</p>

        @php
            $today = \Carbon\Carbon::now()->format('Y-m-d');
            $startDateTime = \Carbon\Carbon::parse($today . ' ' . $emploi->heure_debut);
            $endDateTime = \Carbon\Carbon::parse($today . ' ' . $emploi->heure_fin);
        @endphp

        @if($now->between($startDateTime, $endDateTime))
            <a href="{{ route('admin.presences.scan', ['type' => 'emploi', 'id' => $emploi->id]) }}" class="btn btn-primary">Scanner les présences</a>
        @else
            <span class="text-red-500">Séance terminée ou non commencée</span>
        @endif
    </div>
@endforeach

@foreach($seances as $seance)
    <div class="mb-4 border p-3 rounded bg-gray-50">
        <p><strong>Module :</strong> {{ $seance->module->nom }}</p>
        <p><strong>Heure :</strong> {{ $seance->heure_debut }} - {{ $seance->heure_fin }}</p>

        @if($now->between(Carbon\Carbon::parse($seance->heure_debut), Carbon\Carbon::parse($seance->heure_fin)))
            <a href="{{ route('admin.presences.scan', ['type' => 'seance', 'id' => $seance->id]) }}" class="btn btn-primary">Scanner les présences</a>
        @else
            <span class="text-red-500">Séance terminée ou non commencée</span>
        @endif
    </div>
@endforeach
