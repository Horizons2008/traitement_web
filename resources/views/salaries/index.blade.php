@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Salary Calculation Results for {{ $month }}</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Net Salary</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($results as $result)
                        <tr>
                            <td>{{ $result['employee'] }}</td>
                            <td>{{ number_format($result['net_salary'], 2) }}</td>
                            <td>
                                <a href="{{ route('salaries.show', $result['salary_id']) }}" 
                                   class="btn btn-sm btn-info">
                                   View Details
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="table-primary">
                            <th>Total Employees</th>
                            <td colspan="2">{{ count($results) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('salaries.index') }}" class="btn btn-secondary">
                Back to Salary List
            </a>
            <a href="#" class="btn btn-success" onclick="window.print()">
                Print Report
            </a>
        </div>
    </div>
</div>
@endsection