
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Mon Profil</h1>
        <p class="text-gray-600">Gérez vos informations personnelles</p>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 bg-blue-600 text-white">
            <h3 class="text-lg font-semibold">Informations personnelles</h3>
        </div>
        <div class="p-6">
            <form action="{{ route('etudiant.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="nom" class="block text-sm font-medium text-gray-700">Nom</label>
                        <input type="text" name="nom" id="nom" value="{{ old('nom', $etudiant->nom) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <label for="prenom" class="block text-sm font-medium text-gray-700">Prénom</label>
                        <input type="text" name="prenom" id="prenom" value="{{ old('prenom', $etudiant->prenom) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <label for="telephone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                        <input type="text" name="telephone" id="telephone" value="{{ old('telephone', $etudiant->telephone) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <label for="date_naissance" class="block text-sm font-medium text-gray-700">Date de naissance</label>
                        <input type="date" name="date_naissance" id="date_naissance" value="{{ old('date_naissance', $etudiant->date_naissance ? $etudiant->date_naissance->format('Y-m-d') : '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <label for="cin" class="block text-sm font-medium text-gray-700">CIN</label>
                        <input type="text" name="cin" id="cin" value="{{ old('cin', $etudiant->cin) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div class="md:col-span-2">
                        <label for="adresse" class="block text-sm font-medium text-gray-700">Adresse</label>
                        <textarea name="adresse" id="adresse" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('adresse', $etudiant->adresse) }}</textarea>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
