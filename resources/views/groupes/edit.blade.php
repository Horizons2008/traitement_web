@extends('layouts.dashboard')

@section('title', 'Modifier une Fonction')

@section('content')
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Modifier la Fonction</h2>
        
        <form method="POST" action="{{ route('positions.update', $position->id) }}">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Titre</label>
                <input type="text" name="title" id="title" value="{{ $position->title }}" required
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            
            <div class="mb-4">
                <label for="abrv" class="block text-gray-700 text-sm font-bold mb-2">Abréviation</label>
                <input type="text" name="abrv" id="abrv" value="{{ $position->abrv }}" required maxlength="10"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            
            <div class="mb-4">
                <label for="cat" class="block text-gray-700 text-sm font-bold mb-2">Catégorie</label>
                <input type="number" name="cat" id="cat" value="{{ $position->cat }}" required
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Mettre à jour
                </button>
                <a href="{{ route('fonctions.index') }}" class="text-gray-600 hover:text-gray-800">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection