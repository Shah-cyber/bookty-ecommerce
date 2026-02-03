<aside
    class="fixed inset-y-0 left-0 z-50 w-64 bg-white dark:bg-gray-800 shadow-xl transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0"
    :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}" @click.away="sidebarOpen = false"
    @keydown.escape.window="sidebarOpen = false">
    <!-- Logo -->
    <div
        class="flex items-center h-16 bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 px-4">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group w-full">
            <!-- Logo Container with Subtle Circle -->
            <div class="relative flex-shrink-0">
                <div class="w-10 h-10 rounded-full bg-purple-50 dark:bg-purple-900/30 flex items-center justify-center overflow-hidden">
                    <img src="{{ asset('images/BooktyL.png') }}" alt="Bookty Logo" 
                         class="w-7 h-7 object-contain">
                </div>
            </div>
            
            <!-- Brand Text -->
            <div class="flex-1 min-w-0">
                <span class="text-base font-semibold text-purple-700 dark:text-purple-300 truncate block">
                    Bookty Enterprise
                </span>
            </div>
        </a>
    </div>

    <!-- Nav -->
    <nav class="h-[calc(100vh-4rem)] overflow-y-auto custom-scrollbar p-3 space-y-1">

        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}"
            class="flex items-center px-3 py-2.5 rounded-lg transition-all duration-200 group
                  {{ request()->routeIs('admin.dashboard')
    ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 font-medium'
    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
            <svg class="w-5 h-5 transition-colors duration-200 {{ request()->routeIs('admin.dashboard') ? 'text-purple-600 dark:text-purple-400' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-700 dark:group-hover:text-gray-200' }}"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                </path>
            </svg>
            <span class="ml-3 text-sm">Dashboard</span>
        </a>

        {{-- Catalog Section - Show if user can view any catalog items --}}
        @canany(['view books', 'view genres', 'view tropes'])
        <div class="pt-3 pb-2">
            <p class="px-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Catalog</p>
        </div>

        <!-- Books -->
        @can('view books')
        <a href="{{ route('admin.books.index') }}"
            class="flex items-center px-3 py-2.5 rounded-lg transition-all duration-200 group
                  {{ request()->routeIs('admin.books.*')
    ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 font-medium'
    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
            <svg class="w-5 h-5 transition-colors duration-200 {{ request()->routeIs('admin.books.*') ? 'text-purple-600 dark:text-purple-400' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-700 dark:group-hover:text-gray-200' }}"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                </path>
            </svg>
            <span class="ml-3 text-sm">Books</span>
        </a>
        @endcan

        <!-- Genres -->
        @can('view genres')
        <a href="{{ route('admin.genres.index') }}"
            class="flex items-center px-3 py-2.5 rounded-lg transition-all duration-200 group
                  {{ request()->routeIs('admin.genres.*')
    ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 font-medium'
    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
            <svg class="w-5 h-5 transition-colors duration-200 {{ request()->routeIs('admin.genres.*') ? 'text-purple-600 dark:text-purple-400' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-700 dark:group-hover:text-gray-200' }}"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                </path>
            </svg>
            <span class="ml-3 text-sm">Genres</span>
        </a>
        @endcan

        <!-- Tropes -->
        @can('view tropes')
        <a href="{{ route('admin.tropes.index') }}"
            class="flex items-center px-3 py-2.5 rounded-lg transition-all duration-200 group
                  {{ request()->routeIs('admin.tropes.*')
    ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 font-medium'
    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
            <svg class="w-5 h-5 transition-colors duration-200 {{ request()->routeIs('admin.tropes.*') ? 'text-purple-600 dark:text-purple-400' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-700 dark:group-hover:text-gray-200' }}"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z">
                </path>
            </svg>
            <span class="ml-3 text-sm">Tropes</span>
        </a>
        @endcan
        @endcanany

        {{-- Sales & Users Section - Show if user can view orders or customers --}}
        @canany(['view orders', 'view customers', 'view discounts', 'view coupons', 'view flash sales'])
        <div class="pt-3 pb-2">
            <p class="px-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Sales & Users</p>
        </div>

        <!-- Orders -->
        @can('view orders')
        <a href="{{ route('admin.orders.index') }}"
            class="flex items-center px-3 py-2.5 rounded-lg transition-all duration-200 group
                  {{ request()->routeIs('admin.orders.*')
    ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 font-medium'
    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
            <svg class="w-5 h-5 transition-colors duration-200 {{ request()->routeIs('admin.orders.*') ? 'text-purple-600 dark:text-purple-400' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-700 dark:group-hover:text-gray-200' }}"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
            </svg>
            <span class="ml-3 text-sm">Orders</span>
        </a>
        @endcan

        <!-- Customers -->
        @can('view customers')
        <a href="{{ route('admin.customers.index') }}"
            class="flex items-center px-3 py-2.5 rounded-lg transition-all duration-200 group
                  {{ request()->routeIs('admin.customers.*')
    ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 font-medium'
    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
            <svg class="w-5 h-5 transition-colors duration-200 {{ request()->routeIs('admin.customers.*') ? 'text-purple-600 dark:text-purple-400' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-700 dark:group-hover:text-gray-200' }}"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                </path>
            </svg>
            <span class="ml-3 text-sm">Customers</span>
        </a>
        @endcan

        <!-- Promotions (Collapsible) -->
        @canany(['view discounts', 'view coupons', 'view flash sales'])
        <div
            x-data="{ open: {{ request()->routeIs('admin.discounts.*') || request()->routeIs('admin.coupons.*') || request()->routeIs('admin.flash-sales.*') ? 'true' : 'false' }} }">
            <button @click="open = !open"
                class="flex items-center w-full px-3 py-2.5 rounded-lg transition-all duration-200 group justify-between
                           {{ request()->routeIs('admin.discounts.*') || request()->routeIs('admin.coupons.*') || request()->routeIs('admin.flash-sales.*')
    ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 font-medium'
    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                <div class="flex items-center">
                    <svg class="w-5 h-5 transition-colors duration-200 {{ request()->routeIs('admin.discounts.*') || request()->routeIs('admin.coupons.*') || request()->routeIs('admin.flash-sales.*') ? 'text-purple-600 dark:text-purple-400' : 'text-gray-400 group-hover:text-gray-600 dark:text-gray-500 dark:group-hover:text-gray-300' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                        </path>
                    </svg>
                    <span class="ml-3 text-sm">Promotions</span>
                </div>
                <svg class="w-4 h-4 transition-transform duration-200" :class="{'rotate-180': open}" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div x-show="open" x-collapse class="space-y-1 pl-11 pr-4 overflow-hidden">
                @can('view discounts')
                <a href="{{ route('admin.discounts.index') }}"
                    class="block py-2 text-sm rounded-lg transition-colors duration-200
                          {{ request()->routeIs('admin.discounts.*') ? 'text-purple-600 dark:text-purple-400 font-medium' : 'text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200' }}">
                    Book Discounts
                </a>
                @endcan
                @can('view coupons')
                <a href="{{ route('admin.coupons.index') }}"
                    class="block py-2 text-sm rounded-lg transition-colors duration-200
                          {{ request()->routeIs('admin.coupons.*') ? 'text-purple-600 dark:text-purple-400 font-medium' : 'text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200' }}">
                    Coupon Codes
                </a>
                @endcan
                @can('view flash sales')
                <a href="{{ route('admin.flash-sales.index') }}"
                    class="block py-2 text-sm rounded-lg transition-colors duration-200
                          {{ request()->routeIs('admin.flash-sales.*') ? 'text-purple-600 dark:text-purple-400 font-medium' : 'text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200' }}">
                    Flash Sales
                </a>
                @endcan
            </div>
        </div>
        @endcanany
        @endcanany

        {{-- Reports Section --}}
        @can('view reports')
        <!-- Reports (Collapsible) -->
        <div x-data="{ open: {{ request()->routeIs('admin.reports.*') ? 'true' : 'false' }} }">
            <button @click="open = !open"
                class="flex items-center w-full px-3 py-2.5 rounded-lg transition-all duration-200 group justify-between
                           {{ request()->routeIs('admin.reports.*')
    ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 font-medium'
    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                <div class="flex items-center">
                    <svg class="w-5 h-5 transition-colors duration-200 {{ request()->routeIs('admin.reports.*') ? 'text-purple-600 dark:text-purple-400' : 'text-gray-400 group-hover:text-gray-600 dark:text-gray-500 dark:group-hover:text-gray-300' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                        </path>
                    </svg>
                    <span class="ml-3 text-sm">Reports</span>
                </div>
                <svg class="w-4 h-4 transition-transform duration-200" :class="{'rotate-180': open}" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div x-show="open" x-collapse class="space-y-1 pl-11 pr-4 overflow-hidden">
                <a href="{{ route('admin.reports.index') }}"
                    class="block py-2 text-sm rounded-lg transition-colors duration-200
                          {{ request()->routeIs('admin.reports.index') ? 'text-purple-600 dark:text-purple-400 font-medium' : 'text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200' }}">
                    Dashboard
                </a>
                <a href="{{ route('admin.reports.sales') }}"
                    class="block py-2 text-sm rounded-lg transition-colors duration-200
                          {{ request()->routeIs('admin.reports.sales') ? 'text-purple-600 dark:text-purple-400 font-medium' : 'text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200' }}">
                    Sales
                </a>
                <a href="{{ route('admin.reports.customers') }}"
                    class="block py-2 text-sm rounded-lg transition-colors duration-200
                          {{ request()->routeIs('admin.reports.customers') ? 'text-purple-600 dark:text-purple-400 font-medium' : 'text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200' }}">
                    Customers
                </a>
                <a href="{{ route('admin.reports.inventory') }}"
                    class="block py-2 text-sm rounded-lg transition-colors duration-200
                          {{ request()->routeIs('admin.reports.inventory') ? 'text-purple-600 dark:text-purple-400 font-medium' : 'text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200' }}">
                    Inventory
                </a>
                <a href="{{ route('admin.reports.promotions') }}"
                    class="block py-2 text-sm rounded-lg transition-colors duration-200
                          {{ request()->routeIs('admin.reports.promotions') ? 'text-purple-600 dark:text-purple-400 font-medium' : 'text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200' }}">
                    Promotions
                </a>
                <a href="{{ route('admin.reports.profitability') }}"
                    class="block py-2 text-sm rounded-lg transition-colors duration-200
                          {{ request()->routeIs('admin.reports.profitability') ? 'text-purple-600 dark:text-purple-400 font-medium' : 'text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200' }}">
                    Profitability
                </a>
            </div>
        </div>
        @endcan

        <!-- Recommendations -->
        @can('view recommendations')
        <a href="{{ route('admin.recommendations.index') }}"
            class="flex items-center px-3 py-2.5 rounded-lg transition-all duration-200 group
                  {{ request()->routeIs('admin.recommendations.*')
    ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 font-medium'
    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
            <svg class="w-5 h-5 transition-colors duration-200 {{ request()->routeIs('admin.recommendations.*') ? 'text-purple-600 dark:text-purple-400' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-700 dark:group-hover:text-gray-200' }}"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z">
                </path>
            </svg>
            <span class="ml-3 text-sm">Recommendations</span>
        </a>
        @endcan

        <!-- Reviews (Collapsible) -->
        @can('view reviews')
        <div x-data="{ open: {{ request()->routeIs('admin.reviews.*') ? 'true' : 'false' }} }">
            <button @click="open = !open"
                class="flex items-center w-full px-3 py-2.5 rounded-lg transition-all duration-200 group justify-between
                           {{ request()->routeIs('admin.reviews.*')
    ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 font-medium'
    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                <div class="flex items-center">
                    <svg class="w-5 h-5 transition-colors duration-200 {{ request()->routeIs('admin.reviews.*') ? 'text-purple-600 dark:text-purple-400' : 'text-gray-400 group-hover:text-gray-600 dark:text-gray-500 dark:group-hover:text-gray-300' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z">
                        </path>
                    </svg>
                    <span class="ml-3 text-sm">Reviews</span>
                </div>
                <svg class="w-4 h-4 transition-transform duration-200" :class="{'rotate-180': open}" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div x-show="open" x-collapse class="space-y-1 pl-11 pr-4 overflow-hidden">
                <a href="{{ route('admin.reviews.reports.index') }}"
                    class="block py-2 text-sm rounded-lg transition-colors duration-200
                          {{ request()->routeIs('admin.reviews.reports.*') ? 'text-purple-600 dark:text-purple-400 font-medium' : 'text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200' }}">
                    Review Reports
                </a>
                <a href="{{ route('admin.reviews.helpful.index') }}"
                    class="block py-2 text-sm rounded-lg transition-colors duration-200
                          {{ request()->routeIs('admin.reviews.helpful.*') ? 'text-purple-600 dark:text-purple-400 font-medium' : 'text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200' }}">
                    Helpful Analytics
                </a>
            </div>
        </div>
        @endcan

        <!-- Settings (Collapsible) -->
        @canany(['view settings', 'view postage rates'])
        <div
            x-data="{ open: {{ request()->routeIs('admin.settings.*') || request()->routeIs('admin.postage-rates.*') ? 'true' : 'false' }} }">
            <button @click="open = !open"
                class="flex items-center w-full px-3 py-2.5 rounded-lg transition-all duration-200 group justify-between
                           {{ request()->routeIs('admin.settings.*') || request()->routeIs('admin.postage-rates.*')
    ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 font-medium'
    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                <div class="flex items-center">
                    <svg class="w-5 h-5 transition-colors duration-200 {{ request()->routeIs('admin.settings.*') || request()->routeIs('admin.postage-rates.*') ? 'text-purple-600 dark:text-purple-400' : 'text-gray-400 group-hover:text-gray-600 dark:text-gray-500 dark:group-hover:text-gray-300' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span class="ml-3 text-sm">Settings</span>
                </div>
                <svg class="w-4 h-4 transition-transform duration-200" :class="{'rotate-180': open}" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div x-show="open" x-collapse class="space-y-1 pl-11 pr-4 overflow-hidden">
                @can('view settings')
                <a href="{{ route('admin.settings.system') }}"
                    class="block py-2 text-sm rounded-lg transition-colors duration-200
                          {{ request()->routeIs('admin.settings.system') ? 'text-purple-600 dark:text-purple-400 font-medium' : 'text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200' }}">
                    System Preference
                </a>
                @endcan
                @can('view postage rates')
                <a href="{{ route('admin.postage-rates.index') }}"
                    class="block py-2 text-sm rounded-lg transition-colors duration-200
                          {{ request()->routeIs('admin.postage-rates.index') || request()->routeIs('admin.postage-rates.edit') || request()->routeIs('admin.postage-rates.create') ? 'text-purple-600 dark:text-purple-400 font-medium' : 'text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200' }}">
                    Postage Rates
                </a>
                <a href="{{ route('admin.postage-rates.all-history') }}"
                    class="block py-2 text-sm rounded-lg transition-colors duration-200
                          {{ request()->routeIs('admin.postage-rates.all-history') || request()->routeIs('admin.postage-rates.history') ? 'text-purple-600 dark:text-purple-400 font-medium' : 'text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200' }}">
                     Postage Rate History
                </a>
                @endcan
            </div>
        </div>
        @endcanany

        <div class="pt-3 pb-2">
            <p class="px-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Other</p>
        </div>

        {{-- SuperAdmin Dashboard - Only visible to users with access superadmin permission --}}
        @can('access superadmin')
        <a href="{{ route('superadmin.dashboard') }}"
            class="flex items-center px-3 py-2.5 rounded-lg transition-all duration-200 group
                  {{ request()->routeIs('superadmin.*')
    ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 font-medium'
    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
            <svg class="w-5 h-5 transition-colors duration-200 {{ request()->routeIs('superadmin.*') ? 'text-purple-600 dark:text-purple-400' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-700 dark:group-hover:text-gray-200' }}"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                </path>
            </svg>
            <span class="ml-3 text-sm">SuperAdmin Dashboard</span>
        </a>
        @endcan

        <!-- Visit Store -->
        <a href="{{ route('home') }}" target="_blank"
            class="flex items-center px-3 py-2.5 rounded-lg transition-all duration-200 group text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50">
            <svg class="w-5 h-5 transition-colors duration-200 text-gray-500 dark:text-gray-400 group-hover:text-gray-700 dark:group-hover:text-gray-200"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
            </svg>
            <span class="ml-3 text-sm">Visit Store</span>
        </a>

        <div class="h-12"></div> <!-- Spacer -->
    </nav>
</aside>

<!-- Mobile Backdrop -->
<div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0" class="fixed inset-0 z-40 bg-gray-900/50 backdrop-blur-sm lg:hidden"
    @click="sidebarOpen = false"></div>
