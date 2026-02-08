{{-- Discounts Table Partial for AJAX --}}
<div class="overflow-x-auto">
    <table class="w-full" id="discounts-table">
        <thead>
            <tr class="text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider border-b border-gray-200 dark:border-gray-700">
                <th class="px-6 py-4">Book</th>
                <th class="px-6 py-4">Discount</th>
                <th class="px-6 py-4">Period</th>
                <th class="px-6 py-4">Status</th>
                <th class="px-6 py-4 text-right">Actions</th>
            </tr>
        </thead>
        <tbody id="discounts-tbody" class="divide-y divide-gray-100 dark:divide-gray-700">
            @forelse($discounts as $discount)
                <tr class="discount-row hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors" data-discount-id="{{ $discount->id }}">
                    {{-- Book --}}
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            @if($discount->book->cover_image)
                                <img class="w-12 h-16 rounded-lg object-cover shadow-sm" src="{{ asset('storage/' . $discount->book->cover_image) }}" alt="{{ $discount->book->title }}">
                            @else
                                <div class="w-12 h-16 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                </div>
                            @endif
                            <div>
                                <p class="font-semibold text-gray-900 dark:text-gray-100">{{ Str::limit($discount->book->title, 30) }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $discount->book->author }}</p>
                                <p class="text-xs text-gray-400 dark:text-gray-500">RM {{ number_format($discount->book->price, 2) }}</p>
                            </div>
                        </div>
                    </td>
                    
                    {{-- Discount --}}
                    <td class="px-6 py-4">
                        @if($discount->discount_amount)
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-sm font-medium bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">
                                RM {{ number_format($discount->discount_amount, 2) }} off
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400">
                                {{ $discount->discount_percent }}% off
                            </span>
                        @endif
                        @if($discount->description)
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ Str::limit($discount->description, 30) }}</p>
                        @endif
                        @if($discount->free_shipping)
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs font-medium bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400 mt-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                                Free Shipping
                            </span>
                        @endif
                    </td>
                    
                    {{-- Period --}}
                    <td class="px-6 py-4">
                        <div class="text-sm">
                            @if($discount->starts_at)
                                <p class="text-gray-900 dark:text-gray-100">{{ $discount->starts_at->format('M d, Y') }}</p>
                            @else
                                <p class="text-gray-400 dark:text-gray-500">No start date</p>
                            @endif
                            @if($discount->ends_at)
                                <p class="text-gray-500 dark:text-gray-400">to {{ $discount->ends_at->format('M d, Y') }}</p>
                            @else
                                <p class="text-gray-400 dark:text-gray-500">No end date</p>
                            @endif
                        </div>
                    </td>
                    
                    {{-- Status --}}
                    <td class="px-6 py-4">
                        @if($discount->is_active)
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">
                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                                Active
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                                <span class="w-1.5 h-1.5 bg-gray-400 rounded-full"></span>
                                Inactive
                            </span>
                        @endif
                    </td>
                    
                    {{-- Actions --}}
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-end gap-1">
                            <a href="{{ route('admin.discounts.show', $discount->id) }}" 
                               class="p-2 text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded-lg transition-colors"
                               title="View">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </a>
                            <a href="{{ route('admin.discounts.edit', $discount->id) }}" 
                               class="p-2 text-gray-500 hover:text-purple-600 dark:text-gray-400 dark:hover:text-purple-400 hover:bg-purple-50 dark:hover:bg-purple-900/30 rounded-lg transition-colors"
                               title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <form action="{{ route('admin.discounts.toggle', $discount->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" 
                                        class="p-2 text-gray-500 hover:text-amber-600 dark:text-gray-400 dark:hover:text-amber-400 hover:bg-amber-50 dark:hover:bg-amber-900/30 rounded-lg transition-colors"
                                        title="{{ $discount->is_active ? 'Deactivate' : 'Activate' }}">
                                    @if($discount->is_active)
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    @endif
                                </button>
                            </form>
                            <form action="{{ route('admin.discounts.destroy', $discount->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this discount?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="p-2 text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg transition-colors"
                                        title="Delete">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <div class="w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                            </div>
                            <p class="text-gray-500 dark:text-gray-400 font-medium">No discounts found</p>
                            <p class="text-gray-400 dark:text-gray-500 text-sm mt-1">Create your first book discount</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Pagination --}}
@if($discounts->hasPages())
    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Showing <span class="font-medium text-gray-900 dark:text-gray-100">{{ $discounts->firstItem() ?? 0 }}</span>
                to <span class="font-medium text-gray-900 dark:text-gray-100">{{ $discounts->lastItem() ?? 0 }}</span>
                of <span class="font-medium text-gray-900 dark:text-gray-100">{{ $discounts->total() }}</span> discounts
            </p>
            
            <div class="flex items-center gap-1">
                @if(!$discounts->onFirstPage())
                    <a href="{{ $discounts->previousPageUrl() }}" class="p-2 rounded-lg border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </a>
                @endif
                
                @foreach($discounts->getUrlRange(max(1, $discounts->currentPage() - 2), min($discounts->lastPage(), $discounts->currentPage() + 2)) as $page => $url)
                    <a href="{{ $url }}" class="px-3 py-1.5 rounded-lg text-sm font-medium {{ $page == $discounts->currentPage() ? 'bg-purple-600 text-white' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                        {{ $page }}
                    </a>
                @endforeach
                
                @if($discounts->hasMorePages())
                    <a href="{{ $discounts->nextPageUrl() }}" class="p-2 rounded-lg border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                @endif
            </div>
        </div>
    </div>
@endif
