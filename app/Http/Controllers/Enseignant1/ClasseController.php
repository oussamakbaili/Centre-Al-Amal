<?php

namespace App\Http\Controllers\Enseignant1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\Classe;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ClasseController extends Controller
{
public function create()
{
    return view('enseignant.classes.create');
}

public function store(Request $request)
{
    $request->validate([
        'nom' => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);

    Classe::create([
        'enseignant_id' => Auth::guard('enseignant')->id(),
        'nom' => $request->nom,
        'description' => $request->description,
    ]);

    return redirect()->route('enseignant.documents.index')
                   ->with('success', 'Classe créée avec succès');
}
}
