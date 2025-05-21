<?php

namespace App\Http\Controllers\Enseignant1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmploiDuTemps;
use Auth;

class EmploiDuTempsController extends Controller
{
    public function index()
    {
        // Get the authenticated user's teacher ID
        $enseignant = Auth::user()->enseignant;

        if (!$enseignant) {
            return redirect()->back()->with('error', 'Aucun profil enseignant trouvé');
        }

        // Get the teacher's schedule
        $emplois = EmploiDuTemps::with('module',)
            ->where('enseignant_id', $enseignant->id)  // Use the enseignant's ID from enseignants table
            ->orderByRaw("FIELD(jour, 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi')")
            ->orderBy('heure_debut')
            ->get()
            ->groupBy('jour');

        return view('enseignant.emploi-du-temps.index', compact('emplois'));
    }
}
