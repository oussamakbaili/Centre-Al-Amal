<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AbsenceController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $absences = $user->etudiant->absences()->with('module')->latest()->get();

        return view('etudiant.absences', [
            'title' => 'Mes Absences',
            'absences' => $absences
        ]);
    }
}
