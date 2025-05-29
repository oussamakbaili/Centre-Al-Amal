<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $etudiant = $user->etudiant;

        // Charger les relations de base
        $etudiant->load([
            'groupe.emplois.module',
            'notes.module',
            'absences.module',
        ]);

        // Vérifier si le groupe existe
        $documents = collect(); // valeur par défaut
        if ($etudiant->groupe) {
            $etudiant->groupe->load('modules.documents');

            $documents = $etudiant->groupe->modules
                ->flatMap(function ($module) {
                    return $module->documents;
                });
        }

        return view('etudiant.dashboard', [
            'title' => 'Tableau de bord étudiant',
            'user' => $user,
            'etudiant' => $etudiant,
            'emplois' => $etudiant->groupe->emplois ?? collect(),
            'notes' => $etudiant->notes,
            'absences' => $etudiant->absences,
            'documents' => $documents,
        ]);
    }
}
