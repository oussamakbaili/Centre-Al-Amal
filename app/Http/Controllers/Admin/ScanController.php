<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Seance;
use App\Models\EmploiDuTemps;
use App\Models\Presence;
use App\Models\Etudiant;
use Carbon\Carbon;

class ScanController extends Controller
{
    public function start($type, $id)
    {
        $now = Carbon::now();
        $afficherScanner = false;

        if ($type === 'seance') {
            $seance = Seance::with('module')->findOrFail($id);

            // Afficher le scanner uniquement si on est dans l’intervalle de temps
            if ($now->between($seance->heure_debut, $seance->heure_fin)) {
                $afficherScanner = true;
            }

            return view('admin.presences.scan', compact('seance', 'afficherScanner'));
        }

        if ($type === 'emploi') {
            $emploi = EmploiDuTemps::with('module')->findOrFail($id);

            if ($now->between($emploi->heure_debut, $emploi->heure_fin)) {
                $afficherScanner = true;
            }

            return view('admin.presences.scan', compact('emploi', 'afficherScanner'));
        }

        return redirect()->route('presences.index')->with('error', 'Type invalide');
    }
  public function scanSeance($id)
{
    $seance = Seance::with('module')->findOrFail($id);

    $now = \Carbon\Carbon::now();
    $heureDebut = \Carbon\Carbon::parse($seance->heure_debut);
    $heureFin = \Carbon\Carbon::parse($seance->heure_fin);

    $afficherScanner = $now->between($heureDebut, $heureFin);

    return view('admin.presences.scan', compact('seance', 'afficherScanner'));
}

public function store(Request $request)
{
    $qrData = json_decode($request->qr_code, true);

    
    if (!$qrData || !isset($qrData['etudiant_id'])) {
        return response()->json(['error' => 'QR code invalide'], 400);
    }

    // Find the student by ID from QR code data
    $etudiant = Etudiant::find($qrData['etudiant_id']);

    if (!$etudiant) {
        return response()->json(['error' => 'Étudiant introuvable'], 404);
    }

    // Optional: Add additional validation
    // Check if QR code is not too old (example: max 1 day)
    $qrTimestamp = $qrData['timestamp'] ?? null;
    if ($qrTimestamp && (time() - $qrTimestamp) > 86400) { // 24 hours
        return response()->json(['error' => 'QR code expiré'], 400);
    }

    // Check if presence already exists for this student and session
    $existingPresence = Presence::where('etudiant_id', $qrData['etudiant_id'])
                               ->where('seance_id', $request->seance_id)
                               ->first();

    if ($existingPresence) {
        return response()->json(['message' => 'Présence déjà enregistrée'], 200);
    }

    // Create the presence record
    Presence::create([
        'etudiant_id' => $qrData['etudiant_id'],
        'seance_id' => $request->seance_id,
        'etat' => 'present',
    ]);

    return response()->json([
        'message' => 'Présence enregistrée',
        'etudiant' => $etudiant->name ?? $etudiant->nom, // Adjust field name as needed
    ]);
}

}

