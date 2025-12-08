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


</head>

<body class="font-sans antialiased" data-layout="admin">
  <div class="min-h-screen bg-bookty-cream dark:bg-gray-900">
    <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-bookty-cream dark:bg-gray-900 overflow-hidden">

      <!-- Sidebar Partial -->
      @include('layouts.partials.admin-sidebar')

      <div class="flex flex-col flex-1 overflow-hidden w-0">
        <header
          class="flex items-center justify-between px-4 sm:px-6 py-4 bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 shadow-sm z-10">
          <div class="flex items-center gap-3">
            <!-- Mobile Hamburger -->
            <button @click.stop="sidebarOpen = !sidebarOpen" type="button"
              class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg lg:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
              <span class="sr-only">Open sidebar</span>
              <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                <path clip-rule="evenodd" fill-rule="evenodd"
                  d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z" />
              </svg>
            </button>

            <div class="mx-1 sm:mx-4">
              <h1 class="text-xl sm:text-2xl font-semibold text-gray-800 dark:text-gray-100 truncate">
                @yield('header', 'Dashboard')</h1>
            </div>
          </div>

          <div class="flex items-center space-x-4">
            <div x-data="{ dropdownOpen: false }" class="relative">
              <button @click="dropdownOpen = ! dropdownOpen"
                class="flex items-center space-x-2 relative focus:outline-none group">
                <div
                  class="h-9 w-9 rounded-full bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center ring-2 ring-transparent group-hover:ring-purple-200 transition-all duration-200">
                  <span
                    class="text-sm font-medium text-purple-700 dark:text-purple-300">{{ substr(Auth::user()->name, 0, 1) }}</span>
                </div>
                <span
                  class="hidden md:block text-gray-700 dark:text-gray-200 font-medium text-sm">{{ Auth::user()->name }}</span>
                <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-600 transition-colors duration-200"
                  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd"
                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                    clip-rule="evenodd" />
                </svg>
              </button>

              <div x-show="dropdownOpen" @click.away="dropdownOpen = false"
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95"
                class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 py-1 z-50">
                <div class="px-4 py-2 border-b border-gray-100 dark:border-gray-700 md:hidden">
                  <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ Auth::user()->name }}</p>
                  <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ Auth::user()->email }}</p>
                </div>
                <a href="{{ route('profile.edit') }}"
                  class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-purple-50 dark:hover:bg-gray-700 hover:text-purple-700 dark:hover:text-purple-300 transition-colors">Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button type="submit"
                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-purple-50 dark:hover:bg-gray-700 hover:text-purple-700 dark:hover:text-purple-300 transition-colors">Logout</button>
                </form>
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