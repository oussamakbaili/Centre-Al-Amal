<?php

namespace App\Http\Controllers\Enseignant1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Enseignant;
use App\Models\Etudiant;
use App\Models\Absence;
use App\Models\Emploi;

class DashboardController extends Controller
{
    public function dashboard1()
    {
        $enseignant = auth('enseignant')->user();

        if (!$enseignant) {
            abort(403, 'Non autorisé. Enseignant non connecté.');
        }

        // Nombre d'étudiants liés à cet enseignant
        $nombreEtudiants = Etudiant::whereHas('modules', function ($q) use ($enseignant) {
            $q->where('enseignant_id', $enseignant->id);
        })->count();

        // Nombre d’absences enregistrées par cet enseignant
        $nombreAbsences = Absence::where('enseignant_id', $enseignant->id)->count();

        // Nombre d’emplois du temps assignés à cet enseignant
        $nombreEmplois = Emploi::where('enseignant_id', $enseignant->id)->count();

        // Événements pour FullCalendar
        $evenementsCalendrier = Emploi::where('enseignant_id', $enseignant->id)
            ->get()
            ->map(function ($emploi) {
                return [
                    'title' => $emploi->module->nom ?? 'Cours',
                    'start' => $emploi->date . 'T' . $emploi->heure_debut,
                    'end'   => $emploi->date . 'T' . $emploi->heure_fin,
                ];
            });

        return view('enseignant1.dashboard1', compact(
            'nombreEtudiants',
            'nombreAbsences',
            'nombreEmplois',
            'evenementsCalendrier'
        ));
    }
}
