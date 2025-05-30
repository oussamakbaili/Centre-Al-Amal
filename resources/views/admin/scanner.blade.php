
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4><i class="fas fa-qrcode"></i> Scanner de présence - Administration</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Scanner -->
                        <div class="col-md-6">
                            <div class="scanner-container mb-3">
                                <video id="scanner" width="100%" class="border rounded"></video>
                            </div>
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i> Scannez le QR Code d'un étudiant pour enregistrer sa présence
                            </div>
                            <input type="hidden" id="qr_data" name="qr_data">
                        </div>

                        <!-- Résultats -->
                        <div class="col-md-6">
                            <div id="scan-result" class="alert alert-secondary">
                                <i class="fas fa-sync-alt fa-spin"></i> En attente de scan...
                            </div>
                            <div id="student-info" class="card d-none">
                                <div class="card-header bg-success text-white">
                                    <h5 class="mb-0">Présence enregistrée</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-4 text-center">
                                            <img id="student-photo" src="" class="img-thumbnail" style="max-height: 150px;">
                                        </div>
                                        <div class="col-8">
                                            <h5 id="student-name"></h5>
                                            <p class="mb-1"><strong>Classe:</strong> <span id="student-classe"></span></p>
                                            <p class="mb-1"><strong>ID:</strong> <span id="student-id"></span></p>
                                            <p class="mb-1"><strong>Heure:</strong> <span id="scan-time"></span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.min.js"></script>
<script>
    const scanner = document.getElementById('scanner');
    const qrData = document.getElementById('qr_data');
    const scanResult = document.getElementById('scan-result');
    const studentInfo = document.getElementById('student-info');
    const studentName = document.getElementById('student-name');
    const studentId = document.getElementById('student-id');
    const studentClasse = document.getElementById('student-classe');
    const studentPhoto = document.getElementById('student-photo');
    const scanTime = document.getElementById('scan-time');

    // Démarrer le scanner
    function startScanner() {
        navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } })
            .then(function(stream) {
                scanner.srcObject = stream;
                scanner.play();

                const canvas = document.createElement('canvas');
                const context = canvas.getContext('2d');

                setInterval(() => {
                    canvas.width = scanner.videoWidth;
                    canvas.height = scanner.videoHeight;
                    context.drawImage(scanner, 0, 0, canvas.width, canvas.height);

                    const imageData = context.getImageData(0, 0, canvas.width, canvas.height);
                    const code = jsQR(imageData.data, imageData.width, imageData.height);

                    if (code) {
                        qrData.value = code.data;
                        processQRCode(code.data);
                    }
                }, 500);
            })
            .catch(function(err) {
                console.error("Erreur d'accès à la caméra: ", err);
                scanResult.innerHTML = `
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle"></i> Erreur d'accès à la caméra.
                        <button class="btn btn-sm btn-warning float-end" onclick="location.reload()">
                            <i class="fas fa-sync-alt"></i> Réessayer
                        </button>
                    </div>`;
            });
    }

    // Traiter le QR Code scanné
    function processQRCode(data) {
        try {
            const jsonData = JSON.parse(data);

            // Envoyer les données au serveur
            fetch("{{ route('admin.scan.process') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ qr_data: data })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    scanResult.innerHTML = `
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i> ${data.message}
                        </div>`;

                    // Afficher les infos de l'étudiant
                    studentName.textContent = data.etudiant.prenom + ' ' + data.etudiant.nom;
                    studentId.textContent = data.etudiant.id;
                    studentClasse.textContent = data.etudiant.groupe ? data.etudiant.groupe.nom : 'Non spécifié';
                    scanTime.textContent = new Date().toLocaleTimeString();

                    // Photo de l'étudiant
                    if (data.etudiant.photo) {
                        studentPhoto.src = "/storage/" + data.etudiant.photo;
                    } else {
                        studentPhoto.src = "https://ui-avatars.com/api/?name=" +
                            encodeURIComponent(data.etudiant.prenom + ' ' + data.etudiant.nom) +
                            "&background=random";
                    }

                    studentInfo.classList.remove('d-none');

                    // Réinitialiser après 5 secondes
                    setTimeout(() => {
                        studentInfo.classList.add('d-none');
                        scanResult.innerHTML = `
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i> Prêt pour un nouveau scan
                            </div>`;
                    }, 5000);
                } else {
                    scanResult.innerHTML = `
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle"></i> ${data.error || 'Erreur lors du traitement'}
                        </div>`;
                }
            });
        } catch (e) {
            scanResult.innerHTML = `
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i> QR Code invalide
                </div>`;
        }
    }

    // Démarrer le scanner quand la page est chargée
    window.addEventListener('load', startScanner);
</script>

<style>
    .scanner-container {
        position: relative;
        margin-bottom: 1rem;
        border: 2px dashed #dee2e6;
        border-radius: .25rem;
        padding: 10px;
        background: #f8f9fa;
    }

    #scanner {
        background: #000;
    }
</style>
@endpush

