<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        return view('etudiant.dashboard', [
            'title' => 'Tableau de bord',
            'user' => $user
        ]);
    }
}