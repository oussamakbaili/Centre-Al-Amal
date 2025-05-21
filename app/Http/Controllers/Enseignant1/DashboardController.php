<?php

namespace App\Http\Controllers\Enseignant1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Etudiant;
use App\Models\Absence;
use App\Models\Emploidutemps;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        
        
        $enseignant = Auth::guard('enseignant')->user();
        $nombreEtudiants = Etudiant::count();
        $nombreAbsences = Absence::count();
        $nombreEmplois = Emploidutemps::count();

        return view('enseignant.dashboard', compact(
            'nombreEtudiants',
            'nombreAbsences',
            'nombreEmplois',
            'enseignant'
        ));
    }
}