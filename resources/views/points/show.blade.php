@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        Point Details
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">ID</dt>
            <dd class="col-sm-9">{{ $point->id }}</dd>

            <dt class="col-sm-3">Category</dt>
            <dd class="col-sm-9">{{ $point->formatted_cat }}</dd>

            <dt class="col-sm-3">Echelon</dt>
            <dd class="col-sm-9">{{ $point->formatted_echelon }}</dd>

            <dt class="col-sm-3">Value</dt>
            <dd class="col-sm-9"><span class="badge bg-primary">{{ $point->valeur }}</span></dd>
        </dl>
    </div>
    <div class="card-footer text-end">
        <a href="{{ route('points.index') }}" class="btn btn-secondary">Back</a>
        <a href="{{ route('points.edit', $point->id) }}" class="btn btn-primary">Edit</a>
    </div>
</div>
@endsection