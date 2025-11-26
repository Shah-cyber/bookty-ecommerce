<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Bookty Enterprise') }} - Admin Dashboard</title>
    <link rel="icon" type="image/png" href="{{ asset('images/BooktyL.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    

</head>
    <body class="font-sans antialiased" data-layout="admin">
    <div class="min-h-screen bg-bookty-cream dark:bg-gray-900">
        <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-bookty-cream dark:bg-gray-900">
            <!-- Sidebar -->
           <!-- Sidebar -->
<aside id="sidebar-admin" 
class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full 
       sm:translate-x-0 bg-white dark:bg-gray-800 shadow-lg" 
aria-label="Sidebar">

<div class="h-full px-3 py-4 overflow-y-auto">
  <!-- Mobile Close Button -->
  <div class="flex justify-end sm:hidden">
    <button data-drawer-hide="sidebar-admin" aria-controls="sidebar-admin" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
      <span class="sr-only">Close sidebar</span>
      <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" clip-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" />
      </svg>
    </button>
  </div>
  <!-- Logo -->
  <div class="flex items-center justify-center mt-6">
                        <img src="{{ asset('images/BooktyL.png') }}" alt="Bookty Logo" class="h-10 w-auto">
    <span class="ml-2 text-xl font-serif font-bold text-bookty-purple-700">Bookty Enterprise</span>
                </div>

  <!-- Nav -->
  <ul class="mt-8 space-y-2 font-medium">

    <!-- Dashboard -->
    <li>
      <a href="{{ route('admin.dashboard') }}" 
        class="flex items-center p-2 rounded-lg 
               {{ request()->routeIs('admin.dashboard') 
                  ? 'bg-bookty-purple-600 text-white' 
                  : 'text-bookty-black hover:bg-bookty-pink-50 hover:text-bookty-purple-700 dark:text-gray-200 dark:hover:bg-gray-700 dark:hover:text-white' }}">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
          <path d="M2 10a8 8 0 018-8v8h8a8 8 
                   0 11-16 0z"></path>
          <path d="M12 2.252A8.014 8.014 
                   0 0117.748 8H12V2.252z"></path>
                        </svg>
        <span class="ms-3">Dashboard</span>
      </a>
    </li>

    <!-- Books -->
    <li>
      <a href="{{ route('admin.books.index') }}" 
        class="flex items-center p-2 rounded-lg 
               {{ request()->routeIs('admin.books.*') 
                  ? 'bg-bookty-purple-600 text-white' 
                  : 'text-bookty-black hover:bg-bookty-pink-50 hover:text-bookty-purple-700 dark:text-gray-200 dark:hover:bg-gray-700 dark:hover:text-white' }}">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
          <path d="M9 4.804A7.968 7.968 
                   0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 
                   7.969 0 015.5 14c1.669 0 3.218.51 
                   4.5 1.385A7.962 7.962 0 0114.5 
                   14c1.255 0 2.443.29 3.5.804v-10A7.968 
                   7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 
                   1 0 11-2 0V4.804z"></path>
                        </svg>
        <span class="ms-3">Books</span>
      </a>
    </li>

    <!-- Genres -->
    <li>
      <a href="{{ route('admin.genres.index') }}" 
        class="flex items-center p-2 rounded-lg 
               {{ request()->routeIs('admin.genres.*') 
                  ? 'bg-bookty-purple-600 text-white' 
                  : 'text-bookty-black hover:bg-bookty-pink-50 hover:text-bookty-purple-700 dark:text-gray-200 dark:hover:bg-gray-700 dark:hover:text-white' }}">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
          <path d="M7 3a1 1 0 000 2h6a1 1 
                   0 100-2H7zM4 7a1 1 0 011-1h10a1 1 
                   0 110 2H5a1 1 0 01-1-1zM2 11a2 2 
                   0 012-2h12a2 2 0 012 2v4a2 2 0 
                   01-2 2H4a2 2 0 01-2-2v-4z"></path>
                        </svg>
        <span class="ms-3">Genres</span>
      </a>
    </li>

    <!-- Tropes -->
    <li>
      <a href="{{ route('admin.tropes.index') }}" 
        class="flex items-center p-2 rounded-lg 
               {{ request()->routeIs('admin.tropes.*') 
                  ? 'bg-bookty-purple-600 text-white' 
                  : 'text-bookty-black hover:bg-bookty-pink-50 hover:text-bookty-purple-700 dark:text-gray-200 dark:hover:bg-gray-700 dark:hover:text-white' }}">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M17.707 9.293a1 1 
                   0 010 1.414l-7 7a1 1 0 01-1.414 
                   0l-7-7A.997.997 0 012 10V5a3 3 
                   0 013-3h5c.256 0 .512.098.707.293l7 
                   7zM5 6a1 1 0 100-2 1 1 0 000 2z" 
                clip-rule="evenodd"></path>
                        </svg>
        <span class="ms-3">Tropes</span>
      </a>
    </li>

    <!-- Orders -->
    <li>
      <a href="{{ route('admin.orders.index') }}" 
        class="flex items-center p-2 rounded-lg 
               {{ request()->routeIs('admin.orders.*') 
                  ? 'bg-bookty-purple-600 text-white' 
                  : 'text-bookty-black hover:bg-bookty-pink-50 hover:text-bookty-purple-700 dark:text-gray-200 dark:hover:bg-gray-700 dark:hover:text-white' }}">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
          <path d="M3 1a1 1 0 000 2h1.22l.305 
                   1.222a.997.997 0 00.01.042l1.358 
                   5.43-.893.892C3.74 11.846 4.632 
                   14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 
                   1 0 00.894-.553l3-6A1 1 0 
                   0017 3H6.28l-.31-1.243A1 1 0 
                   005 1H3zM16 16.5a1.5 1.5 0 11-3 
                   0 1.5 1.5 0 013 0zM6.5 18a1.5 
                   1.5 0 100-3 1.5 1.5 0 000 3z"></path>
                        </svg>
        <span class="ms-3">Orders</span>
      </a>
    </li>

    <!-- Customers -->
    <li>
      <a href="{{ route('admin.customers.index') }}" 
        class="flex items-center p-2 rounded-lg 
               {{ request()->routeIs('admin.customers.*') 
                  ? 'bg-bookty-purple-600 text-white' 
                  : 'text-bookty-black hover:bg-bookty-pink-50 hover:text-bookty-purple-700 dark:text-gray-200 dark:hover:bg-gray-700 dark:hover:text-white' }}">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
          <path d="M13 6a3 3 0 11-6 0 3 3 
                   0 016 0zM18 8a2 2 0 11-4 0 2 2 
                   0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 
                   8a2 2 0 11-4 0 2 2 0 014 
                   0zM16 18v-3a5.972 5.972 0 
                   00-.75-2.906A3.005 3.005 0 
                   0119 15v3h-3zM4.75 12.094A5.973 
                   5.973 0 004 15v3H1v-3a3 3 0 
                   013.75-2.906z"></path>
                        </svg>
        <span class="ms-3">Customers</span>
      </a>
    </li>

    <!-- ========== Promotions (Collapsible) ========== -->
    <li>
      <button type="button" 
        class="flex items-center w-full p-2 text-bookty-black transition duration-75 rounded-lg 
               hover:bg-bookty-pink-50 hover:text-bookty-purple-700 dark:text-gray-200 dark:hover:bg-gray-700 dark:hover:text-white" 
        aria-controls="dropdown-promotions" 
        data-collapse-toggle="dropdown-promotions">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 
                    7a1 1 0 01-1.414 0l-7-7A.997.997 
                    0 012 10V5a3 3 0 013-3h5c.256 
                    0 .512.098.707.293l7 7zM5 6a1 1 
                    0 100-2 1 1 0 000 2z" 
                clip-rule="evenodd"></path>
                        </svg>
        <span class="flex-1 ms-3 text-left whitespace-nowrap">Promotions</span>
        <svg class="w-3 h-3" aria-hidden="true" fill="none" viewBox="0 0 10 6">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" 
                stroke-width="2" d="m1 1 4 4 4-4"/>
                            </svg>
                        </button>
      <ul id="dropdown-promotions" class="hidden py-2 space-y-2">
        <li>
          <a href="{{ route('admin.discounts.index') }}" 
            class="flex items-center w-full p-2 pl-11 rounded-lg 
                   {{ request()->routeIs('admin.discounts.*') 
                      ? 'bg-bookty-purple-600 text-white' 
                      : 'text-bookty-black hover:bg-bookty-pink-50 hover:text-bookty-purple-700 dark:text-gray-200 dark:hover:bg-gray-700 dark:hover:text-white' }}">
            Book Discounts
          </a>
        </li>
        <li>
          <a href="{{ route('admin.coupons.index') }}" 
            class="flex items-center w-full p-2 pl-11 rounded-lg 
                   {{ request()->routeIs('admin.coupons.*') 
                      ? 'bg-bookty-purple-600 text-white' 
                      : 'text-bookty-black hover:bg-bookty-pink-50 hover:text-bookty-purple-700 dark:text-gray-200 dark:hover:bg-gray-700 dark:hover:text-white' }}">
            Coupon Codes
          </a>
        </li>
        <li>
          <a href="{{ route('admin.flash-sales.index') }}" 
            class="flex items-center w-full p-2 pl-11 rounded-lg 
                   {{ request()->routeIs('admin.flash-sales.*') 
                      ? 'bg-bookty-purple-600 text-white' 
                      : 'text-bookty-black hover:bg-bookty-pink-50 hover:text-bookty-purple-700 dark:text-gray-200 dark:hover:bg-gray-700 dark:hover:text-white' }}">
            Flash Sales
          </a>
        </li>
      </ul>
    </li>

    <!-- ========== Reports (Collapsible) ========== -->
    <li>
      <button type="button" 
        class="flex items-center w-full p-2 text-bookty-black transition duration-75 rounded-lg 
               hover:bg-bookty-pink-50 hover:text-bookty-purple-700 dark:text-gray-200 dark:hover:bg-gray-700 dark:hover:text-white" 
        aria-controls="dropdown-reports" 
        data-collapse-toggle="dropdown-reports">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
          <path d="M2 11a1 1 0 011-1h2a1 1 0 
                   011 1v5a1 1 0 01-1 1H3a1 
                   1 0 01-1-1v-5zM8 7a1 1 0 
                   011-1h2a1 1 0 011 1v9a1 1 
                   0 01-1 1H9a1 1 0 01-1-1V7zM14 
                   4a1 1 0 011-1h2a1 1 0 011 
                   1v12a1 1 0 01-1 1h-2a1 1 
                   0 01-1-1V4z"></path>
                                </svg>
        <span class="flex-1 ms-3 text-left whitespace-nowrap">Reports</span>
        <svg class="w-3 h-3" aria-hidden="true" fill="none" viewBox="0 0 10 6">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" 
                stroke-width="2" d="m1 1 4 4 4-4"/>
                                </svg>
      </button>
      <ul id="dropdown-reports" class="hidden py-2 space-y-2">
        <li><a href="{{ route('admin.reports.index') }}" class="flex items-center w-full p-2 pl-11 rounded-lg {{ request()->routeIs('admin.reports.index') ? 'bg-bookty-purple-600 text-white' : 'text-bookty-black hover:bg-bookty-pink-50 hover:text-bookty-purple-700 dark:text-gray-200 dark:hover:bg-gray-700 dark:hover:text-white' }}">Reports Dashboard</a></li>
        <li><a href="{{ route('admin.reports.sales') }}" class="flex items-center w-full p-2 pl-11 rounded-lg {{ request()->routeIs('admin.reports.sales') ? 'bg-bookty-purple-600 text-white' : 'text-bookty-black hover:bg-bookty-pink-50 hover:text-bookty-purple-700 dark:text-gray-200 dark:hover:bg-gray-700 dark:hover:text-white' }}">Sales Reports</a></li>
        <li><a href="{{ route('admin.reports.customers') }}" class="flex items-center w-full p-2 pl-11 rounded-lg {{ request()->routeIs('admin.reports.customers') ? 'bg-bookty-purple-600 text-white' : 'text-bookty-black hover:bg-bookty-pink-50 hover:text-bookty-purple-700 dark:text-gray-200 dark:hover:bg-gray-700 dark:hover:text-white' }}">Customer Reports</a></li>
        <li><a href="{{ route('admin.reports.inventory') }}" class="flex items-center w-full p-2 pl-11 rounded-lg {{ request()->routeIs('admin.reports.inventory') ? 'bg-bookty-purple-600 text-white' : 'text-bookty-black hover:bg-bookty-pink-50 hover:text-bookty-purple-700 dark:text-gray-200 dark:hover:bg-gray-700 dark:hover:text-white' }}">Inventory Reports</a></li>
        <li><a href="{{ route('admin.reports.promotions') }}" class="flex items-center w-full p-2 pl-11 rounded-lg {{ request()->routeIs('admin.reports.promotions') ? 'bg-bookty-purple-600 text-white' : 'text-bookty-black hover:bg-bookty-pink-50 hover:text-bookty-purple-700 dark:text-gray-200 dark:hover:bg-gray-700 dark:hover:text-white' }}">Promotions Reports</a></li>
        <li><a href="{{ route('admin.reports.profitability') }}" class="flex items-center w-full p-2 pl-11 rounded-lg {{ request()->routeIs('admin.reports.profitability') ? 'bg-bookty-purple-600 text-white' : 'text-bookty-black hover:bg-bookty-pink-50 hover:text-bookty-purple-700 dark:text-gray-200 dark:hover:bg-gray-700 dark:hover:text-white' }}">Profitability Reports</a></li>
      </ul>
    </li>

    <!-- Recommendation Analytics -->
    <li>
      <a href="{{ route('admin.recommendations.index') }}" 
        class="flex items-center p-2 rounded-lg 
               {{ request()->routeIs('admin.recommendations.*') 
                  ? 'bg-bookty-purple-600 text-white' 
                  : 'text-bookty-black hover:bg-bookty-pink-50 hover:text-bookty-purple-700 dark:text-gray-200 dark:hover:bg-gray-700 dark:hover:text-white' }}">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
          <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <span class="ms-3">Recommendations</span>
      </a>
    </li>

    <!-- ========== Reviews (Collapsible) ========== -->
    <li>
      <button type="button"
        class="flex items-center w-full p-2 text-bookty-black transition duration-75 rounded-lg
               hover:bg-bookty-pink-50 hover:text-bookty-purple-700 dark:text-gray-200 dark:hover:bg-gray-700 dark:hover:text-white"
        aria-controls="dropdown-reviews"
        data-collapse-toggle="dropdown-reviews">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
          <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <span class="flex-1 ms-3 text-left whitespace-nowrap">Reviews</span>
        <svg class="w-3 h-3" aria-hidden="true" fill="none" viewBox="0 0 10 6">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                stroke-width="2" d="m1 1 4 4 4-4"/>
        </svg>
      </button>
      <ul id="dropdown-reviews" class="hidden py-2 space-y-2">
        <li><a href="{{ route('admin.reviews.reports.index') }}" class="flex items-center w-full p-2 pl-11 rounded-lg {{ request()->routeIs('admin.reviews.reports.*') ? 'bg-bookty-purple-600 text-white' : 'text-bookty-black hover:bg-bookty-pink-50 hover:text-bookty-purple-700 dark:text-gray-200 dark:hover:bg-gray-700 dark:hover:text-white' }}">Review Reports</a></li>
        <li><a href="{{ route('admin.reviews.helpful.index') }}" class="flex items-center w-full p-2 pl-11 rounded-lg {{ request()->routeIs('admin.reviews.helpful.*') ? 'bg-bookty-purple-600 text-white' : 'text-bookty-black hover:bg-bookty-pink-50 hover:text-bookty-purple-700 dark:text-gray-200 dark:hover:bg-gray-700 dark:hover:text-white' }}">Review Helpful Analytics</a></li>
      </ul>
    </li>

    <!-- ========== Settings (Collapsible) ========== -->
    <li>
      <button type="button" 
        class="flex items-center w-full p-2 text-bookty-black transition duration-75 rounded-lg 
               hover:bg-bookty-pink-50 hover:text-bookty-purple-700 dark:text-gray-200 dark:hover:bg-gray-700 dark:hover:text-white" 
        aria-controls="dropdown-settings" 
        data-collapse-toggle="dropdown-settings">
        <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd" d="M11.983 1.724a1 1 0 00-1.966 0l-.094.564a7.967 7.967 0 00-1.788.74l-.51-.295a1 1 0 00-1.366.366l-.983 1.703a1 1 0 00.366 1.366l.51.295a7.967 7.967 0 000 1.48l-.51.295a1 1 0 00-.366 1.366l.983 1.703a1 1 0 001.366.366l.51-.295c.567.32 1.17.573 1.788.74l.094.564a1 1 0 001.966 0l.094-.564c.618-.167 1.221-.42 1.788-.74l.51.295a1 1 0 001.366-.366l.983-1.703a1 1 0 00-.366-1.366l-.51-.295c.06-.486.06-.994 0-1.48l.51-.295a1 1 0 00.366-1.366l-.983-1.703a1 1 0 00-1.366-.366l-.51.295a7.967 7.967 0 00-1.788-.74l-.094-.564zM10 7a3 3 0 110 6 3 3 0 010-6z" clip-rule="evenodd"/>
        </svg>
        <span class="flex-1 ms-3 text-left whitespace-nowrap">Settings</span>
        <svg class="w-3 h-3" aria-hidden="true" fill="none" viewBox="0 0 10 6">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" 
                stroke-width="2" d="m1 1 4 4 4-4"/>
        </svg>
      </button>
      <ul id="dropdown-settings" class="hidden py-2 space-y-2">
        <li>
          <a href="{{ route('admin.settings.system') }}" 
            class="flex items-center w-full p-2 pl-11 rounded-lg 
                   {{ request()->routeIs('admin.settings.system') 
                      ? 'bg-bookty-purple-600 text-white' 
                      : 'text-bookty-black hover:bg-bookty-pink-50 hover:text-bookty-purple-700 dark:text-gray-200 dark:hover:bg-gray-700 dark:hover:text-white' }}">
            System Preference
          </a>
        </li>
        <li>
          <a href="{{ route('admin.postage-rates.index') }}" 
            class="flex items-center w-full p-2 pl-11 rounded-lg 
                   {{ request()->routeIs('admin.postage-rates.*') 
                      ? 'bg-bookty-purple-600 text-white' 
                      : 'text-bookty-black hover:bg-bookty-pink-50 hover:text-bookty-purple-700 dark:text-gray-200 dark:hover:bg-gray-700 dark:hover:text-white' }}">
            Postage Rates
          </a>
        </li>
      </ul>
    </li>

    <!-- SuperAdmin -->
    <li>
      <a href="{{ route('superadmin.dashboard') }}" 
        class="flex items-center p-2 rounded-lg 
               {{ request()->routeIs('superadmin.*') 
                  ? 'bg-bookty-purple-600 text-white' 
                  : 'text-bookty-black hover:bg-bookty-pink-50 hover:text-bookty-purple-700 dark:text-gray-200 dark:hover:bg-gray-700 dark:hover:text-white' }}">
        <i class="fa-solid fa-user-shield w-5 h-5"></i>
        <span class="ms-3">SuperAdmin</span>
      </a>
    </li>

    <!-- Visit Store -->
    <li>
      <a href="{{ route('home') }}" target="_blank"
        class="flex items-center p-2 rounded-lg 
               text-bookty-black hover:bg-bookty-pink-50 hover:text-bookty-purple-700 dark:text-gray-200 dark:hover:bg-gray-700 dark:hover:text-white">
        <i class="fa-solid fa-store w-5 h-5"></i>
        <span class="ms-3">Visit Store</span>
      </a>
    </li>

    <!-- Logout -->
    {{-- <li>
                        <form method="POST" action="{{ route('logout') }}" onsubmit="return handleLogout(event, this)">
                            @csrf
        <button type="submit" 
          class="flex items-center w-full p-2 text-bookty-black rounded-lg 
                 hover:bg-bookty-pink-50 hover:text-bookty-purple-700 dark:text-gray-200 dark:hover:bg-gray-700 dark:hover:text-white">
          <i class="fa-solid fa-right-from-bracket w-5 h-5"></i>
          <span class="ms-3">Logout</span>
                            </button>
                        </form>
    </li> --}}

  </ul>
                    </div>
