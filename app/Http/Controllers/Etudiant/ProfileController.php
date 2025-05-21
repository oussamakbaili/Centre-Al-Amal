<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('etudiant.profile', [
            'title' => 'Profil étudiant',
            'user' => $user,
            'etudiant' => $user->etudiant
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $etudiant = $user->etudiant;

        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'telephone' => 'nullable|string|max:20',
            'adresse' => 'nullable|string|max:255',
            'date_naissance' => 'nullable|date',
            'cin' => 'nullable|string|max:20',
        ]);

        $user->update([
            'name' => $request->nom.' '.$request->prenom,
            'email' => $request->email,
        ]);

        $etudiant->update($request->only([
            'nom', 'prenom', 'telephone', 'adresse', 'date_naissance', 'cin'
        ]));

        return back()->with('success', 'Profil mis à jour avec succès.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Mot de passe mis à jour avec succès.');
    }
}
