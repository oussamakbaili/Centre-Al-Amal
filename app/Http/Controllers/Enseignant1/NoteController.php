<?php

namespace App\Http\Controllers\Enseignant1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Note;
use App\Models\Etudiant;
use App\Models\Enseignant;
use App\Models\Module;
use Illuminate\Support\Facades\Auth;


    class NoteController extends Controller
    {
        public function index()
        {
            $user = Auth::user();
            $enseignant = Enseignant::where('user_id', $user->id)->first();
            $modules = $enseignant->module()
                ->with(['notes.etudiant' => function($query) {
                    $query->select('id', 'nom', 'prenom');
                }])
                ->get();

            return view('enseignant.notes.index', compact('modules'));
        }

        public function create()
        {
            $enseignant = Auth::guard('enseignant')->user();

            // Get only the teacher's modules with enrolled students
            $modules = $enseignant->modules()
                ->with(['etudiants' => function($query) {
                    $query->select('etudiants.id', 'nom', 'prenom');
                }])
                ->get();

            return view('enseignant.notes.create', compact('modules'));
        }

        public function store(Request $request)
        {
            $enseignant = Auth::guard('enseignant')->user();

            // Validate the request
            $request->validate([
                'notes' => 'required|array',
                'notes.*.etudiant_id' => 'required|exists:etudiants,id',
                'notes.*.module_id' => [
                    'required',
                    'exists:modules,id',
                    function ($attribute, $value, $fail) use ($enseignant) {
                        if (!$enseignant->module->contains('id', $value)) {
                            $fail('Vous ne pouvez pas ajouter des notes pour ce module.');
                        }
                    }
                ],
                'notes.*.valeur' => 'required|numeric|min:0|max:20',
            ]);

            // Process each note
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

            return redirect()->route('enseignant.notes.index')
                ->with('success', 'Notes enregistrées avec succès.');
        }
    }

