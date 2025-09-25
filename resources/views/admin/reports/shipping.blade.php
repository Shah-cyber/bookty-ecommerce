@extends('layouts.admin')

@section('header', 'Shipping Reports')

@section('content')
<div class="space-y-8">
    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Report Filters</h3>
        <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                <input type="date" name="start_date" value="{{ $startDate }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                <input type="date" name="end_date" value="{{ $endDate }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                    Apply Filters
                </button>
            </div>
        </form>
    </div>

    <!-- Orders by Status -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Orders by Status</h3>
            <div class="flex space-x-2">
                <button class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700">Export PDF</button>
                <button class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700">Export Excel</button>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            @if(isset($ordersByStatus) && count($ordersByStatus) > 0)
                @foreach($ordersByStatus as $status)
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <div class="text-2xl font-bold text-gray-700">{{ $status->count }}</div>
                        <div class="text-sm text-gray-500 capitalize">{{ $status->status }}</div>
                    </div>
                @endforeach
            @else
                <div class="col-span-5 text-center py-8">
                    <p class="text-sm text-gray-500">No order data available for the selected period.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Average Shipping Time -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Average Shipping Time</h3>
            <div class="flex space-x-2">
                <button class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700">Export PDF</button>
                <button class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700">Export Excel</button>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="text-center p-6 bg-gray-50 rounded-lg">
                <div class="text-3xl font-bold text-blue-600">{{ $avgShippingTime['avg_days'] ?? 0 }} days</div>
                <div class="text-sm text-gray-500 mt-2">Average Shipping Time</div>
            </div>
            <div class="text-center p-6 bg-gray-50 rounded-lg">
                <div class="text-3xl font-bold text-green-600">{{ $avgShippingTime['fastest'] ?? 0 }} day</div>
                <div class="text-sm text-gray-500 mt-2">Fastest Delivery</div>
            </div>
            <div class="text-center p-6 bg-gray-50 rounded-lg">
                <div class="text-3xl font-bold text-red-600">{{ $avgShippingTime['slowest'] ?? 0 }} days</div>
                <div class="text-sm text-gray-500 mt-2">Slowest Delivery</div>
            </div>
        </div>
    </div>

    <!-- Refunds & Cancellations -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Refunds & Cancellations Rate</h3>
            <div class="flex space-x-2">
                <button class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700">Export PDF</button>
                <button class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700">Export Excel</button>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="text-center p-6 bg-gray-50 rounded-lg">
                <div class="text-3xl font-bold text-blue-600">{{ $refundCancellationStats['total_orders'] ?? 0 }}</div>
                <div class="text-sm text-gray-500 mt-2">Total Orders</div>
            </div>
            <div class="text-center p-6 bg-gray-50 rounded-lg">
                <div class="text-3xl font-bold text-red-600">{{ $refundCancellationStats['cancelled_orders'] ?? 0 }}</div>
                <div class="text-sm text-gray-500 mt-2">Cancelled Orders</div>
            </div>
            <div class="text-center p-6 bg-gray-50 rounded-lg">
                <div class="text-3xl font-bold text-orange-600">{{ $refundCancellationStats['cancellation_rate'] ?? 0 }}%</div>
                <div class="text-sm text-gray-500 mt-2">Cancellation Rate</div>
            </div>
        </div>
    </div>
</div>
@endsection
