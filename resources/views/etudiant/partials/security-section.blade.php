<div class="relative">
    <button id="securityDropdownButton" class="flex items-center space-x-2 text-gray-700 hover:text-gray-900 focus:outline-none">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
        </svg>
        <span>Sécurité</span>
    </button>

    <div id="securityDropdown" class="hidden absolute right-0 mt-2 w-64 bg-white rounded-md shadow-lg z-10">
        <div class="p-4">
            <h4 class="font-medium text-gray-800 mb-2">Changer le mot de passe</h4>
            <form action="{{ route('etudiant.profile.password') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="current_password" class="block text-sm text-gray-600">Mot de passe actuel</label>
                    <input type="password" name="current_password" id="current_password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="block text-sm text-gray-600">Nouveau mot de passe</label>
                    <input type="password" name="password" id="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                </div>
                <div class="mb-4">
                    <label for="password_confirmation" class="block text-sm text-gray-600">Confirmer le mot de passe</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Mettre à jour
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('securityDropdownButton').addEventListener('click', function() {
        document.getElementById('securityDropdown').classList.toggle('hidden');
    });

    // Fermer le dropdown quand on clique ailleurs
    window.addEventListener('click', function(e) {
        if (!document.getElementById('securityDropdown').contains(e.target) &&
            !document.getElementById('securityDropdownButton').contains(e.target)) {
            document.getElementById('securityDropdown').classList.add('hidden');
        }
    });
</script>
