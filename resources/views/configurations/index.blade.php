@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Configurations for Prime: {{ $prime->title }}</h3>
       
       
        <a href="{{ route('primes.configurations.create', ['prime' => $prime->id]) }}" class="btn btn-primary">
            Add New Configuration
        </a>
    </div>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Category Range</th>
                <th>Valeur</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($configurations as $config)
            <tr>
                <td>{{ $config->category_range }}</td>
                <td>{{ $config->valeur }}</td>
                <td>
                    <a href="{{ route('primes.configurations.edit', ['prime' => $prime->id, 'configuration' => $config->id]) }}" 
                       class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('primes.configurations.destroy', ['prime' => $prime->id, 'configuration' => $config->id]) }}" 
                          method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" 
                                onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <a href="{{ route('primes.index') }}" class="btn btn-secondary">Back to Primes</a>
</div>
@endsection