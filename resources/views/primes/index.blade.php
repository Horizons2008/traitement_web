@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5>Primes List</h5>
        <a href="{{ route('primes.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Prime
        </a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Title</th>
                        <th>Abbreviation</th>
                        <th>Groupe</th>
                        <th>Category Range</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($primes as $prime)
                    <tr>
                        <td>{{ $prime->title }}</td>
                        <td><span class="badge bg-secondary">{{ $prime->abrv }}</span></td>
                        <td>{{ $prime->groupe->title }}</td>
                        <td>{{ $prime->category_range }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('primes.show', $prime->id) }}" class="btn btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('primes.edit', $prime->id) }}" class="btn btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('primes.destroy', $prime->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" 
                                            onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">No primes found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection