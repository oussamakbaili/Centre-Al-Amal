<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $etudiant = $user->etudiant;

        // Charger les relations de base
        $etudiant->load([
            'groupe.emplois.module',
            'notes.module',
            'absences.module',
        ]);

        // Vérifier si le groupe existe
        $documents = collect(); // valeur par défaut
        if ($etudiant->groupe) {
            $etudiant->groupe->load('modules.documents');

            $documents = $etudiant->groupe->modules
                ->flatMap(function ($module) {
                    return $module->documents;
                });
        }
        // Générer le QR Code
        $qrData = json_encode([
            'etudiant_id' => $etudiant->id,
            'user_id' => $user->id,
            'date' => now()->format('Y-m-d'),
            'timestamp' => now()->timestamp
        ]);

        $qrCode = QrCode::size(200)->generate($qrData);

        return view('etudiant.dashboard', [
            'title' => 'Tableau de bord étudiant',
            'user' => $user,
            'etudiant' => $etudiant,
            'emplois' => $etudiant->groupe->emplois ?? collect(),
            'notes' => $etudiant->notes,
            'absences' => $etudiant->absences,
            'documents' => $documents,
            'qrCode' => $qrCode,
            'qrData' => $qrData

        ]);
    }
}
