@extends('layouts.dashboard')

@section('title', isset($configuration) ? 'Modifier Configuration' : 'Nouvelle Configuration')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">
            {{ isset($configuration) ? 'Modifier Configuration' : 'Nouvelle Configuration' }} - {{ $prime->title }}
        </h1>
        <a href="{{ route('primes.configurations.index', ['prime' => $prime->id]) }}" class="text-gray-600 hover:text-gray-900">
            <i class="fas fa-arrow-left mr-2"></i>Retour
        </a>
    </div>

    @if($errors->has('unique'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ $errors->first('unique') }}</span>
    </div>
    @endif

    <form action="{{ isset($configuration) 
        ? route('primes.configurations.update', ['prime' => $prime->id, 'configuration' => $configuration->id]) 
        : route('primes.configurations.store', ['prime' => $prime->id]) }}" 
        method="POST" class="space-y-6">
        @csrf
        @if(isset($configuration))
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="min_cat" class="block text-sm font-medium text-gray-700 mb-2">Catégorie Minimum</label>
                <input type="number" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('min_cat') border-red-500 @enderror" 
                       id="min_cat" 
                       name="min_cat" 
                       value="{{ old('min_cat', $configuration->min_cat ?? '') }}"
                       required>
                @error('min_cat')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="max_cat" class="block text-sm font-medium text-gray-700 mb-2">Catégorie Maximum</label>
                <input type="number" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('max_cat') border-red-500 @enderror" 
                       id="max_cat" 
                       name="max_cat" 
                       value="{{ old('max_cat', $configuration->max_cat ?? '') }}"
                       required>
                @error('max_cat')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label for="valeur" class="block text-sm font-medium text-gray-700 mb-2">Valeur</label>
            <input type="number" 
                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('valeur') border-red-500 @enderror" 
                   id="valeur" 
                   name="valeur" 
                   value="{{ old('valeur', $configuration->valeur ?? '') }}"
                   required>
            @error('valeur')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end space-x-4">
            <a href="{{ route('primes.configurations.index', ['prime' => $prime->id]) }}" 
               class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Annuler
            </a>
            <button type="submit" 
                    class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                {{ isset($configuration) ? 'Mettre à jour' : 'Créer' }}
            </button>
        </div>
    </form>
</div>
@endsection