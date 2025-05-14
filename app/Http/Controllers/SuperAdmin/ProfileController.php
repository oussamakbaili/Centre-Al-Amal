<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    // Afficher le formulaire de modification du profil
    public function edit()
    {
        $user = Auth::user();
        return view('superadmin.profile.edit', compact('user'));
    }

    // Mettre à jour le profil
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nom' => 'required',
            'email' => 'required|email|unique:admins,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
        ]);

        $user->nom = $request->nom;
        $user->email = $request->email;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('superadmin.dashboard')->with('success', 'Profil mis à jour avec succès.');
    }
}