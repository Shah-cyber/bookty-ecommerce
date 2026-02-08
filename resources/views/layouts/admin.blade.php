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
  <link
    href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Inter:wght@300;400;500;600;700&display=swap"
    rel="stylesheet">

  <!-- Scripts -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  @stack('styles')
</head>

<body class="font-sans antialiased" data-layout="admin">
  <div class="min-h-screen bg-bookty-cream dark:bg-gray-900">
    <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-bookty-cream dark:bg-gray-900 overflow-hidden">

      <!-- Sidebar Partial -->
      @include('layouts.partials.admin-sidebar')

      <div class="flex flex-col flex-1 overflow-hidden w-0">
        <header class="relative bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 z-30">
          <div class="flex items-center justify-between px-4 sm:px-6 lg:px-8 h-16 sm:h-20">
            {{-- Left Section --}}
            <div class="flex items-center gap-4">
              {{-- Mobile Hamburger --}}
              <button @click.stop="sidebarOpen = !sidebarOpen" type="button"
                class="inline-flex items-center justify-center w-10 h-10 text-gray-500 rounded-xl lg:hidden hover:bg-gray-100 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-purple-500/20 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200 transition-all">
                <span class="sr-only">Open sidebar</span>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
              </button>

              {{-- Page Title & Breadcrumb --}}
              <div>
                <h1 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">@yield('header', 'Dashboard')</h1>
                <p class="hidden sm:block text-sm text-gray-500 dark:text-gray-400">{{ now()->format('l, F j, Y') }}</p>
              </div>
            </div>

            {{-- Right Section --}}
            <div class="flex items-center gap-2 sm:gap-4">
              {{-- Search Button (Mobile) --}}
              <button type="button" class="sm:hidden p-2.5 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-xl transition-all dark:text-gray-400 dark:hover:text-gray-200 dark:hover:bg-gray-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
              </button>

              {{-- Quick Actions --}}
              <div class="hidden sm:flex items-center gap-2">
                {{-- Visit Store --}}
                <a href="{{ route('home') }}" target="_blank" 
                  class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 bg-gray-100 hover:bg-gray-200 rounded-xl transition-all dark:text-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                  </svg>
                  <span class="hidden lg:inline">View Store</span>
                </a>
              </div>

              {{-- Divider --}}
              <div class="hidden sm:block w-px h-8 bg-gray-200 dark:bg-gray-700"></div>

              {{-- User Dropdown --}}
              <div x-data="{ dropdownOpen: false }" class="relative">
                <button @click="dropdownOpen = !dropdownOpen"
                  class="flex items-center gap-3 p-1.5 pr-3 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-700 transition-all focus:outline-none focus:ring-2 focus:ring-purple-500/20">
                  {{-- Avatar --}}
                  @if(Auth::user()->avatar)
                    <img src="{{ Auth::user()->getAvatarUrl() }}" alt="{{ Auth::user()->name }}" 
                      class="w-9 h-9 rounded-xl object-cover ring-2 ring-purple-100 dark:ring-purple-900">
                  @else
                    <div class="w-9 h-9 rounded-xl bg-purple-100 dark:bg-purple-900/50 flex items-center justify-center ring-2 ring-purple-50 dark:ring-purple-900">
                      <span class="text-sm font-bold text-purple-600 dark:text-purple-400">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    </div>
                  @endif
                  <div class="hidden md:block text-left">
                    <p class="text-sm font-semibold text-gray-900 dark:text-white leading-tight">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                      @if(Auth::user()->hasRole('superadmin'))
                        Super Admin
                      @else
                        Admin
                      @endif
                    </p>
                  </div>
                  <svg class="w-4 h-4 text-gray-400 hidden md:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                  </svg>
                </button>

                {{-- User Dropdown Menu --}}
                <div x-show="dropdownOpen" @click.away="dropdownOpen = false"
                  x-transition:enter="transition ease-out duration-200"
                  x-transition:enter-start="opacity-0 translate-y-2"
                  x-transition:enter-end="opacity-100 translate-y-0"
                  x-transition:leave="transition ease-in duration-150"
                  x-transition:leave-start="opacity-100 translate-y-0"
                  x-transition:leave-end="opacity-0 translate-y-2"
                  class="absolute right-0 mt-2 w-64 bg-white dark:bg-gray-800 rounded-2xl shadow-2xl border border-gray-100 dark:border-gray-700 overflow-hidden z-[100]">
                  
                  {{-- User Info Header --}}
                  <div class="px-4 py-4 bg-gray-50 dark:bg-gray-700/50 border-b border-gray-100 dark:border-gray-700">
                    <div class="flex items-center gap-3">
                      @if(Auth::user()->avatar)
                        <img src="{{ Auth::user()->getAvatarUrl() }}" alt="{{ Auth::user()->name }}" 
                          class="w-12 h-12 rounded-xl object-cover">
                      @else
                        <div class="w-12 h-12 rounded-xl bg-purple-100 dark:bg-purple-900/50 flex items-center justify-center">
                          <span class="text-lg font-bold text-purple-600 dark:text-purple-400">{{ substr(Auth::user()->name, 0, 1) }}</span>
                        </div>
                      @endif
                      <div class="flex-1 min-w-0">
                        <p class="font-semibold text-gray-900 dark:text-white truncate">{{ Auth::user()->name }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 truncate">{{ Auth::user()->email }}</p>
                      </div>
                    </div>
                  </div>

                  {{-- Menu Items --}}
                  <div class="py-2">
                    <a href="{{ route('profile.edit') }}"
                      class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                      <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                      </svg>
                      My Profile
                    </a>
                    <a href="{{ route('admin.settings.system') }}"
                      class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                      <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                      </svg>
                      Settings
                    </a>
                    <a href="{{ route('home') }}" target="_blank"
                      class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors sm:hidden">
                      <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                      </svg>
                      View Store
                    </a>
                  </div>

                  {{-- Logout --}}
                  <div class="border-t border-gray-100 dark:border-gray-700 py-2">
                    <form method="POST" action="{{ route('logout') }}" onsubmit="return handleLogout(event, this)">
                      @csrf
                      <button type="submit"
                        class="flex items-center gap-3 w-full px-4 py-2.5 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
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

        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 dark:bg-gray-900 relative">
          <div class="container mx-auto px-4 sm:px-6 py-6 sm:py-8">
            @yield('content')
          </div>
        </main>
      </div>
    </div>
  </div>

  <!-- Session Flash Message Handler -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // Handle session flash messages
      @if(session('success'))
        showToast({!! json_encode(session('success')) !!}, 'success');
      @endif

      @if(session('error'))
        showToast({!! json_encode(session('error')) !!}, 'error');
      @endif

      @if(session('warning'))
        showToast({!! json_encode(session('warning')) !!}, 'warning');
      @endif

      @if(session('info'))
        showToast({!! json_encode(session('info')) !!}, 'info');
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
  <!-- Flowbite JS (for dropdowns, etc.) -->
  <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>

  <!-- Theme preference (light/dark/system) -->
  <script>
    (function () {
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
      mq && mq.addEventListener && mq.addEventListener('change', function () {
        if (getPref() === 'system') applyTheme('system');
      });
    })();
  </script>

  <!-- Global Session Expiration Handler -->
  <script>
    (function () {
      // Intercept all fetch requests
      const originalFetch = window.fetch;
      window.fetch = function (...args) {
        return originalFetch.apply(this, args)
          .then(response => {
            // Check for session expiration (401 Unauthorized)
            if (response.status === 401) {
              return response.json().then(data => {
                if (data.session_expired) {
                  handleSessionExpiration(data);
                }
                return Promise.reject(response);
              }).catch(() => {
                // If JSON parsing fails, still handle as expired session
                handleSessionExpiration({ redirect: '{{ route("home") }}' });
                return Promise.reject(response);
              });
            }

            // Check for CSRF token expiration (419 Page Expired)
            if (response.status === 419) {
              return response.json().then(data => {
                if (data.session_expired || data.csrf_expired) {
                  handleSessionExpiration(data);
                }
                return Promise.reject(response);
              }).catch(() => {
                handleSessionExpiration({ redirect: '{{ route("home") }}' });
                return Promise.reject(response);
              });
            }

            return response;
          });
      };

      // Handle session expiration
      function handleSessionExpiration(data) {
        const redirectUrl = data.redirect || '{{ route("home") }}';
        const message = data.message || 'Your session has expired. Redirecting to home page...';

        // Show notification if toast function exists
        if (typeof window.showToast === 'function') {
          window.showToast(message, 'warning');
        } else {
          alert(message);
        }

        // Redirect after short delay
        setTimeout(() => {
          window.location.href = redirectUrl;
        }, 1500);
      }

      // Handle XMLHttpRequest (for older AJAX code)
      const originalOpen = XMLHttpRequest.prototype.open;
      const originalSend = XMLHttpRequest.prototype.send;

      XMLHttpRequest.prototype.open = function (method, url, ...args) {
        this._url = url;
        return originalOpen.apply(this, [method, url, ...args]);
      };

      XMLHttpRequest.prototype.send = function (...args) {
        this.addEventListener('load', function () {
          if (this.status === 401 || this.status === 419) {
            try {
              const data = JSON.parse(this.responseText);
              if (data.session_expired || data.csrf_expired) {
                handleSessionExpiration(data);
              }
            } catch (e) {
              handleSessionExpiration({ redirect: '{{ route("home") }}' });
            }
          }
        });
        return originalSend.apply(this, args);
      };
    })();
  </script>
  @stack('scripts')
</body>

</html>