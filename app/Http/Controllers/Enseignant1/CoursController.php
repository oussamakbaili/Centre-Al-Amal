<?php

namespace App\Http\Controllers\Enseignant1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cours;
use Illuminate\Support\Facades\Auth;

class CoursController extends Controller
{
    /**
     * Affiche la liste des cours de l'enseignant.
     */
    public function index()
    {
        $enseignantId = Auth::guard('enseignant')->id();
        $cours = Cours::where('enseignant_id', $enseignantId)->latest()->get();

        return view('enseignant.cours.index', compact('cours'));
    }

    /**
     * Affiche le formulaire de création de cours.
     */
    public function create()
    {
        return view('enseignant.cours.create');
    }

    /**
     * Enregistre un nouveau cours.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'contenu' => 'required|string',
        ]);

        Cours::create([
            'titre' => $request->titre,
            'contenu' => $request->contenu,
            'enseignant_id' => Auth::guard('enseignant')->id(),
        ]);

        return redirect()->route('enseignant.cours.index')->with('success', 'Cours créé avec succès.');
    }

    /**
     * Affiche un cours.
     */
    public function show(Cours $cours)
    {
        return view('enseignant.cours.show', compact('cours'));
    }

    /**
     * Affiche le formulaire d'édition.
     */
    public function edit(Cours $cours)
    {
        return view('enseignant.cours.edit', compact('cours'));
    }

    /**
     * Met à jour un cours.
     */
    public function update(Request $request, Cours $cours)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'contenu' => 'required|string',
        ]);

        $cours->update([
            'titre' => $request->titre,
            'contenu' => $request->contenu,
        ]);

        return redirect()->route('enseignant.cours.index')->with('success', 'Cours mis à jour avec succès.');
    }

    /**
     * Supprime un cours.
     */
    public function destroy(Cours $cours)
    {
        $cours->delete();
        return redirect()->route('enseignant.cours.index')->with('success', 'Cours supprimé.');
    }
}
