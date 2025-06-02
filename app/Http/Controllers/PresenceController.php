<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmploiDuTemps;
use App\Models\Seance;
use App\Models\Presence;
use App\Models\Etudiant;

class PresenceController extends Controller
{
   public function index()
{
    $today = now()->format('Y-m-d');
    $dayName = now()->locale('fr_FR')->dayName;

    // Récupérer les séances programmées pour aujourd’hui depuis emploi_du_temps
    $emplois = EmploiDuTemps::with('module')
        ->where('jour', $dayName)
        ->get();

    // Récupérer les séances exceptionnelles
    $seances = Seance::with('module')
        ->whereDate('date', $today)
        ->get();

    return view('admin.presences.index', [
        'emplois' => $emplois,
        'seances' => $seances,
        'etudiants' => Etudiant::all(),
        'now' => now()
    ]);
}
    public function scan(Request $request)
    {
    $etudiant_id = $request->etudiant_id;
    $seance_id = $request->seance_id;

    $presence = Presence::firstOrCreate(
        ['etudiant_id' => $etudiant_id, 'seance_id' => $seance_id],
        ['etat' => 'present', 'heure_arrivee' => now()]
    );

    return response()->json(['message' => 'Présence enregistrée avec succès.']);
    }
}
