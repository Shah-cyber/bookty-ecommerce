@extends('layouts.admin')

@section('header', 'Discount Details')

@section('content')
<div class="space-y-6">
    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.discounts.index') }}" 
               class="p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Discount Details</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1">View discount information</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.discounts.edit', $discount->id) }}" 
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-purple-600 text-white font-medium rounded-xl hover:bg-purple-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Book Info --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Book Information</h3>
            </div>
            <div class="p-6">
                <div class="flex flex-col items-center text-center">
                    @if($discount->book->cover_image)
                        <img src="{{ asset('storage/' . $discount->book->cover_image) }}" alt="{{ $discount->book->title }}" class="w-32 h-48 object-cover rounded-xl shadow-md mb-4">
                    @else
                        <div class="w-32 h-48 bg-gray-100 dark:bg-gray-700 flex items-center justify-center rounded-xl shadow-md mb-4">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                    @endif
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $discount->book->title }}</h3>
                    <p class="text-gray-500 dark:text-gray-400">by {{ $discount->book->author }}</p>
                    
                    <div class="mt-4 space-y-2 w-full">
                        <div class="flex justify-between items-center py-2 border-t border-gray-100 dark:border-gray-700">
                            <span class="text-gray-500 dark:text-gray-400">Original Price:</span>
                            <span class="font-semibold text-gray-900 dark:text-gray-100">RM {{ number_format($discount->book->price, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-t border-gray-100 dark:border-gray-700">
                            <span class="text-gray-500 dark:text-gray-400">Discounted Price:</span>
                            <span class="font-bold text-green-600 dark:text-green-400">RM {{ number_format($discount->getDiscountedPrice($discount->book->price), 2) }}</span>
                        </div>
                    </div>
                    
                    <a href="{{ route('admin.books.show', $discount->book->id) }}" class="mt-4 inline-flex items-center gap-2 text-purple-600 hover:text-purple-700 dark:text-purple-400 dark:hover:text-purple-300 font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                        View Book
                    </a>
                </div>
            </div>
        </div>

        {{-- Discount Details --}}
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Discount Details</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Discount Type</p>
                            <div class="mt-1">
                                @if($discount->discount_amount)
                                    <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-sm font-medium bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">
                                        Fixed Amount: RM {{ number_format($discount->discount_amount, 2) }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-sm font-medium bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400">
                                        Percentage: {{ $discount->discount_percent }}%
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Status</p>
                            <div class="mt-1">
                                @if($discount->is_active)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">
                                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                                        Inactive
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Description</p>
                            <p class="mt-1 font-medium text-gray-900 dark:text-gray-100">{{ $discount->description ?: 'No description provided' }}</p>
                        </div>
                        
                        @if($discount->free_shipping)
                            <div>
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                                    Includes Free Shipping
                                </span>
                            </div>
                        @endif
                    </div>
                    
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Start Date</p>
                            <p class="mt-1 font-medium text-gray-900 dark:text-gray-100">
                                {{ $discount->starts_at ? $discount->starts_at->format('M d, Y H:i A') : 'No start date' }}
                            </p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">End Date</p>
                            <p class="mt-1 font-medium text-gray-900 dark:text-gray-100">
                                {{ $discount->ends_at ? $discount->ends_at->format('M d, Y H:i A') : 'No end date' }}
                            </p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Created At</p>
                            <p class="mt-1 font-medium text-gray-900 dark:text-gray-100">{{ $discount->created_at->format('M d, Y H:i A') }}</p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Last Updated</p>
                            <p class="mt-1 font-medium text-gray-900 dark:text-gray-100">{{ $discount->updated_at->format('M d, Y H:i A') }}</p>
                        </div>
                    </div>
                </div>
                
                {{-- Actions --}}
                <div class="flex flex-wrap gap-3 mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <form action="{{ route('admin.discounts.toggle', $discount->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-2 px-4 py-2.5 {{ $discount->is_active ? 'bg-amber-50 text-amber-600 dark:bg-amber-900/30 dark:text-amber-400 hover:bg-amber-100 dark:hover:bg-amber-900/50' : 'bg-green-50 text-green-600 dark:bg-green-900/30 dark:text-green-400 hover:bg-green-100 dark:hover:bg-green-900/50' }} font-medium rounded-xl transition-colors">
                            @if($discount->is_active)
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                </svg>
                                Deactivate
                            @else
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Activate
                            @endif
                        </button>
                    </form>
                    
                    <form action="{{ route('admin.discounts.destroy', $discount->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this discount?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center gap-2 px-4 py-2.5 bg-red-50 text-red-600 dark:bg-red-900/30 dark:text-red-400 font-medium rounded-xl hover:bg-red-100 dark:hover:bg-red-900/50 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
