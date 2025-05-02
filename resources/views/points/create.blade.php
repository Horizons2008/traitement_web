@php
    $isEdit = isset($point);
    $title = $isEdit ? 'Edit Point' : 'Create Point';
    $route = $isEdit ? route('points.update', $point->id) : route('points.store');
    $method = $isEdit ? 'PUT' : 'POST';
@endphp

@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        {{ $title }}
    </div>
    <div class="card-body">
        <form method="POST" action="{{ $route }}">
            @csrf
            @method($method)

            <div class="mb-3">
                <label for="cat" class="form-label">Category</label>
                <input type="number" class="form-control" id="cat" name="cat" 
                       value="{{ old('cat', $point->cat ?? '') }}" min="1" required>
            </div>

            <div class="mb-3">
                <label for="echelon" class="form-label">Echelon</label>
                <input type="number" class="form-control" id="echelon" name="echelon" 
                       value="{{ old('echelon', $point->echelon ?? '') }}" min="1" required>
            </div>

            <div class="mb-3">
                <label for="valeur" class="form-label">Value</label>
                <input type="number" class="form-control" id="valeur" name="valeur" 
                       value="{{ old('valeur', $point->valeur ?? '') }}" min="0" required>
            </div>

            <button type="submit" class="btn btn-primary">
                {{ $isEdit ? 'Update' : 'Create' }}
            </button>
            <a href="{{ route('points.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection