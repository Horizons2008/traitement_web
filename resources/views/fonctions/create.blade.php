@extends('layouts.dashboard')

@section('title', 'Créer une Fonction')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">Créer une Nouvelle Fonction</h2>
    </div>

    @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-400"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">
                        Une erreur est survenue
                    </h3>
                    <div class="mt-2 text-sm text-red-700">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <form method="POST" action="{{ route('fonctions.store') }}" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Title Field -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Titre</label>
                <input type="text" 
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('title') border-red-500 @enderror" 
                       id="title" 
                       name="title" 
                       value="{{ old('title') }}" 
                       required>
                @error('title')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Abbreviation Field -->
            <div>
                <label for="abrv" class="block text-sm font-medium text-gray-700 mb-1">Abréviation</label>
                <input type="text" 
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('abrv') border-red-500 @enderror" 
                       id="abrv" 
                       name="abrv" 
                       value="{{ old('abrv') }}" 
                       required>
                @error('abrv')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category Field -->
            <div>
                <label for="cat" class="block text-sm font-medium text-gray-700 mb-1">Catégorie</label>
                <input type="number" 
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('cat') border-red-500 @enderror" 
                       id="cat" 
                       name="cat" 
                       value="{{ old('cat') }}" 
                       required>
                @error('cat')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Groupe Field -->
            <div>
                <label for="groupe_id" class="block text-sm font-medium text-gray-700 mb-1">Groupe</label>
                <select class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('groupe_id') border-red-500 @enderror" 
                        id="groupe_id" 
                        name="groupe_id">
                    <option value="">-- Sélectionner un Groupe --</option>
                    @foreach($groupes as $groupe)
                        <option value="{{ $groupe->id }}" {{ old('groupe_id') == $groupe->id ? 'selected' : '' }}>
                            {{ $groupe->title }}
                        </option>
                    @endforeach
                </select>
                @error('groupe_id')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end space-x-4">
            <a href="{{ route('fonctions.index') }}" 
               class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-200">
                Annuler
            </a>
            <button type="submit" 
                    class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-200">
                Créer la Fonction
            </button>
        </div>
    </form>
</div>
@endsection