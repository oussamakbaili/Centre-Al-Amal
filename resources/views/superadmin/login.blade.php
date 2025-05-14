<form method="POST" action="{{ route('superadmin.login') }}">
    @csrf

    <div>
        <label for="email">Email</label>
        <input type="email" name="email" required value="{{ old('email') }}">
        @error('email') <span>{{ $message }}</span> @enderror
    </div>

    <div>
        <label for="password">Mot de passe</label>
        <input type="password" name="password" required>
        @error('password') <span>{{ $message }}</span> @enderror
    </div>

    <button type="submit">Se connecter</button>

    @if ($errors->any())
        <div>
            <strong>{{ $errors->first() }}</strong>
        </div>
    @endif
</form>
