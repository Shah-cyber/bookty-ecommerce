<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('code') • @yield('title') | Bookty Enterprise</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-950 text-slate-100 flex items-center justify-center p-6" style="font-family: 'Inter', sans-serif;">
    <div class="max-w-5xl w-full space-y-10">
        <div class="bg-slate-900/80 border border-slate-800 rounded-3xl shadow-2xl overflow-hidden relative">
            <div class="absolute inset-0 bg-gradient-to-br from-purple-600/20 via-slate-900/30 to-pink-500/20 pointer-events-none"></div>
            <div class="relative z-10 p-10 flex flex-col gap-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                    <div class="space-y-2">
                        <p class="text-sm uppercase tracking-[0.4em] text-amber-300">Error @yield('code')</p>
                        <h1 class="text-3xl md:text-4xl font-extrabold text-white">@yield('title')</h1>
                        <p class="text-base text-slate-300 leading-relaxed">@yield('message')</p>
                        <p class="text-sm text-slate-400">@yield('hint')</p>
                    </div>
                    <div class="text-7xl md:text-8xl font-black text-transparent bg-clip-text bg-gradient-to-b from-white to-slate-500 drop-shadow-lg text-right">@yield('code')</div>
                </div>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('home') }}" class="px-5 py-3 rounded-2xl bg-gradient-to-r from-purple-500 to-pink-500 text-white font-semibold shadow-lg shadow-purple-900/30 hover:scale-[1.02] transition">
                        Go back Home
                    </a>
                    <button onclick="window.history.back()" class="px-5 py-3 rounded-2xl border border-slate-700 text-slate-200 hover:bg-slate-800 transition">
                        Try Previous Page
                    </button>
                    {{-- <a href="mailto:{{ config('mail.from.address') }}" class="px-5 py-3 rounded-2xl border border-slate-700 text-slate-200 hover:bg-slate-800 transition">
                        Contact Support
                    </a> --}}
                </div>
            </div>
        </div>

        {{-- <div class="bg-slate-900/70 border border-slate-800 rounded-3xl p-8 shadow-xl space-y-6">
            <div class="flex items-center gap-3">
                <span class="text-amber-300 text-xl">⭐</span>
                <h2 class="text-xl font-semibold text-white">Most used error codes</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-slate-200">
                @php
                    $codes = [
                        ['400', 'Bad Request', 'Invalid input data'],
                        ['401', 'Unauthorized', 'User not logged in'],
                        ['403', 'Forbidden', 'No permission'],
                        ['404', 'Not Found', 'Missing page or resource'],
                        ['419', 'Page Expired', 'Laravel CSRF token expired'],
                        ['422', 'Validation Error', 'Submitted data is invalid'],
                        ['429', 'Too Many Requests', 'Rate limit reached'],
                        ['500', 'Server Error', 'Unexpected crash/bug'],
                        ['503', 'Maintenance', 'Service temporarily unavailable'],
                    ];
                @endphp
                @foreach($codes as [$statusCode, $statusTitle, $statusDesc])
                    <div class="flex items-center justify-between bg-slate-800/60 rounded-2xl px-4 py-3 border border-slate-700">
                        <div>
                            <p class="text-slate-400 text-xs uppercase tracking-wide">Code {{ $statusCode }}</p>
                            <p class="font-semibold text-slate-100">{{ $statusTitle }}</p>
                            <p class="text-xs text-slate-400">{{ $statusDesc }}</p>
                        </div>
                        <div class="text-lg font-bold text-slate-500">{{ $statusCode }}</div>
                    </div>
                @endforeach
            </div>
            <p class="text-xs text-slate-500">Laravel adds 419 Page Expired — it is not a standard HTTP status but widely used for CSRF token expiration.</p>
        </div> --}}

        <p class="text-center text-xs text-slate-500">&copy; {{ date('Y') }} Bookty Enterprise. All rights reserved.</p>
    </div>
</body>
</html>

