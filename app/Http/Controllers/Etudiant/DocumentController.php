<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    public function index()
{
    $modules = Module::with('documents')->get(); // tous les modules avec leurs documents
    return view('etudiant.documents', compact('modules'));
}
}
