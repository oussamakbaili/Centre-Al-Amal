<?php

namespace App\Http\Controllers\Enseignant1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\Classe;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index()
    {
        $classes = Classe::where('enseignant_id', Auth::guard('enseignant')->id())->with('documents')->get();
        return view('enseignant.documents.index', compact('classes'));
    }

    public function create()
{
    $enseignant = Auth::guard('enseignant')->user();

    if (!$enseignant) {
        return redirect()->route('enseignant.login')->with('error', 'Veuillez vous connecter');
    }

    $classes = $enseignant->classes;

    return view('enseignant.documents.create', compact('classes'));
}

public function store(Request $request)
{
    $request->validate([
        'classe_id' => 'required|exists:classes,id',
        'titre' => 'required|string|max:255',
        'type_contenu' => 'required|in:texte,fichier', // Nouveau champ
        'contenu' => 'required_if:type_contenu,texte',
        'fichier' => 'required_if:type_contenu,fichier|file|mimes:pdf,jpg,jpeg,png,doc,docx,txt'
    ]);

    $data = [
        'enseignant_id' => Auth::guard('enseignant')->id(),
        'classe_id' => $request->classe_id,
        'titre' => $request->titre,
    ];

    if ($request->type_contenu === 'fichier' && $request->hasFile('fichier')) {
        $data['fichier'] = $request->file('fichier')->store('documents', 'public');
        $data['contenu'] = null;
    } else {
        $data['contenu'] = $request->contenu;
        $data['fichier'] = null;
    }

    Document::create($data);

    return redirect()->route('enseignant.documents.index')
                   ->with('success', 'Contenu ajouté avec succès.');
}
    public function show($id)
    {
        $document = Document::findOrFail($id);
        return view('enseignant.documents.show', compact('document'));
    }
}
