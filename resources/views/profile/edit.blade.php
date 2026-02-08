@extends('layouts.app')

@section('content')
<div class="min-h-screen py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Page Header --}}
        <div class="mb-8" data-aos="fade-up">
            <h1 class="text-3xl font-bold text-gray-900">Account Settings</h1>
            <p class="text-gray-500 mt-1">Manage your profile and preferences</p>
        </div>

        <div class="grid lg:grid-cols-4 gap-8">
            {{-- Sidebar / Profile Card --}}
            <div class="lg:col-span-1" data-aos="fade-up" data-aos-delay="100">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-28">
                    {{-- Avatar --}}
                    <div class="text-center">
                        <div class="relative inline-block">
                            @if(Auth::user()->hasAvatar())
                                <img src="{{ Auth::user()->getAvatarUrl() }}" alt="{{ Auth::user()->name }}" class="w-24 h-24 rounded-full object-cover ring-4 ring-gray-100">
                            @else
                                <div class="w-24 h-24 rounded-full bg-gray-100 flex items-center justify-center ring-4 ring-gray-50">
                                    <span class="text-3xl font-bold text-gray-600">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                </div>
                            @endif
                            @if(Auth::user()->isGoogleUser())
                                <div class="absolute -bottom-1 -right-1 w-8 h-8 bg-white rounded-full shadow-md flex items-center justify-center border border-gray-100">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24">
                                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <h2 class="mt-4 text-lg font-semibold text-gray-900">{{ Auth::user()->name }}</h2>
                        <p class="text-sm text-gray-500">{{ Auth::user()->email }}</p>

                        @if(Auth::user()->isGoogleUser())
                            <span class="mt-3 inline-flex items-center gap-1.5 px-3 py-1 bg-gray-50 rounded-full text-xs font-medium text-gray-600">
                                Google Account
                            </span>
                        @endif
                    </div>

                    {{-- Stats --}}
                    <div class="mt-6 pt-6 border-t border-gray-100">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-500">Member since</span>
                                <span class="font-medium text-gray-900">{{ Auth::user()->created_at->format('M Y') }}</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-500">Role</span>
                                <span class="font-medium text-gray-900">{{ ucfirst(Auth::user()->getRoleNames()->first() ?? 'Customer') }}</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-500">Orders</span>
                                <span class="font-medium text-gray-900">{{ Auth::user()->orders()->count() }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Quick Links --}}
                    <div class="mt-6 pt-6 border-t border-gray-100 space-y-2">
                        <a href="{{ route('profile.orders') }}" class="flex items-center gap-3 px-3 py-2 text-sm text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                            View Orders
                        </a>
                        <a href="{{ route('wishlist.index') }}" class="flex items-center gap-3 px-3 py-2 text-sm text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                            Wishlist
                        </a>
                    </div>
                </div>
            </div>

            {{-- Main Content --}}
            <div class="lg:col-span-3 space-y-6">
                {{-- Profile Information --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden" data-aos="fade-up" data-aos-delay="200">
                    <div class="px-6 py-5 border-b border-gray-100">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-purple-50 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900">Profile Information</h2>
                                <p class="text-sm text-gray-500">Update your personal details and address</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                {{-- Update Password --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden" data-aos="fade-up" data-aos-delay="300">
                    <div class="px-6 py-5 border-b border-gray-100">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900">Security</h2>
                                <p class="text-sm text-gray-500">Update your password to keep your account secure</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                {{-- Delete Account --}}
                <div class="bg-white rounded-2xl shadow-sm border border-red-100 overflow-hidden" data-aos="fade-up" data-aos-delay="400">
                    <div class="px-6 py-5 border-b border-red-100 bg-red-50/50">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900">Danger Zone</h2>
                                <p class="text-sm text-gray-500">Permanently delete your account and all data</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
