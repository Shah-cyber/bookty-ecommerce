@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8 dark:bg-gray-900 dark:text-gray-100">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Flash Sale Details</h1>
        <div class="flex space-x-2">
            <a href="{{ route('admin.flash-sales.edit', $flashSale->id) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                Edit
            </a>
            <a href="{{ route('admin.flash-sales.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Flash Sales
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Flash Sale Info -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden dark:bg-gray-800 dark:shadow-none">
            <div class="bg-gray-100 dark:bg-gray-700 px-6 py-4 border-b border-gray-200 dark:border-gray-600">
                <h2 class="text-xl font-bold text-white">Sale Information</h2>
            </div>
            <div class="p-6">
                <div class="mb-4">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-300">Name</h3>
                    <p class="mt-1 text-lg font-bold text-gray-900 dark:text-gray-100">{{ $flashSale->name }}</p>
                </div>
                
                <div class="mb-4">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-300">Description</h3>
                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $flashSale->description ?? 'No description provided' }}</p>
                </div>
                
                <div class="mb-4">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-300">Status</h3>
                    <div class="mt-1">
                        @if($flashSale->isActive())
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Active
                            </span>
                            <p class="text-sm text-green-600 mt-1">Ends in: {{ $flashSale->getRemainingTime() }}</p>
                        @elseif($flashSale->is_active && $flashSale->starts_at > now())
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                Scheduled
                            </span>
                            <p class="text-sm text-yellow-600 mt-1">Starts in: {{ $flashSale->starts_at->diffForHumans() }}</p>
                        @elseif($flashSale->is_active && $flashSale->ends_at < now())
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                Ended
                            </span>
                            <p class="text-sm text-gray-600 mt-1">Ended: {{ $flashSale->ends_at->diffForHumans() }}</p>
                        @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                Inactive
                            </span>
                        @endif
                    </div>
                </div>
                
                <div class="mb-4">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-300">Discount Type</h3>
                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                        @if($flashSale->discount_type === 'fixed')
                            Fixed Amount: RM {{ number_format($flashSale->discount_value, 2) }}
                        @else
                            Percentage: {{ $flashSale->discount_value }}%
                        @endif
                    </p>
                </div>
                
                <div class="mb-4">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-300">Sale Period</h3>
                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                        From: {{ $flashSale->starts_at->format('M d, Y H:i A') }}<br>
                        To: {{ $flashSale->ends_at->format('M d, Y H:i A') }}
                    </p>
                </div>
                
                <div class="mb-4">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-300">Created At</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $flashSale->created_at->format('M d, Y H:i A') }}</p>
                </div>
                
                <div class="mb-4">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-300">Last Updated</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $flashSale->updated_at->format('M d, Y H:i A') }}</p>
                </div>
            </div>
            
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 dark:bg-gray-700 dark:border-gray-600">
                <div class="flex space-x-3">
                    <form action="{{ route('admin.flash-sales.toggle', $flashSale->id) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="{{ $flashSale->is_active ? 'bg-yellow-600 hover:bg-yellow-700' : 'bg-green-600 hover:bg-green-700' }} text-white font-bold py-2 px-4 rounded">
                            {{ $flashSale->is_active ? 'Deactivate' : 'Activate' }}
                        </button>
                    </form>
                    
                    <form action="{{ route('admin.flash-sales.destroy', $flashSale->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this flash sale?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Books in Sale -->
        <div class="md:col-span-2 bg-white shadow-md rounded-lg overflow-hidden dark:bg-gray-800 dark:shadow-none">
            <div class="bg-gradient-to-r from-purple-600 to-pink-600 px-6 py-4 flex justify-between items-center">
                <h2 class="text-xl font-bold text-white">Books in Sale</h2>
                <span class="bg-white text-purple-600 px-3 py-1 rounded-full text-sm font-medium">
                    {{ $flashSale->books->count() }} Books
                </span>
            </div>
            
            <div class="p-6">
                @if($flashSale->books->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Book</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Original Price</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sale Price</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Discount</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Orders</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                @foreach($flashSale->books as $book)
                                    @php
                                        $specialPrice = $book->pivot->special_price;
                                        $salePrice = $specialPrice ?? $flashSale->getDiscountedPrice($book->price);
                                        $discountAmount = $book->price - $salePrice;
                                        $discountPercent = ($discountAmount / $book->price) * 100;
                                    @endphp
                                    <tr>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                @if($book->cover_image)
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        <img class="h-10 w-10 rounded object-cover" src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}">
                                                    </div>
                                                @endif
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ $book->title }}</div>
                                                    <div class="text-xs text-gray-500">by {{ $book->author }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                            RM {{ number_format($book->price, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-red-600 font-medium">
                                            RM {{ number_format($salePrice, 2) }}
                                            @if($specialPrice)
                                                <span class="text-xs text-gray-500">(Custom price)</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                {{ round($discountPercent) }}% off
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                            {{ $book->order_items_count ?? 0 }} orders
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                        No books added to this flash sale yet.
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Preview Section -->
    @if($flashSale->isActive())
        <div class="mt-8 bg-white shadow-md rounded-lg overflow-hidden dark:bg-gray-800 dark:shadow-none">
            <div class="bg-gradient-to-r from-purple-600 to-pink-600 px-6 py-4">
                <h2 class="text-xl font-bold text-white">Flash Sale Preview</h2>
            </div>
            <div class="p-6">
                <x-flash-sale-countdown :end-time="$flashSale->ends_at->toIso8601String()" :title="$flashSale->name" class="mb-6">
                    <p class="text-sm">{{ $flashSale->description }}</p>
                </x-flash-sale-countdown>
                
                <div class="text-center text-sm text-gray-500 mt-4">
                    This is how the flash sale appears to customers on the website.
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
