<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Bookty Enterprise') }} - Admin Dashboard</title>
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
                        <span class="ml-2 text-2xl font-serif font-bold text-bookty-purple-700">Bookty Enterprise</span>
                    </div>
                </div>

                <nav class="mt-10">
                    <a class="flex items-center px-6 py-2 mt-4 {{ request()->routeIs('admin.dashboard') ? 'text-white bg-bookty-purple-600' : 'text-bookty-black hover:bg-bookty-pink-50 hover:text-bookty-purple-700' }} transition-colors duration-200 rounded-md" href="{{ route('admin.dashboard') }}">
                        <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                            <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                        </svg>

                        <span class="mx-3">Dashboard</span>
                    </a>

                    <a class="flex items-center px-6 py-2 mt-4 {{ request()->routeIs('admin.books.*') ? 'text-white bg-bookty-purple-600' : 'text-bookty-black hover:bg-bookty-pink-50 hover:text-bookty-purple-700' }} transition-colors duration-200 rounded-md" href="{{ route('admin.books.index') }}">
                        <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"></path>
                        </svg>

                        <span class="mx-3">Books</span>
                    </a>

                    <a class="flex items-center px-6 py-2 mt-4 {{ request()->routeIs('admin.genres.*') ? 'text-white bg-bookty-purple-600' : 'text-bookty-black hover:bg-bookty-pink-50 hover:text-bookty-purple-700' }} transition-colors duration-200 rounded-md" href="{{ route('admin.genres.index') }}">
                        <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path>
                        </svg>

                        <span class="mx-3">Genres</span>
                    </a>

                    <a class="flex items-center px-6 py-2 mt-4 {{ request()->routeIs('admin.tropes.*') ? 'text-white bg-bookty-purple-600' : 'text-bookty-black hover:bg-bookty-pink-50 hover:text-bookty-purple-700' }} transition-colors duration-200 rounded-md" href="{{ route('admin.tropes.index') }}">
                        <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                        </svg>

                        <span class="mx-3">Tropes</span>
                    </a>

                    <a class="flex items-center px-6 py-2 mt-4 {{ request()->routeIs('admin.orders.*') ? 'text-white bg-bookty-purple-600' : 'text-bookty-black hover:bg-bookty-pink-50 hover:text-bookty-purple-700' }} transition-colors duration-200 rounded-md" href="{{ route('admin.orders.index') }}">
                        <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"></path>
                        </svg>

                        <span class="mx-3">Orders</span>
                    </a>

                    <a class="flex items-center px-6 py-2 mt-4 {{ request()->routeIs('admin.customers.*') ? 'text-white bg-bookty-purple-600' : 'text-bookty-black hover:bg-bookty-pink-50 hover:text-bookty-purple-700' }} transition-colors duration-200 rounded-md" href="{{ route('admin.customers.index') }}">
                        <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                        </svg>

                        <span class="mx-3">Customers</span>
                    </a>

                    <div class="border-t border-bookty-pink-100 mt-6 pt-4">
                        @role('superadmin')
                        <a href="{{ route('superadmin.dashboard') }}" class="flex items-center px-6 py-2 mt-4 text-bookty-black hover:bg-bookty-pink-50 hover:text-bookty-purple-700 transition-colors duration-200 rounded-md">
                            <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="mx-3">SuperAdmin Dashboard</span>
                        </a>
                        @endrole
                        
                        <a href="{{ route('home') }}" class="flex items-center px-6 py-2 mt-4 text-bookty-black hover:bg-bookty-pink-50 hover:text-bookty-purple-700 transition-colors duration-200 rounded-md">
                            <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
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
                            <h1 class="text-2xl font-serif font-semibold text-bookty-black">@yield('header', 'Dashboard')</h1>
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
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-bookty-black hover:bg-bookty-pink-50">Logout</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </header>

                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-bookty-cream">
                    <div class="container mx-auto px-6 py-8">
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
