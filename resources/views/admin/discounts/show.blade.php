@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8 dark:bg-gray-900 dark:text-gray-100">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Discount Details</h1>
        <div class="flex space-x-2">
            <a href="{{ route('admin.discounts.edit', $discount->id) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                Edit
            </a>
            <a href="{{ route('admin.discounts.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Discounts
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 dark:bg-green-900 dark:border-green-400 dark:text-green-200" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden dark:bg-gray-800 dark:shadow-none">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Book Info -->
            <div class="md:col-span-1 p-6 border-r border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Book Information</h2>
                <div class="flex flex-col items-center">
                    @if($discount->book->cover_image)
                        <img src="{{ asset('storage/' . $discount->book->cover_image) }}" alt="{{ $discount->book->title }}" class="w-32 h-48 object-cover rounded shadow-md mb-4">
                    @else
                        <div class="w-32 h-48 bg-gray-200 dark:bg-gray-600 flex items-center justify-center rounded shadow-md mb-4">
                            <svg class="w-12 h-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                    @endif
                    <h3 class="text-lg font-bold text-center text-gray-900 dark:text-gray-100">{{ $discount->book->title }}</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-center">by {{ $discount->book->author }}</p>
                    <div class="mt-2 text-center">
                        <span class="text-gray-600 dark:text-gray-400">Original Price:</span>
                        <span class="font-semibold text-gray-900 dark:text-gray-100">RM {{ number_format($discount->book->price, 2) }}</span>
                    </div>
                    <div class="mt-1 text-center">
                        <span class="text-gray-600 dark:text-gray-400">Discounted Price:</span>
                        <span class="font-semibold text-red-600 dark:text-red-400">RM {{ number_format($discount->getDiscountedPrice($discount->book->price), 2) }}</span>
                    </div>
                    <a href="{{ route('admin.books.show', $discount->book->id) }}" class="mt-4 text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">View Book Details</a>
                </div>
            </div>
            
            <!-- Discount Details -->
            <div class="md:col-span-2 p-6">
                <h2 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Discount Details</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <div class="mb-4">
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Discount Type</h3>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                @if($discount->discount_amount)
                                    Fixed Amount (RM {{ number_format($discount->discount_amount, 2) }})
                                @else
                                    Percentage ({{ $discount->discount_percent }}%)
                                @endif
                            </p>
                        </div>
                        
                        <div class="mb-4">
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</h3>
                            <p class="mt-1">
                                @if($discount->is_active)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Active
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        Inactive
                                    </span>
                                @endif
                            </p>
                        </div>
                        
                        <div class="mb-4">
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Description</h3>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                {{ $discount->description ?? 'No description provided' }}
                            </p>
                        </div>
                    </div>
                    
                    <div>
                        <div class="mb-4">
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Start Date</h3>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                {{ $discount->starts_at ? $discount->starts_at->format('M d, Y H:i A') : 'No start date (always active)' }}
                            </p>
                        </div>
                        
                        <div class="mb-4">
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">End Date</h3>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                {{ $discount->ends_at ? $discount->ends_at->format('M d, Y H:i A') : 'No end date (never expires)' }}
                            </p>
                        </div>
                        
                        <div class="mb-4">
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Created At</h3>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                {{ $discount->created_at->format('M d, Y H:i A') }}
                            </p>
                        </div>
                        
                        <div class="mb-4">
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Last Updated</h3>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                {{ $discount->updated_at->format('M d, Y H:i A') }}
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="mt-6 flex space-x-3">
                    <form action="{{ route('admin.discounts.toggle', $discount->id) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="{{ $discount->is_active ? 'bg-yellow-600 hover:bg-yellow-700' : 'bg-green-600 hover:bg-green-700' }} text-white font-bold py-2 px-4 rounded">
                            {{ $discount->is_active ? 'Deactivate' : 'Activate' }}
                        </button>
                    </form>
                    
                    <form action="{{ route('admin.discounts.destroy', $discount->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this discount?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
