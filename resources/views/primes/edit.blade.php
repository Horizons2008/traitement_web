@php
    $isEdit = isset($prime);
    $title = $isEdit ? 'Modifier Prime' : 'Créer Prime';
    $route = $isEdit ? route('primes.update', $prime->id) : route('primes.store');
    $method = $isEdit ? 'PUT' : 'POST';
@endphp

@extends('layouts.dashboard')

@section('title', $title)

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">{{ $title }}</h2>
        <a href="{{ route('primes.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md transition duration-200">
            <i class="fas fa-arrow-left mr-2"></i>Retour
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

    <form method="POST" action="{{ $route }}" class="space-y-6">
        @csrf
        @method($method)

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Titre *</label>
                <input type="text" name="title" id="title" 
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('title') border-red-500 @enderror"
                       value="{{ old('title', $prime->title ?? '') }}" required>
                @error('title')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="abrv" class="block text-sm font-medium text-gray-700 mb-1">Abréviation *</label>
                <input type="text" name="abrv" id="abrv" 
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('abrv') border-red-500 @enderror"
                       value="{{ old('abrv', $prime->abrv ?? '') }}" required maxlength="10">
                @error('abrv')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="groupe_id" class="block text-sm font-medium text-gray-700 mb-1">Groupe *</label>
                <select name="groupe_id" id="groupe_id" 
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('groupe_id') border-red-500 @enderror" required>
                    <option value="">-- Sélectionner Groupe --</option>
                    @foreach($groupes as $groupe)
                        <option value="{{ $groupe->id }}"
                            {{ (old('groupe_id', $prime->groupe_id ?? '') == $groupe->id) ? 'selected' : '' }}>
                            {{ $groupe->title }}
                        </option>
                    @endforeach
                </select>
                @error('groupe_id')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="mode" class="block text-sm font-medium text-gray-700 mb-1">Mode *</label>
                <select name="mode" id="mode" 
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('mode') border-red-500 @enderror" required>
                    <option value="">Sélectionner Mode</option>
                    <option value="0" {{ old('mode', $prime->mode ?? '') == '0' ? 'selected' : '' }}>Pourcentage</option>
                    <option value="1" {{ old('mode', $prime->mode ?? '') == '1' ? 'selected' : '' }}>Point</option>
                    <option value="2" {{ old('mode', $prime->mode ?? '') == '2' ? 'selected' : '' }}>Valeur</option>
                </select>
                @error('mode')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="min_cat" class="block text-sm font-medium text-gray-700 mb-1">Catégorie Min</label>
                <input type="number" name="min_cat" id="min_cat" 
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('min_cat') border-red-500 @enderror"
                       value="{{ old('min_cat', $prime->min_cat ?? '') }}" min="1">
                @error('min_cat')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="max_cat" class="block text-sm font-medium text-gray-700 mb-1">Catégorie Max</label>
                <input type="number" name="max_cat" id="max_cat" 
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('max_cat') border-red-500 @enderror"
                       value="{{ old('max_cat', $prime->max_cat ?? '') }}" min="1">
                @error('max_cat')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex justify-end space-x-4">
            <a href="{{ route('primes.index') }}" 
               class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-200">
                Annuler
            </a>
            <button type="submit" 
                    class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-200">
                <i class="fas fa-save mr-2"></i>{{ $isEdit ? 'Mettre à jour' : 'Créer' }}
            </button>
        </div>
    </form>
</div>
@endsection