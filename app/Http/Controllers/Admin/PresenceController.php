<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Models\Seance;
use App\Models\EmploiDuTemps;
use App\Models\Etudiant;
use App\Models\Absence;
use Carbon\Carbon;

class PresenceController extends Controller
{
    public function ajouterAbsentsAutomatiquement()
    {
        $maintenant = Carbon::now();

        // 🔹 Cas 1 : Séances supplémentaires
        $seances = Seance::whereDate('date', $maintenant->toDateString())
            ->whereTime('heure_fin', '<=', $maintenant->format('H:i:s'))
            ->get();

        foreach ($seances as $seance) {
            $etudiants = Etudiant::all(); // ou filtrer par groupe/module si tu veux

            foreach ($etudiants as $etudiant) {
                $absenceExistante = Absence::where('etudiant_id', $etudiant->id)
                    ->where('seance_id', $seance->id)
                    ->exists();

                if (!$absenceExistante) {
                    Absence::create([
                        'etudiant_id' => $etudiant->id,
                        'seance_id' => $seance->id,
                        'etat' => 'absent',
                    ]);
                }
            }
        }

        // 🔹 Cas 2 : Cours normaux de l'emploi du temps
        $jourActuel = strtolower($maintenant->locale('fr_FR')->dayName); // e.g. lundi, mardi

        $coursDuJour = EmploiDuTemps::where('jour', $jourActuel)
            ->whereTime('heure_fin', '<=', $maintenant->format('H:i:s'))
            ->get();

        foreach ($coursDuJour as $cours) {
            $etudiants = Etudiant::all(); // à adapter selon module/groupe

            foreach ($etudiants as $etudiant) {
                $absenceExistante = Absence::where('etudiant_id', $etudiant->id)
                    ->where('emploi_du_temps_id', $cours->id)
                    ->exists();

                if (!$absenceExistante) {
                    Absence::create([
                        'etudiant_id' => $etudiant->id,
                        'emploi_du_temps_id' => $cours->id,
                        'etat' => 'absent',
                    ]);
                }
            }
        }

        return response()->json(['message' => 'Absences ajoutées avec succès.']);
    }
}

