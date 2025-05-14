<?php

namespace App\Http\Controllers\Enseignant1;

use App\Http\Controllers\Controller;
use App\Models\Etudiant;
use App\Models\Enseignant;
use App\Models\Module;

class EnseignantEtudiantController extends Controller
{
    public function index($enseignantId)
    {
        $enseignant = Enseignant::find($enseignantId);
        
        if (!$enseignant) {
            abort(404, 'Enseignant non trouvé');
        }
        
        $modules = $enseignant->modules()->pluck('id');
        
        $etudiants = Etudiant::whereHas('modules', function ($query) use ($modules) {
            $query->whereIn('modules.id', $modules);
        })->get();
        
        return view('enseignant.etudiants.index', compact('etudiants'));
    }

    public function showProfile($id)
    {
        $etudiant = Etudiant::with([
            'groupe', 
            'modules', 
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