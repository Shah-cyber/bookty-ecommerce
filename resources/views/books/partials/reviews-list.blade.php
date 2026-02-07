@forelse($reviews as $review)
    <div class="py-6">
        <div class="flex items-center gap-4">
            <div class="shrink-0">
                <div class="w-11 h-11 rounded-full bg-gradient-to-br from-primary-500 to-primary-400 flex items-center justify-center text-white font-semibold border-2 border-gray-400">
                    {{ strtoupper(substr($review->user->name, 0, 1)) }}
                </div>
            </div>
            <div>
                <p class="text-sm text-slate-900 font-semibold">{{ $review->user->name }}</p>
                <div class="flex items-center gap-2 mt-2">
                    <span class="w-4 h-4 flex items-center justify-center rounded-full bg-green-600/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-2 h-2 fill-green-700" viewBox="0 0 24 24">
                            <path d="M9.225 20.656a1.206 1.206 0 0 1-1.71 0L.683 13.823a1.815 1.815 0 0 1 0-2.566l.855-.856a1.815 1.815 0 0 1 2.567 0l4.265 4.266L19.895 3.14a1.815 1.815 0 0 1 2.567 0l.855.856a1.815 1.815 0 0 1 0 2.566z" />
                        </svg>
                    </span>
                    <p class="text-slate-600 text-xs">Verified Buyer</p>
                </div>
            </div>
        </div>
        <div class="mt-4">
            <h6 class="text-slate-900 text-[15px] font-semibold">{{ $review->title ?? 'Customer Review' }}</h6>
            <div class="flex items-center space-x-0.5 text-orange-500 mt-2">
                @for ($i = 1; $i <= 5; $i++)
                    @if($i <= $review->rating)
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-[18px] h-[18px] fill-current" viewBox="0 0 24 24">
                            <path d="M12 17.42L6.25 21.54c-.29.2-.66-.09-.56-.43l2.14-6.74L2.08 10.15c-.26-.2-.13-.6.2-.62l7.07-.05L11.62 2.66c.1-.32.56-.32.66 0l2.24 6.82 7.07.05c.33.01.46.42.2.62l-5.75 4.22 2.14 6.74c.1.34-.27.63-.56.43L12 17.42z" />
                        </svg>
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-[18px] h-[18px] text-gray-300 fill-current" viewBox="0 0 24 24">
                            <path d="M12 17.42L6.25 21.54c-.29.2-.66-.09-.56-.43l2.14-6.74L2.08 10.15c-.26-.2-.13-.6.2-.62l7.07-.05L11.62 2.66c.1-.32.56-.32.66 0l2.24 6.82 7.07.05c.33.01.46.42.2.62l-5.75 4.22 2.14 6.74c.1.34-.27.63-.56.43L12 17.42z" />
                        </svg>
                    @endif
                @endfor
                <p class="text-slate-600 text-sm !ml-2">{{ $review->created_at->diffForHumans() }}</p>
            </div>
            @if($review->comment)
                <div class="mt-4">
                    <p class="text-slate-600 text-sm leading-relaxed">{{ $review->comment }}</p>
                </div>
            @endif
        </div>
        
        <!-- Review Images -->
        @if($review->hasImages())
            <div class="flex items-center gap-4 mt-4 overflow-auto">
                @foreach($review->image_urls as $index => $imageUrl)
                    <img src="{{ $imageUrl }}" 
                         class="bg-gray-100 object-cover p-2 w-48 h-48 cursor-pointer hover:opacity-90 transition-opacity" 
                         alt="review-img-{{ $index + 1 }}" 
                         onclick="openImageModal('{{ $imageUrl }}', {{ $index }}, {{ json_encode($review->image_urls) }})" />
                @endforeach
            </div>
        @endif
        
        <!-- Review Actions -->
        <div class="mt-4">
            <p class="text-xs text-gray-500 mb-2">{{ $review->helpful_count }} people found this helpful</p>
            <div class="flex items-center gap-4">
                @auth
                    <button type="button" 
                            class="helpful-btn px-3 py-1.5 text-xs font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 {{ $review->isMarkedHelpfulBy(Auth::id()) ? 'bg-blue-100 text-blue-700 border-blue-300' : '' }}"
                            data-review-id="{{ $review->id }}"
                            data-is-helpful="{{ $review->isMarkedHelpfulBy(Auth::id()) ? 'true' : 'false' }}">
                        {{ $review->isMarkedHelpfulBy(Auth::id()) ? 'Helpful ✓' : 'Helpful' }}
                    </button>
                    <button type="button" 
                            class="report-btn text-sm font-medium text-blue-600 hover:underline"
                            data-review-id="{{ $review->id }}">
                        Report abuse
                    </button>
                @endauth
            </div>
        </div>
    </div>
@empty
    <div class="py-6 text-center">
        <p class="text-gray-500">No reviews yet. Be the first to review this book!</p>
    </div>
@endforelse

