<section>
    <header>
        <h2 class="text-xl font-serif font-medium text-bookty-black">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-bookty-purple-700">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="block text-sm font-medium text-bookty-black">Current Password</label>
            <input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full rounded-md border-bookty-pink-300 shadow-sm focus:border-bookty-purple-500 focus:ring focus:ring-bookty-purple-200 focus:ring-opacity-50" autocomplete="current-password" />
            @error('current_password', 'updatePassword')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mt-4">
            <label for="update_password_password" class="block text-sm font-medium text-bookty-black">New Password</label>
            <input id="update_password_password" name="password" type="password" class="mt-1 block w-full rounded-md border-bookty-pink-300 shadow-sm focus:border-bookty-purple-500 focus:ring focus:ring-bookty-purple-200 focus:ring-opacity-50" autocomplete="new-password" />
            @error('password', 'updatePassword')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mt-4">
            <label for="update_password_password_confirmation" class="block text-sm font-medium text-bookty-black">Confirm Password</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full rounded-md border-bookty-pink-300 shadow-sm focus:border-bookty-purple-500 focus:ring focus:ring-bookty-purple-200 focus:ring-opacity-50" autocomplete="new-password" />
            @error('password_confirmation', 'updatePassword')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-4 mt-6">
            <button type="submit" class="px-4 py-2 bg-bookty-purple-600 border border-transparent rounded-md font-medium text-white hover:bg-bookty-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-bookty-purple-500">
                {{ __('Save') }}
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-bookty-purple-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>