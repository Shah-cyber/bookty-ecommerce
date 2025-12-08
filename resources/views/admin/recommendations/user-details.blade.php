@extends('layouts.admin')

@section('title', 'User Recommendation Details')

@section('content')
<div class="p-6 bg-gray-50 dark:bg-gray-900 min-h-screen transition-colors duration-300">
    <!-- Enhanced Header -->
    <div class="flex flex-wrap justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100 flex items-center">
                <i class="fas fa-user-chart text-blue-600 mr-2"></i>
                User Recommendation Analysis
            </h1>
            <p class="text-gray-500 dark:text-gray-400">Detailed analysis and insights for {{ $user->name }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.recommendations.index') }}" class="px-4 py-2 border border-blue-500 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900 rounded-lg text-sm font-medium transition">
                <i class="fas fa-chart-line mr-1"></i> Analytics Dashboard
            </a>
            <button class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition" onclick="refreshUserAnalysis()">
                <i class="fas fa-sync-alt mr-1"></i> Refresh Analysis
            </button>
        </div>
    </div>

    <!-- Enhanced User Info Card -->
    <div class="mb-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                <!-- User Profile & Stats -->
                <div class="flex-1 w-full">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center mr-4 text-blue-600 dark:text-blue-400">
                            <i class="fas fa-user fa-2x"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100">{{ $user->name }}</h2>
                            <p class="text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg text-center">
                            <i class="fas fa-calendar-alt text-blue-500 text-2xl mb-2"></i>
                            <div class="font-bold text-gray-800 dark:text-gray-100">{{ $user->created_at->format('M Y') }}</div>
                            <small class="text-gray-500 dark:text-gray-400">Member Since</small>
                        </div>
                        <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg text-center">
                            <i class="fas fa-shopping-cart text-green-500 text-2xl mb-2"></i>
                            <div class="font-bold text-gray-800 dark:text-gray-100">{{ $userOrders->count() }}</div>
                            <small class="text-gray-500 dark:text-gray-400">Total Orders</small>
                        </div>
                        <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg text-center">
                            <i class="fas fa-book text-cyan-500 text-2xl mb-2"></i>
                            <div class="font-bold text-gray-800 dark:text-gray-100">{{ $userOrders->sum(function($order) { return $order->items->sum('quantity'); }) }}</div>
                            <small class="text-gray-500 dark:text-gray-400">Books Purchased</small>
                        </div>
                        <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg text-center">
                            <i class="fas fa-heart text-red-500 text-2xl mb-2"></i>
                            <div class="font-bold text-gray-800 dark:text-gray-100">{{ $userWishlist->count() }}</div>
                            <small class="text-gray-500 dark:text-gray-400">Wishlist Items</small>
                        </div>
                    </div>
                </div>

                <!-- Status Badges -->
                <div class="flex flex-col gap-2 min-w-[200px] text-right">
                    <span class="px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 rounded-full text-sm font-semibold text-center">
                        Active Customer
                    </span>
                    <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-full text-sm font-semibold text-center">
                        Recommendation Ready
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Enhanced User Preferences -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center bg-gray-50 dark:bg-gray-800/50 rounded-t-lg">
                    <h3 class="font-semibold text-blue-600 dark:text-blue-400 flex items-center">
                        <i class="fas fa-heart mr-2"></i>User Preferences
                    </h3>
                    <span class="px-2 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded text-xs font-semibold">AI Analyzed</span>
                </div>
                <div class="p-4 space-y-6">
                    <!-- Favorite Genres -->
                    <div>
                        <div class="flex items-center mb-3 text-gray-800 dark:text-gray-200 font-medium">
                            <i class="fas fa-tags text-blue-500 mr-2"></i> Favorite Genres
                        </div>
                        <div class="space-y-2">
                            @forelse($userPreferences['genres'] as $genre => $count)
                                <div class="flex justify-between items-center p-2 rounded-lg {{ $loop->index % 2 == 0 ? 'bg-gray-50 dark:bg-gray-700/30' : '' }}">
                                    <div class="flex items-center">
                                        <span class="w-6 h-6 rounded-full bg-blue-500 text-white text-xs flex items-center justify-center mr-3 font-bold">{{ $loop->index + 1 }}</span>
                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $genre }}</span>
                                    </div>
                                    <span class="text-xs px-2 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-lg">{{ $count }} books</span>
                                </div>
                            @empty
                                <div class="text-center py-4 text-gray-400">
                                    <i class="fas fa-tags mb-2"></i>
                                    <p class="text-sm">No genre preferences yet</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                    
                    <hr class="border-gray-200 dark:border-gray-700">
                    
                    <!-- Favorite Authors -->
                    <div>
                        <div class="flex items-center mb-3 text-gray-800 dark:text-gray-200 font-medium">
                            <i class="fas fa-user-edit text-green-500 mr-2"></i> Favorite Authors
                        </div>
                        <div class="space-y-2">
                            @forelse($userPreferences['authors'] as $author => $count)
                                <div class="flex justify-between items-center p-2 rounded-lg {{ $loop->index % 2 == 0 ? 'bg-gray-50 dark:bg-gray-700/30' : '' }}">
                                    <div class="flex items-center">
                                        <span class="w-6 h-6 rounded-full bg-green-500 text-white text-xs flex items-center justify-center mr-3 font-bold">{{ $loop->index + 1 }}</span>
                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $author }}</span>
                                    </div>
                                    <span class="text-xs px-2 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 rounded-lg">{{ $count }} books</span>
                                </div>
                            @empty
                                <div class="text-center py-4 text-gray-400">
                                    <i class="fas fa-user-edit mb-2"></i>
                                    <p class="text-sm">No author preferences yet</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                    
                    <hr class="border-gray-200 dark:border-gray-700">
                    
                    <!-- Favorite Tropes -->
                    <div>
                        <div class="flex items-center mb-3 text-gray-800 dark:text-gray-200 font-medium">
                            <i class="fas fa-magic text-purple-500 mr-2"></i> Favorite Tropes
                        </div>
                        <div class="space-y-2">
                            @forelse($userPreferences['tropes'] as $trope => $count)
                                <div class="flex justify-between items-center p-2 rounded-lg {{ $loop->index % 2 == 0 ? 'bg-gray-50 dark:bg-gray-700/30' : '' }}">
                                    <div class="flex items-center">
                                        <span class="w-6 h-6 rounded-full bg-purple-500 text-white text-xs flex items-center justify-center mr-3 font-bold">{{ $loop->index + 1 }}</span>
                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $trope }}</span>
                                    </div>
                                    <span class="text-xs px-2 py-1 bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 rounded-lg">{{ $count }} books</span>
                                </div>
                            @empty
                                <div class="text-center py-4 text-gray-400">
                                    <i class="fas fa-magic mb-2"></i>
                                    <p class="text-sm">No trope preferences yet</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Current Recommendations -->
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 h-full">
                <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center bg-gray-50 dark:bg-gray-800/50 rounded-t-lg">
                    <h3 class="font-semibold text-blue-600 dark:text-blue-400 flex items-center">
                        <i class="fas fa-star mr-2"></i>Current Recommendations
                    </h3>
                    <div class="flex rounded-lg shadow-sm">
                        <button class="px-3 py-1 text-xs font-medium border border-blue-500 bg-blue-500 text-white rounded-l-lg">All</button>
                        <button class="px-3 py-1 text-xs font-medium border-t border-b border-blue-500 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900">High Score</button>
                        <button class="px-3 py-1 text-xs font-medium border border-blue-500 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900 rounded-r-lg">New</button>
                    </div>
                </div>
                <div class="p-6">
                    @if($userRecommendations->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($userRecommendations as $book)
                                <div class="bg-white dark:bg-gray-800 border-l-4 border-blue-500 rounded-r-lg shadow-sm hover:shadow-md transition p-4 border border-gray-100 dark:border-gray-700">
                                    <div class="flex gap-4">
                                        @if($book->cover_image)
                                            <img src="{{ asset('storage/' . $book->cover_image) }}" 
                                                 class="w-16 h-24 object-cover rounded shadow-sm shrink-0">
                                        @else
                                            <div class="w-16 h-24 bg-gray-100 dark:bg-gray-700 rounded flex items-center justify-center shrink-0">
                                                <i class="fas fa-book text-gray-400"></i>
                                            </div>
                                        @endif
                                        <div class="flex-1 min-w-0">
                                            <h4 class="font-bold text-gray-800 dark:text-gray-100 truncate" title="{{ $book->title }}">{{ $book->title }}</h4>
                                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">by {{ $book->author }}</p>
                                            
                                            <div class="flex justify-between items-center mb-2">
                                                <span class="px-2 py-0.5 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded text-xs">{{ $book->genre->name ?? 'N/A' }}</span>
                                                @if(isset($book->score))
                                                    <div class="flex items-center gap-2">
                                                        <div class="w-16 h-1.5 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                                            <div class="h-full bg-green-500" style="width: {{ $book->score * 100 }}%"></div>
                                                        </div>
                                                        <span class="text-xs font-bold text-green-600 dark:text-green-400">{{ round($book->score * 100) }}%</span>
                                                    </div>
                                                @endif
                                            </div>
                                            
                                            <div class="flex justify-between items-center mt-3">
                                                <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">RM {{ number_format($book->price, 2) }}</span>
                                                <div class="flex gap-1">
                                                    <a href="{{ route('books.show', $book) }}" class="p-1.5 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900 rounded transition" title="View Book">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <button class="p-1.5 text-green-600 hover:bg-green-50 dark:hover:bg-green-900 rounded transition" title="Add to Cart">
                                                        <i class="fas fa-cart-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="inline-flex p-4 rounded-full bg-gray-100 dark:bg-gray-800 mb-4">
                                <i class="fas fa-book-open text-4xl text-gray-400"></i>
                            </div>
                            <h5 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">No Recommendations Available</h5>
                            <p class="text-gray-500 dark:text-gray-400 mb-6">This user needs more purchase history for accurate recommendations.</p>
                            <div class="max-w-md mx-auto bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 flex items-start text-left">
                                <i class="fas fa-info-circle text-blue-500 mt-1 mr-3 shrink-0"></i>
                                <div>
                                    <h6 class="font-semibold text-blue-800 dark:text-blue-300 text-sm">Cold Start Problem</h6>
                                    <p class="text-blue-600 dark:text-blue-400 text-xs mt-1">Users with limited purchase history require different recommendation strategies.</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Purchase History -->
    <div class="mb-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center bg-gray-50 dark:bg-gray-800/50 rounded-t-lg">
                <h3 class="font-semibold text-blue-600 dark:text-blue-400 flex items-center">
                    <i class="fas fa-shopping-cart mr-2"></i>Purchase History
                </h3>
                <div class="flex rounded-lg shadow-sm">
                    <button class="px-3 py-1 text-xs font-medium border border-blue-500 bg-blue-500 text-white rounded-l-lg">All Orders</button>
                    <button class="px-3 py-1 text-xs font-medium border-t border-b border-blue-500 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900">Completed</button>
                    <button class="px-3 py-1 text-xs font-medium border border-blue-500 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900 rounded-r-lg">Recent</button>
                </div>
            </div>
            <div class="overflow-x-auto">
                @if($userOrders->count() > 0)
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b border-gray-200 dark:border-gray-700">
                            <tr>
                                <th class="px-6 py-3">Order Date</th>
                                <th class="px-6 py-3">Books</th>
                                <th class="px-6 py-3 text-right">Total</th>
                                <th class="px-6 py-3 text-center">Status</th>
                                <th class="px-6 py-3 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($userOrders as $order)
                                <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="p-2 bg-blue-50 dark:bg-blue-900/20 rounded text-blue-500 mr-3">
                                                <i class="fas fa-calendar-alt"></i>
                                            </div>
                                            <div>
                                                <div class="font-semibold text-gray-800 dark:text-gray-200">{{ $order->created_at->format('M d, Y') }}</div>
                                                <small class="text-gray-500 dark:text-gray-400">{{ $order->created_at->format('h:i A') }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="space-y-2">
                                            @foreach($order->items as $item)
                                                <div class="flex items-center p-2 rounded-lg bg-gray-50 dark:bg-gray-700/30">
                                                    @if($item->book->cover_image)
                                                        <img src="{{ asset('storage/' . $item->book->cover_image) }}" 
                                                             class="w-8 h-12 object-cover rounded shadow-sm mr-3">
                                                    @else
                                                        <div class="w-8 h-12 bg-gray-200 dark:bg-gray-600 rounded shadow-sm mr-3 flex items-center justify-center">
                                                            <i class="fas fa-book text-gray-400 text-xs"></i>
                                                        </div>
                                                    @endif
                                                    <div class="flex-1 min-w-0">
                                                        <div class="font-medium text-gray-800 dark:text-gray-200 text-xs truncate">{{ $item->book->title }}</div>
                                                        <div class="flex justify-between items-center mt-0.5">
                                                            <span class="text-[10px] px-1.5 py-0.5 bg-gray-200 dark:bg-gray-600 text-gray-600 dark:text-gray-300 rounded">{{ $item->book->genre->name ?? 'N/A' }}</span>
                                                            <small class="text-gray-500 dark:text-gray-400">Qty: {{ $item->quantity }}</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="font-bold text-gray-800 dark:text-gray-200">RM {{ number_format($order->total_amount, 2) }}</div>
                                        <small class="text-gray-500 dark:text-gray-400">{{ $order->items->sum('quantity') }} items</small>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($order->status === 'completed')
                                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">
                                                <i class="fas fa-check-circle mr-1"></i> Completed
                                            </span>
                                        @elseif($order->status === 'pending')
                                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300">
                                                <i class="fas fa-clock mr-1"></i> Pending
                                            </span>
                                        @else
                                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                                <i class="fas fa-info-circle mr-1"></i> {{ ucfirst($order->status) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center gap-2">
                                            <a href="{{ route('admin.orders.show', $order) }}" class="p-2 bg-blue-50 dark:bg-blue-900/20 text-blue-600 hover:bg-blue-100 dark:hover:bg-blue-900/40 rounded-lg transition" title="View Order">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.orders.edit', $order) }}" class="p-2 bg-cyan-50 dark:bg-cyan-900/20 text-cyan-600 hover:bg-cyan-100 dark:hover:bg-cyan-900/40 rounded-lg transition" title="Edit Order">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center py-12">
                        <div class="inline-flex p-4 rounded-full bg-gray-100 dark:bg-gray-800 mb-4">
                            <i class="fas fa-shopping-cart text-4xl text-gray-400"></i>
                        </div>
                        <h5 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">No Purchase History</h5>
                        <p class="text-gray-500 dark:text-gray-400 mb-6">This user hasn't made any purchases yet.</p>
                        <div class="max-w-md mx-auto bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4 flex items-start text-left">
                            <i class="fas fa-exclamation-triangle text-yellow-500 mt-1 mr-3 shrink-0"></i>
                            <div>
                                <h6 class="font-semibold text-yellow-800 dark:text-yellow-300 text-sm">New User</h6>
                                <p class="text-yellow-600 dark:text-yellow-400 text-xs mt-1">Consider showing popular books or new arrivals to encourage first purchase.</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Enhanced Wishlist -->
    @if($userWishlist->count() > 0)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center bg-gray-50 dark:bg-gray-800/50 rounded-t-lg">
                <h3 class="font-semibold text-red-600 dark:text-red-400 flex items-center">
                    <i class="fas fa-heart mr-2"></i>Wishlist
                </h3>
                <span class="px-2.5 py-1 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 rounded-full text-xs font-semibold">
                    {{ $userWishlist->count() }} items
                </span>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    @foreach($userWishlist as $book)
                        <div class="bg-white dark:bg-gray-800 border-l-4 border-red-500 rounded-r-lg shadow-sm hover:shadow-md transition p-3 border border-gray-100 dark:border-gray-700 h-full">
                            <div class="flex gap-3">
                                @if($book->cover_image)
                                    <img src="{{ asset('storage/' . $book->cover_image) }}" 
                                         class="w-14 h-20 object-cover rounded shadow-sm shrink-0">
                                @else
                                    <div class="w-14 h-20 bg-gray-100 dark:bg-gray-700 rounded flex items-center justify-center shrink-0">
                                        <i class="fas fa-book text-gray-400"></i>
                                    </div>
                                @endif
                                <div class="flex-1 min-w-0 flex flex-col justify-between">
                                    <div>
                                        <h4 class="font-bold text-gray-800 dark:text-gray-100 text-sm truncate" title="{{ $book->title }}">{{ $book->title }}</h4>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">by {{ $book->author }}</p>
                                        <div class="flex justify-between items-center mb-1">
                                            <span class="text-[10px] px-1.5 py-0.5 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded">{{ $book->genre->name ?? 'N/A' }}</span>
                                            <span class="text-xs font-bold text-green-600 dark:text-green-400">RM {{ number_format($book->price, 2) }}</span>
                                        </div>
                                    </div>
                                    <div class="flex gap-2 mt-2">
                                        <a href="{{ route('books.show', $book) }}" class="flex-1 py-1 text-center bg-blue-50 dark:bg-blue-900/20 text-blue-600 hover:bg-blue-100 dark:hover:bg-blue-900/40 rounded text-xs transition" title="View Book">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button class="flex-1 py-1 text-center bg-green-50 dark:bg-green-900/20 text-green-600 hover:bg-green-100 dark:hover:bg-green-900/40 rounded text-xs transition" title="Add to Cart">
                                            <i class="fas fa-cart-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>

@endsection

@push('scripts')
<script>
function refreshUserAnalysis() {
    const btn = event.target;
    // Store original content
    const originalContent = btn.innerHTML;
    // Set loading state
    btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Refreshing...';
    btn.disabled = true;
    
    // Simulate refresh (in reality you might want to make an AJAX call or just reload)
    setTimeout(() => {
        location.reload();
    }, 1500);
}
</script>
@endpush
