@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-serif font-semibold text-bookty-black">Customers</h1>
    </div>

    @if(session('success'))
        <div class="bg-bookty-purple-50 border-l-4 border-bookty-purple-500 text-bookty-purple-700 p-4 mb-4" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif
    
    <!-- Search and Filters -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
        <div class="px-4 py-5 sm:p-6">
            <form action="{{ route('admin.customers.index') }}" method="GET" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="search" class="block text-sm font-medium text-bookty-purple-700">Search</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input type="text" name="search" id="search" value="{{ request('search') }}" 
                                class="focus:ring-bookty-purple-500 focus:border-bookty-purple-500 block w-full pl-3 pr-10 py-2 sm:text-sm border-bookty-pink-300 rounded-md" 
                                placeholder="Name, email or phone">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <label for="has_orders" class="block text-sm font-medium text-bookty-purple-700">Has Orders</label>
                        <select id="has_orders" name="has_orders" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-bookty-pink-300 focus:outline-none focus:ring-bookty-purple-500 focus:border-bookty-purple-500 sm:text-sm rounded-md">
                            <option value="">All Customers</option>
                            <option value="yes" {{ request('has_orders') === 'yes' ? 'selected' : '' }}>With Orders</option>
                            <option value="no" {{ request('has_orders') === 'no' ? 'selected' : '' }}>Without Orders</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="sort" class="block text-sm font-medium text-bookty-purple-700">Sort By</label>
                        <select id="sort" name="sort" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-bookty-pink-300 focus:outline-none focus:ring-bookty-purple-500 focus:border-bookty-purple-500 sm:text-sm rounded-md">
                            <option value="latest" {{ request('sort') === 'latest' || !request('sort') ? 'selected' : '' }}>Newest First</option>
                            <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Oldest First</option>
                            <option value="name" {{ request('sort') === 'name' ? 'selected' : '' }}>Name (A-Z)</option>
                        </select>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="date_from" class="block text-sm font-medium text-bookty-purple-700">Registered From</label>
                        <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}" 
                            class="mt-1 focus:ring-bookty-purple-500 focus:border-bookty-purple-500 block w-full shadow-sm sm:text-sm border-bookty-pink-300 rounded-md">
                    </div>
                    
                    <div>
                        <label for="date_to" class="block text-sm font-medium text-bookty-purple-700">Registered To</label>
                        <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}" 
                            class="mt-1 focus:ring-bookty-purple-500 focus:border-bookty-purple-500 block w-full shadow-sm sm:text-sm border-bookty-pink-300 rounded-md">
                    </div>
                </div>
                
                <div class="flex justify-end">
                    <a href="{{ route('admin.customers.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-bookty-purple-500 mr-2">
                        Clear
                    </a>
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-bookty-purple-600 hover:bg-bookty-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-bookty-purple-500">
                        Apply Filters
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-bookty-pink-100">
                <thead class="bg-bookty-pink-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-bookty-purple-700 uppercase tracking-wider">
                            Customer
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-bookty-purple-700 uppercase tracking-wider">
                            Contact Info
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-bookty-purple-700 uppercase tracking-wider">
                            Location
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-bookty-purple-700 uppercase tracking-wider">
                            Orders
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-bookty-purple-700 uppercase tracking-wider">
                            Registered
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-bookty-purple-700 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($customers as $customer)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-bookty-purple-200 flex items-center justify-center">
                                    <span class="text-sm font-medium text-bookty-purple-800">{{ substr($customer->name, 0, 1) }}</span>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $customer->name }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        ID: {{ $customer->id }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">{{ $customer->email }}</div>
                            @if($customer->phone_number)
                                <div class="text-sm text-gray-500">{{ $customer->phone_number }}</div>
                            @else
                                <div class="text-sm text-gray-400 italic">No phone</div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($customer->city && $customer->state)
                                <div class="text-sm text-gray-900">{{ $customer->city }}, {{ $customer->state }}</div>
                                @if($customer->country)
                                    <div class="text-sm text-gray-500">{{ $customer->country }}</div>
                                @endif
                            @else
                                <div class="text-sm text-gray-400 italic">No address</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $customer->orders_count }} orders</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $customer->created_at->format('M d, Y') }}</div>
                            <div class="text-xs text-gray-500">{{ $customer->created_at->diffForHumans() }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('admin.customers.show', $customer->id) }}" class="text-bookty-purple-600 hover:text-bookty-purple-800">View Details</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $customers->links() }}
    </div>
</div>
@endsection
