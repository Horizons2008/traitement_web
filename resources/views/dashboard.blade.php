@extends('layouts.dashboard')
@extends('layouts.app')

@section('title', 'Tableau de Bord')

@section('content')
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-6">
        <h3 class="text-lg font-medium text-gray-900">Bienvenue dans votre système de gestion de paie</h3>
        <p class="mt-1 text-sm text-gray-600">Utilisez le menu de gauche pour naviguer entre les différentes sections.</p>
        
        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Stats Cards -->
            <div class="bg-blue-50 p-4 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-users text-blue-600 text-2xl mr-3"></i>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Employés</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $employeeCount ?? 0 }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-green-50 p-4 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-briefcase text-green-600 text-2xl mr-3"></i>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Fonctions</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $positionCount ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <a href="{{ route('fonctions.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-700 hover:text-white">
                <i class="fas fa-briefcase mr-2"></i> Fonctions
            </a>
            
            <div class="bg-yellow-50 p-4 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-gift text-yellow-600 text-2xl mr-3"></i>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Primes</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $bonusCount ?? 0 }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-purple-50 p-4 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-money-check-alt text-purple-600 text-2xl mr-3"></i>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Salaires</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $salaryCount ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection