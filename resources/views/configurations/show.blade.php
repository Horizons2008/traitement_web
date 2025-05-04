@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        Prime Details
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">Title</dt>
            <dd class="col-sm-9">{{ $prime->title }}</dd>

            <dt class="col-sm-3">Abbreviation</dt>
            <dd class="col-sm-9"><span class="badge bg-secondary">{{ $prime->abrv }}</span></dd>

            <dt class="col-sm-3">Groupe</dt>
            <dd class="col-sm-9">{{ $prime->groupe->title }}</dd>

            <dt class="col-sm-3">Category Range</dt>
            <dd class="col-sm-9">{{ $prime->category_range }}</dd>
        </dl>
    </div>
    <div class="card-footer text-end">
        <a href="{{ route('primes.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
        <a href="{{ route('primes.edit', $prime->id) }}" class="btn btn-primary">
            <i class="fas fa-edit"></i> Edit
        </a>
    </div>
</div>
@endsection