@if($reviews->hasPages())
    <div class="py-6">
        <ul class="flex space-x-4 justify-end">
            {{-- Previous Page Link --}}
            @if ($reviews->onFirstPage())
                <li class="flex items-center justify-center shrink-0 bg-gray-100 w-9 h-9 rounded-full cursor-not-allowed">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 fill-gray-300" viewBox="0 0 55.753 55.753">
                        <path d="M12.745 23.915c.283-.282.59-.52.913-.727L35.266 1.581a5.4 5.4 0 0 1 7.637 7.638L24.294 27.828l18.705 18.706a5.4 5.4 0 0 1-7.636 7.637L13.658 32.464a5.367 5.367 0 0 1-.913-.727 5.367 5.367 0 0 1-1.572-3.911 5.369 5.369 0 0 1 1.572-3.911z" data-original="#000000" />
                    </svg>
                </li>
            @else
                <li class="flex items-center justify-center shrink-0 hover:bg-gray-50 border-2 border-gray-300 cursor-pointer w-9 h-9 rounded-full">
                    <a href="{{ $reviews->previousPageUrl() }}" class="flex items-center justify-center w-full h-full ajax-pagination-link">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 fill-gray-400" viewBox="0 0 55.753 55.753">
                            <path d="M12.745 23.915c.283-.282.59-.52.913-.727L35.266 1.581a5.4 5.4 0 0 1 7.637 7.638L24.294 27.828l18.705 18.706a5.4 5.4 0 0 1-7.636 7.637L13.658 32.464a5.367 5.367 0 0 1-.913-.727 5.367 5.367 0 0 1-1.572-3.911 5.369 5.369 0 0 1 1.572-3.911z" data-original="#000000" />
                        </svg>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @php
                $start = max(1, $reviews->currentPage() - 2);
                $end = min($reviews->lastPage(), $reviews->currentPage() + 2);
            @endphp

            {{-- First page --}}
            @if($start > 1)
                <li class="flex items-center justify-center shrink-0 hover:bg-gray-50 border-2 border-gray-300 cursor-pointer text-[15px] font-medium text-slate-900 w-9 h-9 rounded-full">
                    <a href="{{ $reviews->url(1) }}" class="flex items-center justify-center w-full h-full ajax-pagination-link">1</a>
                </li>
                @if($start > 2)
                    <li class="flex items-center justify-center shrink-0 text-[15px] font-medium text-slate-900 w-9 h-9">
                        <span>...</span>
                    </li>
                @endif
            @endif

            {{-- Page numbers around current page --}}
            @for ($page = $start; $page <= $end; $page++)
                @if ($page == $reviews->currentPage())
                    <li class="flex items-center justify-center shrink-0 bg-blue-500 border-2 border-blue-500 cursor-pointer text-[15px] font-medium text-white w-9 h-9 rounded-full">
                        {{ $page }}
                    </li>
                @else
                    <li class="flex items-center justify-center shrink-0 hover:bg-gray-50 border-2 border-gray-300 cursor-pointer text-[15px] font-medium text-slate-900 w-9 h-9 rounded-full">
                        <a href="{{ $reviews->url($page) }}" class="flex items-center justify-center w-full h-full ajax-pagination-link">{{ $page }}</a>
                    </li>
                @endif
            @endfor

            {{-- Last page --}}
            @if($end < $reviews->lastPage())
                @if($end < $reviews->lastPage() - 1)
                    <li class="flex items-center justify-center shrink-0 text-[15px] font-medium text-slate-900 w-9 h-9">
                        <span>...</span>
                    </li>
                @endif
                <li class="flex items-center justify-center shrink-0 hover:bg-gray-50 border-2 border-gray-300 cursor-pointer text-[15px] font-medium text-slate-900 w-9 h-9 rounded-full">
                    <a href="{{ $reviews->url($reviews->lastPage()) }}" class="flex items-center justify-center w-full h-full ajax-pagination-link">{{ $reviews->lastPage() }}</a>
                </li>
            @endif

            {{-- Next Page Link --}}
            @if ($reviews->hasMorePages())
                <li class="flex items-center justify-center shrink-0 hover:bg-gray-50 border-2 border-gray-300 cursor-pointer w-9 h-9 rounded-full">
                    <a href="{{ $reviews->nextPageUrl() }}" class="flex items-center justify-center w-full h-full ajax-pagination-link">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 fill-gray-400 rotate-180" viewBox="0 0 55.753 55.753">
                            <path d="M12.745 23.915c.283-.282.59-.52.913-.727L35.266 1.581a5.4 5.4 0 0 1 7.637 7.638L24.294 27.828l18.705 18.706a5.4 5.4 0 0 1-7.636 7.637L13.658 32.464a5.367 5.367 0 0 1-.913-.727 5.367 5.367 0 0 1-1.572-3.911 5.369 5.369 0 0 1 1.572-3.911z" data-original="#000000" />
                        </svg>
                    </a>
                </li>
            @else
                <li class="flex items-center justify-center shrink-0 bg-gray-100 w-9 h-9 rounded-full cursor-not-allowed">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 fill-gray-300 rotate-180" viewBox="0 0 55.753 55.753">
                        <path d="M12.745 23.915c.283-.282.59-.52.913-.727L35.266 1.581a5.4 5.4 0 0 1 7.637 7.638L24.294 27.828l18.705 18.706a5.4 5.4 0 0 1-7.636 7.637L13.658 32.464a5.367 5.367 0 0 1-.913-.727 5.367 5.367 0 0 1-1.572-3.911 5.369 5.369 0 0 1 1.572-3.911z" data-original="#000000" />
                    </svg>
                </li>
            @endif
        </ul>
    </div>
@endif
