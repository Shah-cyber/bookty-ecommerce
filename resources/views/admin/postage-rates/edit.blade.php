@extends('layouts.admin')

@section('header', __('Edit Postage Rate'))

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.postage-rates.index') }}" class="text-bookty-purple-600 hover:text-bookty-purple-800 text-sm">&larr; {{ __('Back to Postage Rates') }}</a>
    </div>

    @if(session('error'))
        <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-2 rounded mb-4 dark:bg-red-900/30 dark:border-red-700 dark:text-red-300">{{ session('error') }}</div>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <form action="{{ route('admin.postage-rates.update', $rate) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1 dark:text-gray-200">{{ __('Region') }}</label>
                <select name="region" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50" required>
                    @foreach($regions as $region)
                        <option value="{{ $region }}" @selected(old('region', $rate->region)===$region)>{{ __('regions.'.$region) }}</option>
                    @endforeach
                </select>
                @error('region')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1 dark:text-gray-200">{{ __('Customer Price (RM)') }}</label>
                    <input type="number" step="0.01" name="customer_price" value="{{ old('customer_price', $rate->customer_price) }}" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50" required>
                    @error('customer_price')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1 dark:text-gray-200">{{ __('Actual Cost (RM)') }}</label>
                    <input type="number" step="0.01" name="actual_cost" value="{{ old('actual_cost', $rate->actual_cost) }}" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50" required>
                    @error('actual_cost')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <button type="submit" class="px-4 py-2 bg-bookty-purple-600 text-white rounded-md hover:bg-bookty-purple-700">{{ __('Update') }}</button>
            </div>
        </form>
    </div>
@endsection


