<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enseignant;
use App\Models\Module;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\EnseignantRegistered;


class EnseignantController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sort = $request->input('sort', 'nom');

        $query = Enseignant::with('module')
            ->select('enseignants.*')
            ->when($search, function ($query, $search) {
                $query->where('nom', 'like', "%{$search}%")
                      ->orWhere('prenom', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
            })
            ->orderBy($sort);

        $enseignants = $query->paginate(10);




        return view('admin.enseignants.index', compact('enseignants', 'search', 'sort'));
    }

    public function create()
    {
        $modules = Module::all();
        return view('admin.enseignants.create', compact('modules'));
    }

    public function store(Request $request)
    {
        // Génération d’un mot de passe aléatoire
        $password = Str::random(8);
        $hashedPassword = Hash::make($password);

        // Validation du formulaire
        $request->validate([
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'photo' => 'nullable|image',
            'id_module' => "required",
        ]);

        // Traitement de la photo
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
        }
        $user = User::create([
            'email' => $request->email,
            'password' => $hashedPassword,
            'role' => 'enseignant',

            'nom' => $request->nom,
        ]);

        // Création de l’enseignant
        $enseignant = Enseignant::create([
            'user_id' => $user->id,
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'photo' => $photoPath,
            'password' => $hashedPassword,
            'module_id' => $request->id_module,
        ]);

        // Création de l'utilisateur lié


        // Associer les modules si fournis
        if ($request->filled('module')) {
            $enseignant->module()->attach($request->module);
        }

        // Envoi de l'email avec les identifiants
        Mail::to($enseignant->email)->send(new EnseignantRegistered($enseignant, $password));

        return redirect()->route('admin.enseignants.index')->with('success', 'Enseignant ajouté avec succès.');
    }

    public function edit($id)
    {
        $enseignant = Enseignant::with('module')->findOrFail($id);
        $module = Module::all();
        return view('admin.enseignants.edit', compact('enseignant', 'module'));
    }

    public function update(Request $request, Enseignant $enseignant)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:enseignants,email,' . $enseignant->id,
            'module_id' => "required",
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('photo')) {
            if ($enseignant->photo) {
                Storage::disk('public')->delete($enseignant->photo);
            }
            $photoPath = $request->file('photo')->store('photos', 'public');
            $enseignant->photo = $photoPath;
        }

        $enseignant->update([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'module_id' => $request->module_id,

        ]);



        return redirect()->route('admin.enseignants.index')->with('success', 'Enseignant mis à jour avec succès.');
    }

    public function destroy(Enseignant $enseignant)
    {

        $enseignant->delete();

        return redirect()->route('admin.enseignants.index')->with('success', 'Enseignant supprimé avec succès.');
    }
}
