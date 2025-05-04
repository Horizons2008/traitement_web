@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">Detailed Salary Report - {{ $month }}</h3>
        </div>
        
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>Employee</th>
                            <th class="text-center">Point Cat</th>
                            <th class="text-center">Mont Cat</th>
                            <th class="text-center">Point Echelon</th>
                            <th class="text-center">Mont Echelon</th>
                            <th class="text-center">Base Salary</th>
                            <th class="text-center">Total Primes</th>
                            <th class="text-center">Gross Salary</th>
                            <th class="text-center">Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($results as $result)
                        <tr>
                            <td>{{ $result['employee']->full_name }}</td>
                            <!-- ... other columns ... -->
                            <td class="text-center">
                                <button class="btn btn-sm btn-info" type="button" data-bs-toggle="collapse" 
                                    data-bs-target="#details-{{ $result['employee']->id }}">
                                    <i class="fas fa-list"></i> Show All Primes
                                </button>
                            </td>
                        </tr>
                        <tr class="collapse" id="details-{{ $result['employee']->id }}">
                            <td colspan="9">
                                <div class="p-3 bg-light">
                                    <h5>All Primes Calculation for {{ $result['employee']->full_name }}</h5>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <strong>Total Applicable Primes:</strong> 
                                            {{ count(array_filter($result['prime_details'], fn($p) => $p['applied'])) }}
                                        </div>
                                        <div class="col-md-4">
                                            <strong>Total Non-Applicable Primes:</strong> 
                                            {{ count(array_filter($result['prime_details'], fn($p) => !$p['applied'])) }}
                                        </div>
                                        <div class="col-md-4">
                                            <strong>Base Salary:</strong> 
                                            {{ number_format($result['salary']->sal_base, 2) }}
                                        </div>
                                    </div>
                                    
                                    <table class="table table-bordered">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>Prime Name</th>
                                                <th>Category Range</th>
                                                <th>Percentage</th>
                                                <th>Calculation</th>
                                                <th class="text-end">Amount</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($result['prime_details'] as $prime)
                                            <tr class="{{ $prime['applied'] ? 'table-success' : 'table-secondary' }}">
                                                <td>{{ $prime['prime_title'] }}</td>
                                                <td>
                                                    @if($prime['min_cat'] === 'N/A' && $prime['max_cat'] === 'N/A')
                                                        All Categories
                                                    @else
                                                        {{ $prime['min_cat'] }} - {{ $prime['max_cat'] }}
                                                    @endif
                                                </td>
                                                <td class="text-end">{{ $prime['percentage'] }}%</td>
                                                <td>
                                                    @if($prime['applied'])
                                                        <code>{{ $prime['calculation'] }}</code>
                                                    @else
                                                        <span class="text-muted">Not applicable</span>
                                                    @endif
                                                </td>
                                                <td class="text-end">
                                                    {{ number_format($prime['mont_prime'], 2) }}
                                                </td>
                                                <td class="text-center">
                                                    @if($prime['applied'])
                                                        <span class="badge bg-success">Applied</span>
                                                    @else
                                                        <span class="badge bg-secondary">Not Applicable</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr class="table-primary">
                                                <td colspan="4" class="text-end"><strong>Total Primes:</strong></td>
                                                <td class="text-end">{{ number_format($result['salary']->total_primes, 2) }}</td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-primary">
                       
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="card-footer d-flex justify-content-between">
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
            <div>
                <button onclick="window.print()" class="btn btn-success">
                    <i class="fas fa-print"></i> Print Report
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .table thead th {
        vertical-align: middle;
    }
    .collapse td {
        border-top: none;
    }
    @media print {
        .card-footer, .btn {
            display: none !important;
        }
        .collapse {
            display: block !important;
        }
    }
</style>
@endsection