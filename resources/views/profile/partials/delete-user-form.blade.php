<section class="space-y-6">
    <header>
        <h2 class="text-xl font-serif font-medium text-bookty-black">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-sm text-bookty-purple-700">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <button 
        type="button"
        class="px-4 py-2 bg-bookty-pink-600 border border-transparent rounded-md font-medium text-white hover:bg-bookty-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-bookty-pink-500"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >
        {{ __('Delete Account') }}
    </button>

    <div
        x-data="{ show: false, name: '' }"
        x-on:open-modal.window="show = ($event.detail === name)"
        x-on:close-modal.window="show = false"
        x-on:keydown.escape.window="show = false"
        x-show="show"
        x-trap.noscroll.inert="show"
        class="fixed inset-0 z-50 overflow-y-auto"
        style="display: none;"
        id="confirm-user-deletion"
        x-init="name = 'confirm-user-deletion'"
    >
        <div class="min-h-screen px-4 text-center">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

            <span class="inline-block h-screen align-middle" aria-hidden="true">&#8203;</span>

            <div 
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                x-show="show"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            >
                <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                    @csrf
                    @method('delete')

                    <h2 class="text-xl font-serif font-medium text-bookty-black">
                        {{ __('Are you sure you want to delete your account?') }}
                    </h2>

                    <p class="mt-2 text-sm text-bookty-purple-700">
                        {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                    </p>

                    <div class="mt-6">
                        <label for="password" class="sr-only">{{ __('Password') }}</label>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            class="mt-1 block w-3/4 rounded-md border-bookty-pink-300 shadow-sm focus:border-bookty-purple-500 focus:ring focus:ring-bookty-purple-200 focus:ring-opacity-50"
                            placeholder="{{ __('Password') }}"
                        />

                        @error('password', 'userDeletion')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button 
                            type="button" 
                            class="px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 mr-3"
                            x-on:click="$dispatch('close')"
                        >
                            {{ __('Cancel') }}
                        </button>

                        <button 
                            type="submit"
                            class="px-4 py-2 bg-bookty-pink-600 border border-transparent rounded-md font-medium text-white hover:bg-bookty-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-bookty-pink-500"
                        >
                            {{ __('Delete Account') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>