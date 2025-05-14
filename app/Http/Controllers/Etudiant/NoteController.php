<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use App\Models\Note;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    public function index()
    {
        $notes = Note::with('module')
            ->where('etudiant_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('etudiant.notes', [
            'title' => 'Mes Notes',
            'notes' => $notes
        ]);
    }
}