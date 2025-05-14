<?php

namespace App\Http\Controllers\Enseignant1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Module;
use App\Models\Post;

class EnseignantModuleController extends Controller
{
    public function index()
    {
        $enseignant = auth()->user()->enseignant;

        $modules = $enseignant ? $enseignant->modules : collect();

        return view('enseignant.modules.index', compact('modules'));
    }

    public function create($moduleId)
    {
        $module = Module::findOrFail($moduleId);

        return view('enseignant.modules.create', compact('module'));
    }

    public function store(Request $request, $moduleId)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'contenu' => 'nullable|string',
            'fichier' => 'nullable|file|max:10240', // max 10MB
        ]);

        $module = Module::findOrFail($moduleId);

        $post = new Post();
        $post->titre = $request->titre;
        $post->contenu = $request->contenu;

        if ($request->hasFile('fichier')) {
            $post->fichier = $request->file('fichier')->store('posts', 'public');
        }

        $post->module_id = $module->id;
        $post->enseignant_id = auth()->user()->enseignant->id;
        $post->save();

        return redirect()->route('enseignant.modules.index')->with('success', 'Post ajouté avec succès.');
    }
}
