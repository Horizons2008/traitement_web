@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Salary Calculations for {{ $month }}</h2>
    <h1>Employees List</h1>
    <a href="{{ route('employees.create') }}" class="btn btn-primary mb-3">Add New Employee</a>
    <form action="{{ route('calculate-all') }}" method="POST" class="mt-4">
        @csrf
       
<div class="col-md-6">
        <label for="groupe_id" class="form-label">Groupe *</label>
        <select class="form-select" id="groupe_id" name="groupe_id" required>
            <option value="">-- Select Groupe --</option>
            @foreach($groupes as $groupe)
                <option value="{{ $groupe->id }}" {{ $groupe->id == $groupe_id ? 'selected' : '' }}>
                   
                   
                    {{ $groupe->title }}
                </option>
            @endforeach
        </select>
    </div>
        <button type="submit" class="btn btn-lg btn-success w-100">
            <i class="fas fa-calculator"></i> Calculate All Salaries
        </button>
    </form>
    
    

    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <!-- Specified Columns -->
                <th>Name</th>
                <th>Fonction</th>
                <th>Cat</th>
                <th>Point Cat</th>
                <th>Mont Cat</th>
                <th>{{$groupe_id}}</th>
                <th>Point Echelon</th>
                <th>Mont Echelon</th>
                <th>Base Salary</th>
                
                <!-- Prime Columns -->
                @if(isset($results[0]['salary']['prime_details']))
                    @foreach($results[0]['salary']['prime_details'] as $prime)
                        <th>{{ $prime['prime_title'] }}</th>
                    @endforeach
                @endif
                
                <!-- Remaining Columns -->
                <th>Gross Salary</th>
                <th>Assurance</th>
                <th>Net Salary</th>
            </tr>
        </thead>
        <tbody>
            @foreach($results as $result)
                @php
                    $employee = $result['employee'];
                    $salary = $result['salary'];
                    
                    // Create prime amounts map
                    $primeMap = collect($salary['prime_details'])->pluck('mont_prime', 'prime_title');
                @endphp

                <tr>
                    <!-- Employee Info -->
                    <td>{{ $employee->nomAr }} {{ $employee->prenAr
                     }}</td>
                    <td>{{ $employee->fonction->title ?? 'N/A' }}</td>
                    <td>{{ $employee->cat }}</td>
                    <td>{{ $salary['point_cat'] }}</td>
                    <td>{{ number_format($salary['mont_cat'], 2) }}</td>
                    <td>{{ $employee->echelon }}</td>
                    <td>{{ $salary['point_echelon'] }}</td>
                    <td>{{ number_format($salary['mont_echelon'], 2) }}</td>
                    <td>{{ number_format($salary['sal_base'], 2) }}</td>
                    
                    <!-- Primes -->
                    @if(isset($results[0]['salary']['prime_details']))
                        @foreach($results[0]['salary']['prime_details'] as $prime)
                            <td>{{ number_format($primeMap[$prime['prime_title']] ?? 0, 2) }}</td>
                        @endforeach
                    @endif
                    
                    <!-- Salary Calculations -->
                    <td>{{ number_format($salary['sal_brut'], 2) }}</td>
                    <td>{{ number_format($salary['assurance'], 2) }}</td>
                    <td>{{ number_format($salary['net_salary'], 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

<style>
    table th, table td {
        white-space: nowrap;
        text-align: right;
    }
    table td:first-child,
    table td:nth-child(2) {
        text-align: left;
    }
</style>