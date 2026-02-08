@extends('layouts.admin')

@section('header', 'Flash Sale Details')

@section('content')
<div class="space-y-6">
    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.flash-sales.index') }}" 
               class="p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Flash Sale Details</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1">View flash sale information and books</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.flash-sales.edit', $flashSale->id) }}" 
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-rose-600 text-white font-medium rounded-xl hover:bg-rose-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit
            </a>
        </div>
    </div>

    {{-- Sale Header Card --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex flex-col md:flex-row md:items-center gap-6">
            <div class="w-16 h-16 rounded-2xl bg-rose-100 dark:bg-rose-900/30 flex items-center justify-center flex-shrink-0">
                <svg class="w-8 h-8 text-rose-600 dark:text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <div class="flex-1">
                <div class="flex flex-wrap items-center gap-3 mb-2">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $flashSale->name }}</h2>
                    @if($flashSale->isActive())
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">
                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span>
                            Live
                        </span>
                    @elseif($flashSale->is_active && $flashSale->starts_at > now())
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400">
                            Scheduled
                        </span>
                    @elseif($flashSale->ends_at < now())
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                            Ended
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400">
                            Inactive
                        </span>
                    @endif
                </div>
                @if($flashSale->description)
                    <p class="text-gray-500 dark:text-gray-400">{{ $flashSale->description }}</p>
                @endif
                @if($flashSale->isActive())
                    <p class="text-sm text-green-600 dark:text-green-400 mt-2 font-medium">
                        <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Ends in: {{ $flashSale->getRemainingTime() }}
                    </p>
                @elseif($flashSale->is_active && $flashSale->starts_at > now())
                    <p class="text-sm text-yellow-600 dark:text-yellow-400 mt-2 font-medium">
                        Starts {{ $flashSale->starts_at->diffForHumans() }}
                    </p>
                @endif
            </div>
            <div class="text-center md:text-right">
                @if($flashSale->discount_type === 'fixed')
                    <p class="text-3xl font-bold text-green-600 dark:text-green-400">RM {{ number_format($flashSale->discount_value, 2) }}</p>
                @else
                    <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $flashSale->discount_value }}%</p>
                @endif
                <p class="text-sm text-gray-500 dark:text-gray-400">off</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        {{-- Sale Info --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Sale Information</h3>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Discount Type</p>
                    <p class="font-medium text-gray-900 dark:text-gray-100">{{ ucfirst($flashSale->discount_type) }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Discount Value</p>
                    <p class="font-medium text-gray-900 dark:text-gray-100">
                        {{ $flashSale->discount_type === 'fixed' ? 'RM ' . number_format($flashSale->discount_value, 2) : $flashSale->discount_value . '%' }}
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Start Date</p>
                    <p class="font-medium text-gray-900 dark:text-gray-100">{{ $flashSale->starts_at->format('M d, Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">End Date</p>
                    <p class="font-medium text-gray-900 dark:text-gray-100">{{ $flashSale->ends_at->format('M d, Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Books</p>
                    <p class="font-medium text-gray-900 dark:text-gray-100">{{ $flashSale->books->count() }} books</p>
                </div>
                @if($flashSale->free_shipping)
                    <div class="pt-2">
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                            Free Shipping
                        </span>
                    </div>
                @endif
            </div>
            
            {{-- Actions --}}
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50 space-y-2">
                <form action="{{ route('admin.flash-sales.toggle', $flashSale->id) }}" method="POST" class="w-full">
                    @csrf
                    <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 {{ $flashSale->is_active ? 'bg-amber-50 text-amber-600 dark:bg-amber-900/30 dark:text-amber-400' : 'bg-green-50 text-green-600 dark:bg-green-900/30 dark:text-green-400' }} font-medium rounded-xl hover:bg-opacity-80 transition-colors">
                        {{ $flashSale->is_active ? 'Deactivate' : 'Activate' }}
                    </button>
                </form>
                
                <form action="{{ route('admin.flash-sales.destroy', $flashSale->id) }}" method="POST" class="w-full" onsubmit="return confirm('Are you sure you want to delete this flash sale?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-red-50 text-red-600 dark:bg-red-900/30 dark:text-red-400 font-medium rounded-xl hover:bg-opacity-80 transition-colors">
                        Delete
                    </button>
                </form>
            </div>
        </div>

        {{-- Books in Sale --}}
        <div class="lg:col-span-3 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Books in Sale</h3>
                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm font-medium bg-rose-100 text-rose-700 dark:bg-rose-900/30 dark:text-rose-400">
                    {{ $flashSale->books->count() }} Books
                </span>
            </div>
            
            @if($flashSale->books->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider border-b border-gray-200 dark:border-gray-700">
                                <th class="px-6 py-4">Book</th>
                                <th class="px-6 py-4">Original Price</th>
                                <th class="px-6 py-4">Sale Price</th>
                                <th class="px-6 py-4">Discount</th>
                                <th class="px-6 py-4">Orders</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach($flashSale->books as $book)
                                @php
                                    $specialPrice = $book->pivot->special_price;
                                    $salePrice = $specialPrice ?? $flashSale->getDiscountedPrice($book->price);
                                    $discountAmount = $book->price - $salePrice;
                                    $discountPercent = $book->price > 0 ? ($discountAmount / $book->price) * 100 : 0;
                                @endphp
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            @if($book->cover_image)
                                                <img class="w-10 h-14 rounded-lg object-cover" src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}">
                                            @else
                                                <div class="w-10 h-14 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                                    </svg>
                                                </div>
                                            @endif
                                            <div>
                                                <p class="font-medium text-gray-900 dark:text-gray-100">{{ Str::limit($book->title, 30) }}</p>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $book->author }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                                        RM {{ number_format($book->price, 2) }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="font-medium text-rose-600 dark:text-rose-400">RM {{ number_format($salePrice, 2) }}</span>
                                        @if($specialPrice)
                                            <span class="text-xs text-gray-400 dark:text-gray-500 block">Custom price</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">
                                            {{ round($discountPercent) }}% off
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                                        {{ $book->order_items_count ?? 0 }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-12 text-center">
                    <div class="w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <p class="text-gray-500 dark:text-gray-400">No books added to this flash sale yet.</p>
                    <a href="{{ route('admin.flash-sales.edit', $flashSale->id) }}" class="inline-flex items-center gap-2 text-rose-600 hover:text-rose-700 dark:text-rose-400 dark:hover:text-rose-300 font-medium mt-4">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Add Books
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
