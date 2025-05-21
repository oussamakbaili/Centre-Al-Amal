<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absence;
use App\Models\Enseignant;
use App\Models\Etudiant;
use App\Models\Module;
use Illuminate\Http\Request;
use Carbon\Carbon;


class AbsenceController extends Controller
{
    // Afficher la liste des absences
    public function index(Request $request)
    {
        $type = $request->get('type');

        if ($type === 'Enseignant') {
            $absences = Absence::with(['enseignant', 'module'])
                ->whereNotNull('enseignant_id')
                ->get();
        } else {
            $absences = Absence::with(['etudiant', 'module'])
                ->whereNotNull('etudiant_id')
                ->get();
        }

        return view('admin.absences.index', compact('absences', 'type'));
    }

    public function showByEnseignant($id)
    {
        $enseignant = Enseignant::with('modules')->findOrFail($id);

        $absences = Absence::where('type', 'Enseignant')
            ->where('enseignant_id', $id)
            ->with('module')
            ->get();

        return view('admin.absences.byEnseignant', compact('enseignant', 'absences'));
    }

    public function create()
    {
        $etudiants = Etudiant::all();
        $enseignants = Enseignant::all();
        $modules = Module::all(); // Add this line

        return view('admin.absences.create', compact('etudiants', 'enseignants', 'modules'));
    }

    public function store(Request $request)
    {

    $rules = [
        'type' => 'required|in:Étudiant,Enseignant',
        'date_absence' => 'required|date',
        'etat' => 'required',
        'motif' => 'nullable|string',
    ];

    if ($request->type == 'Étudiant') {
        $rules['etudiant_id'] = 'required|exists:etudiants,id';
        $rules['module_id'] = 'required|exists:modules,id';
    } else {
        $rules['enseignant_id'] = 'required|exists:enseignants,id';
    }

    $request->validate($rules);

        $absence = new Absence();
        $absence->type = $request->type;
        $absence->date_absence = $request->date_absence;
        $absence->etat = $request->etat;
        $absence->motif = $request->motif;
        $absence->module_id = $request->module_id; // Add this line

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
