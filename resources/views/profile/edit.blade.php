@extends('layouts.app')

@section('content')
<div class="py-12 bg-bookty-cream">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6">
            <h1 class="text-3xl font-serif font-bold text-bookty-black">Your Profile</h1>
            <p class="text-bookty-purple-700 mt-2">Manage your account settings and preferences</p>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6">
                <div class="flex flex-col md:flex-row">
                    <div class="md:w-1/3 mb-6 md:mb-0">
                        <div class="flex flex-col items-center">
                            <div class="h-32 w-32 rounded-full bg-bookty-purple-200 flex items-center justify-center mb-4">
                                <span class="text-4xl font-medium text-bookty-purple-800">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </div>
                            <h2 class="text-xl font-medium text-bookty-black">{{ Auth::user()->name }}</h2>
                            <p class="text-bookty-purple-600">{{ Auth::user()->email }}</p>
                            <div class="mt-4 text-sm text-bookty-purple-700">
                                <p>Member since {{ Auth::user()->created_at->format('F Y') }}</p>
                                <p class="mt-1">Role: {{ ucfirst(Auth::user()->getRoleNames()->first() ?? 'Customer') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="md:w-2/3 md:pl-8 md:border-l border-bookty-pink-100">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection