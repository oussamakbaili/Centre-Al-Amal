<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Etudiant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\EtudiantRegistered;

class EtudiantController extends Controller
{
    // Afficher la liste des étudiants
    public function index(Request $request)
    {
    $query = Etudiant::query();

    // Recherche par nom ou téléphone
    if ($request->has('search')) {
        $search = $request->input('search');
        $query->where('nom', 'like', "%{$search}%")
              ->orWhere('telephone', 'like', "%{$search}%");
    }

    // Tri par nom
    if ($request->has('sort')) {
        $sort = $request->input('sort');
        if ($sort == 'name_asc') {
            $query->orderBy('nom', 'asc');
        } elseif ($sort == 'name_desc') {
            $query->orderBy('nom', 'desc');
        }
    }

    $etudiants = $query->get();
    return view('admin.etudiants.index', compact('etudiants'));
    }

    // Afficher le formulaire de création
    public function create()
    {
        return view('admin.etudiants.create');
    }

    // Enregistrer un nouvel étudiant
    public function store(Request $request)
{
    // Génération d'un mot de passe aléatoire
        $password = Str::random(8);
        $hashedPassword = Hash::make($password);

    // Validation des données
    $request->validate([
        'nom' => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        'email' => 'required|email|unique:etudiants,email|unique:users,email',
        'adresse' => 'required|string|max:255',
        'telephone' => 'required|string|max:20',
        'date_naissance' => 'required|date',
        'cin' => 'required|string|max:10|unique:etudiants,cin',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'niveau' => 'required|string|in:Bac,Licence,Master,Doctorat',
    ]);

    // Gestion de l'image
    $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }
        $user = User::create([
            'nom' => $request->nom . ' ' . $request->prenom,
            'email' => $request->email,
            'password' => $hashedPassword,
            'role' => 'etudiant',
        ]);

    // Création de l'étudiant
    $etudiant = Etudiant::create([
        'user_id' => $user->id,
        'nom' => $validatedData['nom'],
        'prenom' => $validatedData['prenom'],
        'email' => $validatedData['email'],
        'adresse' => $validatedData['adresse'],
        'telephone' => $validatedData['telephone'],
        'date_naissance' => $validatedData['date_naissance'],
        'cin' => $validatedData['cin'],
        'niveau' => $validatedData['niveau'],
        'image' => $validatedData['image'] ?? null,
    ]);

    // Création de l'utilisateur associé
    $user = User::create([
        'name' => $validatedData['nom'] . ' ' . $validatedData['prenom'],
        'email' => $validatedData['email'],
        'password' => Hash::make($password),
        'role' => 'etudiant',
    ]);



    Mail::to($etudiant->email)->send(new EtudiantRegistered($etudiant, $password));

    return redirect()->route('admin.etudiants.index')->with('success', 'Étudiant ajouté avec succès.');
}

    // Afficher les détails d'un étudiant
    public function show(Etudiant $etudiant)
    {
        return view('admin.etudiants.show', compact('etudiant'));
    }

    // Afficher le formulaire de modification
    public function edit($id)
    {
        $etudiant = Etudiant::findOrFail($id);
        return view('admin.etudiants.edit', compact('etudiant'));
    }

    // Mettre à jour un étudiant
    public function update(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $etudiant = Etudiant::findOrFail($id);
        $etudiant->update([
            'nom' => $request->nom,
            'email' => $request->email,
        ]);

        // Mettre aussi à jour les infos de l'utilisateur
        $etudiant->user->update([
            'name' => $request->nom,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.etudiants.index')->with('success', 'Étudiant mis à jour avec succès');
    }

    // Supprimer un étudiant
    public function destroy($id)
    {
        $etudiant = Etudiant::findOrFail($id);

        // Supprimer l'utilisateur lié avant l'étudiant
        if ($etudiant->user) {
            $etudiant->user->delete();
        }

        $etudiant->delete();

        return redirect()->route('admin.etudiants.index')->with('success', 'Étudiant supprimé avec succès');
    }

    public function absences(Etudiant $etudiant)
    {
        $absences = $etudiant->absences; // Supposons que vous avez une relation `absences` dans le modèle Etudiant
        return view('admin.etudiants.absences', compact('etudiant', 'absences'));
    }

    public function showAbsences($etudiantId)
    {
        // Récupérer l'étudiant avec ses absences
        $etudiant = Etudiant::with('absences')->findOrFail($etudiantId);

        // Passer les données à la vue
        return view('admin.etudiants.absences', compact('etudiant'));
    }
    // Ajouter une absence pour un étudiant
    public function addAbsence(Request $request, Etudiant $etudiant)
    {
        $request->validate([
            'date' => 'required|date',
            'justifiee' => 'required|boolean',
        ]);

        // Ajouter l'absence à l'étudiant
        $etudiant->absences()->create([
            'date' => $request->date,
            'justifiee' => $request->justifiee,
        ]);

        return redirect()->route('admin.etudiants.absences', $etudiant->id)->with('success', 'Absence ajoutée avec succès.');
    }

    // Supprimer une absence
    public function deleteAbsence($absenceId)
    {
        $absence = Absence::findOrFail($absenceId);
        $absence->delete();
        return redirect()->back()->with('success', 'Absence supprimée avec succès.');
    }
}
