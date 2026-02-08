{{-- Genres Table Partial for AJAX --}}
<div class="overflow-x-auto">
    <table class="w-full" id="genres-table">
        <thead>
            <tr class="text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider border-b border-gray-200 dark:border-gray-700">
                <th class="px-6 py-4">Genre</th>
                <th class="px-6 py-4">Slug</th>
                <th class="px-6 py-4">Books</th>
                <th class="px-6 py-4">Description</th>
                <th class="px-6 py-4 text-right">Actions</th>
            </tr>
        </thead>
        <tbody id="genres-tbody" class="divide-y divide-gray-100 dark:divide-gray-700">
            @forelse($genres as $genre)
                <tr class="genre-row hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors" data-genre-id="{{ $genre->id }}">
                    {{-- Genre Name with Icon --}}
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $genre->name }}</p>
                            </div>
                        </div>
                    </td>
                    
                    {{-- Slug --}}
                    <td class="px-6 py-4">
                        <code class="px-2 py-1 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 text-sm rounded">{{ $genre->slug }}</code>
                    </td>
                    
                    {{-- Books Count --}}
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-sm font-medium {{ $genre->books_count > 0 ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' : 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            {{ $genre->books_count }}
                        </span>
                    </td>
                    
                    {{-- Description --}}
                    <td class="px-6 py-4">
                        <p class="text-sm text-gray-600 dark:text-gray-400 truncate max-w-xs">
                            {{ $genre->description ?? '-' }}
                        </p>
                    </td>
                    
                    {{-- Actions --}}
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.genres.edit', $genre) }}" 
                               class="p-2 text-gray-500 hover:text-purple-600 dark:text-gray-400 dark:hover:text-purple-400 hover:bg-purple-50 dark:hover:bg-purple-900/30 rounded-lg transition-colors"
                               title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <button type="button"
                                    class="delete-genre-btn p-2 text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg transition-colors"
                                    data-genre-id="{{ $genre->id }}"
                                    data-genre-name="{{ $genre->name }}"
                                    data-books-count="{{ $genre->books_count }}"
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
                    <td colspan="5" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <div class="w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                            </div>
                            <p class="text-gray-500 dark:text-gray-400 font-medium">No genres found</p>
                            <p class="text-gray-400 dark:text-gray-500 text-sm mt-1">Try adjusting your search or filters</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Pagination --}}
@if($genres->hasPages())
    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Showing <span class="font-medium text-gray-900 dark:text-gray-100">{{ $genres->firstItem() ?? 0 }}</span>
                to <span class="font-medium text-gray-900 dark:text-gray-100">{{ $genres->lastItem() ?? 0 }}</span>
                of <span class="font-medium text-gray-900 dark:text-gray-100">{{ $genres->total() }}</span> genres
            </p>
            
            <div class="flex items-center gap-1">
                {{-- Previous --}}
                <button type="button" 
                        class="pagination-btn p-2 rounded-lg border border-gray-200 dark:border-gray-700 {{ $genres->onFirstPage() ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-50 dark:hover:bg-gray-700' }}"
                        data-page="{{ $genres->currentPage() - 1 }}"
                        {{ $genres->onFirstPage() ? 'disabled' : '' }}>
                    <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                
                {{-- Page Numbers --}}
                @php
                    $start = max(1, $genres->currentPage() - 2);
                    $end = min($genres->lastPage(), $genres->currentPage() + 2);
                @endphp
                
                @if($start > 1)
                    <button type="button" class="pagination-btn px-3 py-1.5 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700" data-page="1">1</button>
                    @if($start > 2)
                        <span class="px-2 text-gray-400">...</span>
                    @endif
                @endif
                
                @for($i = $start; $i <= $end; $i++)
                    <button type="button" 
                            class="pagination-btn px-3 py-1.5 rounded-lg text-sm font-medium {{ $i == $genres->currentPage() ? 'bg-purple-600 text-white' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700' }}"
                            data-page="{{ $i }}">
                        {{ $i }}
                    </button>
                @endfor
                
                @if($end < $genres->lastPage())
                    @if($end < $genres->lastPage() - 1)
                        <span class="px-2 text-gray-400">...</span>
                    @endif
                    <button type="button" class="pagination-btn px-3 py-1.5 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700" data-page="{{ $genres->lastPage() }}">{{ $genres->lastPage() }}</button>
                @endif
                
                {{-- Next --}}
                <button type="button" 
                        class="pagination-btn p-2 rounded-lg border border-gray-200 dark:border-gray-700 {{ !$genres->hasMorePages() ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-50 dark:hover:bg-gray-700' }}"
                        data-page="{{ $genres->currentPage() + 1 }}"
                        {{ !$genres->hasMorePages() ? 'disabled' : '' }}>
                    <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
@endif
