@extends('layouts.admin')

@section('header', 'Coupon Codes')

@section('content')
<div class="space-y-6">
    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Coupon Codes</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Manage promotional codes and discounts</p>
        </div>
        <a href="{{ route('admin.coupons.create') }}" 
           class="inline-flex items-center gap-2 px-4 py-2.5 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-xl transition-colors shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add Coupon
        </a>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $coupons->total() }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Coupons</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $coupons->where('is_active', true)->where('expires_at', '>', now())->count() }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Active</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $coupons->sum('usages_count') }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Uses</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                    <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $coupons->where('expires_at', '<', now())->count() }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Expired</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        {{-- Table Container --}}
        <div id="coupons-container">
            @include('admin.coupons._table', ['coupons' => $coupons])
        </div>
    </div>
</div>

{{-- Delete Confirmation Modal --}}
<div id="delete-modal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
        <div class="fixed inset-0 bg-gray-900/75 transition-opacity" id="modal-backdrop"></div>
        
        <div class="relative bg-white dark:bg-gray-800 rounded-2xl max-w-md w-full mx-auto shadow-xl transform transition-all">
            <div class="p-6">
                <div class="w-12 h-12 rounded-full bg-red-100 dark:bg-red-900/30 mx-auto flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Delete Coupon</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-1">Are you sure you want to delete <span id="delete-coupon-code" class="font-mono font-semibold text-gray-900 dark:text-gray-100"></span>?</p>
                <p id="delete-warning" class="text-red-500 dark:text-red-400 text-sm mb-6"></p>
                
                <div class="flex gap-3">
                    <button type="button" id="cancel-delete-btn" class="flex-1 px-4 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-medium rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                        Cancel
                    </button>
                    <form id="delete-form" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" id="confirm-delete-btn" class="w-full px-4 py-2.5 bg-red-600 text-white font-medium rounded-xl hover:bg-red-700 transition-colors">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const deleteModal = document.getElementById('delete-modal');
    const modalBackdrop = document.getElementById('modal-backdrop');
    const deleteCouponCode = document.getElementById('delete-coupon-code');
    const deleteWarning = document.getElementById('delete-warning');
    const cancelDeleteBtn = document.getElementById('cancel-delete-btn');
    const deleteForm = document.getElementById('delete-form');
    const confirmDeleteBtn = document.getElementById('confirm-delete-btn');
    
    function showModal() {
        deleteModal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    
    function hideModal() {
        deleteModal.classList.add('hidden');
        document.body.style.overflow = '';
    }
    
    function bindDeleteButtons() {
        document.querySelectorAll('.delete-coupon-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const couponId = this.dataset.couponId;
                const couponCode = this.dataset.couponCode;
                const usagesCount = parseInt(this.dataset.usagesCount);
                
                deleteCouponCode.textContent = couponCode;
                deleteForm.action = `{{ url('admin/coupons') }}/${couponId}`;
                
                if (usagesCount > 0) {
                    deleteWarning.textContent = `This coupon has been used ${usagesCount} time(s) and cannot be deleted.`;
                    confirmDeleteBtn.disabled = true;
                    confirmDeleteBtn.classList.add('opacity-50', 'cursor-not-allowed');
                } else {
                    deleteWarning.textContent = 'This action cannot be undone.';
                    confirmDeleteBtn.disabled = false;
                    confirmDeleteBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                }
                
                showModal();
            });
        });
    }
    
    cancelDeleteBtn.addEventListener('click', hideModal);
    modalBackdrop.addEventListener('click', hideModal);
    
    bindDeleteButtons();
});
</script>
@endpush
