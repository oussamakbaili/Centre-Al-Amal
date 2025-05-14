@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-6">Liste des Modules</h1>
    
    <div class="bg-white shadow-md rounded my-6">
        <table class="min-w-full">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($modules as $module)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $module->nom }}</td>
                    <td class="px-6 py-4">{{ $module->description }}</td>
                    
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('admin.modules.edit', $module->id) }}" class="text-blue-600 hover:text-blue-900 mr-2">Modifier</a>
                        <form action="{{ route('admin.modules.destroy', $module->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Supprimer</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
