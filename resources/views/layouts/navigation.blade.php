<nav class="bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center">
                        <img src="{{ asset('storage/BooktyLogo/BooktyL.png') }}" alt="Bookty Logo" class="h-8 w-auto">
                        <span class="ml-2 text-2xl font-serif font-bold text-bookty-purple-700">Bookty Enterprise</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <a href="{{ route('home') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out {{ request()->routeIs('home') ? 'border-purple-500 text-gray-900' : '' }}">
                        Home
                    </a>
                    <a href="{{ route('books.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out {{ request()->routeIs('books.*') ? 'border-purple-500 text-gray-900' : '' }}">
                        Shop
                    </a>
                    <a href="#" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                        Collections
                    </a>
                    <a href="{{ route('about') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out {{ request()->routeIs('about') ? 'border-purple-500 text-gray-900' : '' }}">
                        About
                    </a>
                    <a href="#" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                        Contact
                    </a>
                </div>
            </div>

            <!-- Search -->
            <div class="flex-1 flex items-center justify-center px-2 lg:ml-6 lg:justify-end">
                <div class="max-w-lg w-full lg:max-w-xs">
                    <label for="search" class="sr-only">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input id="search" name="search" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-purple-500 focus:border-purple-500 sm:text-sm" placeholder="Search for books..." type="search">
                    </div>
                </div>
            </div>

            <div class="hidden sm:ml-6 sm:flex sm:items-center">
                <!-- Account Dropdown -->
                <div class="ml-3 relative">
                    @auth
                        <div class="flex items-center space-x-4">
                            <!-- Notification Bell -->
                            <div x-data="{ open: false }" class="relative">
                                <button @click="open = !open" type="button" class="p-1 rounded-full text-gray-600 hover:text-purple-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 relative">
                                    <span class="sr-only">View notifications</span>
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                    </svg>
                                    <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-purple-600 rounded-full">3</span>
                                </button>
                                
                                <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-80 rounded-md shadow-lg py-1 bg-white ring-1 ring-bookty-pink-100 focus:outline-none z-50" role="menu" aria-orientation="vertical" tabindex="-1">
                                    <div class="px-4 py-2 border-b border-gray-100">
                                        <h3 class="text-sm font-medium text-gray-900">New Book Arrivals</h3>
                                    </div>
                                    
                                    <a href="{{ route('books.show', ['book' => 'romance-in-kuala-lumpur']) }}" class="block px-4 py-3 hover:bg-bookty-pink-50 border-b border-gray-100">
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0 h-10 w-8 bg-purple-100 rounded overflow-hidden">
                                                <svg class="h-full w-full text-purple-400 p-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                </svg>
                                            </div>
                                            <div class="ml-3 flex-1">
                                                <p class="text-sm font-medium text-gray-900">Romance in Kuala Lumpur</p>
                                                <p class="text-xs text-gray-500">New book by Azizah Rahman</p>
                                                <p class="text-xs text-purple-600 mt-1">Added 2 hours ago</p>
                                            </div>
                                        </div>
                                    </a>
                                    
                                    <a href="{{ route('books.show', ['book' => 'midnight-in-melaka']) }}" class="block px-4 py-3 hover:bg-bookty-pink-50 border-b border-gray-100">
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0 h-10 w-8 bg-purple-100 rounded overflow-hidden">
                                                <svg class="h-full w-full text-purple-400 p-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                </svg>
                                            </div>
                                            <div class="ml-3 flex-1">
                                                <p class="text-sm font-medium text-gray-900">Midnight in Melaka</p>
                                                <p class="text-xs text-gray-500">New book by Lee Kai Ming</p>
                                                <p class="text-xs text-purple-600 mt-1">Added yesterday</p>
                                            </div>
                                        </div>
                                    </a>
                                    
                                    <a href="{{ route('books.show', ['book' => 'love-in-langkawi']) }}" class="block px-4 py-3 hover:bg-bookty-pink-50">
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0 h-10 w-8 bg-purple-100 rounded overflow-hidden">
                                                <svg class="h-full w-full text-purple-400 p-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                </svg>
                                            </div>
                                            <div class="ml-3 flex-1">
                                                <p class="text-sm font-medium text-gray-900">Love in Langkawi</p>
                                                <p class="text-xs text-gray-500">New book by Sarah Devi</p>
                                                <p class="text-xs text-purple-600 mt-1">Added 3 days ago</p>
                                            </div>
                                        </div>
                                    </a>
                                    
                                    <div class="px-4 py-2 border-t border-gray-100">
                                        <a href="{{ route('books.index', ['sort' => 'newest']) }}" class="text-sm text-purple-600 font-medium hover:text-purple-800">View all new arrivals</a>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Cart -->
                            <a href="{{ route('cart.index') }}" class="p-1 rounded-full text-gray-600 hover:text-purple-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 relative">
                                <span class="sr-only">View cart</span>
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-purple-600 rounded-full">{{ Auth::user()->cart ? Auth::user()->cart->items->count() : 0 }}</span>
                            </a>

                            <!-- User Menu -->
                            <div x-data="{ open: false }" class="relative">
                                <button @click="open = !open" type="button" class="flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                    <span class="sr-only">Open user menu</span>
                                    <div class="h-8 w-8 rounded-full bg-bookty-purple-200 flex items-center justify-center">
                                        <span class="text-sm font-medium text-bookty-purple-800">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                    </div>
                                </button>

                                <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-bookty-pink-100 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                                    @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('superadmin'))
                                        <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-bookty-black hover:bg-bookty-pink-50" role="menuitem">Admin Dashboard</a>
                                    @endif
                                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-bookty-black hover:bg-bookty-pink-50" role="menuitem">Your Profile</a>
                                    <a href="{{ route('profile.orders') }}" class="block px-4 py-2 text-sm text-bookty-black hover:bg-bookty-pink-50" role="menuitem">Your Orders</a>
                                    <form method="POST" action="{{ route('logout') }}" onsubmit="return handleLogout(event, this)">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-bookty-black hover:bg-bookty-pink-50" role="menuitem">Sign out</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center space-x-4">
                            <button onclick="document.dispatchEvent(new CustomEvent('open-auth-modal', {detail: 'login'}))" class="text-sm font-medium text-gray-500 hover:text-gray-900">Log in</button>
                            <button onclick="document.dispatchEvent(new CustomEvent('open-auth-modal', {detail: 'register'}))" class="text-sm font-medium text-purple-600 hover:text-purple-500">Register</button>
                        </div>
                    @endauth
                </div>
            </div>

            <!-- Mobile menu button -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-purple-500" aria-controls="mobile-menu" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu, show/hide based on menu state. -->
    <div class="sm:hidden" id="mobile-menu">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('home') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('home') ? 'border-purple-500 text-purple-700 bg-purple-50' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }} text-base font-medium">Home</a>
            <a href="{{ route('books.index') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('books.*') ? 'border-purple-500 text-purple-700 bg-purple-50' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }} text-base font-medium">Shop</a>
            <a href="#" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800 text-base font-medium">Collections</a>
            <a href="{{ route('about') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('about') ? 'border-purple-500 text-purple-700 bg-purple-50' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }} text-base font-medium">About</a>
            <a href="#" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800 text-base font-medium">Contact</a>
        </div>
        <div class="pt-4 pb-3 border-t border-gray-200">
            @auth
                <div class="flex items-center px-4">
                    <div class="flex-shrink-0">
                        <div class="h-10 w-10 rounded-full bg-bookty-purple-200 flex items-center justify-center">
                            <span class="text-sm font-medium text-bookty-purple-800">{{ substr(Auth::user()->name, 0, 1) }}</span>
                        </div>
                    </div>
                    <div class="ml-3">
                        <div class="text-base font-medium text-bookty-black">{{ Auth::user()->name }}</div>
                        <div class="text-sm font-medium text-bookty-purple-600">{{ Auth::user()->email }}</div>
                    </div>
                    <div class="ml-auto flex items-center space-x-3">
                        <!-- Mobile Notification Bell -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" type="button" class="p-1 rounded-full text-gray-600 hover:text-purple-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 relative">
                                <span class="sr-only">View notifications</span>
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-purple-600 rounded-full">3</span>
                            </button>
                            
                            <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-80 rounded-md shadow-lg py-1 bg-white ring-1 ring-bookty-pink-100 focus:outline-none z-50" role="menu" aria-orientation="vertical" tabindex="-1">
                                <div class="px-4 py-2 border-b border-gray-100">
                                    <h3 class="text-sm font-medium text-gray-900">New Book Arrivals</h3>
                                </div>
                                
                                <a href="{{ route('books.show', ['book' => 'romance-in-kuala-lumpur']) }}" class="block px-4 py-3 hover:bg-bookty-pink-50 border-b border-gray-100">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 h-10 w-8 bg-purple-100 rounded overflow-hidden">
                                            <svg class="h-full w-full text-purple-400 p-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                            </svg>
                                        </div>
                                        <div class="ml-3 flex-1">
                                            <p class="text-sm font-medium text-gray-900">Romance in Kuala Lumpur</p>
                                            <p class="text-xs text-gray-500">New book by Azizah Rahman</p>
                                            <p class="text-xs text-purple-600 mt-1">Added 2 hours ago</p>
                                        </div>
                                    </div>
                                </a>
                                
                                <a href="{{ route('books.show', ['book' => 'midnight-in-melaka']) }}" class="block px-4 py-3 hover:bg-bookty-pink-50 border-b border-gray-100">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 h-10 w-8 bg-purple-100 rounded overflow-hidden">
                                            <svg class="h-full w-full text-purple-400 p-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                            </svg>
                                        </div>
                                        <div class="ml-3 flex-1">
                                            <p class="text-sm font-medium text-gray-900">Midnight in Melaka</p>
                                            <p class="text-xs text-gray-500">New book by Lee Kai Ming</p>
                                            <p class="text-xs text-purple-600 mt-1">Added yesterday</p>
                                        </div>
                                    </div>
                                </a>
                                
                                <div class="px-4 py-2 border-t border-gray-100">
                                    <a href="{{ route('books.index', ['sort' => 'newest']) }}" class="text-sm text-purple-600 font-medium hover:text-purple-800">View all new arrivals</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-3 space-y-1">
                    @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('superadmin'))
                        <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-base font-medium text-bookty-black hover:text-bookty-purple-700 hover:bg-bookty-pink-50">Admin Dashboard</a>
                    @endif
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-base font-medium text-bookty-black hover:text-bookty-purple-700 hover:bg-bookty-pink-50">Your Profile</a>
                    <a href="{{ route('profile.orders') }}" class="block px-4 py-2 text-base font-medium text-bookty-black hover:text-bookty-purple-700 hover:bg-bookty-pink-50">Your Orders</a>
                    <form method="POST" action="{{ route('logout') }}" onsubmit="return handleLogout(event, this)">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 text-base font-medium text-bookty-black hover:text-bookty-purple-700 hover:bg-bookty-pink-50">Sign out</button>
                    </form>
                </div>
            @else
                <div class="mt-3 space-y-1">
                    <button onclick="document.dispatchEvent(new CustomEvent('open-auth-modal', {detail: 'login'}))" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100 w-full text-left">Log in</button>
                    <button onclick="document.dispatchEvent(new CustomEvent('open-auth-modal', {detail: 'register'}))" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100 w-full text-left">Register</button>
                </div>
            @endauth
        </div>
    </div>
</nav>