<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Etudiant;
use App\Models\Emploidutemps;
use App\Models\Absence;
use App\Models\Module;
use App\Models\Cours;
use Illuminate\Support\Facades\Auth;


class EnseignantController extends Controller
{
    public function dashboard()
    {
        $enseignant = Auth::user();

        $nombreEtudiants = Etudiant::count();

        $absencesAPrendre = Absence::where('enseignant_id', $enseignant->id)->count();
        $evenementsCalendrier = Emploidutemps::where('enseignant_id', $enseignant->id)
            ->get()
            ->map(function ($event) {
                return [
                    'title' => $event->titre,
                    'start' => $event->date . 'T' . $event->heure_debut,
                    'end' => $event->date . 'T' . $event->heure_fin,
                ];
            });

        return view('enseignant.dashboard', compact(
            'nombreEtudiants',
            'absencesAPrendre',
            'evenementsCalendrier'
        ));
    }
}