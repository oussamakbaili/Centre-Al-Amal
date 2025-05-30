<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Models\Absence;
use App\Models\Emploi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;

class QRScanController extends Controller
{
    /**
     * Traiter le scan du QR Code
     */
    public function scan(Request $request)
    {
        try {
            // Décrypter les données du QR Code
            $qrData = Crypt::decrypt($request->qr_data);

            $etudiantId = $qrData['etudiant_id'];
            $qrDate = $qrData['date'];
            $timestamp = $qrData['timestamp'];

            // Vérifier si le QR Code n'est pas expiré (valide pendant 24h)
            $qrGeneratedAt = Carbon::createFromTimestamp($timestamp);
            if ($qrGeneratedAt->diffInHours(now()) > 24) {
                return response()->json([
                    'success' => false,
                    'message' => 'QR Code expiré'
                ], 400);
            }

            // Vérifier si la date correspond à aujourd'hui
            if ($qrDate !== now()->format('Y-m-d')) {
                return response()->json([
                    'success' => false,
                    'message' => 'QR Code invalide pour cette date'
                ], 400);
            }

            $etudiant = Etudiant::find($etudiantId);
            if (!$etudiant) {
                return response()->json([
                    'success' => false,
                    'message' => 'Étudiant non trouvé'
                ], 404);
            }

            // Trouver le cours actuel (dans les 2 heures)
            $coursActuel = $this->findCurrentCourse($etudiant);

            if (!$coursActuel) {
                return response()->json([
                    'success' => false,
                    'message' => 'Aucun cours en cours actuellement'
                ], 400);
            }

            // Marquer comme présent
            $absence = Absence::updateOrCreate(
                [
                    'etudiant_id' => $etudiantId,
                    'emploi_id' => $coursActuel->id,
                    'date_cours' => now()->format('Y-m-d')
                ],
                [
                    'status' => 'present',
                    'scanned_at' => now()
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'Présence enregistrée avec succès',
                'etudiant' => $etudiant->nom . ' ' . $etudiant->prenom,
                'cours' => $coursActuel->module->nom ?? 'Cours',
                'time' => now()->format('H:i')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du traitement: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Trouver le cours actuel pour un étudiant
     */
    private function findCurrentCourse($etudiant)
    {
        $today = now()->format('l'); // Jour de la semaine en anglais
        $currentTime = now()->format('H:i');

        // Convertir le jour en français si nécessaire
        $joursFrancais = [
            'Monday' => 'Lundi',
            'Tuesday' => 'Mardi',
            'Wednesday' => 'Mercredi',
            'Thursday' => 'Jeudi',
            'Friday' => 'Vendredi',
            'Saturday' => 'Samedi',
            'Sunday' => 'Dimanche'
        ];

        $jourFrancais = $joursFrancais[$today] ?? $today;

        return Emploi::where('groupe_id', $etudiant->groupe_id)
            ->where('jour', $jourFrancais)
            ->where('heure_debut', '<=', $currentTime)
            ->where('heure_fin', '>=', $currentTime)
            ->with('module')
            ->first();
    }

    /**
     * Marquer automatiquement les absents
     */
    public function markAbsents()
    {
        // Cette méthode sera appelée par un cron job
        $coursPassés = Emploi::where('heure_fin', '<', now()->format('H:i'))
            ->whereDate('created_at', today())
            ->with(['groupe.etudiants'])
            ->get();

        foreach ($coursPassés as $cours) {
            foreach ($cours->groupe->etudiants as $etudiant) {
                // Vérifier si l'étudiant n'a pas scanné son QR Code
                $absence = Absence::where('etudiant_id', $etudiant->id)
                    ->where('emploi_id', $cours->id)
                    ->where('date_cours', today())
                    ->first();

                if (!$absence) {
                    // Créer une absence automatiquement
                    Absence::create([
                        'etudiant_id' => $etudiant->id,
                        'emploi_id' => $cours->id,
                        'date_cours' => today(),
                        'status' => 'absent'
                    ]);
                }
            }
        }

        return response()->json(['message' => 'Absences automatiques créées']);
    }
}
