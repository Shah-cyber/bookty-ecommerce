@extends('layouts.admin')

@section('header', __('Postage Rates'))

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <a href="{{ route('admin.settings.system') }}" class="text-bookty-purple-600 hover:text-bookty-purple-800 text-sm">&larr; {{ __('Back to Settings') }}</a>
        <div class="flex gap-2">
            <a href="{{ route('admin.postage-rates.all-history') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ __('View Price History') }}
            </a>
            <a href="{{ route('admin.postage-rates.create') }}" class="px-4 py-2 bg-bookty-purple-600 text-white rounded-md hover:bg-bookty-purple-700">{{ __('Add Rate') }}</a>
        </div>
    </div>

    <!-- Info Banner -->
    <div class="mb-6 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
        <div class="flex items-start gap-3">
            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
            </svg>
            <div class="flex-1">
                <h3 class="text-sm font-semibold text-blue-900 dark:text-blue-200 mb-1">
                    🎉 New: Price History Tracking
                </h3>
                <p class="text-sm text-blue-800 dark:text-blue-300">
                    All price changes are now tracked with full audit trail. Click "History" to see who changed prices, when, and why. Changes are recorded automatically with accountability.
                </p>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-200">{{ __('Region') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-200">{{ __('Customer Price') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-200">{{ __('Actual Cost') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-200">{{ __('Profit Margin') }}</th>
                    <th class="px-6 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($rates as $rate)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4 dark:text-gray-100">
                            <div class="font-medium">{{ __('regions.'.$rate->region) }}</div>
                            @if($rate->currentHistory)
                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                Updated {{ $rate->currentHistory->created_at->diffForHumans() }}
                            </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 dark:text-gray-100">
                            <div class="font-semibold text-gray-900 dark:text-white">RM {{ number_format($rate->customer_price, 2) }}</div>
                        </td>
                        <td class="px-6 py-4 dark:text-gray-100">
                            <div class="text-gray-900 dark:text-white">RM {{ number_format($rate->actual_cost, 2) }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-semibold rounded {{ $rate->getProfitMargin() > 0 ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' }}">
                                {{ number_format($rate->getProfitMargin(), 1) }}%
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('admin.postage-rates.history', $rate->region) }}" 
                               class="inline-flex items-center px-3 py-1 text-sm bg-gray-600 text-white rounded hover:bg-gray-700"
                               title="View price history">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                History
                            </a>
                            <a href="{{ route('admin.postage-rates.edit', $rate) }}" class="px-3 py-1 text-sm bg-blue-600 text-white rounded hover:bg-blue-700">{{ __('Edit') }}</a>
                            <form class="inline" method="POST" action="{{ route('admin.postage-rates.destroy', $rate) }}" onsubmit="return confirm('{{ __('Are you sure?') }}');">
                                @csrf
                                @method('DELETE')
                                <button class="px-3 py-1 text-sm bg-red-600 text-white rounded hover:bg-red-700" type="submit">{{ __('Delete') }}</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-6 text-center text-gray-500 dark:text-gray-300">{{ __('No postage rates yet.') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-6 py-4">{{ $rates->links() }}</div>
    </div>
@endsection


