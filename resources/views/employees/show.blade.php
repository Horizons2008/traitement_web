@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Employee Details</h1>
    
    <div class="card">
        <div class="card-header">
            <h3>{{ $employee->full_name }} / {{ $employee->full_name_ar }}</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h4>Personal Information</h4>
                    <p><strong>Mobile:</strong> {{ $employee->mobile }}</p>
                    <p><strong>Date of Birth:</strong> {{ $employee->ddn->format('d/m/Y') }}</p>
                    <p><strong>Place of Birth:</strong> {{ $employee->ldn }}</p>
                    <p><strong>Family Situation:</strong> {{ $employee->family_situation }}</p>
                    @if($employee->sit_famill != 0)
                        <p><strong>Number of Children:</strong> {{ $employee->nbrEnfant }}</p>
                        @if($employee->nbrEnfant > 0)
                            <p><strong>Plus 10:</strong> {{ $employee->Plus10 ? 'Yes' : 'No' }}</p>
                        @endif
                    @endif
                    <p><strong>Endicape:</strong> {{ $employee->endicape ? 'Yes' : 'No' }}</p>
                </div>
                
                <div class="col-md-6">
                    <h4>Professional Information</h4>
                    <p><strong>CCP Date:</strong> {{ $employee->ccp->format('d/m/Y') }}</p>
                    <p><strong>Recruitment Date:</strong> {{ $employee->dateRecrut->format('d/m/Y') }}</p>
                    <p><strong>Last Graduation Date:</strong> {{ $employee->lastGraduation->format('d/m/Y') }}</p>
                    <p><strong>Category:</strong> {{ $employee->cat }}</p>
                    <p><strong>Echelon:</strong> {{ $employee->echelon }}</p>
                    <p><strong>Years of Experience:</strong> {{ $employee->nbrAnneeExperience }}</p>
                    <p><strong>Groupe:</strong> {{ $employee->groupe->title ?? 'N/A' }}</p>
                    <p><strong>Fonction:</strong> {{ $employee->fonction->title ?? 'N/A' }}</p>
                    
                    <h5 class="mt-3">Primes</h5>
                    <ul>
                        @forelse($employee->primes as $prime)
                            <li>{{ $prime->title }} ({{ $prime->abrv }}) - {{ $prime->category_range }}</li>
                        @empty
                            <li>No primes assigned</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('employees.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>
</div>
@endsection