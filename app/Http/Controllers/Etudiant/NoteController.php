<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $etudiant = $user->etudiant;

        // Charger toutes les notes avec les modules
        $notes = $etudiant->notes()->with('module')->latest()->paginate(10);

        // Calculer la moyenne générale
        $moyenneGenerale = $notes->avg('valeur');

        // Grouper les notes par module pour un meilleur affichage
        $notesParModule = $notes->groupBy('module.nom');

        return view('etudiant.notes', compact('notes', 'moyenneGenerale', 'etudiant'));

    }
}
