
<div class="p-6">
    <h2 class="text-xl font-bold mb-4">Scanner les présences - {{ $seance->module->nom ?? '' }}</h2>
    <p><strong>Heure :</strong> {{ $seance->heure_debut }} - {{ $seance->heure_fin }}</p>

    @if ($afficherScanner)
        <div class="mt-6">
            <h3 class="text-lg font-semibold mb-2">Scanner le QR code de l'étudiant</h3>

            <!-- Zone du scanner (ex: Html5QrcodeScanner) -->
            <div id="qr-reader" style="width: 500px;"></div>
            <div id="qr-reader-results" class="mt-2"></div>
        </div>
    @else
        <div class="mt-6 text-red-600">
            Le scanner est désactivé en dehors de la plage horaire de cette séance.
        </div>
    @endif
</div>


@section('scripts')
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
    @if ($afficherScanner)
        const scanner = new Html5QrcodeScanner(
            "qr-reader",
            { fps: 10, qrbox: 250 },
            false
        );

        function onScanSuccess(decodedText, decodedResult) {
            document.getElementById('qr-reader-results').innerText = `Étudiant scanné: ${decodedText}`;

            // Appel AJAX pour enregistrer la présence
            fetch("{{ route('scanner.presence.store') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    qr_code: decodedText,
                    seance_id: {{ $seance->id }}
                })
            }).then(response => response.json())
              .then(data => console.log(data))
              .catch(err => console.error(err));

            scanner.clear();
        }

        scanner.render(onScanSuccess);
    @endif
</script>
@endsection
