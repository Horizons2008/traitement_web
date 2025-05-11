@extends('layouts.dashboard')

@section('title', 'Gestion des Primes')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">Liste des Primes</h2>
        <a href="{{ route('primes.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md transition duration-200">
            <i class="fas fa-plus mr-2"></i>Ajouter
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Search Form -->
    <form method="GET" action="{{ route('primes.index') }}" class="mb-6">
        <div class="flex gap-4">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher..." 
                       class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 w-full">
            </div>
            <div class="w-64">
                <select name="groupe_id" class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 w-full">
                    <option value="">Tous les groupes</option>
                    @foreach($groupes as $groupe)
                        <option value="{{ $groupe->id }}" {{ request('groupe_id') == $groupe->id ? 'selected' : '' }}>
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

    <!-- Primes Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Titre</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Abréviation</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Groupe</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mode</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Configurations</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($primes as $prime)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $prime->title }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $prime->abrv }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $prime->groupe->title ?? 'N/A' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        @switch($prime->mode)
                            @case(0)
                                Pourcentage
                                @break
                            @case(1)
                                Point
                                @break
                            @case(2)
                                Valeur
                                @break
                            @default
                                N/A
                        @endswitch
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <a href="{{ route('primes.configurations.index', ['prime' => $prime->id]) }}" 
                           class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            {{ $prime->configurations_count }} Configs
                        </a>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ route('primes.show', $prime->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('primes.edit', $prime->id) }}" class="text-yellow-600 hover:text-yellow-900 mr-3">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('primes.destroy', $prime->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette prime?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">Aucune prime trouvée</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $primes->links() }}
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add confirmation dialog for delete forms
        const deleteForms = document.querySelectorAll('form[action*="destroy"]');
        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                if (!confirm('Êtes-vous sûr de vouloir supprimer cette prime?')) {
                    e.preventDefault();
                }
            });
        });
    });
</script>
@endpush
@endsection







