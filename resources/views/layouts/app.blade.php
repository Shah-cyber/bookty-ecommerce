<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Bookty Enterprise') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('storage/BooktyLogo/BooktyL.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        
        <!-- AOS Animation Library -->
        <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
        
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Alpine.js cloak style -->
        <style>
            [x-cloak] { display: none !important; }
        </style>
    </head>
    <body class="font-sans antialiased" data-layout="customer">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                @yield('content')
            </main>
        </div>
        
        <!-- Authentication Modal -->
        <x-auth-modal />
        
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
        
        <!-- AOS Animation Init -->
        <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                AOS.init({
                    duration: 800,
                    easing: 'ease-in-out',
                    once: true,
                    offset: 100,
                });
            });
        </script>

        <!-- Global Session Expiration Handler -->
        <script>
            (function() {
                // Intercept all fetch requests
                const originalFetch = window.fetch;
                window.fetch = function(...args) {
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

                XMLHttpRequest.prototype.open = function(method, url, ...args) {
                    this._url = url;
                    return originalOpen.apply(this, [method, url, ...args]);
                };

                XMLHttpRequest.prototype.send = function(...args) {
                    this.addEventListener('load', function() {
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
    </body>
</html>