</aside>
            <div class="flex flex-col flex-1 overflow-hidden">
                <header class="flex items-center justify-between px-4 sm:px-6 py-4 bg-white dark:bg-gray-800 border-b-2 border-bookty-pink-100 dark:border-gray-700 shadow-sm sm:ml-64">
                    <div class="flex items-center gap-3">
                        <button data-drawer-target="sidebar-admin" data-drawer-toggle="sidebar-admin" data-drawer-backdrop="true" aria-controls="sidebar-admin" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                            <span class="sr-only">Open sidebar</span>
                            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z" />
                            </svg>
                        </button>

                        <div class="mx-1 sm:mx-4">
                            <h1 class="text-xl sm:text-2xl  font-semibold text-bookty-black dark:text-gray-100 truncate">@yield('header', 'Dashboard')</h1>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">

                        <div x-data="{ dropdownOpen: false }" class="relative">
                            <button @click="dropdownOpen = ! dropdownOpen" class="flex items-center space-x-2 relative focus:outline-none">
                                <div class="h-9 w-9 rounded-full bg-bookty-purple-200 flex items-center justify-center">
                                    <span class="text-sm font-medium text-bookty-purple-800">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                </div>
                                <span class="text-bookty-black dark:text-gray-200 font-medium">{{ Auth::user()->name }}</span>
                                <svg class="w-5 h-5 text-bookty-purple-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>

                            <div x-show="dropdownOpen" @click.away="dropdownOpen = false" class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md overflow-hidden shadow-xl z-10">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-bookty-black dark:text-gray-200 hover:bg-bookty-pink-50 dark:hover:bg-gray-700">Profile</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-bookty-black dark:text-gray-200 hover:bg-bookty-pink-50 dark:hover:bg-gray-700">Logout</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </header>

                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-bookty-cream dark:bg-gray-900 sm:ml-64">
                    <div class="container mx-auto px-4 sm:px-6 py-6 sm:py-8">
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
                showToast('{{ session('success') }}', 'success');
            @endif
            
            @if(session('error'))
                showToast('{{ session('error') }}', 'error');
            @endif
            
            @if(session('warning'))
                showToast('{{ session('warning') }}', 'warning');
            @endif
            
            @if(session('info'))
                showToast('{{ session('info') }}', 'info');
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

    <!-- ApexCharts CDN -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.46.0/dist/apexcharts.min.js"></script>
    <!-- Simple DataTables CDN (UMD bundle) -->
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@9.0.3/dist/umd.js"></script>
    <!-- Flowbite JS (for dropdowns, etc.) -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>

    <!-- Theme preference (light/dark/system) -->
    <script>
        (function() {
            const root = document.documentElement;
            const prefKey = 'themePreference'; // 'light' | 'dark' | 'system'
            function getPref() {
                return localStorage.getItem(prefKey) || 'system';
            }
            function applyTheme(pref) {
                const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
                const isDark = pref === 'dark' || (pref === 'system' && prefersDark);
                if (isDark) root.classList.add('dark'); else root.classList.remove('dark');
            }
            // Initial
            applyTheme(getPref());
            // Update on system changes if set to system
            const mq = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)');
            mq && mq.addEventListener && mq.addEventListener('change', function() {
                if (getPref() === 'system') applyTheme('system');
            });
        })();
    </script>
</body>
</html>
