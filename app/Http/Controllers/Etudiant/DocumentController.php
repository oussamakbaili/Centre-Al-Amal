<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\Etudiant;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    /**
     * Affiche la liste des modules de l'étudiant
     */
   public function index()
{
    // Récupère tous les modules avec les relations spécifiées
    $modules = Module::with([
            'enseignant:id,nom,email',
            'documents' => function($query) {
                $query->latest()->take(3);
            }
        ])
        ->withCount('documents')
        ->get();

    return view('etudiant.documents.index', compact('modules'));
}
    public function show(Module $module)
{
    $user = Auth::user();

    // Charger tous les modules (comme dans l'index)
    $modules = Module::with([
            'enseignant:id,nom,email',
            'documents' => function($query) {
                $query->latest()->take(3);
            }
        ])
        ->withCount('documents')
        ->get();

    // Charger les informations complètes du module actuel
    $module->load([
        'enseignant:id,nom,email',
        'documents' => function($query) {
            $query->orderBy('created_at', 'desc');
        }
    ]);

    // Créer les activités récentes
    $recentActivities = $module->documents
        ->take(10)
        ->map(function ($doc) {
            return (object) [
                'type' => 'document',
                'titre' => $doc->titre,
                'auteur' => $doc->auteur ?? $module->enseignant->nom ?? 'Enseignant',
                'created_at' => $doc->created_at,
                'description' => $doc->description,
                'lien_fichier' => $doc->lien_fichier,
            ];
        });

    return view('etudiant.documents.show', [
        'modules' => $modules,
        'module' => $module,
        'recentActivities' => $recentActivities
    ]);
}

    /**
 * Télécharger ou ouvrir un document
 */
public function download($moduleId, $documentId)
{
    $user = Auth::user();

    // Charger le module avec ses relations
    $module = Module::with(['enseignant:id,nom,email'])
                ->findOrFail($moduleId);

    // Charger les documents du module (comme dans show)
    $module->load([
        'documents' => function($query) use ($documentId) {
            $query->where('id', $documentId);
        }
    ]);

    // Vérifier que le document existe
    $document = $module->documents->first();
    if (!$document) {
        abort(404, 'Document non trouvé.');
    }

    // Si le document a un lien vers un fichier
    if ($document->lien_fichier) {
        // Si c'est un chemin local
        if (file_exists(storage_path('app/public/' . $document->lien_fichier))) {
            $filePath = storage_path('app/public/' . $document->lien_fichier);
            $fileName = $document->titre . '.' . pathinfo($document->lien_fichier, PATHINFO_EXTENSION);

            // Pour ouvrir dans le navigateur
            if (request()->has('open')) {
                return response()->file($filePath, [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'inline; filename="'.$fileName.'"'
                ]);
            }

            // Pour télécharger
            return response()->download($filePath, $fileName);
        }

        // Si c'est une URL externe, rediriger
        return redirect($document->lien_fichier);
    }

    abort(404, 'Fichier non trouvé.');
}
}
