@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ isset($configuration) ? 'Edit' : 'Add' }} Configuration for Prime: {{ $prime->title }}</h1>
    
    @if($errors->has('unique'))
    <div class="alert alert-danger">
        {{ $errors->first('unique') }}
    </div>
    @endif
    
    <form action="{{ isset($configuration) 
        ? route('primes.configurations.update', ['prime' => $prime->id, 'configuration' => $configuration->id]) 
        : route('primes.configurations.store', ['prime' => $prime->id]) }}" method="POST">
        @csrf
        @if(isset($configuration))
            @method('PUT')
        @endif
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="min_cat">Minimum Category</label>
                    <input type="number" class="form-control" id="min_cat" name="min_cat" 
                           value="{{ old('min_cat', $configuration->min_cat ?? '') }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="max_cat">Maximum Category</label>
                    <input type="number" class="form-control" id="max_cat" name="max_cat" 
                           value="{{ old('max_cat', $configuration->max_cat ?? '') }}">
                </div>
            </div>
        </div>
        
        <div class="form-group">
            <label for="valeur">Valeur</label>
            <input type="number" class="form-control" id="valeur" name="valeur" 
                   value="{{ old('valeur', $configuration->valeur ?? '') }}" required>
        </div>
        
        <button type="submit" class="btn btn-primary">
            {{ isset($configuration) ? 'Update' : 'Create' }} Configuration
        </button>
        <a href="{{ route('primes.configurations.index', ['prime' => $prime->id]) }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection