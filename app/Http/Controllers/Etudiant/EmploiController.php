<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmploiDuTemps;
use App\Models\Module;
use Auth;

class EmploiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $etudiant = $user->etudiant;


        if (!$etudiant) {
            return redirect()->back()->with('error', 'Aucun profil étudiant trouvé');
        }


        $moduleIds = Module::pluck('id'); // Donne un tableau d'IDs simples
        ;

        $emplois = EmploiDuTemps::with('module')
            ->whereIn('module_id', $moduleIds)
            ->orderByRaw("FIELD(jour, 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi')")
            ->orderBy('heure_debut')
            ->get()
            ->groupBy('jour');

        return view('etudiant.emploi', compact('emplois'));
    }
}
