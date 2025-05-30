<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absence;
use App\Models\Etudiant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScanController extends Controller
{
    public function showScanner()
    {
        return view('admin.scanner');
    }

    public function processScan(Request $request)
    {
        $request->validate([
            'qr_data' => 'required|json'
        ]);

        $data = json_decode($request->qr_data, true);

        // Vérifier l'étudiant
        $etudiant = Etudiant::find($data['etudiant_id']);
        if (!$etudiant) {
            return response()->json(['error' => 'Étudiant non trouvé'], 404);
        }

        // Vérifier si la date correspond
        if ($data['date'] !== now()->format('Y-m-d')) {
            return response()->json(['error' => 'QR Code expiré'], 400);
        }

        // Enregistrer la présence
        Absence::updateOrCreate(
            [
                'etudiant_id' => $etudiant->id,
                'date_absence' => now()->format('Y-m-d'),
            ],
            [
                'etat' => 'present',
                'enseignant_id' => null, // ou Auth::id() si l'admin doit être enregistré
                'scanned_at' => now(),
                'heure_cours' => now()->format('H:i:s'),
                'scanned_by_admin' => true, // Nouveau champ à ajouter à la migration
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Présence enregistrée pour ' . $etudiant->prenom . ' ' . $etudiant->nom,
            'etudiant' => $etudiant
        ]);
    }
}
