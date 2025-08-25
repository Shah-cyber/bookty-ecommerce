<section>
    <header>
        <h2 class="text-xl font-serif font-medium text-bookty-black">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-bookty-purple-700">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <label for="name" class="block text-sm font-medium text-bookty-black">Name</label>
            <input id="name" name="name" type="text" class="mt-1 block w-full rounded-md border-bookty-pink-300 shadow-sm focus:border-bookty-purple-500 focus:ring focus:ring-bookty-purple-200 focus:ring-opacity-50" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
            @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mt-4">
            <label for="email" class="block text-sm font-medium text-bookty-black">Email</label>
            <input id="email" name="email" type="email" class="mt-1 block w-full rounded-md border-bookty-pink-300 shadow-sm focus:border-bookty-purple-500 focus:ring focus:ring-bookty-purple-200 focus:ring-opacity-50" value="{{ old('email', $user->email) }}" required autocomplete="username" />
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-sm text-bookty-purple-700">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-bookty-purple-600 hover:text-bookty-purple-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-bookty-purple-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>
        
        <div class="mt-6">
            <h3 class="text-lg font-medium text-bookty-black border-b border-bookty-pink-100 pb-2 mb-4">Personal Information</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="phone_number" class="block text-sm font-medium text-bookty-black">Phone Number</label>
                    <input id="phone_number" name="phone_number" type="text" class="mt-1 block w-full rounded-md border-bookty-pink-300 shadow-sm focus:border-bookty-purple-500 focus:ring focus:ring-bookty-purple-200 focus:ring-opacity-50" value="{{ old('phone_number', $user->phone_number) }}" />
                    @error('phone_number')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="age" class="block text-sm font-medium text-bookty-black">Age</label>
                    <input id="age" name="age" type="number" min="1" max="120" class="mt-1 block w-full rounded-md border-bookty-pink-300 shadow-sm focus:border-bookty-purple-500 focus:ring focus:ring-bookty-purple-200 focus:ring-opacity-50" value="{{ old('age', $user->age) }}" />
                    <p class="mt-1 text-xs text-bookty-purple-700">For statistical purposes only</p>
                    @error('age')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
        
        <div class="mt-6">
            <h3 class="text-lg font-medium text-bookty-black border-b border-bookty-pink-100 pb-2 mb-4">Address Information</h3>
            
            <div class="space-y-4">
                <div>
                    <label for="address_line1" class="block text-sm font-medium text-bookty-black">Address Line 1</label>
                    <input id="address_line1" name="address_line1" type="text" class="mt-1 block w-full rounded-md border-bookty-pink-300 shadow-sm focus:border-bookty-purple-500 focus:ring focus:ring-bookty-purple-200 focus:ring-opacity-50" value="{{ old('address_line1', $user->address_line1) }}" />
                    @error('address_line1')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="address_line2" class="block text-sm font-medium text-bookty-black">Address Line 2 (Optional)</label>
                    <input id="address_line2" name="address_line2" type="text" class="mt-1 block w-full rounded-md border-bookty-pink-300 shadow-sm focus:border-bookty-purple-500 focus:ring focus:ring-bookty-purple-200 focus:ring-opacity-50" value="{{ old('address_line2', $user->address_line2) }}" />
                    @error('address_line2')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="city" class="block text-sm font-medium text-bookty-black">City</label>
                        <input id="city" name="city" type="text" class="mt-1 block w-full rounded-md border-bookty-pink-300 shadow-sm focus:border-bookty-purple-500 focus:ring focus:ring-bookty-purple-200 focus:ring-opacity-50" value="{{ old('city', $user->city) }}" />
                        @error('city')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="state" class="block text-sm font-medium text-bookty-black">State</label>
                        <input id="state" name="state" type="text" class="mt-1 block w-full rounded-md border-bookty-pink-300 shadow-sm focus:border-bookty-purple-500 focus:ring focus:ring-bookty-purple-200 focus:ring-opacity-50" value="{{ old('state', $user->state) }}" />
                        @error('state')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="postal_code" class="block text-sm font-medium text-bookty-black">Postal Code</label>
                        <input id="postal_code" name="postal_code" type="text" class="mt-1 block w-full rounded-md border-bookty-pink-300 shadow-sm focus:border-bookty-purple-500 focus:ring focus:ring-bookty-purple-200 focus:ring-opacity-50" value="{{ old('postal_code', $user->postal_code) }}" />
                        @error('postal_code')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="country" class="block text-sm font-medium text-bookty-black">Country</label>
                        <input id="country" name="country" type="text" class="mt-1 block w-full rounded-md border-bookty-pink-300 shadow-sm focus:border-bookty-purple-500 focus:ring focus:ring-bookty-purple-200 focus:ring-opacity-50" value="{{ old('country', $user->country) }}" />
                        @error('country')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4 mt-6">
            <button type="submit" class="px-4 py-2 bg-bookty-purple-600 border border-transparent rounded-md font-medium text-white hover:bg-bookty-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-bookty-purple-500">
                {{ __('Save') }}
            </button>

            @if (session('status') === 'profile-updated')
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