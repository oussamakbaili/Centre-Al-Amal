<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absence;
use App\Models\Enseignant;
use App\Models\Etudiant;
use Illuminate\Http\Request;

class AbsenceController extends Controller
{
    // Afficher la liste des absences
    public function index(Request $request)
    {
        $type = $request->get('type');

        if ($type === 'Enseignant') {
            // Absences uniquement liées à un enseignant
            $absences = Absence::with('enseignant')
                ->whereNotNull('enseignant_id')
                ->get();
        } else {
            // Absences uniquement liées à un étudiant
            $absences = Absence::with('etudiant')
                ->whereNotNull('etudiant_id')
                ->get();
        }
    
        return view('admin.absences.index', compact('absences', 'type'));
    }
    
    

    public function showByEnseignant($id)
    {
        $enseignant = Enseignant::findOrFail($id);
        $absences = Absence::where('type', 'Enseignant')
                            ->where('enseignant_id', $id)
                            ->get();

        return view('admin.absences.byEnseignant', compact('enseignant', 'absences'));
    }




    // Afficher le formulaire de création
    public function create()
    {
        $etudiants = Etudiant::all();
        $enseignants = Enseignant::all(); 
        return view('admin.absences.create', compact('etudiants', 'enseignants'));
    }

    // Enregistrer une nouvelle absence
    public function store(Request $request)
    {
    $request->validate([
        'type' => 'required|in:Étudiant,Enseignant',
        'date_absence' => 'required|date',
        'etat' => 'required',
        'motif' => 'nullable|string',
    ]);

    $absence = new Absence();
    $absence->type = $request->type;
    $absence->date_absence = $request->date_absence;
    $absence->etat = $request->etat;
    $absence->motif = $request->motif;

    if ($request->type == 'Étudiant') {
        $request->validate(['etudiant_id' => 'required|exists:etudiants,id']);
        $absence->etudiant_id = $request->etudiant_id;
    } else {
        $request->validate(['enseignant_id' => 'required|exists:enseignants,id']);
        $absence->enseignant_id = $request->enseignant_id;
    }

    $absence->save();

    return redirect()->route('admin.absences.index', ['type' => $request->type])
                     ->with('success', 'Absence ajoutée avec succès.');
    }


    // Afficher les détails d'une absence
    public function show(Absence $absence)
    {
        return view('admin.absences.show', compact('absence'));
    }

    // Afficher le formulaire de modification
    public function edit($id)
    {
        $absence = Absence::findOrFail($id);
        return view('admin.absences.edit', compact('absence'));
    }

    // Mettre à jour une absence
    public function update(Request $request, $id)
    {
        $request->validate([
            'date_absence' => 'required|date',
            'etat' => 'required|string|in:Justifié,Non justifié',
            'motif' => 'nullable|string'
        ]);

        $absence = Absence::findOrFail($id);
        $absence->update([
            'date_absence' => $request->date_absence,
            'etat' => $request->etat,
            'motif' => $request->motif,
        ]);

        return redirect()->route('admin.absences.index')->with('success', 'Absence mise à jour avec succès.');
    }

    // Supprimer une absence
    public function destroy($id)
    {
        $absence = Absence::findOrFail($id);
        $absence->delete();

        return redirect()->route('admin.absences.index')->with('success', 'Absence supprimée avec succès.');
    }

}