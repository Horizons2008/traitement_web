
@extends('layouts.app')



@section('content')
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Modifier Groupe</h2>
        
        <form method="POST" action="{{ route('groupes.update', $groupe->id) }}">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Titre</label>
                <input type="text" name="title" id="title" value="{{ $groupe->title }}" required
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            
            
            
            
            
            <div class="flex items-center justify-between">
                <button type="submit" class="btn btn-primary">
                    Mettre à jour
                </button>
                <a href="{{ route('groupes.index') }}" class="btn btn-secondary">
                    Annuler
                </a>
            </div>
           
        </form>
    </div>
</div>
@endsection


