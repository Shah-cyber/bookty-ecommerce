@extends('layouts.admin')

@section('header', 'Book Details')

@section('content')
    {{-- Page Header --}}
    <div class="mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.books.index') }}" class="p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $book->title }}</h2>
                    <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">by {{ $book->author }}</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.books.edit', $book) }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit Book
                </a>
                <form action="{{ route('admin.books.destroy', $book) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this book? This action cannot be undone.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium text-red-600 dark:text-red-400 bg-white dark:bg-gray-700 border border-red-200 dark:border-red-800 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/30 transition-colors shadow-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Main Content --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Book Info Card --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="p-6 sm:p-8">
                    <div class="flex flex-col sm:flex-row gap-6">
                        {{-- Cover Image --}}
                        <div class="flex-shrink-0 sm:w-48">
                            <div class="relative group rounded-xl overflow-hidden shadow-lg border border-gray-100 dark:border-gray-700 bg-gray-100 dark:bg-gray-700 aspect-[2/3]">
                                @if($book->cover_image)
                                    <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400 dark:text-gray-500">
                                        <div class="text-center p-4">
                                            <svg class="h-12 w-12 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <span class="text-xs font-medium">No Cover</span>
                                        </div>
                                    </div>
                                @endif
                                
                                {{-- Stock Badge --}}
                                <div class="absolute top-2 right-2">
                                    @if($book->stock > 10)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-500 text-white shadow-sm">
                                            In Stock
                                        </span>
                                    @elseif($book->stock > 0)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-amber-500 text-white shadow-sm">
                                            Low Stock
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-500 text-white shadow-sm">
                                            Out of Stock
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        {{-- Details --}}
                        <div class="flex-1 min-w-0">
                            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-1">{{ $book->title }}</h1>
                            <p class="text-lg text-gray-500 dark:text-gray-400 mb-4">by <span class="text-gray-900 dark:text-gray-200 font-medium">{{ $book->author }}</span></p>
                            
                            <div class="flex flex-wrap gap-2 mb-6">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800 dark:bg-purple-900/40 dark:text-purple-300">
                                    {{ $book->genre->name ?? 'N/A' }}
                                </span>
                                @if(($book->condition ?? 'new') === 'preloved')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:text-amber-300">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                        </svg>
                                        Preloved
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        New
                                    </span>
                                @endif
                            </div>
                            
                            {{-- Price & Stock Info --}}
                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4">
                                    <p class="text-xs text-gray-500 dark:text-gray-400 font-medium mb-1">Selling Price</p>
                                    <p class="text-2xl font-bold text-gray-900 dark:text-white">RM {{ number_format($book->price, 2) }}</p>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4">
                                    <p class="text-xs text-gray-500 dark:text-gray-400 font-medium mb-1">Stock Available</p>
                                    <p class="text-2xl font-bold {{ $book->stock > 10 ? 'text-green-600 dark:text-green-400' : ($book->stock > 0 ? 'text-amber-600 dark:text-amber-400' : 'text-red-600 dark:text-red-400') }}">{{ $book->stock }} units</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Synopsis --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Synopsis
                </h3>
                <div class="prose prose-purple dark:prose-invert max-w-none text-gray-600 dark:text-gray-300 leading-relaxed">
                    {{ $book->synopsis ?: 'No synopsis available.' }}
                </div>
            </div>

            {{-- Tropes --}}
            @if($book->tropes->count() > 0)
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    Tropes
                </h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($book->tropes as $trope)
                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300 border border-blue-100 dark:border-blue-800">
                            {{ $trope->name }}
                        </span>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            {{-- Quick Stats --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Book Statistics</h3>
                
                <div class="space-y-4">
                    {{-- Pricing Info --}}
                    <div class="flex items-center justify-between py-3 border-b border-gray-100 dark:border-gray-700">
                        <span class="text-sm text-gray-500 dark:text-gray-400">Selling Price</span>
                        <span class="text-sm font-semibold text-gray-900 dark:text-white">RM {{ number_format($book->price, 2) }}</span>
                    </div>
                    
                    @if($book->cost_price)
                    <div class="flex items-center justify-between py-3 border-b border-gray-100 dark:border-gray-700">
                        <span class="text-sm text-gray-500 dark:text-gray-400">Cost Price</span>
                        <span class="text-sm font-semibold text-gray-900 dark:text-white">RM {{ number_format($book->cost_price, 2) }}</span>
                    </div>
                    
                    <div class="flex items-center justify-between py-3 border-b border-gray-100 dark:border-gray-700">
                        <span class="text-sm text-gray-500 dark:text-gray-400">Profit Margin</span>
                        @php
                            $margin = $book->price - $book->cost_price;
                            $marginPercent = $book->cost_price > 0 ? (($margin / $book->cost_price) * 100) : 0;
                        @endphp
                        <span class="text-sm font-semibold {{ $margin > 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                            RM {{ number_format($margin, 2) }} ({{ number_format($marginPercent, 1) }}%)
                        </span>
                    </div>
                    @endif
                    
                    <div class="flex items-center justify-between py-3 border-b border-gray-100 dark:border-gray-700">
                        <span class="text-sm text-gray-500 dark:text-gray-400">Current Stock</span>
                        <span class="text-sm font-semibold {{ $book->stock > 10 ? 'text-green-600 dark:text-green-400' : ($book->stock > 0 ? 'text-amber-600 dark:text-amber-400' : 'text-red-600 dark:text-red-400') }}">
                            {{ $book->stock }} units
                        </span>
                    </div>
                    
                    <div class="flex items-center justify-between py-3 border-b border-gray-100 dark:border-gray-700">
                        <span class="text-sm text-gray-500 dark:text-gray-400">Stock Value</span>
                        <span class="text-sm font-semibold text-gray-900 dark:text-white">RM {{ number_format($book->price * $book->stock, 2) }}</span>
                    </div>
                    
                    <div class="flex items-center justify-between py-3">
                        <span class="text-sm text-gray-500 dark:text-gray-400">Condition</span>
                        @if(($book->condition ?? 'new') === 'preloved')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:text-amber-300">
                                Preloved
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300">
                                New
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Metadata --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Book Details</h3>
                
                <div class="space-y-4">
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium mb-1">Slug</p>
                        <p class="text-sm font-mono text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700/50 rounded-lg px-3 py-2 break-all">{{ $book->slug }}</p>
                    </div>
                    
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium mb-1">Genre</p>
                        <p class="text-sm text-gray-900 dark:text-white">{{ $book->genre->name ?? 'N/A' }}</p>
                    </div>
                    
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium mb-1">Created</p>
                        <p class="text-sm text-gray-900 dark:text-white">{{ $book->created_at->format('M d, Y \a\t g:i A') }}</p>
                    </div>
                    
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium mb-1">Last Updated</p>
                        <p class="text-sm text-gray-900 dark:text-white">{{ $book->updated_at->format('M d, Y \a\t g:i A') }}</p>
                    </div>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Quick Actions</h3>
                
                <div class="space-y-3">
                    <a href="{{ route('admin.books.edit', $book) }}" class="flex items-center w-full px-4 py-3 text-sm font-medium text-gray-700 dark:text-gray-200 bg-gray-50 dark:bg-gray-700/50 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-colors">
                        <svg class="w-5 h-5 mr-3 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit Book Details
                    </a>
                    
                    <a href="{{ route('books.show', $book->slug) }}" target="_blank" class="flex items-center w-full px-4 py-3 text-sm font-medium text-gray-700 dark:text-gray-200 bg-gray-50 dark:bg-gray-700/50 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-colors">
                        <svg class="w-5 h-5 mr-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                        View on Store
                    </a>
                    
                    <a href="{{ route('admin.books.create') }}" class="flex items-center w-full px-4 py-3 text-sm font-medium text-gray-700 dark:text-gray-200 bg-gray-50 dark:bg-gray-700/50 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-colors">
                        <svg class="w-5 h-5 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Add New Book
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
