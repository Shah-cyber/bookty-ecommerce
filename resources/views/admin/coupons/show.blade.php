@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8 dark:bg-gray-900 dark:text-gray-100">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Coupon Details</h1>
        <div class="flex space-x-2">
            <a href="{{ route('admin.coupons.edit', $coupon->id) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                Edit
            </a>
            <a href="{{ route('admin.coupons.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Coupons
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden dark:bg-gray-800 dark:shadow-none">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Coupon Info -->
            <div class="md:col-span-1 p-6 border-r border-gray-200 dark:border-gray-700">
                <div class="mb-6">
                    <h2 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Coupon Information</h2>
                    
                    <div class="mb-4">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Code</h3>
                        <p class="mt-1 text-lg font-bold text-gray-900 dark:text-gray-100">{{ $coupon->code }}</p>
                    </div>
                    
                    <div class="mb-4">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Description</h3>
                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $coupon->description ?? 'No description provided' }}</p>
                    </div>
                    
                    <div class="mb-4">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</h3>
                        <p class="mt-1">
                            @if($coupon->is_active)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Active
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                    Inactive
                                </span>
                            @endif
                        </p>
                    </div>
                </div>
                
                <div class="border-t border-gray-200 pt-4">
                    <h2 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Discount Details</h2>
                    
                    <div class="mb-4">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Discount Type</h3>
                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                            {{ ucfirst($coupon->discount_type) }}
                        </p>
                    </div>
                    
                    <div class="mb-4">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Discount Value</h3>
                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                            @if($coupon->discount_type === 'fixed')
                                RM {{ number_format($coupon->discount_value, 2) }}
                            @else
                                {{ $coupon->discount_value }}%
                            @endif
                        </p>
                    </div>
                    
                    <div class="mb-4">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Minimum Purchase</h3>
                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                            @if($coupon->min_purchase_amount > 0)
                                RM {{ number_format($coupon->min_purchase_amount, 2) }}
                            @else
                                No minimum
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Usage and Validity -->
            <div class="md:col-span-1 p-6 border-r border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Validity</h2>
                
                <div class="mb-4">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Start Date</h3>
                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                        {{ $coupon->starts_at->format('M d, Y H:i A') }}
                    </p>
                </div>
                
                <div class="mb-4">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Expiry Date</h3>
                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                        {{ $coupon->expires_at->format('M d, Y H:i A') }}
                    </p>
                </div>
                
                <div class="mb-4">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Created At</h3>
                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                        {{ $coupon->created_at->format('M d, Y H:i A') }}
                    </p>
                </div>
                
                <div class="mb-4">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Last Updated</h3>
                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                        {{ $coupon->updated_at->format('M d, Y H:i A') }}
                    </p>
                </div>
                
                <div class="border-t border-gray-200 pt-4 mt-4">
                    <h2 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Usage Limits</h2>
                    
                    <div class="mb-4">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Maximum Total Uses</h3>
                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                            {{ $coupon->max_uses_total ? $coupon->max_uses_total : 'Unlimited' }}
                        </p>
                    </div>
                    
                    <div class="mb-4">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Maximum Uses Per User</h3>
                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                            {{ $coupon->max_uses_per_user ? $coupon->max_uses_per_user : 'Unlimited' }}
                        </p>
                    </div>
                    
                    <div class="mb-4">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Current Usage</h3>
                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                            {{ $coupon->usages->count() }} {{ $coupon->max_uses_total ? 'of ' . $coupon->max_uses_total : '' }}
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Usage History -->
            <div class="md:col-span-1 p-6">
                <h2 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Usage History</h2>
                
                @if($coupon->usages->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">User</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">Order</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">Discount</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">Date</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                @foreach($coupon->usages as $usage)
                                    <tr>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm dark:text-gray-100">
                                            {{ $usage->user->name }}
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm dark:text-gray-100">
                                            <a href="{{ route('admin.orders.show', $usage->order_id) }}" class="text-indigo-600 hover:text-indigo-900">
                                                #{{ $usage->order_id }}
                                            </a>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm dark:text-gray-100">
                                            RM {{ number_format($usage->discount_amount, 2) }}
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $usage->created_at->format('M d, Y') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4 text-gray-500 dark:text-gray-400">
                        This coupon has not been used yet.
                    </div>
                @endif
            </div>
        </div>
        
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 dark:bg-gray-700 dark:border-gray-600">
            <div class="flex space-x-3">
                <form action="{{ route('admin.coupons.toggle', $coupon->id) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="{{ $coupon->is_active ? 'bg-yellow-600 hover:bg-yellow-700' : 'bg-green-600 hover:bg-green-700' }} text-white font-bold py-2 px-4 rounded">
                        {{ $coupon->is_active ? 'Deactivate' : 'Activate' }}
                    </button>
                </form>
                
                <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this coupon?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
