@extends('layouts.admin')

@section('header', __('Postage Rates'))

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <a href="{{ route('admin.settings.system') }}" class="text-bookty-purple-600 hover:text-bookty-purple-800 text-sm">&larr; {{ __('Back to Settings') }}</a>
        <a href="{{ route('admin.postage-rates.create') }}" class="px-4 py-2 bg-bookty-purple-600 text-white rounded-md hover:bg-bookty-purple-700">{{ __('Add Rate') }}</a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-2 rounded mb-4 dark:bg-green-900/30 dark:border-green-700 dark:text-green-300">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-2 rounded mb-4 dark:bg-red-900/30 dark:border-red-700 dark:text-red-300">{{ session('error') }}</div>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-200">{{ __('Region') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-200">{{ __('Customer Price') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-200">{{ __('Actual Cost') }}</th>
                    <th class="px-6 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($rates as $rate)
                    <tr>
                        <td class="px-6 py-4 dark:text-gray-100">{{ __('regions.'.$rate->region) }}</td>
                        <td class="px-6 py-4 dark:text-gray-100">RM {{ number_format($rate->customer_price, 2) }}</td>
                        <td class="px-6 py-4 dark:text-gray-100">RM {{ number_format($rate->actual_cost, 2) }}</td>
                        <td class="px-6 py-4 text-right space-x-2">
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
                        <td colspan="4" class="px-6 py-6 text-center text-gray-500 dark:text-gray-300">{{ __('No postage rates yet.') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-6 py-4">{{ $rates->links() }}</div>
    </div>
@endsection


