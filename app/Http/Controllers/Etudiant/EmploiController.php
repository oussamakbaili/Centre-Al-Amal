<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Emploi; // Ajoutez cette ligne

class EmploiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $etudiant = $user->etudiant;

        // Vérifier si l'étudiant a un groupe
        if (!$etudiant || !$etudiant->groupe) {
            return view('etudiant.emploi', [
                'error' => 'Aucun groupe attribué',
                'emplois' => collect(),
                'joursSemaine' => $this->getJoursSemaine()
            ]);
        }

        // Récupérer les emplois du temps du groupe de l'étudiant
        $emplois = Emploi::where('groupe_id', $etudiant->groupe->id)
            ->with(['module', 'enseignant'])
            ->orderBy('jour_semaine')
            ->orderBy('heure_debut')
            ->get();

        return view('etudiant.emploi', [
            'emplois' => $emplois,
            'etudiant' => $etudiant,
            'joursSemaine' => $this->getJoursSemaine(),
            'error' => null
        ]);
    }

    protected function getJoursSemaine()
    {
        return [
            'Monday' => 'Lundi',
            'Tuesday' => 'Mardi',
            'Wednesday' => 'Mercredi',
            'Thursday' => 'Jeudi',
            'Friday' => 'Vendredi',
            'Saturday' => 'Samedi'
        ];
    }
}
