<?php

namespace App\Http\Controllers\Enseignant1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Etudiant;
use App\Models\Absence;
use App\Models\Emploidutemps;
use App\Models\Enseignant;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Crypt;

class DashboardController extends Controller
{
    public function index()
    {
        // Get the authenticated user (using web guard)
        $user = Auth::user();
        
        // Check if user is authenticated and has enseignant role
        if (!$user || $user->role !== 'enseignant') {
            return redirect()->route('login')->with('error', 'Accès non autorisé.');
        }
        
        // Find the enseignant record associated with this user
        $enseignant = Enseignant::where('user_id', $user->id)->first();
        
        // Check if enseignant record exists
        if (!$enseignant) {
            return redirect()->route('login')->with('error', 'Profil enseignant non trouvé.');
        }
        
        $nombreEtudiants = Etudiant::count();
        $nombreAbsences = Absence::count();
        $nombreEmplois = Emploidutemps::count();

        // Générer le QR Code pour l'enseignant
        $qrData = Crypt::encrypt([
            'type' => 'enseignant',
            'enseignant_id' => $enseignant->id,
            'user_id' => $enseignant->user_id,
            'nom' => $enseignant->nom,
            'prenom' => $enseignant->prenom,
            'date' => now()->format('Y-m-d'),
            'timestamp' => now()->timestamp
        ]);

        $qrCode = QrCode::size(200)->generate($qrData);

        return view('enseignant.dashboard', compact(
            'nombreEtudiants',
            'nombreAbsences',
            'nombreEmplois',
            'enseignant',
            'qrCode',
            'qrData'
        ));
    }
}