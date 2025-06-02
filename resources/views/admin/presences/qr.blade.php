@foreach($etudiants as $etudiant)
    <div class="p-4 border mb-2">
        <p>{{ $etudiant->nom }}</p>
        {!! QrCode::size(150)->generate(
            route('presence.scan', ['etudiant_id' => $etudiant->id, 'seance_id' => $seance->id])
        ) !!}
    </div>
@endforeach
