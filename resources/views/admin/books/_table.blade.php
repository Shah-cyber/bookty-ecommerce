{{-- Books Table Partial for AJAX --}}
<div class="overflow-x-auto">
    <table class="w-full" id="books-table">
        <thead class="bg-gray-50 dark:bg-gray-700/50">
            <tr>
                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Book</th>
                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Author</th>
                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Genre</th>
                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Condition</th>
                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Price</th>
                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Stock</th>
                <th scope="col" class="px-6 py-4 text-center text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 dark:divide-gray-700" id="books-tbody">
            @forelse($books as $book)
                <tr class="book-row bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150" data-book-id="{{ $book->id }}">
                    {{-- Book Info --}}
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-4">
                            <div class="flex-shrink-0 h-16 w-12 relative group rounded-lg overflow-hidden shadow-sm bg-gray-100 dark:bg-gray-700">
                                @if($book->cover_image)
                                    <img class="h-full w-full object-cover transform group-hover:scale-110 transition-transform duration-300" src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}">
                                @else
                                    <div class="h-full w-full flex items-center justify-center">
                                        <svg class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="min-w-0">
                                <div class="font-semibold text-gray-900 dark:text-white truncate max-w-[200px]" title="{{ $book->title }}">{{ $book->title }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400 truncate max-w-[200px] mt-0.5">{{ Str::limit($book->synopsis, 40) }}</div>
                            </div>
                        </div>
                    </td>
                    
                    {{-- Author --}}
                    <td class="px-6 py-4">
                        <span class="text-gray-700 dark:text-gray-300">{{ $book->author }}</span>
                    </td>
                    
                    {{-- Genre --}}
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900/40 dark:text-purple-300">
                            {{ $book->genre->name ?? 'N/A' }}
                        </span>
                    </td>
                    
                    {{-- Condition --}}
                    <td class="px-6 py-4">
                        <select 
                            class="condition-select text-xs font-medium rounded-full px-3 py-1.5 border-0 cursor-pointer focus:ring-2 focus:ring-purple-500 transition-all duration-200
                            {{ ($book->condition ?? 'new') === 'new' ? 'bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300' : 'bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:text-amber-300' }}"
                            data-book-id="{{ $book->id }}"
                            data-field="condition"
                        >
                            <option value="new" {{ ($book->condition ?? 'new') === 'new' ? 'selected' : '' }}>New</option>
                            <option value="preloved" {{ ($book->condition ?? 'new') === 'preloved' ? 'selected' : '' }}>Preloved</option>
                        </select>
                    </td>
                    
                    {{-- Price --}}
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <span class="text-gray-500">RM</span>
                            <input 
                                type="number" 
                                step="0.01"
                                min="0"
                                class="price-input w-20 text-sm font-semibold text-gray-900 dark:text-white bg-transparent border-0 border-b-2 border-transparent hover:border-gray-300 focus:border-purple-500 focus:ring-0 p-0 transition-colors"
                                value="{{ number_format($book->price, 2, '.', '') }}"
                                data-book-id="{{ $book->id }}"
                                data-field="price"
                                data-original="{{ $book->price }}"
                            >
                        </div>
                    </td>
                    
                    {{-- Stock --}}
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <input 
                                type="number" 
                                min="0"
                                class="stock-input w-16 text-sm font-semibold text-center rounded-lg border transition-all duration-200 focus:ring-2 focus:ring-purple-500
                                {{ $book->stock > 10 ? 'bg-green-50 border-green-200 text-green-700 dark:bg-green-900/30 dark:border-green-700 dark:text-green-300' : ($book->stock > 0 ? 'bg-amber-50 border-amber-200 text-amber-700 dark:bg-amber-900/30 dark:border-amber-700 dark:text-amber-300' : 'bg-red-50 border-red-200 text-red-700 dark:bg-red-900/30 dark:border-red-700 dark:text-red-300') }}"
                                value="{{ $book->stock }}"
                                data-book-id="{{ $book->id }}"
                                data-field="stock"
                                data-original="{{ $book->stock }}"
                            >
                            @if($book->stock <= 10 && $book->stock > 0)
                                <span class="text-xs text-amber-600 dark:text-amber-400 font-medium">Low</span>
                            @elseif($book->stock === 0)
                                <span class="text-xs text-red-600 dark:text-red-400 font-medium">Out</span>
                            @endif
                        </div>
                    </td>
                    
                    {{-- Actions --}}
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-1">
                            <a href="{{ route('admin.books.show', $book) }}" 
                               class="p-2 text-gray-500 hover:text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded-lg transition-all duration-200" 
                               title="View Details">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </a>
                            <a href="{{ route('admin.books.edit', $book) }}" 
                               class="p-2 text-gray-500 hover:text-purple-600 hover:bg-purple-50 dark:hover:bg-purple-900/30 rounded-lg transition-all duration-200" 
                               title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <button type="button" 
                                    class="delete-book-btn p-2 text-gray-500 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg transition-all duration-200" 
                                    data-book-id="{{ $book->id }}"
                                    data-book-title="{{ $book->title }}"
                                    title="Delete">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <div class="w-20 h-20 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-10 h-10 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">No books found</h3>
                            <p class="text-gray-500 dark:text-gray-400 mb-4">Try adjusting your search or filter criteria</p>
                            <a href="{{ route('admin.books.create') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-purple-600 hover:text-purple-700 bg-purple-50 hover:bg-purple-100 rounded-lg transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Add New Book
                            </a>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Pagination --}}
