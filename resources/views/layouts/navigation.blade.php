<nav class="bg-white/95 backdrop-blur-md shadow-lg z-50 sticky top-0 transition-all duration-300 nav-fade-in">
    <!-- Removed decorative gradient border -->
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex">
                <!-- Enhanced Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center group transition-all duration-300 hover:scale-105">
                        {{-- <div class="relative">
                            <img src="{{ asset('images/BooktyL.png') }}" alt="Bookty Logo" class="h-10 w-auto transition-all duration-300 group-hover:drop-shadow-lg">
                            <div class="absolute inset-0 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full opacity-0 group-hover:opacity-20 transition-opacity duration-300 blur-xl"></div>
                        </div> --}}
                        <div class="relative">
                            <img src="{{ asset('images/BooktyL.png') }}" alt="Bookty Logo" class="h-10 w-auto transition-all duration-300 group-hover:drop-shadow-lg">
                            <div class="absolute inset-0 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full opacity-0 group-hover:opacity-20 transition-opacity duration-300 blur-xl"></div>
                        </div>
                        
                        <div class="ml-3">
                            <span class="text-2xl font-bold bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 bg-clip-text text-transparent">Bookty</span>
                            <div class="text-sm text-gray-600 font-medium -mt-1">Enterprise</div>
                        </div>
                    </a>
                </div>

                <!-- Enhanced Navigation Links -->
                <div class="hidden space-x-1 sm:-my-px sm:ml-12 sm:flex">
                    <a href="{{ route('home') }}" class="relative inline-flex items-center px-4 py-8 text-sm font-semibold {{ request()->routeIs('home') ? 'text-purple-600' : 'text-gray-700' }}">
                        <span class="relative z-10">Home</span>
                    </a>
                    <a href="{{ route('books.index') }}" class="relative inline-flex items-center px-4 py-8 text-sm font-semibold {{ request()->routeIs('books.*') ? 'text-purple-600' : 'text-gray-700' }}">
                        <svg class="w-4 h-4 mr-2 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        <span class="relative z-10">Shop</span>
                    </a>
                    <div x-data="{ open: false }" class="relative group">
                        <button @mouseenter="open = true" @mouseleave="open = false" class="relative inline-flex items-center px-4 py-8 text-sm font-semibold text-gray-700">
                            <svg class="w-4 h-4 mr-2 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                            <span class="relative z-10">Collections</span>
                            <svg class="w-4 h-4 ml-1" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        
                        <div x-show="open" @mouseenter="open = true" @mouseleave="open = false" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-1" x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-95 translate-y-1" class="absolute top-full left-0 mt-1 w-64 bg-white rounded-xl shadow-2xl border border-gray-100 py-2 z-50 backdrop-blur-sm">
                            <div class="px-4 py-2 border-b border-gray-100">
                                <h3 class="text-sm font-semibold text-gray-900">Browse by Genre</h3>
                            </div>
                            <a href="{{ route('books.index', ['genre' => '1']) }}" class="flex items-center px-4 py-3 hover:bg-gradient-to-r hover:from-purple-50 hover:to-pink-50 transition-colors duration-200">
                                <div class="w-8 h-8 bg-gradient-to-br from-purple-100 to-pink-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">Romance</div>
                                    <div class="text-xs text-gray-500">Love stories & relationships</div>
                                </div>
                            </a>
                            <a href="{{ route('books.index', ['genre' => '2']) }}" class="flex items-center px-4 py-3 hover:bg-gradient-to-r hover:from-purple-50 hover:to-pink-50 transition-colors duration-200">
                                <div class="w-8 h-8 bg-gradient-to-br from-indigo-100 to-blue-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">Mystery</div>
                                    <div class="text-xs text-gray-500">Thrillers & detective stories</div>
                                </div>
                            </a>
                            <a href="{{ route('books.index', ['genre' => '3']) }}" class="flex items-center px-4 py-3 hover:bg-gradient-to-r hover:from-purple-50 hover:to-pink-50 transition-colors duration-200">
                                <div class="w-8 h-8 bg-gradient-to-br from-emerald-100 to-teal-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">Fantasy</div>
                                    <div class="text-xs text-gray-500">Magic & adventure</div>
                                </div>
                            </a>
                            <div class="border-t border-gray-100 pt-2 mt-2">
                                <a href="{{ route('books.index') }}" class="block px-4 py-2 text-sm text-purple-600 font-medium hover:text-purple-700">View All Collections →</a>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('about') }}" class="relative inline-flex items-center px-4 py-8 text-sm font-semibold {{ request()->routeIs('about') ? 'text-purple-600' : 'text-gray-700' }}">
                        <svg class="w-4 h-4 mr-2 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="relative z-10">About</span>
                    </a>
                    <a href="#" class="relative inline-flex items-center px-4 py-8 text-sm font-semibold text-gray-700">
                        <svg class="w-4 h-4 mr-2 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                        <span class="relative z-10">Contact</span>
                    </a>
                </div>
            </div>

            <!-- Enhanced Search -->
            <div class="flex-1 flex items-center justify-center px-2 lg:ml-6 lg:justify-end">
                <div class="max-w-lg w-full lg:max-w-xs">
                    <label for="search" class="sr-only">Search</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400 group-focus-within:text-purple-500 transition-colors duration-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input id="search" name="search" class="block w-full pl-12 pr-4 py-3 border border-gray-200 rounded-2xl leading-5 bg-gray-50/80 backdrop-blur-sm placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 focus:bg-white sm:text-sm transition-all duration-300 hover:bg-white hover:shadow-lg hover:shadow-purple-500/10" placeholder="Search for books..." type="search">
                        
                        <!-- Search suggestions dropdown (can be enhanced with JavaScript later) -->
                        <div class="absolute top-full left-0 right-0 mt-2 bg-white rounded-2xl shadow-2xl border border-gray-100 py-2 z-50 opacity-0 pointer-events-none group-focus-within:opacity-100 group-focus-within:pointer-events-auto transition-all duration-200">
                            <div class="px-4 py-2 text-xs text-gray-500 font-medium uppercase tracking-wider">Popular searches</div>
                            <a href="{{ route('books.index', ['search' => 'romance']) }}" class="block px-4 py-2 hover:bg-gray-50 transition-colors duration-150">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                    <span class="text-sm text-gray-700">Romance novels</span>
                                </div>
                            </a>
                            <a href="{{ route('books.index', ['search' => 'mystery']) }}" class="block px-4 py-2 hover:bg-gray-50 transition-colors duration-150">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                    <span class="text-sm text-gray-700">Mystery & thriller</span>
                                </div>
                            </a>
                            <a href="{{ route('books.index', ['search' => 'bestseller']) }}" class="block px-4 py-2 hover:bg-gray-50 transition-colors duration-150">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                    <span class="text-sm text-gray-700">Bestsellers</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="hidden sm:ml-6 sm:flex sm:items-center">
                <!-- Enhanced User Actions -->
                <div class="ml-3 relative">
                    @auth
                        <div class="flex items-center space-x-3">
                            <!-- Enhanced Notification Bell -->
                            <div x-data="{ open: false }" class="relative">
                                <button @click="open = !open" type="button" class="group relative p-3 rounded-2xl bg-gray-50/80 hover:bg-white text-gray-600 hover:text-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:bg-white transition-all duration-300 hover:shadow-lg hover:shadow-purple-500/10 hover:scale-105">
                                    <span class="sr-only">View notifications</span>
                                    <svg class="h-5 w-5 transition-transform duration-300 group-hover:scale-110" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                    </svg>
                                    <span class="absolute -top-1 -right-1 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform bg-gradient-to-r from-purple-500 to-pink-500 rounded-full animate-pulse">3</span>
                                </button>
                                
                                <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-1" x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-95 translate-y-1" class="origin-top-right absolute right-0 mt-3 w-80 rounded-2xl shadow-2xl py-1 bg-white border border-gray-100 focus:outline-none z-50 backdrop-blur-sm" role="menu" aria-orientation="vertical" tabindex="-1">
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
                            
                            <!-- Enhanced Cart -->
                            <a href="{{ route('cart.index') }}" class="group relative p-3 rounded-2xl bg-gray-50/80 hover:bg-white text-gray-600 hover:text-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:bg-white transition-all duration-300 hover:shadow-lg hover:shadow-purple-500/10 hover:scale-105">
                                <span class="sr-only">View cart</span>
                                <svg class="h-5 w-5 transition-transform duration-300 group-hover:scale-110" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                @php $cartCount = Auth::user()->cart ? Auth::user()->cart->items->count() : 0; @endphp
                                @if($cartCount > 0)
                                    <span class="cart-count absolute -top-1 -right-1 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform bg-gradient-to-r from-purple-500 to-pink-500 rounded-full animate-bounce-subtle">{{ $cartCount }}</span>
                                @else
                                    <span class="cart-count absolute -top-1 -right-1 hidden items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform bg-gradient-to-r from-purple-500 to-pink-500 rounded-full">0</span>
                                @endif
                            </a>

                            <!-- Enhanced User Menu -->
                            <div x-data="{ open: false }" class="relative">
                                <button @click="open = !open" type="button" class="group flex items-center text-sm rounded-2xl focus:outline-none focus:ring-2 focus:ring-purple-500/20 transition-all duration-300 hover:scale-105" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                    <span class="sr-only">Open user menu</span>
                                    <div class="h-10 w-10 rounded-2xl bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center shadow-lg group-hover:shadow-xl group-hover:shadow-purple-500/25 transition-all duration-300">
                                        <span class="text-sm font-bold text-white">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                    </div>
                                    <div class="ml-3 hidden md:block text-left">
                                        <div class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</div>
                                        <div class="text-xs text-gray-500">{{ Auth::user()->hasRole('admin') ? 'Admin' : 'Customer' }}</div>
                                    </div>
                                    <svg class="ml-2 h-4 w-4 text-gray-400 group-hover:text-purple-600 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>

                                <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="origin-top-right absolute right-0 mt-3 w-64 rounded-2xl shadow-2xl py-2 bg-white border border-gray-100 focus:outline-none z-50" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                                    <!-- User Info Header -->
                                    <div class="px-4 py-3 border-b border-gray-100">
                                        <div class="flex items-center">
                                            <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center">
                                                <span class="text-lg font-bold text-white">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-semibold text-gray-900">{{ Auth::user()->name }}</div>
                                                <div class="text-xs text-gray-500">{{ Auth::user()->email }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Menu Items -->
                                    @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('superadmin'))
                                        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-purple-50 hover:to-pink-50 hover:text-purple-700 transition-all duration-200" role="menuitem">
                                            <svg class="w-5 h-5 mr-3 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                            </svg>
                                            Admin Dashboard
                                        </a>
                                    @endif
                                    <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-purple-50 hover:to-pink-50 hover:text-purple-700 transition-all duration-200" role="menuitem">
                                        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        Your Profile
                                    </a>
                                    <a href="{{ route('profile.orders') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-purple-50 hover:to-pink-50 hover:text-purple-700 transition-all duration-200" role="menuitem">
                                        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                        </svg>
                                        Your Orders
                                    </a>
                                    
                                    <a href="{{ route('wishlist.index') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-purple-50 hover:to-pink-50 hover:text-purple-700 transition-all duration-200" role="menuitem">
                                        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                        </svg>
                                        Your Wishlist
                                        @php $wishlistCount = Auth::user()->wishlist()->count(); @endphp
                                        @if($wishlistCount > 0)
                                            <span class="wishlist-count ml-auto bg-gradient-to-r from-purple-500 to-pink-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">{{ $wishlistCount }}</span>
                                        @else
                                            <span class="wishlist-count ml-auto bg-gradient-to-r from-purple-500 to-pink-500 text-white text-xs font-bold rounded-full h-5 w-5 hidden">0</span>
                                        @endif
                                    </a>
                                    
                                    <div class="border-t border-gray-100 my-2"></div>
                                    
                                    <form method="POST" action="{{ route('logout') }}" onsubmit="return handleLogout(event, this)">
                                        @csrf
                                        <button type="submit" class="flex items-center w-full px-4 py-3 text-sm text-red-600 hover:bg-red-50 hover:text-red-700 transition-all duration-200" role="menuitem">
                                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                            </svg>
                                            Sign out
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center space-x-3">
                            <button onclick="document.dispatchEvent(new CustomEvent('open-auth-modal', {detail: 'login'}))" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-purple-600 transition-colors duration-200">
                                Log in
                            </button>
                            <button onclick="document.dispatchEvent(new CustomEvent('open-auth-modal', {detail: 'register'}))" class="px-6 py-2 text-sm font-semibold text-white bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl hover:from-purple-700 hover:to-pink-700 transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl hover:shadow-purple-500/25 relative overflow-hidden group">
                                <span class="relative z-10">Sign up</span>
                                <div class="absolute inset-0 bg-gradient-to-r from-purple-400 to-pink-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </button>
                        </div>
                    @endauth
                </div>
            </div>

            <!-- Enhanced Mobile menu button -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button x-data="{ open: false }" @click="open = !open; document.getElementById('mobile-menu').classList.toggle('hidden')" type="button" class="group inline-flex items-center justify-center p-3 rounded-2xl text-gray-600 hover:text-purple-600 hover:bg-purple-50 focus:outline-none focus:ring-2 focus:ring-purple-500/20 transition-all duration-300 hover:scale-105 hover:shadow-lg hover:shadow-purple-500/10" aria-controls="mobile-menu" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="block h-5 w-5 transition-transform duration-300 group-hover:scale-110" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Enhanced Mobile menu -->
    <div class="sm:hidden hidden" id="mobile-menu">
        <div class="bg-white/95 backdrop-blur-md border-t border-gray-100">
            <div class="pt-4 pb-3 space-y-2 px-4">
                <a href="{{ route('home') }}" class="flex items-center px-4 py-3 rounded-2xl {{ request()->routeIs('home') ? 'bg-gradient-to-r from-purple-50 to-pink-50 text-purple-700 border-l-4 border-purple-500' : 'text-gray-700 hover:bg-gradient-to-r hover:from-purple-50 hover:to-pink-50 hover:text-purple-700' }} text-base font-medium transition-all duration-200">
                    <svg class="w-5 h-5 mr-3 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Home
                </a>
                <a href="{{ route('books.index') }}" class="flex items-center px-4 py-3 rounded-2xl {{ request()->routeIs('books.*') ? 'bg-gradient-to-r from-purple-50 to-pink-50 text-purple-700 border-l-4 border-purple-500' : 'text-gray-700 hover:bg-gradient-to-r hover:from-purple-50 hover:to-pink-50 hover:text-purple-700' }} text-base font-medium transition-all duration-200">
                    <svg class="w-5 h-5 mr-3 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    Shop
                </a>
                <a href="#" class="flex items-center px-4 py-3 rounded-2xl text-gray-700 hover:bg-gradient-to-r hover:from-purple-50 hover:to-pink-50 hover:text-purple-700 text-base font-medium transition-all duration-200">
                    <svg class="w-5 h-5 mr-3 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    Collections
                </a>
                <a href="{{ route('about') }}" class="flex items-center px-4 py-3 rounded-2xl {{ request()->routeIs('about') ? 'bg-gradient-to-r from-purple-50 to-pink-50 text-purple-700 border-l-4 border-purple-500' : 'text-gray-700 hover:bg-gradient-to-r hover:from-purple-50 hover:to-pink-50 hover:text-purple-700' }} text-base font-medium transition-all duration-200">
                    <svg class="w-5 h-5 mr-3 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    About
                </a>
                <a href="#" class="flex items-center px-4 py-3 rounded-2xl text-gray-700 hover:bg-gradient-to-r hover:from-purple-50 hover:to-pink-50 hover:text-purple-700 text-base font-medium transition-all duration-200">
                    <svg class="w-5 h-5 mr-3 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    Contact
                </a>
        </div>
            <div class="pt-4 pb-3 border-t border-gray-100 px-4">
            @auth
                    <div class="flex items-center px-4 py-3 bg-gradient-to-r from-purple-50 to-pink-50 rounded-2xl">
                    <div class="flex-shrink-0">
                            <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center shadow-lg">
                                <span class="text-lg font-bold text-white">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </div>
                        </div>
                        <div class="ml-3 flex-1">
                            <div class="text-base font-semibold text-gray-900">{{ Auth::user()->name }}</div>
                            <div class="text-sm text-gray-600">{{ Auth::user()->email }}</div>
                    </div>
                        <div class="ml-auto">
                            <!-- Mobile Cart -->
                            <a href="{{ route('cart.index') }}" class="p-2 rounded-xl bg-white/80 text-gray-600 hover:text-purple-600 relative transition-colors duration-200">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                @php $cartCount = Auth::user()->cart ? Auth::user()->cart->items->count() : 0; @endphp
                                @if($cartCount > 0)
                                    <span class="cart-count absolute -top-1 -right-1 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-gradient-to-r from-purple-500 to-pink-500 rounded-full animate-bounce-subtle">{{ $cartCount }}</span>
                                @endif
                            </a>
                        </div>
                    </div>
                    <div class="mt-4 space-y-2">
                    @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('superadmin'))
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 rounded-2xl text-gray-700 hover:bg-gradient-to-r hover:from-purple-50 hover:to-pink-50 hover:text-purple-700 text-base font-medium transition-all duration-200">
                                <svg class="w-5 h-5 mr-3 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                                Admin Dashboard
                            </a>
                    @endif
                        <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-3 rounded-2xl text-gray-700 hover:bg-gradient-to-r hover:from-purple-50 hover:to-pink-50 hover:text-purple-700 text-base font-medium transition-all duration-200">
                            <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Your Profile
                        </a>
                        <a href="{{ route('profile.orders') }}" class="flex items-center px-4 py-3 rounded-2xl text-gray-700 hover:bg-gradient-to-r hover:from-purple-50 hover:to-pink-50 hover:text-purple-700 text-base font-medium transition-all duration-200">
                            <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                            Your Orders
                        </a>
                        <a href="{{ route('wishlist.index') }}" class="flex items-center justify-between px-4 py-3 rounded-2xl text-gray-700 hover:bg-gradient-to-r hover:from-purple-50 hover:to-pink-50 hover:text-purple-700 text-base font-medium transition-all duration-200">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                                Your Wishlist
                            </div>
                            @php $wishlistCount = Auth::user()->wishlist()->count(); @endphp
                            @if($wishlistCount > 0)
                                <span class="wishlist-count bg-gradient-to-r from-purple-500 to-pink-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">{{ $wishlistCount }}</span>
                            @else
                                <span class="wishlist-count bg-gradient-to-r from-purple-500 to-pink-500 text-white text-xs font-bold rounded-full h-5 w-5 hidden">0</span>
                            @endif
                        </a>
                    <form method="POST" action="{{ route('logout') }}" onsubmit="return handleLogout(event, this)">
                        @csrf
                            <button type="submit" class="flex items-center w-full px-4 py-3 rounded-2xl text-red-600 hover:bg-red-50 hover:text-red-700 text-base font-medium transition-all duration-200">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                Sign out
                            </button>
                    </form>
                </div>
            @else
                    <div class="mt-4 space-y-3 px-4">
                        <button onclick="document.dispatchEvent(new CustomEvent('open-auth-modal', {detail: 'login'}))" class="w-full px-4 py-3 text-center rounded-2xl border border-gray-200 text-gray-700 hover:bg-gray-50 text-base font-medium transition-all duration-200">
                            Log in
                        </button>
                        <button onclick="document.dispatchEvent(new CustomEvent('open-auth-modal', {detail: 'register'}))" class="w-full px-4 py-3 text-center rounded-2xl bg-gradient-to-r from-purple-600 to-pink-600 text-white hover:from-purple-700 hover:to-pink-700 text-base font-semibold transition-all duration-200 shadow-lg">
                            Sign up
                        </button>
                </div>
            @endauth
            </div>
        </div>
    </div>
</nav>