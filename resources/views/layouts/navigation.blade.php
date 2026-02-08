<nav x-data="{ mobileMenuOpen: false, mobileSearchOpen: false }"
    class="bg-white/80 backdrop-blur-xl shadow-sm z-50 sticky top-0 transition-all duration-300 nav-fade-in border-b border-gray-100">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex justify-between h-16 sm:h-24">

            <div class="flex">

                <!-- Enhanced Logo -->

                <div class="shrink-0 flex items-center">

                    <a href="{{ route('home') }}"
                        class="flex items-center group transition-all duration-300 hover:scale-105">

                        <div class="relative">
                            <img src="{{ asset('images/BooktyL.png') }}" alt="Bookty Logo"
                                class="h-8 sm:h-10 w-auto transition-all duration-300 group-hover:drop-shadow-lg">
                            <div
                                class="absolute inset-0 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full opacity-0 group-hover:opacity-20 transition-opacity duration-300 blur-xl">
                            </div>
                        </div>

                        <div class="ml-2 sm:ml-3">
                            <span class="text-xl sm:text-2xl font-bold text-gray-900 font-serif tracking-tight">Bookty</span>
                            <div class="text-xs sm:text-sm text-gray-500 font-medium -mt-1 hidden sm:block">Enterprise</div>
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

                    <a href="{{ route('contact') }}"
                        class="relative inline-flex items-center px-5 py-2.5 rounded-full text-sm font-bold {{ request()->routeIs('contact') ? 'bg-gray-900 text-white shadow-md' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} transition-all duration-200">
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

                                @php $cartCount = Auth::user()->cart ? Auth::user()->cart->items->sum('quantity') : 0; @endphp

                                <span class="cart-count-badge absolute -top-1 -right-1 inline-flex items-center justify-center min-w-[1.25rem] h-5 px-1.5 text-xs font-bold leading-none text-white transform bg-red-500 rounded-full border border-white {{ $cartCount > 0 ? '' : 'hidden' }}">
                                    <span class="cart-count">{{ $cartCount }}</span>
                                </span>

                            </a>



                            <!-- Enhanced User Menu -->

                            <div x-data="{ open: false }" class="relative">

                                <button @click="open = !open" type="button"
                                    class="group flex items-center p-1 pl-2 pr-3 rounded-full bg-white border border-gray-100 hover:border-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-200 transition-all duration-300 hover:shadow-md"
                                    id="user-menu-button" aria-expanded="false" aria-haspopup="true">

                                    <span class="sr-only">Open user menu</span>

                                    @if(Auth::user()->hasAvatar())
                                        <img src="{{ Auth::user()->getAvatarUrl() }}" alt="{{ Auth::user()->name }}" class="h-8 w-8 rounded-full object-cover shadow-sm">
                                    @else
                                        <div class="h-8 w-8 rounded-full bg-gradient-to-br from-gray-700 to-gray-900 flex items-center justify-center text-white font-bold shadow-sm">
                                            {{ substr(Auth::user()->name, 0, 1) }}
                                        </div>
                                    @endif

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

            <!-- Mobile Quick Actions & Menu Button -->

            <div class="flex items-center gap-1 sm:hidden">
                
                <!-- Mobile Search Button -->
                <a href="{{ route('books.index') }}"
                    class="p-2.5 rounded-xl text-gray-500 hover:text-gray-900 hover:bg-gray-100 transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </a>

                @auth
                <!-- Mobile Cart Button -->
                <a href="{{ route('cart.index') }}"
                    class="relative p-2.5 rounded-xl text-gray-500 hover:text-gray-900 hover:bg-gray-100 transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    @php $mobileHeaderCartCount = Auth::user()->cart ? Auth::user()->cart->items->sum('quantity') : 0; @endphp
                    <span class="cart-count-badge absolute -top-0.5 -right-0.5 inline-flex items-center justify-center min-w-[1rem] h-4 px-1 text-[10px] font-bold text-white bg-red-500 rounded-full {{ $mobileHeaderCartCount > 0 ? '' : 'hidden' }}">
                        <span class="cart-count">{{ $mobileHeaderCartCount }}</span>
                    </span>
                </a>
                @endauth

                <!-- Mobile Menu Button with Animation -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" type="button"
                    class="relative p-2.5 rounded-xl text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:outline-none transition-all duration-200"
                    :aria-expanded="mobileMenuOpen.toString()">

                    <span class="sr-only">Open main menu</span>

                    <!-- Hamburger to X animation -->
                    <div class="w-5 h-5 flex flex-col justify-center items-center">
                        <span class="block h-0.5 w-5 bg-current transform transition-all duration-300 ease-out"
                            :class="mobileMenuOpen ? 'rotate-45 translate-y-0.5' : '-translate-y-1'"></span>
                        <span class="block h-0.5 w-5 bg-current transition-all duration-300 ease-out"
                            :class="mobileMenuOpen ? 'opacity-0 scale-0' : 'opacity-100'"></span>
                        <span class="block h-0.5 w-5 bg-current transform transition-all duration-300 ease-out"
                            :class="mobileMenuOpen ? '-rotate-45 -translate-y-0.5' : 'translate-y-1'"></span>
                    </div>

                </button>

            </div>

        </div>

    </div>



    

    <!-- Enhanced Mobile Menu - Full Screen Overlay -->
    
    <template x-teleport="body">
        <!-- Backdrop -->
        <div x-show="mobileMenuOpen" x-cloak
            class="sm:hidden fixed inset-0 bg-black/20 backdrop-blur-sm z-[9998]"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="mobileMenuOpen = false">
        </div>

        <!-- Mobile Menu Panel -->
        <div class="sm:hidden" id="mobile-menu" x-show="mobileMenuOpen" x-cloak 
            x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="opacity-0 translate-x-full"
            x-transition:enter-end="opacity-100 translate-x-0"
            x-transition:leave="transition ease-in duration-200 transform"
            x-transition:leave-start="opacity-100 translate-x-0"
            x-transition:leave-end="opacity-0 translate-x-full"
            @keydown.escape.window="mobileMenuOpen = false">

            <div class="fixed inset-y-0 right-0 w-full max-w-sm bg-white shadow-2xl z-[9999] flex flex-col" x-data="{ colOpen: false }">
                
                <!-- Mobile Menu Header -->
                <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                    <div class="flex items-center">
                        <img src="{{ asset('images/BooktyL.png') }}" alt="Bookty" class="h-8 w-auto">
                        <span class="ml-2 text-lg font-bold text-gray-900">Bookty</span>
                    </div>
                    <button @click="mobileMenuOpen = false" 
                        class="p-2 rounded-xl text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-all">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Scrollable Content -->
                <div class="flex-1 overflow-y-auto">
                    
                    @auth
                    <!-- User Profile Card -->
                    <div class="p-4 bg-gray-50 border-b border-gray-100">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                @if(Auth::user()->hasAvatar())
                                    <img src="{{ Auth::user()->getAvatarUrl() }}" alt="{{ Auth::user()->name }}" class="h-14 w-14 rounded-2xl object-cover shadow-md ring-2 ring-white">
                                @else
                                    <div class="h-14 w-14 rounded-2xl bg-gray-900 flex items-center justify-center shadow-md ring-2 ring-white">
                                        <span class="text-xl font-bold text-white">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="ml-4 flex-1 min-w-0">
                                <p class="text-base font-bold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                                <p class="text-sm text-gray-500 truncate">{{ Auth::user()->email }}</p>
                            </div>
                        </div>
                        
                        <!-- Quick Stats -->
                        <div class="flex gap-3 mt-4">
                            @php 
                                $mobileCartCount = Auth::user()->cart ? Auth::user()->cart->items->sum('quantity') : 0;
                                $mobileWishlistCount = Auth::user()->wishlist()->count();
                            @endphp
                            <a href="{{ route('cart.index') }}" class="flex-1 flex items-center justify-center gap-2 py-2.5 px-3 bg-white rounded-xl border border-gray-200 hover:border-gray-300 hover:shadow-sm transition-all">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                                <span class="text-sm font-semibold text-gray-700">Cart</span>
                                @if($mobileCartCount > 0)
                                    <span class="cart-count inline-flex items-center justify-center min-w-[1.25rem] h-5 px-1.5 text-xs font-bold text-white bg-red-500 rounded-full">{{ $mobileCartCount }}</span>
                                @endif
                            </a>
                            <a href="{{ route('wishlist.index') }}" class="flex-1 flex items-center justify-center gap-2 py-2.5 px-3 bg-white rounded-xl border border-gray-200 hover:border-gray-300 hover:shadow-sm transition-all">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                                <span class="text-sm font-semibold text-gray-700">Wishlist</span>
                                @if($mobileWishlistCount > 0)
                                    <span class="inline-flex items-center justify-center min-w-[1.25rem] h-5 px-1.5 text-xs font-bold text-white bg-pink-500 rounded-full">{{ $mobileWishlistCount }}</span>
                                @endif
                            </a>
                        </div>
                    </div>
                    @endauth

                    <!-- Navigation Links -->
                    <div class="p-4 space-y-1">
                        <p class="px-3 py-2 text-xs font-bold text-gray-400 uppercase tracking-wider">Menu</p>
                        
                        <a href="{{ route('home') }}" @click="mobileMenuOpen = false"
                            class="flex items-center px-4 py-3.5 rounded-xl {{ request()->routeIs('home') ? 'bg-gray-900 text-white' : 'text-gray-700 hover:bg-gray-50' }} transition-all duration-200">
                            <div class="w-9 h-9 rounded-lg {{ request()->routeIs('home') ? 'bg-white/20' : 'bg-gray-100' }} flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 {{ request()->routeIs('home') ? 'text-white' : 'text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                            </div>
                            <span class="font-semibold">Home</span>
                        </a>

                        <a href="{{ route('books.index') }}" @click="mobileMenuOpen = false"
                            class="flex items-center px-4 py-3.5 rounded-xl {{ request()->routeIs('books.*') ? 'bg-gray-900 text-white' : 'text-gray-700 hover:bg-gray-50' }} transition-all duration-200">
                            <div class="w-9 h-9 rounded-lg {{ request()->routeIs('books.*') ? 'bg-white/20' : 'bg-gray-100' }} flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 {{ request()->routeIs('books.*') ? 'text-white' : 'text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>
                            <span class="font-semibold">Shop Books</span>
                        </a>

                        <!-- Collections Accordion -->
                        <div class="rounded-xl overflow-hidden">
                            <button @click="colOpen = !colOpen" type="button"
                                class="w-full flex items-center justify-between px-4 py-3.5 text-gray-700 hover:bg-gray-50 transition-all duration-200">
                                <div class="flex items-center">
                                    <div class="w-9 h-9 rounded-lg bg-gray-100 flex items-center justify-center mr-3">
                                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                        </svg>
                                    </div>
                                    <span class="font-semibold">Collections</span>
                                </div>
                                <svg class="w-5 h-5 text-gray-400 transition-transform duration-200" :class="colOpen ? 'rotate-180' : ''"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <div x-show="colOpen" x-collapse class="bg-gray-50">
                                @php $mobileAuthors = \App\Models\Book::select('author')->distinct()->orderBy('author')->limit(6)->pluck('author'); @endphp
                                
                                <div class="py-2 px-4 space-y-1">
                                    @foreach($mobileAuthors as $mAuthor)
                                        <a href="{{ route('books.index', ['author' => $mAuthor]) }}" @click="mobileMenuOpen = false"
                                            class="flex items-center px-3 py-2.5 rounded-lg text-gray-600 hover:bg-white hover:text-gray-900 text-sm font-medium transition-all">
                                            <span class="w-6 h-6 rounded-full bg-gray-200 flex items-center justify-center mr-2 text-xs font-bold text-gray-500">
                                                {{ substr($mAuthor, 0, 1) }}
                                            </span>
                                            <span class="truncate">{{ $mAuthor }}</span>
                                        </a>
                                    @endforeach

                                    <a href="{{ route('books.index') }}" @click="mobileMenuOpen = false"
                                        class="flex items-center justify-center px-3 py-2.5 mt-2 text-sm text-gray-900 font-bold hover:bg-white rounded-lg transition-all">
                                        View All Authors
                                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('about') }}" @click="mobileMenuOpen = false"
                            class="flex items-center px-4 py-3.5 rounded-xl {{ request()->routeIs('about') ? 'bg-gray-900 text-white' : 'text-gray-700 hover:bg-gray-50' }} transition-all duration-200">
                            <div class="w-9 h-9 rounded-lg {{ request()->routeIs('about') ? 'bg-white/20' : 'bg-gray-100' }} flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 {{ request()->routeIs('about') ? 'text-white' : 'text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <span class="font-semibold">About Us</span>
                        </a>

                        <a href="{{ route('contact') }}" @click="mobileMenuOpen = false"
                            class="flex items-center px-4 py-3.5 rounded-xl {{ request()->routeIs('contact') ? 'bg-gray-900 text-white' : 'text-gray-700 hover:bg-gray-50' }} transition-all duration-200">
                            <div class="w-9 h-9 rounded-lg {{ request()->routeIs('contact') ? 'bg-white/20' : 'bg-gray-100' }} flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 {{ request()->routeIs('contact') ? 'text-white' : 'text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <span class="font-semibold">Contact</span>
                        </a>
                    </div>

                    @auth
                    <!-- Account Section -->
                    <div class="p-4 space-y-1 border-t border-gray-100">
                        <p class="px-3 py-2 text-xs font-bold text-gray-400 uppercase tracking-wider">Account</p>

                        @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('superadmin'))
                            <a href="{{ route('admin.dashboard') }}" @click="mobileMenuOpen = false"
                                class="flex items-center px-4 py-3.5 rounded-xl text-gray-700 hover:bg-gray-50 transition-all duration-200">
                                <div class="w-9 h-9 rounded-lg bg-purple-100 flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                    </svg>
                                </div>
                                <span class="font-semibold">Admin Dashboard</span>
                            </a>
                        @endif

                        <a href="{{ route('profile.edit') }}" @click="mobileMenuOpen = false"
                            class="flex items-center px-4 py-3.5 rounded-xl text-gray-700 hover:bg-gray-50 transition-all duration-200">
                            <div class="w-9 h-9 rounded-lg bg-gray-100 flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <span class="font-semibold">Profile Settings</span>
                        </a>

                        <a href="{{ route('profile.orders') }}" @click="mobileMenuOpen = false"
                            class="flex items-center px-4 py-3.5 rounded-xl text-gray-700 hover:bg-gray-50 transition-all duration-200">
                            <div class="w-9 h-9 rounded-lg bg-gray-100 flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                                </svg>
                            </div>
                            <span class="font-semibold">Order History</span>
                        </a>
                    </div>
                    @endauth

                </div>

                <!-- Bottom Action -->
                <div class="p-4 border-t border-gray-100 bg-gray-50 safe-area-bottom">
                    @auth
                        <form method="POST" action="{{ route('logout') }}" onsubmit="return handleLogout(event, this)">
                            @csrf
                            <button type="submit"
                                class="w-full flex items-center justify-center gap-2 px-4 py-3.5 rounded-xl bg-red-50 text-red-600 hover:bg-red-100 font-semibold transition-all duration-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                Sign Out
                            </button>
                        </form>
                    @else
                        <div class="space-y-3">
                            <button onclick="document.dispatchEvent(new CustomEvent('open-auth-modal', {detail: 'login'})); mobileMenuOpen = false"
                                class="w-full px-4 py-3.5 text-center rounded-xl border-2 border-gray-200 text-gray-700 hover:bg-gray-50 hover:border-gray-300 font-semibold transition-all duration-200">
                                Log In
                            </button>
                            <button onclick="document.dispatchEvent(new CustomEvent('open-auth-modal', {detail: 'register'})); mobileMenuOpen = false"
                                class="w-full px-4 py-3.5 text-center rounded-xl bg-gray-900 text-white hover:bg-black font-semibold transition-all duration-200 shadow-lg">
                                Create Account
                            </button>
                        </div>
                    @endauth
                </div>

            </div>

        </div>

    </template>

    <!-- Mobile Bottom Navigation Bar (Visible only on mobile) -->
    <div class="sm:hidden fixed bottom-0 inset-x-0 bg-white border-t border-gray-200 z-[999] safe-area-bottom">
        <div class="flex items-center justify-around h-16">
            <a href="{{ route('home') }}" class="flex flex-col items-center justify-center flex-1 py-2 {{ request()->routeIs('home') ? 'text-gray-900' : 'text-gray-400' }} transition-colors">
                <svg class="w-6 h-6 {{ request()->routeIs('home') ? 'text-gray-900' : '' }}" fill="{{ request()->routeIs('home') ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ request()->routeIs('home') ? '0' : '1.5' }}" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span class="text-[10px] font-semibold mt-1">Home</span>
            </a>
            
            <a href="{{ route('books.index') }}" class="flex flex-col items-center justify-center flex-1 py-2 {{ request()->routeIs('books.*') ? 'text-gray-900' : 'text-gray-400' }} transition-colors">
                <svg class="w-6 h-6" fill="{{ request()->routeIs('books.*') ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ request()->routeIs('books.*') ? '0' : '1.5' }}" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                <span class="text-[10px] font-semibold mt-1">Shop</span>
            </a>

            @auth
            <a href="{{ route('cart.index') }}" class="flex flex-col items-center justify-center flex-1 py-2 relative {{ request()->routeIs('cart.*') ? 'text-gray-900' : 'text-gray-400' }} transition-colors">
                <div class="relative">
                    <svg class="w-6 h-6" fill="{{ request()->routeIs('cart.*') ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ request()->routeIs('cart.*') ? '0' : '1.5' }}" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    @php $bottomNavCartCount = Auth::user()->cart ? Auth::user()->cart->items->sum('quantity') : 0; @endphp
                    <span class="cart-count-badge absolute -top-1.5 -right-1.5 inline-flex items-center justify-center min-w-[1rem] h-4 px-1 text-[10px] font-bold text-white bg-red-500 rounded-full {{ $bottomNavCartCount > 0 ? '' : 'hidden' }}">
                        <span class="cart-count">{{ $bottomNavCartCount }}</span>
                    </span>
                </div>
                <span class="text-[10px] font-semibold mt-1">Cart</span>
            </a>

            <a href="{{ route('wishlist.index') }}" class="flex flex-col items-center justify-center flex-1 py-2 {{ request()->routeIs('wishlist.*') ? 'text-gray-900' : 'text-gray-400' }} transition-colors">
                <svg class="w-6 h-6" fill="{{ request()->routeIs('wishlist.*') ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ request()->routeIs('wishlist.*') ? '0' : '1.5' }}" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
                <span class="text-[10px] font-semibold mt-1">Wishlist</span>
            </a>

            <a href="{{ route('profile.edit') }}" class="flex flex-col items-center justify-center flex-1 py-2 {{ request()->routeIs('profile.*') ? 'text-gray-900' : 'text-gray-400' }} transition-colors">
                @if(Auth::user()->hasAvatar())
                    <img src="{{ Auth::user()->getAvatarUrl() }}" alt="{{ Auth::user()->name }}" class="w-6 h-6 rounded-full object-cover {{ request()->routeIs('profile.*') ? 'ring-2 ring-gray-900' : '' }}">
                @else
                    <div class="w-6 h-6 rounded-full {{ request()->routeIs('profile.*') ? 'bg-gray-900 ring-2 ring-gray-900' : 'bg-gray-300' }} flex items-center justify-center">
                        <span class="text-[10px] font-bold {{ request()->routeIs('profile.*') ? 'text-white' : 'text-gray-600' }}">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    </div>
                @endif
                <span class="text-[10px] font-semibold mt-1">Profile</span>
            </a>
            @else
            <button onclick="document.dispatchEvent(new CustomEvent('open-auth-modal', {detail: 'login'}))" class="flex flex-col items-center justify-center flex-1 py-2 text-gray-400 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <span class="text-[10px] font-semibold mt-1">Login</span>
            </button>
            @endauth
        </div>
    </div>

</nav>

<!-- Add bottom padding to body for mobile bottom nav -->
<style>
    @media (max-width: 639px) {
        body {
            padding-bottom: 4rem;
        }
        .safe-area-bottom {
            padding-bottom: env(safe-area-inset-bottom, 0);
        }
    }
</style>