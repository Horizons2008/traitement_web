@php
    $isEdit = isset($prime);
    $title = $isEdit ? 'Edit Prime' : 'Create Prime';
    $route = $isEdit ? route('primes.update', $prime->id) : route('primes.store');
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

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="title" class="form-label">Title *</label>
                    <input type="text" class="form-control" id="title" name="title" 
                           value="{{ old('title', $prime->title ?? '') }}" required>
                </div>
                
                <div class="col-md-6">
                    <label for="abrv" class="form-label">Abbreviation *</label>
                    <input type="text" class="form-control" id="abrv" name="abrv" 
                           value="{{ old('abrv', $prime->abrv ?? '') }}" required maxlength="10">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="groupe_id" class="form-label">Groupe *</label>
                    <select class="form-select" id="groupe_id" name="groupe_id" required>
                        <option value="">-- Select Groupe --</option>
                        @foreach($groupes as $groupe)
                            <option value="{{ $groupe->id }}"
                                {{ (old('groupe_id', $prime->groupe_id ?? '') == $groupe->id) ? 'selected' : '' }}>
                                {{ $groupe->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-3">
                    <label for="min_cat" class="form-label">Min Category</label>
                    <input type="number" class="form-control" id="min_cat" name="min_cat" 
                           value="{{ old('min_cat', $prime->min_cat ?? '') }}" min="1">
                </div>
                
                <div class="col-md-3">
                    <label for="max_cat" class="form-label">Max Category</label>
                    <input type="number" class="form-control" id="max_cat" name="max_cat" 
                           value="{{ old('max_cat', $prime->max_cat ?? '') }}" min="1">
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('primes.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    {{ $isEdit ? 'Update' : 'Create' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection