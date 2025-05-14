<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Note;
use App\Models\Etudiant;
use App\Models\Module;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index(Request $request)
    {
        $modules = Module::all();
        $etudiants = Etudiant::all();
        $selectedModule = $request->module_id;

        $query = Note::with(['etudiant', 'module']);

        if ($selectedModule) {
            $query->where('module_id', $selectedModule)
                ->selectRaw('etudiant_id, module_id, GROUP_CONCAT(id) as note_ids, GROUP_CONCAT(note) as notes')
                ->groupBy('etudiant_id', 'module_id');
        } else {
            $query->select('etudiant_id', 'module_id')->distinct();
        }

        $notes = $query->get();

        return view('admin.notes.index', compact('notes', 'modules', 'selectedModule', 'etudiants'));
    }

    public function create()
    {
        $etudiants = Etudiant::all();
        $modules = Module::all();
        return view('admin.notes.create', compact('etudiants', 'modules'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'etudiant_id' => 'required|exists:etudiants,id',
            'module_id' => 'required|exists:modules,id',
            'note_type' => 'required|in:note1,note2',
            'note' => 'required|numeric|min:0|max:20',
        ]);

        // Vérifier si la note existe déjà
        $existingNote = Note::where('etudiant_id', $validated['etudiant_id'])
            ->where('module_id', $validated['module_id'])
            ->where('note_type', $validated['note_type'])
            ->first();

        if ($existingNote) {
            $existingNote->update(['note' => $validated['note']]);
        } else {
            Note::create($validated);
        }

        return redirect()->route('admin.notes.index')
            ->with('success', 'Note enregistrée avec succès.');
    }

    public function edit($etudiant_id, $module_id)
    {
        $etudiants = Etudiant::all();
        $modules = Module::all();
        $currentEtudiant = Etudiant::findOrFail($etudiant_id);
        $currentModule = Module::findOrFail($module_id);

        // Récupérer les notes existantes
        $notes = Note::where('etudiant_id', $etudiant_id)
            ->where('module_id', $module_id)
            ->get();

        $note1 = $notes->where('note_type', 'note1')->first();
        $note2 = $notes->where('note_type', 'note2')->first();

        return view('admin.notes.edit', compact(
            'etudiants',
            'modules',
            'currentEtudiant',
            'currentModule',
            'note1',
            'note2'
        ));
    }

    public function update(Request $request, $etudiant_id, $module_id)
    {
        $request->validate([
            'etudiant_id' => 'required|exists:etudiants,id',
            'module_id' => 'required|exists:modules,id',
            'note1' => 'nullable|numeric|min:0|max:20',
            'note2' => 'nullable|numeric|min:0|max:20',
        ]);

        // Mettre à jour l'étudiant et le module
        Note::where('etudiant_id', $etudiant_id)
            ->where('module_id', $module_id)
            ->update([
                'etudiant_id' => $request->etudiant_id,
                'module_id' => $request->module_id
            ]);

        // Mettre à jour les notes
        $this->updateOrCreateNote($request->etudiant_id, $request->module_id, 'note1', $request->note1);
        $this->updateOrCreateNote($request->etudiant_id, $request->module_id, 'note2', $request->note2);

        return redirect()->route('admin.notes.index')
            ->with('success', 'Informations mises à jour avec succès.');
    }
    public function editNotes($id)
    {
        $note = Note::findOrFail($id);
        return view('admin.notes.edit_notes', compact('note'));
    }

    public function updateNotes(Request $request, $id)
    {
        $note = Note::findOrFail($id);

        $request->validate([
            'note1' => 'required|numeric|min:0|max:20',
            'note2' => 'required|numeric|min:0|max:20',
        ]);

        $note->update([
            'note1' => $request->note1,
            'note2' => $request->note2,
        ]);

        return redirect()->route('admin.notes.index')->with('success', 'Les notes ont été modifiées.');
    }


    protected function updateOrCreateNote($etudiant_id, $module_id, $note_type, $note_value)
    {
        if ($note_value !== null) {
            Note::updateOrCreate(
                [
                    'etudiant_id' => $etudiant_id,
                    'module_id' => $module_id,
                    'note_type' => $note_type
                ],
                ['note' => $note_value]
            );
        } else {
            Note::where('etudiant_id', $etudiant_id)
                ->where('module_id', $module_id)
                ->where('note_type', $note_type)
                ->delete();
        }
    }

    public function destroy($id)
    {
        $note = Note::findOrFail($id);
        $module_id = $note->module_id;
        $note->delete();

        return redirect()->route('admin.notes.index', ['module_id' => $module_id])
            ->with('success', 'Note supprimée avec succès.');
    }
    public function destroyAll($etudiant_id, $module_id)
    {
        Note::where('etudiant_id', $etudiant_id)
            ->where('module_id', $module_id)
            ->delete();

        return redirect()->route('admin.notes.index')
            ->with('success', 'Toutes les notes ont été supprimées.');
    }
}