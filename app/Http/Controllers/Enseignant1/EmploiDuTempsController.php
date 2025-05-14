<?php

namespace App\Http\Controllers\Enseignant1; 

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmploiDuTemps;

class EmploiDuTempsController extends Controller
{
    public function index()
    {
        // Récupérer l'emploi du temps de l'enseignant connecté
        $emplois = EmploiDuTemps::with(['module'])
            ->where('enseignant_id', Auth::id())
            ->orderBy('jour_semaine')
            ->orderBy('heure_debut')
            ->get()
            ->groupBy('jour_semaine');

        return view('enseignant.emploi-du-temps.index', compact('emplois'));
    }
}
