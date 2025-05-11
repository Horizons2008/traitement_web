@extends('layouts.dashboard')

@section('title', 'Gestion des Fonctions')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">Liste des Fonctions</h2>
        <a href="{{ route('fonctions.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md transition duration-200">
            <i class="fas fa-plus mr-2"></i>Ajouter
        </a>
    </div>

    <!-- Search Form -->
    <form method="GET" action="{{ route('fonctions.index') }}" class="mb-6">
        <div class="flex gap-4">
            <div class="flex-1">
                <input type="text" name="search" value="{{ $search }}" placeholder="Rechercher..." 
                       class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 w-full">
            </div>
            <div class="w-64">
                <select name="groupe_id" class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 w-full">
                    <option value="">Tous les groupes</option>
                    @foreach($groupes as $groupe)
                        <option value="{{ $groupe->id }}" {{ $groupeId == $groupe->id ? 'selected' : '' }}>
                            {{ $groupe->title }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </form>

    <!-- Positions Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Titre</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Abréviation</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Catégorie</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Groupe</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($fonctions as $fonction)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $fonction->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $fonction->title }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $fonction->abrv }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $fonction->cat }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $fonction->groupe->title ?? 'None' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ route('fonctions.edit', $fonction->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                            <i class="fas fa-edit"></i> Modifier
                        </a>
                        <form action="{{ route('fonctions.destroy', $fonction->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette fonction?')">
                                <i class="fas fa-trash"></i> Supprimer
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">Aucune fonction trouvée</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $fonctions->links() }}
    </div>
</div>
@endsection