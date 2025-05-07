@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Primes List</h1>

    <form action="{{ route('primes.index') }}" method="GET" class="mt-4">
        @csrf
       
<div class="col-md-6">
        <label for="groupe_id" class="form-label">Groupe *</label>
        <select class="form-select" id="groupe_id" name="groupe_id" required>
            <option value="">-- Select Groupe --</option>
            @foreach($groupes as $groupe)
                <option value="{{ $groupe->id }}"  {{ request('groupe_id') == $groupe->id ? 'selected' : '' }}>
                   
                   
                    {{ $groupe->title }}
                </option>
            @endforeach
        </select>
    </div>
        <button type="submit" class="btn btn-lg btn-success w-100">
            <i class="fas fa-calculator"></i> Filtrer
        </button>
    </form>

    <a href="{{ route('primes.create') }}" class="btn btn-primary mb-3">Add New Prime</a>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                
                    <th>Title</th>
                    <th>Abbreviation</th>
                    <th>Groupe</th>
                    <th>Mode</th>
                    <th>Configurations</th> <!-- New Column -->
                    <th>Actions</th>
                
            </tr>
        </thead>
        <tbody>
            @foreach($primes as $prime)
            <tr>
                <td>{{ $prime->title }}</td>
                <td>{{ $prime->abrv }}</td>
                <td>{{ $prime->groupe->title ?? 'N/A' }}</td>
                <td>{{ $prime->mode }}</td>
                <td>

                    <a href="{{ route('primes.configurations.index', ['prime' => $prime->id]) }}" 
                        class="btn btn-sm btn-info">
                        {{ $prime->configurations_count }} Configs
                    </a>


                </td>
                
                <td>
                    <a href="{{ route('employees.show', $prime->id) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('employees.edit', $prime->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('employees.destroy', $prime->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                    
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection







