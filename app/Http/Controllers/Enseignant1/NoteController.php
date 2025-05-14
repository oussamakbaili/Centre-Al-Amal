<?php

namespace App\Http\Controllers\Enseignant1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Note;
use App\Models\Etudiant;
use App\Models\Module;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    public function index()
    {
        $enseignant = Auth::guard('enseignant')->user();
        $modules = $enseignant->modules()->with('notes.etudiant')->get();

        return view('enseignant.notes.index', compact('modules'));
    }

    public function create()
    {
        $enseignant = Auth::guard('enseignant')->user();
        $modules = $enseignant->modules;

        return view('enseignant.notes.create', compact('modules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'notes' => 'required|array',
            'notes.*.etudiant_id' => 'required|exists:etudiants,id',
            'notes.*.module_id' => 'required|exists:modules,id',
            'notes.*.valeur' => 'required|numeric|min:0|max:20',
        ]);

        foreach ($request->notes as $data) {
            Note::updateOrCreate(
                [
                    'etudiant_id' => $data['etudiant_id'],
                    'module_id' => $data['module_id'],
                ],
                [
                    'valeur' => $data['valeur'],
                ]
            );
        }

        return redirect()->route('enseignant.notes.index')->with('success', 'Notes enregistrées avec succès.');
    }
}