@if($books->hasPages())
    <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
            {{-- Results Info --}}
            <div class="text-sm text-gray-600 dark:text-gray-400">
                Showing <span class="font-semibold text-gray-900 dark:text-white">{{ $books->firstItem() }}</span> 
                to <span class="font-semibold text-gray-900 dark:text-white">{{ $books->lastItem() }}</span> 
                of <span class="font-semibold text-gray-900 dark:text-white">{{ $books->total() }}</span> books
            </div>
            
            {{-- Pagination Buttons --}}
            <div class="flex items-center gap-2">
                {{-- Previous --}}
                <button 
                    class="pagination-btn px-3 py-2 text-sm font-medium rounded-lg border transition-colors duration-200
                    {{ $books->onFirstPage() ? 'text-gray-400 border-gray-200 dark:border-gray-700 cursor-not-allowed' : 'text-gray-700 dark:text-gray-300 border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700' }}"
                    data-page="{{ $books->currentPage() - 1 }}"
                    {{ $books->onFirstPage() ? 'disabled' : '' }}
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                
                {{-- Page Numbers --}}
                @php
                    $currentPage = $books->currentPage();
                    $lastPage = $books->lastPage();
                    $start = max(1, $currentPage - 2);
                    $end = min($lastPage, $currentPage + 2);
                @endphp
                
                @if($start > 1)
                    <button class="pagination-btn px-3 py-2 text-sm font-medium rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors" data-page="1">1</button>
                    @if($start > 2)
                        <span class="px-2 text-gray-400">...</span>
                    @endif
                @endif
                
                @for($page = $start; $page <= $end; $page++)
                    <button 
                        class="pagination-btn px-3 py-2 text-sm font-medium rounded-lg border transition-colors duration-200
                        {{ $page == $currentPage ? 'bg-purple-600 border-purple-600 text-white' : 'border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}"
                        data-page="{{ $page }}"
                    >{{ $page }}</button>
                @endfor
                
                @if($end < $lastPage)
                    @if($end < $lastPage - 1)
                        <span class="px-2 text-gray-400">...</span>
                    @endif
                    <button class="pagination-btn px-3 py-2 text-sm font-medium rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors" data-page="{{ $lastPage }}">{{ $lastPage }}</button>
                @endif
                
                {{-- Next --}}
                <button 
                    class="pagination-btn px-3 py-2 text-sm font-medium rounded-lg border transition-colors duration-200
                    {{ $books->hasMorePages() ? 'text-gray-700 dark:text-gray-300 border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700' : 'text-gray-400 border-gray-200 dark:border-gray-700 cursor-not-allowed' }}"
                    data-page="{{ $books->currentPage() + 1 }}"
                    {{ !$books->hasMorePages() ? 'disabled' : '' }}
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
@endif
