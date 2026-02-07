<nav x-data="{ mobileMenuOpen: false }"
    class="bg-white/80 backdrop-blur-xl shadow-sm z-50 sticky top-0 transition-all duration-300 nav-fade-in border-b border-gray-100">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex justify-between h-24">

            <div class="flex">

                <!-- Enhanced Logo -->

                <div class="shrink-0 flex items-center">

                    <a href="{{ route('home') }}"
                        class="flex items-center group transition-all duration-300 hover:scale-105">

                        <div class="relative">
                            <img src="{{ asset('images/BooktyL.png') }}" alt="Bookty Logo"
                                class="h-10 w-auto transition-all duration-300 group-hover:drop-shadow-lg">
                            <div
                                class="absolute inset-0 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full opacity-0 group-hover:opacity-20 transition-opacity duration-300 blur-xl">
                            </div>
                        </div>

                        <div class="ml-3">
                            <span class="text-2xl font-bold text-gray-900 font-serif tracking-tight">Bookty</span>
                            <div class="text-sm text-gray-500 font-medium -mt-1">Enterprise</div>
                        </div>

                    </a>

                </div>



                <!-- Enhanced Navigation Links -->

                <div class="hidden space-x-2 sm:-my-px sm:ml-12 sm:flex items-center">

                    <a href="{{ route('home') }}"
                        class="relative inline-flex items-center px-5 py-2.5 rounded-full text-sm font-bold {{ request()->routeIs('home') ? 'bg-gray-900 text-white shadow-md' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} transition-all duration-200">
                        <span class="relative z-10">Home</span>
                    </a>

                    <a href="{{ route('books.index') }}"
                        class="relative inline-flex items-center px-5 py-2.5 rounded-full text-sm font-bold {{ request()->routeIs('books.*') ? 'bg-gray-900 text-white shadow-md' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} transition-all duration-200">
                        <span class="relative z-10">Shop</span>
                    </a>

                    <div x-data="{ open: false }" class="relative group">

                        <button @mouseenter="open = true" @mouseleave="open = false" @click="open = !open"
                            @keydown.escape.window="open = false"
                            class="relative inline-flex items-center px-5 py-2.5 rounded-full text-sm font-bold text-gray-600 hover:text-gray-900 hover:bg-gray-50 transition-all duration-200"
                            aria-haspopup="true" :aria-expanded="open.toString()">

                            <span class="relative z-10">Collections</span>

                            <svg class="w-4 h-4 ml-1 opacity-70" :class="open ? 'rotate-180' : ''" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>

                        </button>

                        <div x-show="open" @mouseenter="open = true" @mouseleave="open = false"
                            @click.away="open = false" x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 scale-95 translate-y-1"
                            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                            x-transition:leave-end="opacity-0 scale-95 translate-y-1"
                            class="absolute top-full left-0 mt-2 w-64 bg-white rounded-2xl shadow-xl border border-gray-100 py-2 z-50">

                            <div class="px-4 py-3 border-b border-gray-100">
                                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Browse by Author</h3>
                            </div>

                            @php $navAuthors = \App\Models\Book::select('author')->distinct()->orderBy('author')->limit(6)->pluck('author'); @endphp

                            @foreach($navAuthors as $navAuthor)
                                <a href="{{ route('books.index', ['author' => $navAuthor]) }}"
                                    class="flex items-center px-4 py-3 hover:bg-gray-50 transition-colors duration-200 group">
                                    <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-primary-100 transition-colors">
                                        <svg class="w-4 h-4 text-gray-500 group-hover:text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-gray-900">{{ $navAuthor }}</div>
                                    </div>
                                </a>
                            @endforeach

                            <div class="border-t border-gray-100 pt-2 mt-2 px-2">
                                <a href="{{ route('books.index') }}"
                                    class="block px-4 py-2 text-sm text-center font-bold text-white bg-gray-900 rounded-xl hover:bg-black transition-colors">
                                    View All Collections
                                </a>
                            </div>

                        </div>

                    </div>

                    <a href="{{ route('about') }}"
                        class="relative inline-flex items-center px-5 py-2.5 rounded-full text-sm font-bold {{ request()->routeIs('about') ? 'bg-gray-900 text-white shadow-md' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} transition-all duration-200">
                        <span class="relative z-10">About</span>
                    </a>

                    <a href="#"
                        class="relative inline-flex items-center px-5 py-2.5 rounded-full text-sm font-bold text-gray-600 hover:text-gray-900 hover:bg-gray-50 transition-all duration-200">
                        <span class="relative z-10">Contact</span>
                    </a>

                </div>

            </div>

            <div class="hidden sm:ml-6 sm:flex sm:items-center">

                <!-- Enhanced User Actions -->

                <div class="ml-3 relative">

                    @auth

                        <div class="flex items-center space-x-3">

                            <!-- Enhanced Cart -->

                            <a href="{{ route('cart.index') }}"
                                class="group relative p-3 rounded-full bg-white border border-gray-100 text-gray-600 hover:text-gray-900 hover:border-gray-300 transition-all duration-300 hover:shadow-md">

                                <span class="sr-only">View cart</span>

                                <svg class="h-5 w-5 transition-transform duration-300 group-hover:scale-110"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>

                                @php $cartCount = Auth::user()->cart ? Auth::user()->cart->items->count() : 0; @endphp

                                @if($cartCount > 0)
                                    <span class="absolute -top-1 -right-1 inline-flex items-center justify-center min-w-[1.25rem] h-5 px-1.5 text-xs font-bold leading-none text-white transform bg-red-500 rounded-full border border-white">{{ $cartCount }}</span>
                                @endif

                            </a>



                            <!-- Enhanced User Menu -->

                            <div x-data="{ open: false }" class="relative">

                                <button @click="open = !open" type="button"
                                    class="group flex items-center p-1 pl-2 pr-3 rounded-full bg-white border border-gray-100 hover:border-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-200 transition-all duration-300 hover:shadow-md"
                                    id="user-menu-button" aria-expanded="false" aria-haspopup="true">

                                    <span class="sr-only">Open user menu</span>

                                    <div class="h-8 w-8 rounded-full bg-gradient-to-br from-gray-700 to-gray-900 flex items-center justify-center text-white font-bold shadow-sm">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>

                                    <span class="ml-2 text-sm font-bold text-gray-700 max-w-[100px] truncate hidden md:block group-hover:text-gray-900 transition-colors">{{ Auth::user()->name }}</span>
                                    
                                    <svg class="ml-2 h-4 w-4 text-gray-400 group-hover:text-gray-600 transition-colors duration-300"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>

                                </button>


                                <div x-show="open" @click.away="open = false"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 scale-95"
                                    x-transition:enter-end="opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-150"
                                    x-transition:leave-start="opacity-100 scale-100"
                                    x-transition:leave-end="opacity-0 scale-95"
                                    class="origin-top-right absolute right-0 mt-3 w-64 rounded-2xl shadow-xl py-2 bg-white border border-gray-100 focus:outline-none z-50"
                                    role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button"
                                    tabindex="-1">

                                    <!-- User Info Header -->
                                    <div class="px-4 py-3 border-b border-gray-100">
                                        <p class="text-sm font-bold text-gray-900">{{ Auth::user()->name }}</p>
                                        <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                                    </div>

                                    <!-- Menu Items -->
                                    <div class="py-1">
                                        @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('superadmin'))
                                            <a href="{{ route('admin.dashboard') }}"
                                                class="flex items-center px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900"
                                                role="menuitem">
                                                <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                                </svg>
                                                Admin Dashboard
                                            </a>
                                        @endif

                                        <a href="{{ route('profile.edit') }}"
                                            class="flex items-center px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900"
                                            role="menuitem">
                                            <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            Your Profile
                                        </a>

                                        <a href="{{ route('profile.orders') }}"
                                            class="flex items-center px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900"
                                            role="menuitem">
                                            <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                            </svg>
                                            Your Orders
                                        </a>

                                        <a href="{{ route('wishlist.index') }}"
                                            class="flex items-center px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900"
                                            role="menuitem">
                                            <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                            </svg>
                                            Your Wishlist
                                            @php $wishlistCount = Auth::user()->wishlist()->count(); @endphp
                                            @if($wishlistCount > 0)
                                                <span class="ml-auto bg-red-100 text-red-600 py-0.5 px-2 rounded-full text-xs font-bold">{{ $wishlistCount }}</span>
                                            @endif
                                        </a>
                                    </div>

                                    <div class="border-t border-gray-100 my-1"></div>

                                    <form method="POST" action="{{ route('logout') }}"
                                        onsubmit="return handleLogout(event, this)">
                                        @csrf
                                        <button type="submit"
                                            class="flex items-center w-full px-4 py-2.5 text-sm font-bold text-red-600 hover:bg-red-50 transition-all duration-200"
                                            role="menuitem">
                                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                            </svg>
                                            Sign out
                                        </button>
                                    </form>

                                </div>

                            </div>

                        </div>

                    @else

                        <div class="flex items-center space-x-3">

                            <button onclick="document.dispatchEvent(new CustomEvent('open-auth-modal', {detail: 'login'}))"
                                class="px-5 py-2.5 text-sm font-bold text-gray-600 hover:text-gray-900 transition-colors duration-200">
                                Log in
                            </button>

                            <button
                                onclick="document.dispatchEvent(new CustomEvent('open-auth-modal', {detail: 'register'}))"
                                class="px-6 py-2.5 text-sm font-bold text-white bg-gray-900 rounded-full hover:bg-black transform hover:scale-105 transition-all duration-300 shadow-md">
                                Sign up
                            </button>

                        </div>

                    @endauth

                </div>

            </div>

            <!-- Enhanced Mobile menu button -->

            <div class="-mr-2 flex items-center sm:hidden">

                <button @click="mobileMenuOpen = !mobileMenuOpen" type="button"
                    class="group inline-flex items-center justify-center p-3 rounded-full text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:outline-none transition-all duration-300"
                    :aria-expanded="mobileMenuOpen.toString()">

                    <span class="sr-only">Open main menu</span>

                    <svg class="block h-6 w-6 transition-transform duration-300"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>

                </button>

            </div>

        </div>

    </div>



    

    <!-- Enhanced Mobile menu -->
    
    <template x-teleport="body">
        <div class="sm:hidden" id="mobile-menu" x-show="mobileMenuOpen" x-cloak 
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2" @keydown.escape.window="mobileMenuOpen=false">

            <div class="fixed inset-x-0 top-24 bottom-0 bg-white/95 backdrop-blur-xl border-t border-gray-100 overflow-y-auto z-[9999]">

            <div class="pt-6 pb-6 space-y-2 px-4" x-data="{ colOpen: false }">

                <a href="{{ route('home') }}"
                    class="flex items-center px-4 py-3 rounded-2xl {{ request()->routeIs('home') ? 'bg-indigo-50 text-indigo-700 font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 font-medium' }} text-base transition-all duration-200">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('home') ? 'text-indigo-500' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Home
                </a>

                <a href="{{ route('books.index') }}"
                    class="flex items-center px-4 py-3 rounded-2xl {{ request()->routeIs('books.*') ? 'bg-indigo-50 text-indigo-700 font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 font-medium' }} text-base transition-all duration-200">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('books.*') ? 'text-indigo-500' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    Shop
                </a>

                <!-- Collections (mobile) with author list -->
                <button @click="colOpen = !colOpen" type="button"
                    class="w-full flex items-center justify-between px-4 py-3 rounded-2xl text-gray-600 hover:bg-gray-50 hover:text-gray-900 text-base font-medium transition-all duration-200">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        Collections
                    </span>
                    <svg class="w-4 h-4 ml-2 text-gray-400 transition-transform duration-200" :class="colOpen ? 'rotate-180' : ''"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div x-show="colOpen" x-transition class="pl-4 space-y-1 overflow-hidden">
                    @php $mobileAuthors = \App\Models\Book::select('author')->distinct()->orderBy('author')->limit(8)->pluck('author'); @endphp
                    
                    @foreach($mobileAuthors as $mAuthor)
                        <a href="{{ route('books.index', ['author' => $mAuthor]) }}"
                            class="flex items-center px-4 py-2 rounded-xl text-gray-500 hover:bg-gray-50 hover:text-indigo-600 text-sm font-medium transition-colors">
                            <span class="truncate">{{ $mAuthor }}</span>
                        </a>
                    @endforeach

                    <a href="{{ route('books.index') }}"
                        class="block px-4 py-2 text-sm text-indigo-600 font-bold hover:text-indigo-800 transition-colors">
                        View All Collections →
                    </a>
                </div>

                <a href="{{ route('about') }}"
                    class="flex items-center px-4 py-3 rounded-2xl {{ request()->routeIs('about') ? 'bg-indigo-50 text-indigo-700 font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 font-medium' }} text-base transition-all duration-200">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('about') ? 'text-indigo-500' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    About
                </a>

                <a href="#"
                    class="flex items-center px-4 py-3 rounded-2xl text-gray-600 hover:bg-gray-50 hover:text-gray-900 text-base font-medium transition-all duration-200">
                    <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    Contact
                </a>

          

            </div>

            <div class="pt-6 pb-8 border-t border-gray-100 px-6 bg-gray-50/50">

                @auth
                    <div class="flex items-center p-4 bg-white rounded-2xl border border-gray-100 shadow-sm mb-6">
                        <div class="flex-shrink-0">
                            <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-md">
                                <span class="text-xl font-bold text-white">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </div>
                        </div>
                        <div class="ml-4 flex-1 min-w-0">
                            <div class="text-base font-bold text-gray-900 truncate">{{ Auth::user()->name }}</div>
                            <div class="text-sm text-gray-500 truncate">{{ Auth::user()->email }}</div>
                        </div>
                        
                        <!-- Mobile Cart Badge inside profile card -->
                        <a href="{{ route('cart.index') }}" class="ml-2 relative p-2 text-gray-400 hover:text-indigo-600 transition-colors">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            @if(Auth::user()->cart && Auth::user()->cart->items->count() > 0)
                                <span class="absolute top-0 right-0 block h-2.5 w-2.5 rounded-full bg-red-500 ring-2 ring-white"></span>
                            @endif
                        </a>
                    </div>

                    <div class="space-y-2">
                        @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('superadmin'))
                            <a href="{{ route('admin.dashboard') }}"
                                class="flex items-center px-4 py-3 rounded-xl text-gray-700 hover:bg-white hover:text-indigo-600 hover:shadow-sm text-sm font-bold transition-all duration-200">
                                <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                                Admin Dashboard
                            </a>
                        @endif

                        <a href="{{ route('profile.edit') }}"
                            class="flex items-center px-4 py-3 rounded-xl text-gray-700 hover:bg-white hover:text-indigo-600 hover:shadow-sm text-sm font-bold transition-all duration-200">
                            <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Your Profile
                        </a>

                        <a href="{{ route('profile.orders') }}"
                            class="flex items-center px-4 py-3 rounded-xl text-gray-700 hover:bg-white hover:text-indigo-600 hover:shadow-sm text-sm font-bold transition-all duration-200">
                            <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            Your Orders
                        </a>

                        <a href="{{ route('wishlist.index') }}"
                            class="flex items-center justify-between px-4 py-3 rounded-xl text-gray-700 hover:bg-white hover:text-indigo-600 hover:shadow-sm text-sm font-bold transition-all duration-200">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                                Your Wishlist
                            </div>
                            @php $wishlistCount = Auth::user()->wishlist()->count(); @endphp
                            @if($wishlistCount > 0)
                                <span class="bg-red-100 text-red-600 text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">{{ $wishlistCount }}</span>
                            @endif
                        </a>

                        <form method="POST" action="{{ route('logout') }}" onsubmit="return handleLogout(event, this)">
                            @csrf
                            <button type="submit"
                                class="flex items-center w-full px-4 py-3 rounded-xl text-red-600 hover:bg-red-50 hover:text-red-700 hover:shadow-sm text-sm font-bold transition-all duration-200 mt-4">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Sign out
                            </button>
                        </form>
                    </div>

                @else
                    <div class="space-y-3 pb-8">
                        <button onclick="document.dispatchEvent(new CustomEvent('open-auth-modal', {detail: 'login'}))"
                            class="w-full px-6 py-4 text-center rounded-2xl border border-gray-200 text-gray-700 hover:bg-gray-50 hover:text-gray-900 text-base font-bold transition-all duration-200 shadow-sm">
                            Log in
                        </button>
                        <button onclick="document.dispatchEvent(new CustomEvent('open-auth-modal', {detail: 'register'}))"
                            class="w-full px-6 py-4 text-center rounded-2xl bg-gray-900 text-white hover:bg-black text-base font-bold transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-[1.02] active:scale-[0.98]">
                            Sign up
                        </button>
                    </div>
                @endauth

            </div>

        </div>

    </div>

    </template>

</nav>