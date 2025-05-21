<?php

namespace App\Http\Controllers\Enseignant1;

use App\Http\Controllers\Controller;
use App\Models\Etudiant;
use App\Models\Enseignant;
use App\Models\Module;
use App\Models\Absence;
use Illuminate\Support\Facades\Auth;

class EnseignantEtudiantController extends Controller
{
    public function index()
    {
        $etudiants = etudiant::all();

        return view('enseignant.etudiants.index', compact('etudiants'));
    }

    public function showProfile($id)
    {
        $etudiant = Etudiant::with([
            'groupe',
            'module',
            'notes',
            'absences'
        ])->findOrFail($id);

        return view('enseignant.etudiants.profile', compact('etudiant'));
    }

    public function showAbsences($id)
    {
        $etudiant = Etudiant::with(['absences' => function($query) {
            $query->orderBy('date_absence', 'desc');
        }])->findOrFail($id);

        return view('enseignant.etudiants.absences', compact('etudiant'));
    }
}
