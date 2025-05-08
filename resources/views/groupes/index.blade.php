@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Groupe List</h1>

    

    <a href="{{ route('primes.create') }}" class="btn btn-primary mb-3">Ajouter Nouveau Groupe</a>
    
    <table class="table table-bordered">
        
        <thead>
            <tr>
                
                    <th>ID</th>
                    <th>Titre</th>
                    <th>Abréviation</th>
                    
                    <th>Actions</th>
                
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse ($positions as $position)
            <tr>
                <td >{{ $position->id }}</td>
                <td >{{ $position->title }}</td>
                <td >{{ $position->abrv }}</td>
                <td >{{ $position->cat }}</td>
                <td >
                    <a href="{{ route('groupes.edit', $position->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                        <i class="fas fa-edit"></i> Modifier
                    </a>
                    <form action="{{ route('groupes.destroy', $position->id) }}" method="POST" class="inline">
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
                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">Aucun groupe trouvée</td>
            </tr>
            @endforelse
        </tbody>
        
    </table>
</div>
@endsection














