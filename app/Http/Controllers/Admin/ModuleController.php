<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use Illuminate\Http\Request;
use App\Models\Enseignant;


class ModuleController extends Controller
{
    // Afficher la liste des modules
    public function index()
    {
      $modules = Module::all();
        return view('admin.modules.index', compact('modules'));
    }


    // Afficher le formulaire de création
    public function create()
    {
        $enseignants = Enseignant::all();
        return view('admin.modules.create', compact('enseignants'));
    }

    // Enregistrer un nouveau module
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'description' => 'nullable',
        ]);
        
        Module::create([
            'nom' => $request->nom,
            'description' => $request->description,
        ]);
        
        return redirect()->route('admin.modules.index')->with('success', 'Module créé avec succès.');
    }

    // Afficher les détails d'un module
    public function show(Module $module)
    {
        return view('admin.modules.show', compact('module'));
    }

    // Afficher le formulaire de modification
    public function edit(Module $module)
    {
        $enseignants = Enseignant::all();
        return view('admin.modules.edit', compact('module', 'enseignants'));
    }

    // Mettre à jour un module
    public function update(Request $request, Module $module)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'enseignant_id' => 'nullable|exists:enseignants,id',
        ]);

        $module->update($request->all());
        return redirect()->route('admin.modules.index')->with('success', 'Module mis à jour avec succès.');
    }
    // Supprimer un module
    public function destroy(Module $module)
    {
        $module->delete();
        return redirect()->route('admin.modules.index')->with('success', 'Module supprimé avec succès.');
    }
}