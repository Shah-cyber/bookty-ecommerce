<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Bookty Enterprise') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('images/BooktyL.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased" data-layout="customer">
        <div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-purple-600 to-pink-500 p-4">
            <!-- Modal-like Authentication Box -->
            <div class="w-full max-w-md bg-white rounded-xl shadow-2xl overflow-hidden">
                <!-- Logo Section -->
                <div class="flex justify-end p-2">
                    <a href="/" class="text-gray-400 hover:text-gray-500">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </a>
                </div>
                
                <div class="flex justify-center mb-2">
                    <img src="{{ asset('storage/BooktyLogo/BooktyL.png') }}" alt="Bookty Logo" class="h-14 w-auto">
                </div>
                
                <!-- Form Section -->
                <div class="px-8 pb-8">
                    {{ $slot }}
                </div>
                
                <!-- Footer -->
                <div class="text-center text-xs text-gray-500 pb-4">
                    <p>&copy; {{ date('Y') }} Bookty Enterprise. All rights reserved.</p>
                </div>
            </div>
            
            <!-- Background Decorative Elements -->
            <div class="fixed top-0 right-0 -mr-16 -mt-16 w-80 h-80 rounded-full bg-pink-400 opacity-20 blur-3xl"></div>
            <div class="fixed bottom-0 left-0 -ml-16 -mb-16 w-80 h-80 rounded-full bg-purple-800 opacity-20 blur-3xl"></div>
            
            <!-- Floating Book Icons -->
            <div class="fixed top-1/4 right-12 animate-float">
                <svg class="w-16 h-16 text-white opacity-20" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"></path>
                </svg>
            </div>
            <div class="fixed bottom-1/3 left-12 animate-float-delayed">
                <svg class="w-12 h-12 text-white opacity-20" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"></path>
                </svg>
            </div>
        </div>
    </body>
</html>
