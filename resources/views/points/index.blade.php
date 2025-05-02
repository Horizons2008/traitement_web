@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>Points List</h5>
        <a href="{{ route('points.create') }}" class="btn btn-primary">Add New Point</a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Category</th>
                        <th>Echelon</th>
                        <th>Value</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($points as $point)
                    <tr>
                        <td>{{ $point->id }}</td>
                        <td>{{ $point->cat }}</td>
                        <td>{{ $point->echelon }}</td>
                        <td><span class="badge bg-primary">{{ $point->valeur }}</span></td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('points.show', $point->id) }}" class="btn btn-sm btn-info">View</a>
                                <a href="{{ route('points.edit', $point->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('points.destroy', $point->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection