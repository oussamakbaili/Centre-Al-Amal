<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use App\Models\EmploiDuTemps;
use Illuminate\Support\Facades\Auth;

class EmploiController extends Controller
{
    public function index()
    {
        $emplois = EmploiDuTemps::with(['module', 'enseignant'])
            ->where('groupe_id', Auth::user()->groupe_id)
            ->orderBy('jour_semaine')
            ->orderBy('heure_debut')
            ->get()
            ->groupBy('jour_semaine');

        return view('etudiant.emploi', [
            'title' => 'Emploi du temps',
            'emplois' => $emplois
        ]);
    }
}