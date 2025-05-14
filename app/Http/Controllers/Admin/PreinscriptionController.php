<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Preinscription;
use App\Models\Etudiant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\EtudiantRegistered;

class PreinscriptionController extends Controller
{
    // Afficher la liste des préinscriptions
    public function index()
    {
        $preinscriptions = Preinscription::all();
        return view('preinscription.index', compact('preinscriptions'));
    }

    // Afficher le formulaire de création
    public function create()
    {
        return view('preinscription.create');
    }

    // Enregistrer une nouvelle préinscription
    public function store(Request $request)
{
    $request->validate([
        'nom' => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        'email' => 'required|email|unique:preinscriptions,email',
        'adresse' => 'required|string|max:255',
        'telephone' => 'required|string|max:20',
        'date_naissance' => 'required|date',
        'cin' => 'required|string|max:10|unique:preinscriptions,cin',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'niveau' => 'required|string|in:Bac,Licence,Master,Doctorat', 
    ]);

    $data = $request->all();

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('preinscriptions', 'public');
        $data['image'] = $imagePath;
    }

    Preinscription::create($data);

    return redirect()->route('login')->with('success', 'Préinscription enregistrée avec succès.');
}


    // Afficher les détails d'une préinscription
    public function show(Preinscription $preinscription)
    {
        return view('admin.preinscriptions.show', compact('preinscription'));
    }

    // Afficher le formulaire de modification
    public function edit(Preinscription $preinscription)
    {
        return view('admin.preinscriptions.edit', compact('preinscription'));
    }

    // Mettre à jour une préinscription
    public function update(Request $request, Preinscription $preinscription)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:preinscriptions,email,' . $preinscription->id,
            'telephone' => 'required|string',
            'filiere' => 'required|string',
        ]);

        $preinscription->update($request->all());
        return redirect()->route('admin.preinscriptions.index')->with('success', 'Préinscription mise à jour avec succès.');
    }

    // Supprimer une préinscription
    public function destroy(Preinscription $preinscription)
    {
        $preinscription->delete();
        return redirect()->route('admin.preinscriptions.index')->with('success', 'Préinscription supprimée avec succès.');
    }
    public function accept($id)
{
    $preinscription = Preinscription::findOrFail($id);

    // Vérifier si un étudiant avec le même email existe déjà
    $existingEtudiant = Etudiant::where('email', $preinscription->email)->first();

    if ($existingEtudiant) {
        // Si l'étudiant existe déjà, vous pouvez choisir de ne pas continuer ou mettre à jour l'étudiant
        return redirect()->route('admin.preinscriptions.index')->with('error', 'Un étudiant avec cet email existe déjà.');
    }

    // Création du mot de passe temporaire
    $password = substr(md5(uniqid()), 0, 8);

    // Ajouter l'étudiant
    $etudiant = new Etudiant();
    $etudiant->user_id = null;
    $etudiant->nom = $preinscription->nom;
    $etudiant->prenom = $preinscription->prenom;
    $etudiant->date_naissance = $preinscription->date_naissance;
    $etudiant->cin = $preinscription->cin;
    $etudiant->adresse = $preinscription->adresse;
    $etudiant->image = $preinscription->image;
    $etudiant->niveau = $preinscription->niveau;
    $etudiant->email = $preinscription->email;
    $etudiant->telephone = $preinscription->telephone;
    $etudiant->password = Hash::make($password); // Hashage du mot de passe
    $etudiant->save();

    // Envoyer un email avec les infos de connexion
    Mail::to($etudiant->email)->send(new EtudiantRegistered($etudiant, $password));

    // Supprimer la préinscription
    $preinscription->delete();

    return redirect()->route('admin.preinscriptions.index')->with('success', 'L\'étudiant a été accepté et ajouté.');
}



    public function reject($id)
    {
        $preinscription = Preinscription::findOrFail($id);
        $preinscription->delete();

        return redirect()->route('admin.preinscriptions.index')->with('success', 'La préinscription a été refusée.');
    }
}