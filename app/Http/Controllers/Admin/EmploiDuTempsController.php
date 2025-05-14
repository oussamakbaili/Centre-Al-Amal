<?php

namespace App\Http\Controllers\Admin;

use App\Models\Module;
use App\Http\Controllers\Controller;
use App\Models\EmploiDuTemps;
use App\Models\Enseignant;
use Illuminate\Http\Request;
use Override;

class EmploiDuTempsController extends Controller
{
    public function index()
    {
        $emplois = EmploiDuTemps::with('enseignant')->orderBy('jour')->orderBy('heure_debut')->get();
        return view('admin.emplois.index', compact('emplois'));
    }

    public function create()
    {
        $enseignants = Enseignant::with('modules')->orderBy('nom')->get();
        \Log::info('Tous les enseignants:', $enseignants->toArray());
        return view('admin.emplois.create', compact('enseignants'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'jour' => 'required|string|max:255',
            'heure_debut' => 'required|date_format:H:i',
            'heure_fin' => 'required|date_format:H:i|after:heure_debut',
            'salle' => 'nullable|string|max:50',
            'enseignant_id' => 'required|exists:enseignants,id',
            'module_id' => [
                'required',
                'exists:modules,id',
                function ($attribute, $value, $fail) use ($request) {
                    $enseignant = Enseignant::with('modules')->find($request->enseignant_id);
                    if (!$enseignant->modules->contains($value)) {
                        $fail("Le module sélectionné n'est pas attribué à cet enseignant");
                    }
                }
            ]
        ]);

        EmploiDuTemps::create($validated);

        return redirect()->route('admin.emplois.index')->with('success', 'Emploi du temps ajouté avec succès.');
    }
    public function show(EmploiDuTemps $emploi)
    {
        return view('admin.emplois.show', compact('emploi'));
    }
    public function edit(EmploiDuTemps $emploi)
    {
        $enseignants = Enseignant::with('modules')->orderBy('nom')->get();
        return view('admin.emplois.edit', compact('emploi', 'enseignants'));
    }
    public function update(Request $request, EmploiDuTemps $emploi)
    {
        $validated = $request->validate([
            'jour' => 'required|string|max:255',
            'heure_debut' => 'required|date_format:H:i',
            'heure_fin' => 'required|date_format:H:i|after:heure_debut',
            'salle' => 'nullable|string|max:50',
            'enseignant_id' => [
                'required',
                'exists:enseignants,id',
                function ($attribute, $value, $fail) {
                    $enseignant = Enseignant::with('modules')->find($value);
                    if ($enseignant->modules->isEmpty()) {
                        $fail("L'enseignant sélectionné n'a aucun module attribué");
                    }
                }
            ]
        ]);

        $emploi->update($validated);
        return redirect()->route('admin.emplois.index')->with('success', 'Emploi du temps mis à jour avec succès.');
    }

    public function destroy(EmploiDuTemps $emploi)
    {
        $emploi->delete();
        return redirect()->route('admin.emplois.index')->with('success', 'Emploi du temps supprimé avec succès.');
    }
}