@extends('layouts.admin')

@section('header', 'Coupon Details')

@section('content')
<div class="space-y-6">
    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.coupons.index') }}" 
               class="p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Coupon Details</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1">View coupon information and usage</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.coupons.edit', $coupon->id) }}" 
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-purple-600 text-white font-medium rounded-xl hover:bg-purple-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit
            </a>
        </div>
    </div>

    {{-- Coupon Header Card --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex flex-col md:flex-row md:items-center gap-6">
            <div class="w-16 h-16 rounded-2xl bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center flex-shrink-0">
                <svg class="w-8 h-8 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                </svg>
            </div>
            <div class="flex-1">
                <div class="flex flex-wrap items-center gap-3 mb-2">
                    <h2 class="text-2xl font-mono font-bold text-gray-900 dark:text-gray-100">{{ $coupon->code }}</h2>
                    @if($coupon->is_active && $coupon->expires_at > now() && $coupon->starts_at <= now())
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">
                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                            Active
                        </span>
                    @elseif($coupon->is_active && $coupon->starts_at > now())
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400">
                            Scheduled
                        </span>
                    @elseif($coupon->expires_at < now())
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                            Expired
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400">
                            Inactive
                        </span>
                    @endif
                </div>
                @if($coupon->description)
                    <p class="text-gray-500 dark:text-gray-400">{{ $coupon->description }}</p>
                @endif
            </div>
            <div class="text-center md:text-right">
                @if($coupon->discount_type === 'fixed')
                    <p class="text-3xl font-bold text-green-600 dark:text-green-400">RM {{ number_format($coupon->discount_value, 2) }}</p>
                @else
                    <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $coupon->discount_value }}%</p>
                @endif
                <p class="text-sm text-gray-500 dark:text-gray-400">off</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Discount Details --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Discount Details</h3>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Discount Type</p>
                    <p class="font-medium text-gray-900 dark:text-gray-100">{{ ucfirst($coupon->discount_type) }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Discount Value</p>
                    <p class="font-medium text-gray-900 dark:text-gray-100">
                        {{ $coupon->discount_type === 'fixed' ? 'RM ' . number_format($coupon->discount_value, 2) : $coupon->discount_value . '%' }}
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Minimum Purchase</p>
                    <p class="font-medium text-gray-900 dark:text-gray-100">
                        {{ $coupon->min_purchase_amount > 0 ? 'RM ' . number_format($coupon->min_purchase_amount, 2) : 'No minimum' }}
                    </p>
                </div>
                @if($coupon->free_shipping)
                    <div class="pt-2">
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                            Includes Free Shipping
                        </span>
                    </div>
                @endif
            </div>
        </div>

        {{-- Validity Period --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Validity Period</h3>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Start Date</p>
                    <p class="font-medium text-gray-900 dark:text-gray-100">{{ $coupon->starts_at->format('M d, Y H:i A') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Expiry Date</p>
                    <p class="font-medium text-gray-900 dark:text-gray-100">{{ $coupon->expires_at->format('M d, Y H:i A') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Created</p>
                    <p class="font-medium text-gray-900 dark:text-gray-100">{{ $coupon->created_at->format('M d, Y') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Last Updated</p>
                    <p class="font-medium text-gray-900 dark:text-gray-100">{{ $coupon->updated_at->format('M d, Y') }}</p>
                </div>
            </div>
        </div>

        {{-- Usage Limits --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Usage Statistics</h3>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Current Usage</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                        {{ $coupon->usages->count() }} <span class="text-sm font-normal text-gray-500 dark:text-gray-400">/ {{ $coupon->max_uses_total ?: '∞' }}</span>
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Max Total Uses</p>
                    <p class="font-medium text-gray-900 dark:text-gray-100">{{ $coupon->max_uses_total ?: 'Unlimited' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Max Per User</p>
                    <p class="font-medium text-gray-900 dark:text-gray-100">{{ $coupon->max_uses_per_user ?: 'Unlimited' }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Usage History --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Usage History</h3>
        </div>
        @if($coupon->usages->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider border-b border-gray-200 dark:border-gray-700">
                            <th class="px-6 py-4">User</th>
                            <th class="px-6 py-4">Order</th>
                            <th class="px-6 py-4">Discount Applied</th>
                            <th class="px-6 py-4">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @foreach($coupon->usages as $usage)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <td class="px-6 py-4">
                                    <p class="font-medium text-gray-900 dark:text-gray-100">{{ $usage->user->name }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $usage->user->email }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('admin.orders.show', $usage->order_id) }}" class="text-purple-600 hover:text-purple-700 dark:text-purple-400 dark:hover:text-purple-300 font-medium">
                                        #{{ $usage->order_id }}
                                    </a>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="font-medium text-green-600 dark:text-green-400">- RM {{ number_format($usage->discount_amount, 2) }}</span>
                                </td>
                                <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                                    {{ $usage->created_at->format('M d, Y H:i') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-12 text-center">
                <div class="w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <p class="text-gray-500 dark:text-gray-400">This coupon has not been used yet.</p>
            </div>
        @endif
    </div>

    {{-- Actions --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex flex-wrap gap-3">
            <form action="{{ route('admin.coupons.toggle', $coupon->id) }}" method="POST">
                @csrf
                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2.5 {{ $coupon->is_active ? 'bg-amber-50 text-amber-600 dark:bg-amber-900/30 dark:text-amber-400 hover:bg-amber-100 dark:hover:bg-amber-900/50' : 'bg-green-50 text-green-600 dark:bg-green-900/30 dark:text-green-400 hover:bg-green-100 dark:hover:bg-green-900/50' }} font-medium rounded-xl transition-colors">
                    @if($coupon->is_active)
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                        </svg>
                        Deactivate
                    @else
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Activate
                    @endif
                </button>
            </form>
            
            @if($coupon->usages->count() == 0)
                <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this coupon?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center gap-2 px-4 py-2.5 bg-red-50 text-red-600 dark:bg-red-900/30 dark:text-red-400 font-medium rounded-xl hover:bg-red-100 dark:hover:bg-red-900/50 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Delete Coupon
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
