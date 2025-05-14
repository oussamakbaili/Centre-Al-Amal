<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use App\Models\Absence;
use Illuminate\Support\Facades\Auth;

class AbsenceController extends Controller
{
    public function index()
    {
        $absences = Absence::with('module')
            ->where('etudiant_id', Auth::id())
            ->orderBy('date_absence', 'desc')
            ->paginate(10);

        return view('etudiant.absences', [
            'title' => 'Mes Absences',
            'absences' => $absences
        ]);
    }
}