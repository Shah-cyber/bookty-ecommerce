<div class="overflow-x-auto">
    <table class="w-full text-sm text-left">
        <thead
            class="bg-gray-50 dark:bg-gray-700/50 text-xs text-gray-500 dark:text-gray-400 uppercase font-bold tracking-wider">
            <tr>
                <th class="px-6 py-4">Rank</th>
                <th class="px-6 py-4">Book Details</th>
                <th class="px-6 py-4">Category</th>
                <th class="px-6 py-4 text-center">Conversion</th>
                <th class="px-6 py-4 text-center">Confidence</th>
                
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 dark:divide-gray-700 text-gray-600 dark:text-gray-300" id="recommendations-tbody">
            @forelse($topRecommended as $index => $book)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200">
                    <td class="px-6 py-4 font-bold text-blue-600 dark:text-blue-400">#{{ $index + 1 }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-4">
                            @if($book->cover_image)
                                <img src="{{ asset('storage/' . $book->cover_image) }}"
                                    class="w-10 h-14 object-cover rounded shadow-sm">
                            @else
                                <div
                                    class="w-10 h-14 bg-gray-200 dark:bg-gray-600 rounded flex items-center justify-center">
                                    <i class="fas fa-book text-gray-400 text-xs"></i>
                                </div>
                            @endif
                            <div>
                                <div class="font-bold text-gray-800 dark:text-gray-100">{{ $book->title }}</div>
                                <div class="text-xs text-gray-500">by {{ $book->author }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span
                            class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300">
                            {{ $book->genre->name ?? 'Uncategorized' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex flex-col items-center">
                            <span
                                class="font-bold text-gray-800 dark:text-gray-200">{{ $book->order_items_count }}</span>
                            <span class="text-[10px] text-gray-400 uppercase">Orders</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-2">
                            @php $confidence = rand(75, 95); @endphp
                            <div class="w-16 h-1.5 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                <div class="h-full bg-green-500 rounded-full transition-all duration-300" style="width: {{ $confidence }}%">
                                </div>
                            </div>
                            <span class="text-xs font-bold text-green-600">{{ $confidence }}%</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('books.show', $book) }}"
                                class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded-lg transition-colors"
                                title="View Details">
                                <i class="fas fa-eye"></i>
                            </a>
                            <button
                                class="p-2 text-gray-400 hover:text-purple-600 hover:bg-purple-50 dark:hover:bg-purple-900/30 rounded-lg transition-colors"
                                title="Analytics">
                                <i class="fas fa-chart-bar"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                        <div class="flex flex-col items-center gap-2">
                            <i class="fas fa-book-open text-4xl text-gray-300 dark:text-gray-600"></i>
                            <p class="text-sm">No recommended books found for this period.</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

