
<div class="container">
    <h1 class="text-2xl font-bold mb-4">Mes Modules</h1>

    @if($modules->isEmpty())
        <p>Aucun module disponible pour le moment.</p>
    @else
        <ul>
            @foreach($modules as $module)
                <li>{{ $module->nom }}</li>
            @endforeach
        </ul>
    @endif
</div>
