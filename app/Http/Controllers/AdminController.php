<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use App\Models\Etudiant;
use App\Models\Enseignant;
use App\Models\Absence;
use App\Models\Module;
use App\Models\Preinscription;
use App\Models\Note;
use App\Models\Emploidutemps;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminRegistered;

class AdminController extends Controller
{
    /**
     * Affiche la liste des administrateurs.
     */
    public function index()
    {
        $admins = Admin::all();
        return view('superadmin.admins.index', compact('admins'));
    }

    /**
     * Affiche le formulaire de création d'un administrateur.
     */
    public function create()
    {
        return view('superadmin.admins.create');
    }

    /**
     * Enregistre un nouvel administrateur et crée un utilisateur associé.
     */
    // Assurez-vous que cette classe existe et est correctement configurée

    public function store(Request $request)
    {
        $request->validate([
            'nom'    => 'required|string|max:255',
            'email'   => 'required|string|email|max:255|unique:users', 
          
        ]);
    
        $password = Str::random(8);
        $hashedPassword = Hash::make($password);
    
        $admin = Admin::create([
            'nom'    => $request->nom,
            'email'  =>$request->email,
            'password' =>$hashedPassword,
        ]);
    
        $user = new User([
            'nom'     => $request->nom,
            'email'    => $request->email,
            'password' => $hashedPassword,
            'role'     => 'admin', 
            'roleable_id' => $admin->id, 
            'roleable_type' => Admin::class, 
        ]);
    
        $user->save();
    
        Mail::to($user->email)->send(new AdminRegistered($admin, $password));
    
        return redirect()->route('superadmin.admins.index')->with('success', 'Admin created successfully.');
    }
    /**
     * Affiche le formulaire de modification d'un administrateur.
     */
    public function edit(Admin $admin)
    {
        return view('superadmin.admins.edit', compact('admin'));
    }

    /**
     * Met à jour un administrateur et son utilisateur associé.
     */
    public function update(Request $request, Admin $admin)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $admin->user_id,
        ]);

        $admin->update([
            'nom' => $request->nom,
            'email' => $request->email,
        ]);

        $admin->user->update([
            'name' => $request->nom,
            'email' => $request->email,
        ]);

        return redirect()->route('admins.index')->with('success', 'Administrateur mis à jour avec succès.');
    }

    /**
     * Supprime un administrateur et son utilisateur associé.
     */
    public function destroy(Admin $admin)
    {
        if ($admin->user) {
            $admin->user->delete();
        }
    
        $admin->delete();
    
        return redirect()->route('superadmin.admins.index')->with('success', 'Administrateur supprimé avec succès.');
    }
    /**
     * Affiche le tableau de bord de l'admin.
     */
    public function dashboard()
    {
        $nombreEtudiants = Etudiant::count();
        $nombreEnseignants = Enseignant::count();
        $nombreAbsences = Absence::count();
        $nombreModules = Module::count();
        $nombrePreinscriptions = Preinscription::count();
        $nombreNotes = Note::count();
        $nombreEmploiDuTemps = Emploidutemps::count(); 

        return view('admin.dashboard', compact(
            'nombreEtudiants', 'nombreEnseignants', 'nombreAbsences',
        'nombreModules', 'nombrePreinscriptions', 'nombreNotes', 'nombreEmploiDuTemps'
        ));
    }
    /**
     * Affiche le formulaire de modification du profil.
     */
    public function editProfile()
    {
        $admin = Auth::user();
        return view('admin.profile.edit', compact('admin'));
    }

    /**
     * Met à jour le profil de l'admin.
     */
    public function updateProfile(Request $request)
    {
        $admin = Auth::user();

        $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $admin->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $admin->update([
            'nom' => $request->nom,
            'email' => $request->email,
        ]);

        if ($request->password) {
            $admin->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->route('admin.dashboard')->with('success', 'Profil mis à jour avec succès.');
    }
}  