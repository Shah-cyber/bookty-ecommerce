<section>
    <p class="text-sm text-gray-600 mb-6">
        Once your account is deleted, all of its resources and data will be permanently removed. Before deleting your account, please download any data or information that you wish to retain.
    </p>

    <button 
        type="button"
        class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-red-600 font-semibold border-2 border-red-200 rounded-xl hover:bg-red-50 hover:border-red-300 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-all duration-200"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
        </svg>
        Delete Account
    </button>

    {{-- Delete Confirmation Modal --}}
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
        <div class="min-h-screen px-4 flex items-center justify-center">
            {{-- Backdrop --}}
            <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" 
                x-show="show" 
                x-transition:enter="ease-out duration-300" 
                x-transition:enter-start="opacity-0" 
                x-transition:enter-end="opacity-100" 
                x-transition:leave="ease-in duration-200" 
                x-transition:leave-start="opacity-100" 
                x-transition:leave-end="opacity-0"
                @click="show = false">
            </div>

            {{-- Modal --}}
            <div 
                class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full overflow-hidden"
                x-show="show"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
            >
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')

                    <div class="p-6">
                        {{-- Icon --}}
                        <div class="w-14 h-14 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>

                        <h2 class="text-xl font-bold text-gray-900 text-center mb-2">
                            Delete Account?
                        </h2>

                        <p class="text-sm text-gray-500 text-center mb-6">
                            This action cannot be undone. All your data, orders history, and preferences will be permanently deleted.
                        </p>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                Enter your password to confirm
                            </label>
                            <input
                                id="password"
                                name="password"
                                type="password"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-400 transition-all duration-200"
                                placeholder="Your password"
                            />
                            @error('password', 'userDeletion')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="px-6 py-4 bg-gray-50 flex gap-3 justify-end">
                        <button 
                            type="button" 
                            class="px-5 py-2.5 bg-white text-gray-700 font-semibold border border-gray-200 rounded-xl hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-200 transition-all duration-200"
                            x-on:click="show = false"
                        >
                            Cancel
                        </button>

                        <button 
                            type="submit"
                            class="px-5 py-2.5 bg-red-600 text-white font-semibold rounded-xl hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-all duration-200"
                        >
                            Yes, Delete Account
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
