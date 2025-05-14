<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\Ressource;
use Illuminate\Support\Facades\Auth;

class ModuleController extends Controller
{
    public function index()
    {
        $modules = Module::whereHas('groupes', function($query) {
            $query->where('groupe_id', Auth::user()->groupe_id);
        })->with(['ressources' => function($query) {
            $query->orderBy('created_at', 'desc');
        }])->get();

        return view('etudiant.modules', [
            'title' => 'Modules & Ressources',
            'modules' => $modules
        ]);
    }
}