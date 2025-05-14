<?php

namespace App\Http\Controllers\Enseignant1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Module;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Stocke un nouveau post pour un module.
     */
    public function store(Request $request, Module $module)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'contenu' => 'required|string',
        ]);

        $enseignant = Auth::guard('enseignant')->user();

        $post = new Post();
        $post->titre = $request->input('titre');
        $post->contenu = $request->input('contenu');
        $post->module_id = $module->id;
        $post->enseignant_id = $enseignant->id;
        $post->save();

        return redirect()->back()->with('success', 'Post créé avec succès.');
    }
}
