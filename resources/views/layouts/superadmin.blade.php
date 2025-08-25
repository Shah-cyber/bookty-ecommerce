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
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-bookty-cream">
        <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-bookty-cream">
            <!-- Sidebar -->
            <div :class="{'block': sidebarOpen, 'hidden': !sidebarOpen}" @click="sidebarOpen = false" class="fixed inset-0 z-20 transition-opacity bg-black opacity-50 lg:hidden"></div>
            
            <div :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}" class="fixed inset-y-0 left-0 z-30 w-64 overflow-y-auto transition duration-300 transform bg-white shadow-lg lg:translate-x-0 lg:static lg:inset-0">
                <div class="flex items-center justify-center mt-8">
                    <div class="flex items-center">
                        <img src="{{ asset('storage/BooktyLogo/BooktyL.png') }}" alt="Bookty Logo" class="h-10 w-auto">
                        <span class="ml-2 text-2xl font-serif font-bold text-bookty-purple-700">SuperAdmin</span>
                    </div>
                </div>

                <nav class="mt-10">
                    <a class="flex items-center px-6 py-2 mt-4 {{ request()->routeIs('superadmin.dashboard') ? 'text-white bg-bookty-purple-600' : 'text-bookty-black hover:bg-bookty-pink-50 hover:text-bookty-purple-700' }} transition-colors duration-200 rounded-md" href="{{ route('superadmin.dashboard') }}">
                        <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                            <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                        </svg>

                        <span class="mx-3">Dashboard</span>
                    </a>

                    <a class="flex items-center px-6 py-2 mt-4 {{ request()->routeIs('superadmin.admins.*') ? 'text-white bg-bookty-purple-600' : 'text-bookty-black hover:bg-bookty-pink-50 hover:text-bookty-purple-700' }} transition-colors duration-200 rounded-md" href="{{ route('superadmin.admins.index') }}">
                        <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                        </svg>

                        <span class="mx-3">Manage Admins</span>
                    </a>

                    <a class="flex items-center px-6 py-2 mt-4 {{ request()->routeIs('superadmin.roles.*') ? 'text-white bg-bookty-purple-600' : 'text-bookty-black hover:bg-bookty-pink-50 hover:text-bookty-purple-700' }} transition-colors duration-200 rounded-md" href="{{ route('superadmin.roles.index') }}">
                        <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                        </svg>

                        <span class="mx-3">Roles</span>
                    </a>

                    <a class="flex items-center px-6 py-2 mt-4 {{ request()->routeIs('superadmin.permissions.*') ? 'text-white bg-bookty-purple-600' : 'text-bookty-black hover:bg-bookty-pink-50 hover:text-bookty-purple-700' }} transition-colors duration-200 rounded-md" href="{{ route('superadmin.permissions.index') }}">
                        <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                        </svg>

                        <span class="mx-3">Permissions</span>
                    </a>

                    <a class="flex items-center px-6 py-2 mt-4 {{ request()->routeIs('superadmin.settings.*') ? 'text-white bg-bookty-purple-600' : 'text-bookty-black hover:bg-bookty-pink-50 hover:text-bookty-purple-700' }} transition-colors duration-200 rounded-md" href="{{ route('superadmin.settings.index') }}">
                        <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
                        </svg>

                        <span class="mx-3">System Settings</span>
                    </a>

                    <div class="border-t border-bookty-pink-100 mt-6 pt-4">
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-6 py-2 mt-4 text-bookty-black hover:bg-bookty-pink-50 hover:text-bookty-purple-700 transition-colors duration-200 rounded-md">
                            <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path>
                            </svg>
                            <span class="mx-3">Admin Dashboard</span>
                        </a>

                        <a href="{{ route('home') }}" class="flex items-center px-6 py-2 mt-4 text-bookty-black hover:bg-bookty-pink-50 hover:text-bookty-purple-700 transition-colors duration-200 rounded-md">
                            <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                            </svg>
                            <span class="mx-3">Visit Store</span>
                        </a>

                        <form method="POST" action="{{ route('logout') }}" onsubmit="return handleLogout(event, this)">
                            @csrf
                            <button type="submit" class="flex w-full items-center px-6 py-2 mt-4 text-bookty-black hover:bg-bookty-pink-50 hover:text-bookty-purple-700 transition-colors duration-200 rounded-md">
                                <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="mx-3">Logout</span>
                            </button>
                        </form>
                    </div>
                </nav>
            </div>

            <div class="flex flex-col flex-1 overflow-hidden">
                <header class="flex items-center justify-between px-6 py-4 bg-white border-b-2 border-bookty-pink-100 shadow-sm">
                    <div class="flex items-center">
                        <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none lg:hidden">
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </button>

                        <div class="mx-4">
                            <h1 class="text-2xl font-serif font-semibold text-bookty-black">@yield('header', 'SuperAdmin Dashboard')</h1>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <div x-data="{ dropdownOpen: false }" class="relative">
                            <button @click="dropdownOpen = ! dropdownOpen" class="flex items-center space-x-2 relative focus:outline-none">
                                <div class="h-9 w-9 rounded-full bg-bookty-purple-200 flex items-center justify-center">
                                    <span class="text-sm font-medium text-bookty-purple-800">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                </div>
                                <span class="text-bookty-black font-medium">{{ Auth::user()->name }}</span>
                                <svg class="w-5 h-5 text-bookty-purple-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>

                            <div x-show="dropdownOpen" @click.away="dropdownOpen = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md overflow-hidden shadow-xl z-10">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-bookty-black hover:bg-bookty-pink-50">Profile</a>
                                <form method="POST" action="{{ route('logout') }}" onsubmit="return handleLogout(event, this)">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-bookty-black hover:bg-bookty-pink-50">Logout</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </header>

                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-bookty-cream">
                    <div class="container mx-auto px-6 py-8">
                        @if(session('success'))
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                                {{ session('error') }}
                            </div>
                        @endif

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
