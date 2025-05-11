@extends('layouts.dashboard')

@section('title', 'Configurations')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Configurations pour la Prime: {{ $prime->title }}</h1>
        <div class="flex space-x-4">
            <a href="{{ route('primes.index') }}" class="text-gray-600 hover:text-gray-900">
                <i class="fas fa-arrow-left mr-2"></i>Retour aux Primes
            </a>
            <a href="{{ route('primes.configurations.create', ['prime' => $prime->id]) }}" 
               class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md transition duration-200">
                <i class="fas fa-plus mr-2"></i>Nouvelle Configuration
            </a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Plage de Catégories</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Valeur</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($configurations as $config)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $config->category_range }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $config->valeur }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ route('primes.configurations.edit', ['prime' => $prime->id, 'configuration' => $config->id]) }}" 
                           class="text-blue-600 hover:text-blue-900 mr-3">
                            <i class="fas fa-edit"></i> Modifier
                        </a>
                        <form action="{{ route('primes.configurations.destroy', ['prime' => $prime->id, 'configuration' => $config->id]) }}" 
                              method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="text-red-600 hover:text-red-900" 
                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette configuration?')">
                                <i class="fas fa-trash"></i> Supprimer
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">
                        Aucune configuration trouvée
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection