<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payroll Management System</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .sidebar {
            min-height: 100vh;
            transition: all 0.3s ease;
            width: 16rem;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 40;
        }
        .sidebar.collapsed {
            width: 0;
            padding: 0;
            overflow: hidden;
        }
        .main-content {
            transition: all 0.3s ease;
            margin-left: 16rem;
        }
        .main-content.expanded {
            margin-left: 0;
        }
        .active {
            background-color: #3b82f6;
            color: white !important;
        }
        .active:hover {
            background-color: #2563eb !important;
        }
        .language-dropdown {
            display: none;
            position: absolute;
            right: 0;
            top: 100%;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 0.375rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            z-index: 50;
        }
        .language-dropdown.show {
            display: block;
        }
        #sidebar-toggle {
            position: fixed;
            top: 1rem;
            left: 1rem;
            z-index: 50;
            background: white;
            border-radius: 0.375rem;
            padding: 0.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            width: 2.5rem;
            height: 2.5rem;
            transition: all 0.3s ease;
        }
        #sidebar-toggle:hover {
            background: #f3f4f6;
        }
        @media (min-width: 768px) {
            #sidebar-toggle {
                left: 17rem;
            }
            .sidebar.collapsed + #main-content #sidebar-toggle {
                left: 1rem;
            }
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar Toggle Button -->
        <button id="sidebar-toggle" class="text-gray-600 hover:text-gray-900 focus:outline-none">
            <i class="fas fa-bars text-xl"></i>
        </button>

        <!-- Sidebar -->
        <div id="sidebar" class="sidebar bg-gray-800 text-white space-y-6 py-7 px-2">
            <!-- Logo -->
            <div class="text-white flex items-center space-x-2 px-4">
                <i class="fas fa-money-bill-wave fa-2x"></i>
                <span class="text-2xl font-extrabold">PayrollMS</span>
            </div>

            <!-- Navigation -->
            <nav class="space-y-2">
                <a href="{{ route('employees.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-700 hover:text-white">
                    <i class="fas fa-users mr-2"></i> Employés
                </a>
                <a href="{{ route('fonctions.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-700 hover:text-white">
                    <i class="fas fa-briefcase mr-2"></i> Fonctions
                </a>
                <a href="{{ route('primes.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-700 hover:text-white">
                    <i class="fas fa-gift mr-2"></i> Primes
                </a>
                <a href="{{ route('groupes.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-700 hover:text-white">
                    <i class="fas fa-layer-group mr-2"></i> Groupes
                </a>
                <a href="{{ route('points.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-700 hover:text-white">
                    <i class="fas fa-chart-line mr-2"></i> Points Indiciels
                </a>
            </nav>

            <!-- Logout Button -->
            <div class="absolute bottom-0 w-full px-4 pb-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left block py-2.5 px-4 rounded transition duration-200 hover:bg-red-600 hover:text-white">
                        <i class="fas fa-sign-out-alt mr-2"></i> Déconnexion
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div id="main-content" class="flex-1 transition-all duration-200">
            <!-- Top Navigation -->
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                    <!-- Title -->
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        @yield('title')
                    </h2>

                    <!-- Right side with language and user profile -->
                    <div class="flex items-center space-x-4">
                        <!-- Language Switcher -->
                        <div class="relative">
                            <button id="language-toggle" class="flex items-center space-x-2 text-gray-600 hover:text-gray-900">
                                <i class="fas fa-globe"></i>
                                <span>{{ app()->getLocale() == 'fr' ? 'FR' : 'EN' }}</span>
                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>
                            <div id="language-dropdown" class="language-dropdown mt-2 py-2 w-32">
                                <a href="{{ route('language.switch', 'fr') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Français</a>
                                <a href="{{ route('language.switch', 'en') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">English</a>
                            </div>
                        </div>

                        <!-- User Profile Section -->
                        <div class="flex items-center space-x-4">
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                            </div>
                            <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                <i class="fas fa-user text-gray-500"></i>
                            </div>
                        </div>
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
        // Sidebar Toggle
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');
        const sidebarToggle = document.getElementById('sidebar-toggle');
        let isSidebarOpen = true;

        sidebarToggle.addEventListener('click', () => {
            isSidebarOpen = !isSidebarOpen;
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
            sidebarToggle.innerHTML = isSidebarOpen ? 
                '<i class="fas fa-bars text-xl"></i>' : 
                '<i class="fas fa-chevron-right text-xl"></i>';
        });

        // Language Dropdown Toggle
        const languageToggle = document.getElementById('language-toggle');
        const languageDropdown = document.getElementById('language-dropdown');

        languageToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            languageDropdown.classList.toggle('show');
        });

        // Close language dropdown when clicking outside
        document.addEventListener('click', (e) => {
            if (!languageToggle.contains(e.target) && !languageDropdown.contains(e.target)) {
                languageDropdown.classList.remove('show');
            }
        });

        // Highlight active menu item
        document.querySelectorAll('nav a').forEach(link => {
            if(link.href === window.location.href) {
                link.classList.add('active');
            }
        });
    </script>
</body>
</html>