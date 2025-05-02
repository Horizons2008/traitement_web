<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payroll Management System</title>
   
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar {
            min-height: 100vh;
        }
        .active {
            background-color: #3b82f6;
            color: white !important;
        }
        .active:hover {
            background-color: #2563eb !important;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex">
        <!-- Sidebar -->
        <div class="sidebar bg-gray-800 text-white w-64 space-y-6 py-7 px-2 fixed inset-y-0 left-0 transform -translate-x-full md:translate-x-0 transition duration-200 ease-in-out">
            <div class="text-white flex items-center space-x-2 px-4">
                <i class="fas fa-money-bill-wave fa-2x"></i>
                <span class="text-2xl font-extrabold">PayrollMS</span>
            </div>
            
            <nav>
                <a href="" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-700 hover:text-white">
                    <i class="fas fa-users mr-2"></i> Employés
                </a>
                <a href="" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-700 hover:text-white">
                    <i class="fas fa-briefcase mr-2"></i> Fonctions
                </a>
                <a href="" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-700 hover:text-white">
                    <i class="fas fa-gift mr-2"></i> Primes
                </a>
                <a href="" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-700 hover:text-white">
                    <i class="fas fa-money-check-alt mr-2"></i> Salaires122
                </a>
                
                <form method="POST" action="{{ route('logout') }}" class="mt-10">
                    @csrf
                    <button type="submit" class="w-full text-left block py-2.5 px-4 rounded transition duration-200 hover:bg-red-600 hover:text-white">
                        <i class="fas fa-sign-out-alt mr-2"></i> Déconnexion
                    </button>
                </form>

                <a href="{{ route('fonctions.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-700 hover:text-white">
                    <i class="fas fa-briefcase mr-2"></i> Fonctions9999
                </a>
                <a href="{{ route('groupes.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-700 hover:text-white">
                    <i class="fas fa-briefcase mr-2"></i> Groupe
                </a>
                <a href="{{ route('points.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-700 hover:text-white">
                    <i class="fas fa-briefcase mr-2"></i> Points Indicieles
                </a>
                <a href="{{ route('primes.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-700 hover:text-white">
                    <i class="fas fa-briefcase mr-2"></i> Primes
                </a>
            </a>
            <a href="{{ route('employees.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-700 hover:text-white">
                <i class="fas fa-briefcase mr-2"></i> Employee
            </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 md:ml-64">
            <!-- Top Navigation -->
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        @yield('title')
                    </h2>
                    <div class="flex items-center">
                        <span class="text-gray-600 mr-2">{{ Auth::user()->name }}</span>
                        <i class="fas fa-user-circle text-gray-600 text-xl"></i>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-6">
                @yield('content')
            </main>
        </div>
    </div>
    
    <script>
        // Highlight active menu item
        document.querySelectorAll('nav a').forEach(link => {
            if(link.href === window.location.href) {
                link.classList.add('active');
            }
        });
    </script>
</body>
</html>