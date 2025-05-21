<?php

namespace App\Http\Controllers\Enseignant1;

use App\Http\Controllers\Controller;
use App\Models\Absence;
use App\Models\Etudiant;
use App\Models\Enseignant;

use App\Models\Module;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AbsenceController extends Controller
{
    public function index()
    {
        // 1. Get authenticated teacher's user_id
        $userId = auth()->id();

        // 2. Find teacher record
        $enseignant = Enseignant::where('user_id', $userId)->firstOrFail();

        // 3. Obtenir les absences de l'enseignant connecté
        $absences = Absence::where('enseignant_id', $enseignant->id)->get();

        return view('enseignant.absences.index', compact('absences'));
    }

    public function create()
    {
        $etudiants = Etudiant::orderBy('nom')->get();
        $modules = Module::where('enseignant_id', auth()->id())->get();

        return view('enseignant.absences.create', compact('etudiants', 'modules'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'etudiant_id' => 'required|exists:etudiants,id',
            'module_id' => 'required|exists:modules,id',
            'date_absence' => 'required|date|before_or_equal:today',
            'motif' => 'nullable|string|max:500'
        ]);

        Absence::create([
            'etudiant_id' => $validated['etudiant_id'],
            'module_id' => $validated['module_id'],
            'enseignant_id' => auth()->id(),
            'date_absence' => $validated['date_absence'],
            'motif' => $validated['motif'],
            'etat' => 'Non justifié'
        ]);

        return redirect()->route('enseignant.absences.index')
            ->with('success', 'Absence enregistrée avec succès');
    }

    public function show(Absence $absence)
    {
        $this->authorize('view', $absence);

        return view('enseignant.absences.show', compact('absence'));
    }

    public function edit(Absence $absence)
    {
        $this->authorize('update', $absence);

        $etudiants = Etudiant::orderBy('nom')->get();
        $modules = Module::where('enseignant_id', auth()->id())->get();

        return view('enseignant.absences.edit', compact('absence', 'etudiants', 'modules'));
    }

    public function update(Request $request, Absence $absence)
    {
        $this->authorize('update', $absence);

        $validated = $request->validate([
            'etudiant_id' => 'required|exists:etudiants,id',
            'module_id' => 'required|exists:modules,id',
            'date_absence' => 'required|date|before_or_equal:today',
            'motif' => 'nullable|string|max:500',
            'etat' => 'required|in:Justifié,Non justifié'
        ]);

        $absence->update($validated);

        return redirect()->route('enseignant.absences.index')
            ->with('success', 'Absence mise à jour avec succès');
    }

    public function destroy(Absence $absence)
    {
        $this->authorize('delete', $absence);

        $absence->delete();

        return redirect()->route('enseignant.absences.index')
            ->with('success', 'Absence supprimée avec succès');
    }

    public function justifier(Request $request, Absence $absence)
    {
        $this->authorize('update', $absence);

        $request->validate(['motif' => 'required_if:etat,Justifié|string|max:500']);

        $absence->update([
            'etat' => 'Justifié',
            'motif' => $request->motif
        ]);

        return back()->with('success', 'Absence marquée comme justifiée');
    }
}
