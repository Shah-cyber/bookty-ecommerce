@extends('layouts.admin')

@section('header', 'Book Details')

@section('content')
@section('content')
    <div class="w-full">
        <div class="mb-6 flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Book Details</h2>
            <a href="{{ route('admin.books.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 flex items-center transition-colors">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to Books
            </a>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow-sm border border-gray-100 dark:border-gray-700 rounded-2xl overflow-hidden">
            <div class="p-6 md:p-8">
                <div class="flex flex-col md:flex-row gap-8">
                    <!-- Book Cover -->
                    <div class="md:w-1/3 lg:w-1/4 flex-shrink-0">
                        <div class="relative group rounded-xl overflow-hidden shadow-lg border border-gray-100 dark:border-gray-700 bg-gray-100 dark:bg-gray-700 aspect-[2/3]">
                            @if($book->cover_image)
                                <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400 dark:text-gray-500">
                                    <div class="text-center p-4">
                                        <svg class="h-16 w-16 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span class="text-sm font-medium">No Cover Image</span>
                                    </div>
                                </div>
                            @endif
                            
                            <!-- Stock Overlay -->
                            <div class="absolute top-2 right-2">
                                @if($book->stock > 10)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 shadow-sm">
                                        In Stock ({{ $book->stock }})
                                    </span>
                                @elseif($book->stock > 0)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800 shadow-sm">
                                        Low Stock ({{ $book->stock }})
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 shadow-sm">
                                        Out of Stock
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="mt-6 flex flex-col space-y-3">
                            <a href="{{ route('admin.books.edit', $book) }}" class="flex items-center justify-center w-full px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors shadow-sm">
                                <svg class="w-4 h-4 mr-2 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                Edit Book
                            </a>
                            <form action="{{ route('admin.books.destroy', $book) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this book? This action cannot be undone.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="flex items-center justify-center w-full px-4 py-2 bg-white dark:bg-gray-700 border border-red-200 dark:border-red-800 rounded-lg text-sm font-medium text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors shadow-sm">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    Delete Book
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Book Details -->
                    <div class="md:w-2/3 lg:w-3/4">
                        <div class="flex flex-col h-full">
                            <div>
                                <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 dark:text-white tracking-tight mb-2">{{ $book->title }}</h1>
                                <p class="text-xl text-gray-500 dark:text-gray-400 font-medium">by <span class="text-gray-900 dark:text-gray-200">{{ $book->author }}</span></p>
                            </div>

                            <div class="mt-8 border-t border-gray-100 dark:border-gray-700 pt-8">
                                <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider mb-3">Synopsis</h3>
                                <div class="prose prose-purple dark:prose-invert max-w-none text-gray-600 dark:text-gray-300 leading-relaxed">
                                    {{ $book->synopsis }}
                                </div>
                            </div>
                            
                            <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                                <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-5 border border-gray-100 dark:border-gray-700">
                                    <div class="flex items-center mb-2">
                                        <svg class="h-5 w-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Genre</h3>
                                    </div>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300">
                                        {{ $book->genre->name }}
                                    </span>
                                </div>

                                <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-5 border border-gray-100 dark:border-gray-700">
                                    <div class="flex items-center mb-2">
                                        <svg class="h-5 w-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Tropes</h3>
                                    </div>
                                    <div class="flex flex-wrap gap-2">
                                        @forelse($book->tropes as $trope)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300 border border-blue-100 dark:border-blue-800">
                                                {{ $trope->name }}
                                            </span>
                                        @empty
                                            <span class="text-sm text-gray-400 italic">No tropes assigned</span>
                                        @endforelse
                                    </div>
                                </div>

                                <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-5 border border-gray-100 dark:border-gray-700">
                                    <div class="flex items-center mb-2">
                                        <svg class="h-5 w-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Pricing</h3>
                                    </div>
                                    <div class="flex items-baseline gap-2">
                                        <span class="text-2xl font-bold text-gray-900 dark:text-white">RM {{ number_format($book->price, 2) }}</span>
                                        @if($book->cost_price)
                                            <span class="text-sm text-gray-400">(Cost: RM {{ number_format($book->cost_price, 2) }})</span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-5 border border-gray-100 dark:border-gray-700">
                                    <div class="flex items-center mb-2">
                                        <svg class="h-5 w-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Additional Info</h3>
                                    </div>
                                    <dl class="space-y-1">
                                        <div class="flex justify-between">
                                            <dt class="text-sm text-gray-500">Slug:</dt>
                                            <dd class="text-sm font-mono text-gray-700 dark:text-gray-300">{{ $book->slug }}</dd>
                                        </div>
                                        <div class="flex justify-between">
                                            <dt class="text-sm text-gray-500">Added:</dt>
                                            <dd class="text-sm text-gray-700 dark:text-gray-300">{{ $book->created_at->format('M d, Y') }}</dd>
                                        </div>
                                        <div class="flex justify-between">
                                            <dt class="text-sm text-gray-500">Last Updated:</dt>
                                            <dd class="text-sm text-gray-700 dark:text-gray-300">{{ $book->updated_at->format('M d, Y') }}</dd>
                                        </div>
                                        <div class="flex justify-between">
                                            <dt class="text-sm text-gray-500">Condition:</dt>
                                            <dd class="text-sm">
                                                @if(($book->condition ?? 'new') === 'preloved')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300">
                                                        Preloved
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">
                                                        New
                                                    </span>
                                                @endif
                                            </dd>
                                        </div>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
