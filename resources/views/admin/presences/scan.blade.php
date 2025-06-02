@if ($afficherScanner)
<style>
    .scanner-container {
        max-width: 500px;
        margin: 20px auto;
        padding: 15px;
        text-align: center;
    }

    .message {
        padding: 15px;
        margin: 10px 0;
        border-radius: 8px;
        background: #f8f9fa;
        border: 1px solid #dee2e6;
    }

    .message.success { background: #d4edda; color: #155724; border-color: #c3e6cb; }
    .message.error { background: #f8d7da; color: #721c24; border-color: #f5c6cb; }
    .message.info { background: #cce5ff; color: #004085; border-color: #b8daff; }
    .message.warning { background: #fff3cd; color: #856404; border-color: #ffeeba; }

    .scan-button {
        display: inline-block;
        width: 100%;
        max-width: 300px;
        padding: 15px 25px;
        margin: 10px 0;
        background: #007bff;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        cursor: pointer;
        text-align: center;
        text-decoration: none;
        -webkit-appearance: none;
    }

    .scan-button:disabled {
        background: #ccc;
    }

    .scan-button.secondary {
        background: #6c757d;
    }

    #video-container {
        display: none;
        margin: 20px auto;
        max-width: 100%;
        width: 640px;
        position: relative;
    }

    #qr-video {
        width: 100%;
        border-radius: 8px;
    }

    #stop-button {
        position: absolute;
        top: 10px;
        right: 10px;
        background: rgba(220, 53, 69, 0.9);
        color: white;
        border: none;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        cursor: pointer;
        font-size: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .preview-container {
        margin-top: 20px;
        display: none;
    }

    .preview-container img {
        max-width: 100%;
        border-radius: 8px;
    }

    .instructions {
        margin: 20px 0;
        padding: 15px;
        background: #fff3cd;
        border: 1px solid #ffeeba;
        border-radius: 8px;
        color: #856404;
    }

    .instructions ul {
        text-align: left;
        margin: 10px 0;
        padding-left: 20px;
    }

    .instructions li {
        margin: 5px 0;
    }

    @media (max-width: 768px) {
        .scanner-container {
            padding: 10px;
        }
    }
</style>

<div class="scanner-container">
    <div id="message" class="message info">
        Choisissez une méthode pour scanner le QR code
    </div>

    <div class="instructions">
        <strong>Instructions:</strong>
        <ul>
            <li>Assurez-vous que le QR code est bien éclairé et net</li>
            <li>Centrez le QR code dans l'image</li>
            <li>Évitez les reflets et les ombres</li>
        </ul>
    </div>

    <!-- Native camera input for mobile -->
    <input type="file" id="camera-input" accept="image/*" capture="environment" style="display: none;">

    <!-- Camera button -->
    <button id="start-camera" class="scan-button">
        📷 Prendre une Photo
    </button>

    <!-- File upload button -->
    <label class="scan-button secondary" style="margin-top: 10px;">
        📁 Choisir une Image
        <input type="file" id="file-input" accept="image/*" style="display: none;">
    </label>

    <!-- Video container for webcam -->
    <div id="video-container">
        <video id="qr-video" playsinline></video>
        <button id="stop-button">✕</button>
    </div>

    <!-- Preview container -->
    <div id="preview-container" class="preview-container">
        <img id="preview-image">
    </div>
</div>

<form id="qr-form" action="{{ route('admin.scanner.presence.store') }}" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="qr_code" id="qr_code">
    @if(isset($seance))
        <input type="hidden" name="seance_id" value="{{ $seance->id }}">
        <input type="hidden" name="type" value="seance">
        <input type="hidden" name="date" value="{{ $seance->date }}">
    @elseif(isset($emploi))
        <input type="hidden" name="emploi_du_temps_id" value="{{ $emploi->id }}">
        <input type="hidden" name="type" value="emploi">
        <input type="hidden" name="jour" value="{{ $emploi->jour }}">
        <input type="hidden" name="date" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
    @endif
</form>

<!-- Include jsQR library -->
<script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.min.js"></script>

<script>
class QRScanner {
    constructor() {
        this.messageElement = document.getElementById('message');
        this.fileInput = document.getElementById('file-input');
        this.cameraInput = document.getElementById('camera-input');
        this.previewContainer = document.getElementById('preview-container');
        this.previewImage = document.getElementById('preview-image');
        this.videoContainer = document.getElementById('video-container');
        this.video = document.getElementById('qr-video');
        this.startButton = document.getElementById('start-camera');
        this.stopButton = document.getElementById('stop-button');
        this.stream = null;
        this.scanning = false;
        this.isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
        this.setupEventListeners();
    }

    showMessage(text, type = 'info') {
        this.messageElement.className = `message ${type}`;
        this.messageElement.textContent = text;
    }

    setupEventListeners() {
        this.fileInput.addEventListener('change', (e) => this.handleImageSelect(e));
        this.cameraInput.addEventListener('change', (e) => this.handleImageSelect(e));
        this.startButton.addEventListener('click', () => this.handleCameraStart());
        this.stopButton.addEventListener('click', () => this.stopCamera());
    }

    handleCameraStart() {
        if (this.isMobile) {
            // On mobile, use native camera
            this.cameraInput.click();
        } else {
            // On desktop, use webcam
            this.startCamera();
        }
    }

    async startCamera() {
        try {
            this.stream = await navigator.mediaDevices.getUserMedia({ 
                video: { facingMode: 'environment' }
            });
            this.video.srcObject = this.stream;
            this.video.play();
            this.videoContainer.style.display = 'block';
            this.startQRScanning();
            this.showMessage('Caméra activée. Placez le QR code devant la caméra.', 'info');
        } catch (error) {
            console.error('Camera access error:', error);
            // Fallback to native camera input on error
            this.cameraInput.click();
        }
    }

    stopCamera() {
        if (this.stream) {
            this.stream.getTracks().forEach(track => track.stop());
            this.stream = null;
        }
        this.video.srcObject = null;
        this.videoContainer.style.display = 'none';
        this.scanning = false;
        this.showMessage('Choisissez une méthode pour scanner le QR code', 'info');
    }

    startQRScanning() {
        this.scanning = true;
        const canvas = document.createElement('canvas');
        const context = canvas.getContext('2d');

        const scan = () => {
            if (!this.scanning) return;

            if (this.video.readyState === this.video.HAVE_ENOUGH_DATA) {
                canvas.width = this.video.videoWidth;
                canvas.height = this.video.videoHeight;
                context.drawImage(this.video, 0, 0, canvas.width, canvas.height);
                
                const imageData = context.getImageData(0, 0, canvas.width, canvas.height);
                const code = jsQR(imageData.data, imageData.width, imageData.height);

                if (code) {
                    this.handleSuccess(code.data);
                    this.stopCamera();
                    return;
                }
            }
            requestAnimationFrame(scan);
        };

        requestAnimationFrame(scan);
    }

    async handleImageSelect(event) {
        const file = event.target.files[0];
        if (!file) return;

        this.showMessage('Analyse de l\'image en cours...', 'info');
        
        try {
            // Show preview
            const previewUrl = URL.createObjectURL(file);
            this.previewImage.src = previewUrl;
            this.previewContainer.style.display = 'block';

            // Check if this is from camera or file upload
            const isFromCamera = event.target === this.cameraInput;
            const qrCode = await this.detectQRCode(file, isFromCamera);
            
            if (qrCode) {
                this.handleSuccess(qrCode);
            } else {
                this.showMessage('Aucun QR code trouvé. Essayez avec une image plus claire.', 'error');
            }
        } catch (error) {
            console.error('QR detection error:', error);
            this.showMessage('Erreur lors de l\'analyse. Veuillez réessayer.', 'error');
        }

        event.target.value = '';
    }

    async detectQRCode(file, isFromCamera = false) {
        return new Promise((resolve, reject) => {
            const img = new Image();
            
            img.onload = () => {
                const canvas = document.createElement('canvas');
                const context = canvas.getContext('2d');
                
                // For camera photos, try only original size and one smaller scale
                // For uploaded files, try more scales
                const scales = isFromCamera ? [1.0, 0.75] : [1.0, 1.5, 2.0, 0.75];
                
                // Set a reasonable max size for better performance
                const MAX_SIZE = 1500;
                let targetWidth = img.width;
                let targetHeight = img.height;
                
                // Scale down large images for better performance
                if (img.width > MAX_SIZE || img.height > MAX_SIZE) {
                    const ratio = Math.min(MAX_SIZE / img.width, MAX_SIZE / img.height);
                    targetWidth = img.width * ratio;
                    targetHeight = img.height * ratio;
                }

                // Try detection at different scales
                for (let scale of scales) {
                    canvas.width = targetWidth * scale;
                    canvas.height = targetHeight * scale;
                    
                    // Use better image rendering
                    context.imageSmoothingEnabled = true;
                    context.imageSmoothingQuality = 'high';
                    
                    // Draw image with white background
                    context.fillStyle = 'white';
                    context.fillRect(0, 0, canvas.width, canvas.height);
                    context.drawImage(img, 0, 0, canvas.width, canvas.height);

                    // Try QR detection
                    const imageData = context.getImageData(0, 0, canvas.width, canvas.height);
                    const code = jsQR(imageData.data, imageData.width, imageData.height, {
                        inversionAttempts: isFromCamera ? "dontInvert" : "attemptBoth"
                    });
                    
                    if (code?.data) {
                        resolve(code.data);
                        return;
                    }
                }
                resolve(null);
            };

            img.onerror = reject;
            img.src = URL.createObjectURL(file);
        });
    }

    handleSuccess(decodedText) {
        this.showMessage('QR Code détecté! Traitement...', 'success');
        document.getElementById('qr_code').value = decodedText;
        document.getElementById('qr-form').submit();
    }
}

// Initialize when the page loads
document.addEventListener('DOMContentLoaded', () => {
    new QRScanner();
});
</script>

@else
    <div style="text-align: center; padding: 40px;">
        <p style="color: #dc3545; font-size: 18px; font-weight: bold;">
            ⏰ Scanner désactivé - Hors horaire de séance
        </p>
    </div>
@endif
