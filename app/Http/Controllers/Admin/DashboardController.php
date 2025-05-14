<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Etudiant;
use App\Models\Enseignant;
use App\Models\Module;
use App\Models\Note;
use App\Models\Absence;
use App\Models\Emploidutemps;

class DashboardController extends Controller
{
    public function index()
    {
        $nombreEtudiants = Etudiant::count();
        $nombreEnseignants = Enseignant::count();
        $nombreModules = Module::count();
        $nombreNotes = Note::count();
        $nombreAbsences = Absence::count();
        $nombreEmploidutemps = Emploidutemps::count();

        return view('admin.dashboard', compact(
            'nombreEtudiants',
            'nombreEnseignants',
            'nombreModules',
            'nombreNotes',
            'nombreAbsences',
            'nombreEmploidutemps'
        ));
    }
}
