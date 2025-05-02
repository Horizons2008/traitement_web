@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Employees List</h1>
    <a href="{{ route('employees.create') }}" class="btn btn-primary mb-3">Add New Employee</a>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Full Name (FR)</th>
                <th>Full Name (AR)</th>
                <th>Mobile</th>
                <th>Fonction</th>
                <th>Groupe</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($employees as $employee)
            <tr>
                <td>{{ $employee->id }}</td>
                <td>{{ $employee->full_name }}</td>
                <td>{{ $employee->full_name_ar }}</td>
                <td>{{ $employee->mobile }}</td>
                <td>{{ $employee->fonction->title ?? 'N/A' }}</td>
                <td>{{ $employee->groupe->title ?? 'N/A' }}</td>
                <td>
                    <a href="{{ route('employees.show', $employee->id) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" style="display:inline;">
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