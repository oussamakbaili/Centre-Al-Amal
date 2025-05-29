<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use App\Models\Module;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    public function index()
    {
        $modules = Auth::user()->modules()->withCount('documents')->get();
        return view('etudiant.documents.index', compact('modules'));
    }

    public function show(Module $module)
{
    $modules = Auth::user()
        ->modules()
        ->withCount('documents')
        ->get();

    $module->load('documents');

    $recentActivities = $module->documents()
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get()
        ->map(function($doc) {
            return (object)[
                'type' => 'document',
                'titre' => "Nouveau document: {$doc->titre}",
                'auteur' => $doc->auteur,
                'created_at' => $doc->created_at
            ];
        });

    return view('etudiant.documents'.show, [
        'module' => $module,
        'modules' => $modules,
        'recentActivities' => $recentActivities
    ]);
}
}
