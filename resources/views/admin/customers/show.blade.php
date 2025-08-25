@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <a href="{{ route('admin.customers.index') }}" class="text-bookty-purple-600 hover:text-bookty-purple-800 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Customers
        </a>
    </div>

    <!-- Customer Summary Card -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <!-- Customer Info -->
        <div class="bg-white shadow rounded-lg p-6 md:col-span-3">
            <div class="flex items-center mb-4">
                <div class="h-16 w-16 rounded-full bg-bookty-purple-200 flex items-center justify-center">
                    <span class="text-2xl font-medium text-bookty-purple-800">{{ substr($customer->name, 0, 1) }}</span>
                </div>
                <div class="ml-4">
                    <h2 class="text-xl font-serif font-medium text-bookty-black">{{ $customer->name }}</h2>
                    <p class="text-sm text-bookty-purple-700">Customer ID: #{{ $customer->id }}</p>
                    <p class="text-sm text-bookty-purple-700">Joined {{ $customer->created_at->format('F d, Y') }} ({{ $customer->created_at->diffForHumans() }})</p>
                </div>
            </div>
        </div>
        
        <!-- Order Stats -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-bookty-black mb-4">Order Summary</h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-bookty-purple-700">Total Orders:</span>
                    <span class="text-sm font-medium text-bookty-black">{{ $orderCount }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-bookty-purple-700">Completed:</span>
                    <span class="text-sm font-medium text-bookty-black">{{ $completedOrderCount }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-bookty-purple-700">Pending:</span>
                    <span class="text-sm font-medium text-bookty-black">{{ $pendingOrderCount }}</span>
                </div>
                <div class="pt-3 border-t border-bookty-pink-100">
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-bookty-purple-700">Total Spent:</span>
                        <span class="text-sm font-medium text-bookty-black">RM {{ number_format($totalSpent, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Customer Details -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
        <div class="px-4 py-5 sm:px-6 flex justify-between items-center bg-bookty-pink-50">
            <div>
                <h3 class="text-lg leading-6 font-serif font-medium text-bookty-black">Customer Information</h3>
                <p class="mt-1 max-w-2xl text-sm text-bookty-purple-700">Personal details and contact information.</p>
            </div>
        </div>
        <div class="border-t border-gray-200">
            <dl>
                <!-- Basic Info -->
                <div class="bg-bookty-pink-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-bookty-purple-700">Full name</dt>
                    <dd class="mt-1 text-sm text-bookty-black sm:mt-0 sm:col-span-2">{{ $customer->name }}</dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-bookty-purple-700">Email address</dt>
                    <dd class="mt-1 text-sm text-bookty-black sm:mt-0 sm:col-span-2">{{ $customer->email }}</dd>
                </div>
                <div class="bg-bookty-pink-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-bookty-purple-700">Phone number</dt>
                    <dd class="mt-1 text-sm text-bookty-black sm:mt-0 sm:col-span-2">
                        {{ $customer->phone_number ?: 'Not provided' }}
                    </dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-bookty-purple-700">Age</dt>
                    <dd class="mt-1 text-sm text-bookty-black sm:mt-0 sm:col-span-2">
                        {{ $customer->age ?: 'Not provided' }}
                    </dd>
                </div>
                
                <!-- Address Info -->
                <div class="bg-bookty-pink-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-bookty-purple-700">Address</dt>
                    <dd class="mt-1 text-sm text-bookty-black sm:mt-0 sm:col-span-2">
                        @if($customer->address_line1)
                            {{ $customer->address_line1 }}
                            @if($customer->address_line2)
                                <br>{{ $customer->address_line2 }}
                            @endif
                        @else
                            Not provided
                        @endif
                    </dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-bookty-purple-700">City</dt>
                    <dd class="mt-1 text-sm text-bookty-black sm:mt-0 sm:col-span-2">
                        {{ $customer->city ?: 'Not provided' }}
                    </dd>
                </div>
                <div class="bg-bookty-pink-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-bookty-purple-700">State</dt>
                    <dd class="mt-1 text-sm text-bookty-black sm:mt-0 sm:col-span-2">
                        {{ $customer->state ?: 'Not provided' }}
                    </dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-bookty-purple-700">Postal Code</dt>
                    <dd class="mt-1 text-sm text-bookty-black sm:mt-0 sm:col-span-2">
                        {{ $customer->postal_code ?: 'Not provided' }}
                    </dd>
                </div>
                <div class="bg-bookty-pink-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-bookty-purple-700">Country</dt>
                    <dd class="mt-1 text-sm text-bookty-black sm:mt-0 sm:col-span-2">
                        {{ $customer->country ?: 'Not provided' }}
                    </dd>
                </div>
                
                <!-- Account Info -->
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-bookty-purple-700">Registered on</dt>
                    <dd class="mt-1 text-sm text-bookty-black sm:mt-0 sm:col-span-2">
                        {{ $customer->created_at->format('F d, Y') }} at {{ $customer->created_at->format('h:i A') }}
                    </dd>
                </div>
            </dl>
        </div>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6 bg-bookty-pink-50 flex justify-between items-center">
            <div>
                <h3 class="text-lg leading-6 font-serif font-medium text-bookty-black">Order History</h3>
                <p class="mt-1 max-w-2xl text-sm text-bookty-purple-700">
                    {{ $orders->count() > 0 ? 'All orders placed by this customer.' : 'This customer has not placed any orders yet.' }}
                </p>
            </div>
        </div>
        <div class="border-t border-gray-200">
            @if($orders->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-bookty-pink-100">
                        <thead class="bg-bookty-pink-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-bookty-purple-700 uppercase tracking-wider">
                                    Order ID
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-bookty-purple-700 uppercase tracking-wider">
                                    Date
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-bookty-purple-700 uppercase tracking-wider">
                                    Total
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-bookty-purple-700 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-bookty-purple-700 uppercase tracking-wider">
                                    Payment
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-bookty-purple-700 uppercase tracking-wider">
                                    Items
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-bookty-purple-700 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($orders as $order)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    #{{ $order->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-bookty-black">
                                    {{ $order->created_at->format('M d, Y') }}
                                    <div class="text-xs text-gray-500">{{ $order->created_at->format('h:i A') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-bookty-black">
                                    <div class="font-medium">RM {{ number_format($order->total_amount, 2) }}</div>
                                    <div class="text-xs text-gray-500">{{ $order->items->count() }} {{ Str::plural('item', $order->items->count()) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $order->getStatusBadgeClass() }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $order->getPaymentStatusBadgeClass() }}">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-bookty-black">
                                    {{ $order->getTotalQuantity() }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="text-bookty-purple-600 hover:text-bookty-purple-800">View</a>
                                    <span class="text-gray-300 mx-1">|</span>
                                    <a href="{{ route('admin.orders.edit', $order->id) }}" class="text-bookty-purple-600 hover:text-bookty-purple-800">Edit</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="px-6 py-4 text-sm text-bookty-purple-700 italic">
                    This customer has not placed any orders yet.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
