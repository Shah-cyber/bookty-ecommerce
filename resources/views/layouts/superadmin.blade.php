<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Bookty Enterprise') }} - SuperAdmin Dashboard</title>
    <link rel="icon" type="image/png" href="{{ asset('storage/BooktyLogo/BooktyL.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Custom Styles for Enhanced Layout -->
    <style>
        .sidebar-gradient {
            background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #4338ca 100%);
        }
        .nav-item-active {
            background: linear-gradient(135deg, #8b5cf6 0%, #a855f7 100%);
            box-shadow: 0 4px 14px 0 rgba(139, 92, 246, 0.3);
        }
        .nav-item-hover:hover {
            background: linear-gradient(135deg, rgba(139, 92, 246, 0.1) 0%, rgba(168, 85, 247, 0.1) 100%);
            transform: translateX(4px);
        }
        .header-gradient {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        }
        .floating-animation {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        .pulse-slow {
            animation: pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
    </style>
</head>
    <body class="font-sans antialiased" data-layout="admin">
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100">
        <div x-data="{ sidebarOpen: false }" class="flex h-screen">
            <!-- Sidebar -->
            <div :class="{'block': sidebarOpen, 'hidden': !sidebarOpen}" @click="sidebarOpen = false" class="fixed inset-0 z-20 transition-opacity bg-black opacity-50 lg:hidden"></div>
            
            <div :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}" class="fixed inset-y-0 left-0 z-30 w-72 overflow-y-auto transition duration-300 transform bg-gray-900 shadow-2xl lg:translate-x-0 lg:static lg:inset-0 border-r border-gray-800">
                {{-- Logo Section --}}
                <div class="relative h-20 flex items-center px-6 border-b border-gray-800">
                    <div class="flex items-center gap-3">
                        <div class="relative">
                            <div class="absolute -inset-1.5 bg-indigo-500/30 rounded-xl blur-sm"></div>
                            <div class="relative w-10 h-10 bg-white rounded-xl flex items-center justify-center">
                                <img src="{{ asset('images/BooktyL.png') }}" alt="Bookty Logo" class="h-6 w-auto">
                            </div>
                        </div>
                        <div>
                            <span class="text-xl font-bold text-white">SuperAdmin</span>
                            <span class="block text-[10px] font-semibold text-indigo-400 uppercase tracking-wider">Control Center</span>
                        </div>
                    </div>
                </div>
                
                {{-- System Status --}}
                <div class="px-6 py-4 border-b border-gray-800">
                    <div class="flex items-center gap-3 px-4 py-3 bg-gray-800/50 rounded-xl">
                        <div class="relative">
                            <div class="w-3 h-3 bg-emerald-500 rounded-full"></div>
                            <div class="absolute inset-0 w-3 h-3 bg-emerald-500 rounded-full animate-ping opacity-75"></div>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-white">System Online</p>
                            <p class="text-xs text-gray-400">All services running</p>
                        </div>
                    </div>
                </div>

                {{-- Navigation --}}
                <nav class="px-4 py-6 space-y-1">
                    {{-- Main Navigation Label --}}
                    <div class="px-4 pb-3">
                        <p class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">Main Navigation</p>
                    </div>

                    {{-- Dashboard --}}
                    <a class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('superadmin.dashboard') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}" href="{{ route('superadmin.dashboard') }}">
                        <div class="w-9 h-9 rounded-lg flex items-center justify-center {{ request()->routeIs('superadmin.dashboard') ? 'bg-white/20' : 'bg-gray-800 group-hover:bg-gray-700' }} transition-colors">
                            <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                                <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                            </svg>
                        </div>
                        <span class="font-medium">Dashboard</span>
                    </a>

                    {{-- Manage Admins --}}
                    <a class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('superadmin.admins.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}" href="{{ route('superadmin.admins.index') }}">
                        <div class="w-9 h-9 rounded-lg flex items-center justify-center {{ request()->routeIs('superadmin.admins.*') ? 'bg-white/20' : 'bg-gray-800 group-hover:bg-gray-700' }} transition-colors">
                            <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                            </svg>
                        </div>
                        <span class="font-medium">Manage Admins</span>
                    </a>

                    {{-- Roles --}}
                    <a class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('superadmin.roles.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}" href="{{ route('superadmin.roles.index') }}">
                        <div class="w-9 h-9 rounded-lg flex items-center justify-center {{ request()->routeIs('superadmin.roles.*') ? 'bg-white/20' : 'bg-gray-800 group-hover:bg-gray-700' }} transition-colors">
                            <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <span class="font-medium">Roles</span>
                    </a>

                    {{-- Permissions --}}
                    <a class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('superadmin.permissions.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}" href="{{ route('superadmin.permissions.index') }}">
                        <div class="w-9 h-9 rounded-lg flex items-center justify-center {{ request()->routeIs('superadmin.permissions.*') ? 'bg-white/20' : 'bg-gray-800 group-hover:bg-gray-700' }} transition-colors">
                            <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <span class="font-medium">Permissions</span>
                    </a>

                    {{-- System Settings --}}
                    <a class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('superadmin.settings.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}" href="{{ route('superadmin.settings.index') }}">
                        <div class="w-9 h-9 rounded-lg flex items-center justify-center {{ request()->routeIs('superadmin.settings.*') ? 'bg-white/20' : 'bg-gray-800 group-hover:bg-gray-700' }} transition-colors">
                            <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <span class="font-medium">System Settings</span>
                    </a>

                    {{-- Quick Access Label --}}
                    <div class="px-4 pt-8 pb-3">
                        <p class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">Quick Access</p>
                    </div>

                    {{-- Admin Dashboard --}}
                    <a href="{{ route('admin.dashboard') }}" class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 text-gray-300 hover:bg-purple-900/30 hover:text-purple-300">
                        <div class="w-9 h-9 rounded-lg flex items-center justify-center bg-gray-800 group-hover:bg-purple-900/50 transition-colors">
                            <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path>
                            </svg>
                        </div>
                        <span class="font-medium">Admin Dashboard</span>
                        <svg class="ml-auto w-4 h-4 text-gray-500 group-hover:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                    </a>

                    {{-- Visit Store --}}
                    <a href="{{ route('home') }}" target="_blank" class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 text-gray-300 hover:bg-emerald-900/30 hover:text-emerald-300">
                        <div class="w-9 h-9 rounded-lg flex items-center justify-center bg-gray-800 group-hover:bg-emerald-900/50 transition-colors">
                            <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                            </svg>
                        </div>
                        <span class="font-medium">Visit Store</span>
                        <svg class="ml-auto w-4 h-4 text-gray-500 group-hover:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                    </a>

                    {{-- Logout --}}
                    <div class="pt-4 mt-4 border-t border-gray-800">
                        <form method="POST" action="{{ route('logout') }}" onsubmit="return handleLogout(event, this)">
                            @csrf
                            <button type="submit" class="group flex w-full items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 text-gray-300 hover:bg-red-900/30 hover:text-red-300">
                                <div class="w-9 h-9 rounded-lg flex items-center justify-center bg-gray-800 group-hover:bg-red-900/50 transition-colors">
                                    <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <span class="font-medium">Logout</span>
                            </button>
                        </form>
                    </div>
                </nav>
            </div>

            <div class="flex flex-col flex-1 overflow-hidden">
                <header class="header-gradient border-b border-gray-200/60 shadow-lg backdrop-blur-sm">
                    <div class="flex items-center justify-between px-8 py-5">
                        <!-- Left Section -->
                        <div class="flex items-center space-x-4">
                            <button @click="sidebarOpen = true" class="p-2 text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-lg transition-colors duration-200 focus:outline-none lg:hidden">
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </button>

                            <div class="flex items-center space-x-3">
                                <div class="flex flex-col">
                                    <h1 class="text-2xl font-bold text-gray-800 tracking-tight">@yield('header', 'SuperAdmin Dashboard')</h1>
                                    <p class="text-sm text-gray-500 font-medium">{{ now()->format('l, F j, Y') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Right Section -->
                        <div class="flex items-center space-x-4">
                            <!-- Notifications Bell -->
                            <button class="relative p-2 text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-lg transition-colors duration-200">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                </svg>
                                <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                            </button>

                            <!-- User Profile Dropdown -->
                            <div x-data="{ dropdownOpen: false }" class="relative">
                                <button @click="dropdownOpen = ! dropdownOpen" class="flex items-center space-x-3 p-2 rounded-xl hover:bg-gray-100 transition-colors duration-200 focus:outline-none group">
                                    <div class="relative">
                                        <div class="h-10 w-10 rounded-full bg-gradient-to-br from-bookty-purple-500 to-bookty-pink-500 flex items-center justify-center shadow-lg">
                                            <span class="text-sm font-semibold text-white">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                        </div>
                                        <div class="absolute -bottom-1 -right-1 w-3 h-3 bg-green-400 rounded-full border-2 border-white"></div>
                                    </div>
                                    <div class="hidden md:block text-left">
                                        <p class="text-sm font-semibold text-gray-800 group-hover:text-bookty-purple-600 transition-colors duration-200">{{ Auth::user()->name }}</p>
                                        <p class="text-xs text-gray-500">SuperAdmin</p>
                                    </div>
                                    <svg class="w-4 h-4 text-gray-500 group-hover:text-gray-700 transition-colors duration-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>

                                <div x-show="dropdownOpen" 
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="transform opacity-0 scale-95"
                                     x-transition:enter-end="transform opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-75"
                                     x-transition:leave-start="transform opacity-100 scale-100"
                                     x-transition:leave-end="transform opacity-0 scale-95"
                                     @click.away="dropdownOpen = false" 
                                     class="absolute right-0 mt-2 w-64 bg-white rounded-2xl shadow-2xl z-20 border border-gray-100 overflow-hidden">
                                    
                                    <!-- Profile Header -->
                                    <div class="px-6 py-4 bg-gradient-to-r from-bookty-purple-50 to-bookty-pink-50 border-b border-gray-100">
                                        <div class="flex items-center space-x-3">
                                            <div class="h-12 w-12 rounded-full bg-gradient-to-br from-bookty-purple-500 to-bookty-pink-500 flex items-center justify-center">
                                                <span class="text-white font-semibold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                                                <p class="text-sm text-gray-500">{{ Auth::user()->email }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Menu Items -->
                                    <div class="py-2">
                                        <a href="{{ route('profile.edit') }}" class="flex items-center px-6 py-3 text-sm text-gray-700 hover:bg-gray-50 hover:text-bookty-purple-600 transition-colors duration-200">
                                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                            Profile Settings
                                        </a>
                                        
                                        <div class="border-t border-gray-100 my-2"></div>
                                        
                                <form method="POST" action="{{ route('logout') }}" onsubmit="return handleLogout(event, this)">
                                    @csrf
                                            <button type="submit" class="flex w-full items-center px-6 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors duration-200">
                                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                                </svg>
                                                Sign Out
                                            </button>
                                </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>

                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 relative">
                    <!-- Background Pattern -->
                    <div class="absolute inset-0 opacity-30">
                        <div class="absolute top-0 left-0 w-72 h-72 bg-bookty-purple-300/20 rounded-full mix-blend-multiply filter blur-xl animate-pulse"></div>
                        <div class="absolute top-0 right-0 w-72 h-72 bg-bookty-pink-300/20 rounded-full mix-blend-multiply filter blur-xl animate-pulse" style="animation-delay: 2s;"></div>
                        <div class="absolute bottom-10 left-20 w-72 h-72 bg-indigo-300/20 rounded-full mix-blend-multiply filter blur-xl animate-pulse" style="animation-delay: 4s;"></div>
                    </div>
                    
                    <div class="relative container mx-auto px-8 py-8">
                        {{-- Flash messages are now handled by JavaScript toast notifications --}}

                        @yield('content')
                    </div>
                </main>
            </div>
        </div>
    </div>
    
    <!-- Session Flash Message Handler -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle session flash messages
            @if(session('success'))
                window.showToast('{{ session('success') }}', 'success');
            @endif
            
            @if(session('error'))
                window.showToast('{{ session('error') }}', 'error');
            @endif
            
            @if(session('warning'))
                window.showToast('{{ session('warning') }}', 'warning');
            @endif
            
            @if(session('info'))
                window.showToast('{{ session('info') }}', 'info');
            @endif
        });
    </script>

    <!-- Logout Handler -->
    <script>
        async function handleLogout(event, form) {
            event.preventDefault();
            
            try {
                const formData = new FormData(form);
                
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });

                if (response.ok) {
                    // Show success toast
                    window.showToast('Successfully logged out. See you soon!', 'success');
                    
                    // Redirect after a short delay to show the toast
                    setTimeout(() => {
                        window.location.href = '/';
                    }, 1500);
                } else {
                    // Fallback to regular form submission if AJAX fails
                    form.submit();
                }
            } catch (error) {
                console.error('Logout error:', error);
                // Fallback to regular form submission
                form.submit();
            }
            
            return false;
        }
    </script>
</body>
</html>
