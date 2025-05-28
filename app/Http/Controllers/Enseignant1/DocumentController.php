<?php

namespace App\Http\Controllers\Enseignant1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\Enseignant;
use App\Models\Module;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class DocumentController extends Controller
{
    public function index()
    {
        $enseignant = Auth::user();

        $documents = Document::where('enseignant_id', $enseignant->id)
                             ->with(['module'])
                             ->orderBy('created_at', 'desc')
                             ->get();

        return view('enseignant.documents.index', compact('documents', 'enseignant'));
    }

    public function create()
    {
        $enseignant = Auth::user();

        if (!$enseignant) {
            abort(403, 'Accès non autorisé');
        }

        return view('enseignant.documents.create', compact('enseignant'));
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'contenu' => 'nullable|string',
            'fichier' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:20480',
        ]);


        $user = Auth::user();
        $enseignant = Enseignant::where('user_id', $user->id)->first();

        // ÉTAPE 3: Vérification module
        if (!$enseignant->module) {
            return redirect()->back()
                           ->with('error', 'Aucun module assigné')
                           ->withInput();
        }

        // ÉTAPE 4: Préparation des données
        $documentData = [
            'titre' => $validated['titre'],
            'contenu' => $validated['contenu'] ?? null,
            'enseignant_id' => $enseignant->id,
            'module_id' => $enseignant->module->id,
        ];

        // ÉTAPE 5: Gestion fichier
        if ($request->hasFile('fichier')) {
            $path = $request->file('fichier')->store('documents', 'public');
            $documentData['fichier'] = $path;
        }

        // ÉTAPE 6: Test de connexion DB
        try {
            DB::connection()->getPdo();
            echo "Connexion DB OK<br>";
        } catch (\Exception $e) {
            dd("Erreur DB: " . $e->getMessage());
        }

        // ÉTAPE 7: Création document
        try {
            $document = Document::create($documentData);

            if ($document) {
                echo "Document créé avec ID: " . $document->id . "<br>";

                // Vérification en DB
                $check = Document::find($document->id);
                if ($check) {
                    echo "Document trouvé en DB<br>";
                } else {
                    echo "Document NON trouvé en DB<br>";
                }
            }

        } catch (\Exception $e) {
            dd("Erreur création: " . $e->getMessage());
        }

        return redirect()->route('enseignant.documents.index')
                        ->with('success', 'Document ajouté avec succès');
    }

    public function show($id)
    {
        $enseignant = Auth::user();
        $document = Document::where('id', $id)
                           ->where('enseignant_id', $enseignant->id)
                           ->firstOrFail();

        return view('enseignant.documents.show', compact('document'));
    }

    public function destroy($id)
    {
        $enseignant = Auth::user();
        $document = Document::where('id', $id)
                           ->where('enseignant_id', $enseignant->id)
                           ->firstOrFail();

        if ($document->fichier) {
            Storage::disk('public')->delete($document->fichier);
        }

        $document->delete();

        return redirect()->route('enseignant.documents.index')
                        ->with('success', 'Document supprimé avec succès');
    }
}
