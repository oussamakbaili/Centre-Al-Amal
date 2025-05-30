
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h3><i class="fas fa-qrcode"></i> Scanner QR Code</h3>
                </div>
                <div class="card-body p-4">

                    <div class="alert alert-info">
                        <strong><i class="fas fa-info-circle"></i> Instructions:</strong><br>
                        Collez le code QR de l'étudiant dans le champ ci-dessous pour enregistrer sa présence.
                    </div>

                    <form id="qr-form">
                        @csrf
                        <div class="mb-3">
                            <label for="qr-input" class="form-label">Code QR de l'étudiant</label>
                            <textarea id="qr-input"
                                    class="form-control"
                                    rows="4"
                                    placeholder="Collez ici le code QR de l'étudiant..."
                                    required></textarea>
                        </div>

                        <div class="d-grid">
                            <button type="submit" id="scan-btn" class="btn btn-success btn-lg">
                                <i class="fas fa-check-circle"></i> Enregistrer la présence
                            </button>
                        </div>
                    </form>

                    <div id="loading" class="text-center mt-3" style="display: none;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Chargement...</span>
                        </div>
                        <p class="mt-2">Traitement en cours...</p>
                    </div>

                    <div id="message" class="mt-3"></div>

                </div>
            </div>

            <!-- Statistiques du jour -->
            <div class="card mt-4">
                <div class="card-header bg-info text-white">
                    <h5><i class="fas fa-chart-bar"></i> Statistiques du jour</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-4">
                            <div class="stat-box">
                                <h3 id="presents-count" class="text-success">0</h3>
                                <small>Présents</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="stat-box">
                                <h3 id="absents-count" class="text-danger">0</h3>
                                <small>Absents</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="stat-box">
                                <h3 id="total-scans" class="text-primary">0</h3>
                                <small>Total scans</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.stat-box {
    padding: 10px;
    border-radius: 8px;
    background: #f8f9fa;
}

.card {
    border: none;
    border-radius: 15px;
}

.alert {
    border-radius: 10px;
}

#qr-input {
    border-radius: 10px;
    min-height: 120px;
}

.btn-lg {
    border-radius: 10px;
    padding: 12px 24px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const qrForm = document.getElementById('qr-form');
    const qrInput = document.getElementById('qr-input');
    const scanBtn = document.getElementById('scan-btn');
    const messageDiv = document.getElementById('message');
    const loadingDiv = document.getElementById('loading');

    let totalScans = 0;
    let presentsCount = 0;
    let absentsCount = 0;

    // Auto-focus sur le champ d'entrée
    qrInput.focus();

    // Traitement du formulaire
    qrForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        await processQRCode();
    });

    async function processQRCode() {
        const qrData = qrInput.value.trim();

        if (!qrData) {
            showMessage('Veuillez coller le code QR', 'danger');
            return;
        }

        // Afficher le loader
        showLoading(true);
        scanBtn.disabled = true;

        try {
            const response = await fetch('{{ route("qr.scan") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ qr_data: qrData })
            });

            const data = await response.json();

            if (data.success) {
                showMessage(
                    `<i class="fas fa-check-circle"></i> <strong>${data.etudiant}</strong> marqué(e) présent(e) pour <strong>${data.cours}</strong> à ${data.time}`,
                    'success'
                );
                qrInput.value = '';

                // Mettre à jour les statistiques
                totalScans++;
                presentsCount++;
                updateStats();

            } else {
                showMessage(`<i class="fas fa-exclamation-triangle"></i> ${data.message}`, 'warning');
            }

        } catch (error) {
            showMessage('<i class="fas fa-times-circle"></i> Erreur de connexion. Veuillez réessayer.', 'danger');
            console.error('Erreur:', error);
        }

        // Masquer le loader
        showLoading(false);
        scanBtn.disabled = false;
        qrInput.focus();
    }

    function showMessage(text, type) {
        messageDiv.innerHTML = `<div class="alert alert-${type} alert-dismissible fade show" role="alert">
            ${text}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>`;

        // Auto-effacer le message après 5 secondes pour les succès
        if (type === 'success') {
            setTimeout(() => {
                const alert = messageDiv.querySelector('.alert');
                if (alert) {
                    alert.remove();
                }
            }, 5000);
        }
    }

    function showLoading(show) {
        loadingDiv.style.display = show ? 'block' : 'none';
    }

    function updateStats() {
        document.getElementById('presents-count').textContent = presentsCount;
        document.getElementById('absents-count').textContent = absentsCount;
        document.getElementById('total-scans').textContent = totalScans;
    }
});
</script>
