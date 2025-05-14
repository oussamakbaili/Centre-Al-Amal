<?php

namespace App\Http\Controllers\Enseignant1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Liste tous les documents envoyés par l'enseignant.
     */
    public function index()
    {
        $enseignant = Auth::guard('enseignant')->user();
        $documents = Document::where('enseignant_id', $enseignant->id)->latest()->get();

        return view('enseignant.documents.index', compact('documents'));
    }

    /**
     * Affiche le formulaire d'envoi de document.
     */
    public function create()
    {
        return view('enseignant.documents.create');
    }

    /**
     * Enregistre un document.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'fichier' => 'required|file|mimes:pdf,docx,pptx,zip,rar,jpg,png|max:10240',
        ]);

        $path = $request->file('fichier')->store('documents', 'public');

        Document::create([
            'titre' => $request->titre,
            'fichier' => $path,
            'enseignant_id' => Auth::guard('enseignant')->id(),
        ]);

        return redirect()->route('enseignant.documents.index')->with('success', 'Document envoyé avec succès.');
    }
}
