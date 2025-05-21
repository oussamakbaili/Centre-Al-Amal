<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $etudiant = $user->etudiant;

        // Charger tous les documents avec les modules associés
        $documents = $etudiant->documents()->with('module')->latest()->get();

        // Grouper les documents par module
        $documentsParModule = $documents->groupBy(function($document) {
            return $document->module ? $document->module->nom : 'Autres';
        });

        return view('etudiant.documents', [
            'title' => 'Mes Documents',
            'documentsParModule' => $documentsParModule,
            'etudiant' => $etudiant
        ]);
    }
}
