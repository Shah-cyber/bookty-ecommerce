<aside
    class="fixed inset-y-0 left-0 z-50 w-64 bg-white dark:bg-gray-800 shadow-xl transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0"
    :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}" @click.away="sidebarOpen = false"
    @keydown.escape.window="sidebarOpen = false">
    <!-- Logo: Bookty Enterprise Simple Version -->
    <div class="h-16 flex items-center justify-center bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 px-6">
        <a href="{{ route('superadmin.dashboard') }}" class="flex items-center gap-2">
            <img src="{{ asset('images/BooktyL.png') }}" alt="Bookty Logo" class="h-9 w-9 rounded-full bg-gray-100 ring-2 ring-purple-200 dark:ring-purple-700 object-cover">
            <span class="ml-2 text-lg font-bold text-purple-700 dark:text-purple-300 font-serif">Bookty Enterprise</span>
        </a>
    </div>

    <!-- Nav -->
    <nav class="h-[calc(100vh-4rem)] overflow-y-auto custom-scrollbar p-4 space-y-1">

        <!-- Dashboard -->
        <a href="{{ route('superadmin.dashboard') }}"
            class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group
                  {{ request()->routeIs('superadmin.dashboard')
    ? 'bg-purple-50 dark:bg-purple-900/20 text-purple-700 dark:text-purple-300 shadow-sm ring-1 ring-purple-200 dark:ring-purple-800'
    : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700/50 hover:text-gray-900 dark:hover:text-gray-200' }}">
            <svg class="w-5 h-5 transition-colors duration-200 {{ request()->routeIs('superadmin.dashboard') ? 'text-purple-600 dark:text-purple-400' : 'text-gray-400 group-hover:text-gray-600 dark:text-gray-500 dark:group-hover:text-gray-300' }}"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                </path>
            </svg>
            <span class="ml-3 font-medium">Dashboard</span>
        </a>

        {{-- Management Section - Show if user has any management permissions --}}
        @canany(['manage admins', 'manage roles', 'manage permissions', 'manage system settings'])
        <div class="pt-4 pb-2">
            <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Management</p>
        </div>

        <!-- Manage Admins -->
        @can('manage admins')
        <a href="{{ route('superadmin.admins.index') }}"
            class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group
                  {{ request()->routeIs('superadmin.admins.*')
    ? 'bg-purple-50 dark:bg-purple-900/20 text-purple-700 dark:text-purple-300 shadow-sm ring-1 ring-purple-200 dark:ring-purple-800'
    : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700/50 hover:text-gray-900 dark:hover:text-gray-200' }}">
            <svg class="w-5 h-5 transition-colors duration-200 {{ request()->routeIs('superadmin.admins.*') ? 'text-purple-600 dark:text-purple-400' : 'text-gray-400 group-hover:text-gray-600 dark:text-gray-500 dark:group-hover:text-gray-300' }}"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                </path>
            </svg>
            <span class="ml-3 font-medium">Manage Admins</span>
        </a>
        @endcan

        <!-- Roles -->
        @can('manage roles')
        <a href="{{ route('superadmin.roles.index') }}"
            class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group
                  {{ request()->routeIs('superadmin.roles.*')
    ? 'bg-purple-50 dark:bg-purple-900/20 text-purple-700 dark:text-purple-300 shadow-sm ring-1 ring-purple-200 dark:ring-purple-800'
    : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700/50 hover:text-gray-900 dark:hover:text-gray-200' }}">
            <svg class="w-5 h-5 transition-colors duration-200 {{ request()->routeIs('superadmin.roles.*') ? 'text-purple-600 dark:text-purple-400' : 'text-gray-400 group-hover:text-gray-600 dark:text-gray-500 dark:group-hover:text-gray-300' }}"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                </path>
            </svg>
            <span class="ml-3 font-medium">Roles</span>
        </a>
        @endcan

        <!-- Permissions -->
        @can('manage permissions')
        <a href="{{ route('superadmin.permissions.index') }}"
            class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group
                  {{ request()->routeIs('superadmin.permissions.*')
    ? 'bg-purple-50 dark:bg-purple-900/20 text-purple-700 dark:text-purple-300 shadow-sm ring-1 ring-purple-200 dark:ring-purple-800'
    : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700/50 hover:text-gray-900 dark:hover:text-gray-200' }}">
            <svg class="w-5 h-5 transition-colors duration-200 {{ request()->routeIs('superadmin.permissions.*') ? 'text-purple-600 dark:text-purple-400' : 'text-gray-400 group-hover:text-gray-600 dark:text-gray-500 dark:group-hover:text-gray-300' }}"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                </path>
            </svg>
            <span class="ml-3 font-medium">Permissions</span>
        </a>
        @endcan

        <!-- System Settings -->
        @can('manage system settings')
        <a href="{{ route('superadmin.settings.index') }}"
            class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group
                  {{ request()->routeIs('superadmin.settings.*')
    ? 'bg-purple-50 dark:bg-purple-900/20 text-purple-700 dark:text-purple-300 shadow-sm ring-1 ring-purple-200 dark:ring-purple-800'
    : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700/50 hover:text-gray-900 dark:hover:text-gray-200' }}">
            <svg class="w-5 h-5 transition-colors duration-200 {{ request()->routeIs('superadmin.settings.*') ? 'text-purple-600 dark:text-purple-400' : 'text-gray-400 group-hover:text-gray-600 dark:text-gray-500 dark:group-hover:text-gray-300' }}"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                </path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z">
                </path>
            </svg>
            <span class="ml-3 font-medium">System Settings</span>
        </a>
        @endcan
        @endcanany

        <div class="pt-4 pb-2">
            <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Quick Access</p>
        </div>

        <!-- SuperAdmin Dashboard -->
        <a href="{{ route('superadmin.dashboard') }}"
            class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group
                  {{ request()->routeIs('superadmin.dashboard')
    ? 'bg-purple-50 dark:bg-purple-900/20 text-purple-700 dark:text-purple-300 shadow-sm ring-1 ring-purple-200 dark:ring-purple-800'
    : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700/50 hover:text-gray-900 dark:hover:text-gray-200' }}">
            <svg class="w-5 h-5 transition-colors duration-200 {{ request()->routeIs('superadmin.dashboard') ? 'text-purple-600 dark:text-purple-400' : 'text-gray-400 group-hover:text-gray-600 dark:text-gray-500 dark:group-hover:text-gray-300' }}"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                </path>
            </svg>
            <span class="ml-3 font-medium">SuperAdmin</span>
        </a>

        <!-- Admin Dashboard -->
        @can('access admin')
        <a href="{{ route('admin.dashboard') }}"
            class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700/50 hover:text-gray-900 dark:hover:text-gray-200">
            <svg class="w-5 h-5 transition-colors duration-200 text-gray-400 group-hover:text-gray-600 dark:text-gray-500 dark:group-hover:text-gray-300"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                </path>
            </svg>
            <span class="ml-3 font-medium">Admin Dashboard</span>
        </a>
        @endcan

        <!-- Visit Store -->
        <a href="{{ route('home') }}" target="_blank"
            class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700/50 hover:text-gray-900 dark:hover:text-gray-200">
            <svg class="w-5 h-5 transition-colors duration-200 text-gray-400 group-hover:text-gray-600 dark:text-gray-500 dark:group-hover:text-gray-300"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14">
                </path>
            </svg>
            <span class="ml-3 font-medium">Visit Store</span>
        </a>

    </nav>
</aside>
