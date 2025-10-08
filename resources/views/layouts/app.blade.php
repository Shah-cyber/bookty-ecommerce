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
        
        <!-- Cart AJAX Operations -->
        <script src="{{ asset('js/cart.js') }}"></script>
    </body>
</html>