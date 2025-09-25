@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8 dark:bg-gray-900 dark:text-gray-100">
    <div class="mb-6">
        <a href="{{ route('admin.reviews.reports.index') }}" class="text-purple-600 hover:text-purple-900 dark:text-purple-400 dark:hover:text-purple-300">
            &larr; Back to Reports
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 dark:bg-green-900 dark:text-green-200" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Review Details -->
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
            <div class="bg-gray-100 dark:bg-gray-700 px-6 py-4 border-b border-gray-200 dark:border-gray-600">
                <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">Reported Review</h2>
            </div>
            <div class="p-6">
                <!-- Book Info -->
                <div class="flex items-start mb-6">
                    <div class="flex-shrink-0 h-24 w-16">
                        @if($report->review->book->cover_image)
                            <img src="{{ asset('storage/' . $report->review->book->cover_image) }}" 
                                 alt="{{ $report->review->book->title }}" 
                                 class="h-24 w-16 object-cover rounded">
                        @else
                            <div class="h-24 w-16 bg-gray-200 dark:bg-gray-600 rounded flex items-center justify-center">
                                <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                            {{ $report->review->book->title }}
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400">by {{ $report->review->book->author }}</p>
                        <div class="flex items-center mt-2">
                            @for ($i = 1; $i <= 5; $i++)
                                <svg class="w-4 h-4 {{ $i <= $report->review->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                            <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">{{ $report->review->rating }}/5</span>
                        </div>
                    </div>
                </div>

                <!-- Review Content -->
                <div class="border-t border-gray-200 dark:border-gray-600 pt-4">
                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Review Content</h4>
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <p class="text-gray-900 dark:text-gray-100">{{ $report->review->comment }}</p>
                    </div>
                    <div class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                        <p>Reviewed by: {{ $report->review->user->name }} on {{ $report->review->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Report Details -->
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
            <div class="bg-gray-100 dark:bg-gray-700 px-6 py-4 border-b border-gray-200 dark:border-gray-600">
                <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">Report Details</h2>
            </div>
            <div class="p-6">
                <!-- Report Info -->
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Reported By</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $report->user->name }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $report->user->email }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Reason</label>
                        <span class="mt-1 inline-flex px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                            {{ ucfirst($report->reason) }}
                        </span>
                    </div>

                    @if($report->description)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Description</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $report->description }}</p>
                        </div>
                    @endif

                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Current Status</label>
                        @switch($report->status)
                            @case('pending')
                                <span class="mt-1 inline-flex px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                    Pending
                                </span>
                                @break
                            @case('reviewed')
                                <span class="mt-1 inline-flex px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                    Reviewed
                                </span>
                                @break
                            @case('resolved')
                                <span class="mt-1 inline-flex px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                    Resolved
                                </span>
                                @break
                            @case('dismissed')
                                <span class="mt-1 inline-flex px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200">
                                    Dismissed
                                </span>
                                @break
                        @endswitch
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Reported At</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $report->created_at->format('M d, Y H:i A') }}</p>
                    </div>

                    @if($report->admin)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Reviewed By</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $report->admin->name }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $report->reviewed_at->format('M d, Y H:i A') }}</p>
                        </div>
                    @endif

                    @if($report->admin_notes)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Admin Notes</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $report->admin_notes }}</p>
                        </div>
                    @endif
                </div>

                <!-- Status Update Form -->
                <div class="border-t border-gray-200 dark:border-gray-600 pt-6 mt-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Update Status</h3>
                    <form action="{{ route('admin.reviews.reports.status', $report) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="space-y-4">
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">New Status</label>
                                <select id="status" name="status" class="w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" required>
                                    <option value="pending" {{ $report->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="reviewed" {{ $report->status == 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                                    <option value="resolved" {{ $report->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
                                    <option value="dismissed" {{ $report->status == 'dismissed' ? 'selected' : '' }}>Dismissed</option>
                                </select>
                            </div>
                            <div>
                                <label for="admin_notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Admin Notes</label>
                                <textarea id="admin_notes" name="admin_notes" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" placeholder="Add notes about your decision...">{{ old('admin_notes', $report->admin_notes) }}</textarea>
                            </div>
                            <button type="submit" class="w-full bg-purple-600 text-white py-2 px-4 rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                                Update Status
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
