{{-- Authentication Modal Component --}}
<div x-data="authModal()" x-show="isOpen" x-cloak @open-auth-modal.document="openModal($event.detail)" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    {{-- Background overlay --}}
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div x-show="isOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="closeModal()"></div>

        {{-- This element is to trick the browser into centering the modal contents. --}}
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        {{-- Modal panel --}}
        <div x-show="isOpen" 
             x-transition:enter="ease-out duration-400" 
             x-transition:enter-start="opacity-0 translate-y-8 sm:translate-y-0 sm:scale-90" 
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
             x-transition:leave="ease-in duration-300" 
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
             x-transition:leave-end="opacity-0 translate-y-8 sm:translate-y-0 sm:scale-90" 
             class="relative inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
            {{-- Close button --}}
            <div class="absolute top-0 right-0 pt-4 pr-4">
                <button type="button" @click="closeModal()" class="bg-white rounded-md text-gray-400 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                    <span class="sr-only">Close</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Modal content --}}
            <div class="sm:flex sm:items-start">
                <div class="w-full">
                    {{-- Logo --}}
                    <div class="text-center mb-6">
                        <div class="flex justify-center items-center mb-4">
                            <img src="{{ asset('storage/BooktyLogo/BooktyL.png') }}" alt="Bookty Logo" class="h-12 w-auto">
                        </div>
                        <h2 class="text-2xl font-serif font-bold text-bookty-purple-700">Bookty Enterprise</h2>
                    </div>

                    {{-- Tab Navigation --}}
                    <div class="flex border-b border-gray-200 mb-6">
                        <button @click="switchTab('login')" :class="{'border-purple-500 text-purple-600': currentTab === 'login', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': currentTab !== 'login'}" class="w-1/2 py-2 px-1 border-b-2 font-medium text-sm focus:outline-none transition-all duration-200">
                            Sign In
                        </button>
                        <button @click="switchTab('register')" :class="{'border-purple-500 text-purple-600': currentTab === 'register', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': currentTab !== 'register'}" class="w-1/2 py-2 px-1 border-b-2 font-medium text-sm focus:outline-none transition-all duration-200">
                            Sign Up
                        </button>
                    </div>

                    {{-- Forms Container --}}
                    <div class="relative min-h-[400px]">
                        {{-- Login Form --}}
                        <div x-show="currentTab === 'login'" 
                             x-transition:enter="transition ease-out duration-300" 
                             x-transition:enter-start="opacity-0 transform translate-x-6" 
                             x-transition:enter-end="opacity-100 transform translate-x-0" 
                             x-transition:leave="transition ease-in duration-200" 
                             x-transition:leave-start="opacity-100 transform translate-x-0" 
                             x-transition:leave-end="opacity-0 transform -translate-x-6"
                             class="absolute inset-0 w-full">
                        <form @submit.prevent="submitLogin()" id="loginForm">
                            @csrf
                            {{-- Email --}}
                            <div class="mb-4">
                                <label for="login_email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input type="email" id="login_email" name="email" x-model="loginForm.email" required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                                <p x-show="loginErrors.email" x-text="loginErrors.email" class="mt-1 text-sm text-red-600"></p>
                            </div>

                            {{-- Password --}}
                            <div class="mb-4">
                                <label for="login_password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                                <input type="password" id="login_password" name="password" x-model="loginForm.password" required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                                <p x-show="loginErrors.password" x-text="loginErrors.password" class="mt-1 text-sm text-red-600"></p>
                            </div>

                            {{-- Remember Me --}}
                            <div class="flex items-center justify-between mb-6">
                                <div class="flex items-center">
                                    <input type="checkbox" id="remember_me" name="remember" x-model="loginForm.remember" class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                                    <label for="remember_me" class="ml-2 block text-sm text-gray-900">Remember me</label>
                                </div>
                                <a href="#" class="text-sm text-purple-600 hover:text-purple-500">Forgot password?</a>
                            </div>

                            {{-- Submit Button --}}
                            <button type="submit" :disabled="isLoading" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 disabled:opacity-50 disabled:cursor-not-allowed">
                                <span x-show="!isLoading">Sign In</span>
                                <span x-show="isLoading" class="flex items-center">
                                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Signing In...
                                </span>
                            </button>
                        </form>
                        </div>

                        {{-- Register Form --}}
                        <div x-show="currentTab === 'register'" 
                             x-transition:enter="transition ease-out duration-300" 
                             x-transition:enter-start="opacity-0 transform translate-x-6" 
                             x-transition:enter-end="opacity-100 transform translate-x-0" 
                             x-transition:leave="transition ease-in duration-200" 
                             x-transition:leave-start="opacity-100 transform translate-x-0" 
                             x-transition:leave-end="opacity-0 transform -translate-x-6"
                             class="absolute inset-0 w-full">
                        <form @submit.prevent="submitRegister()" id="registerForm">
                            @csrf
                            {{-- Name --}}
                            <div class="mb-4">
                                <label for="register_name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                                <input type="text" id="register_name" name="name" x-model="registerForm.name" required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                                <p x-show="registerErrors.name" x-text="registerErrors.name" class="mt-1 text-sm text-red-600"></p>
                            </div>

                            {{-- Email --}}
                            <div class="mb-4">
                                <label for="register_email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input type="email" id="register_email" name="email" x-model="registerForm.email" required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                                <p x-show="registerErrors.email" x-text="registerErrors.email" class="mt-1 text-sm text-red-600"></p>
                            </div>

                            {{-- Password --}}
                            <div class="mb-4">
                                <label for="register_password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                                <input type="password" id="register_password" name="password" x-model="registerForm.password" required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                                <p x-show="registerErrors.password" x-text="registerErrors.password" class="mt-1 text-sm text-red-600"></p>
                            </div>

                            {{-- Confirm Password --}}
                            <div class="mb-6">
                                <label for="register_password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                                <input type="password" id="register_password_confirmation" name="password_confirmation" x-model="registerForm.password_confirmation" required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500">
                                <p x-show="registerErrors.password_confirmation" x-text="registerErrors.password_confirmation" class="mt-1 text-sm text-red-600"></p>
                            </div>

                            {{-- Submit Button --}}
                            <button type="submit" :disabled="isLoading" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 disabled:opacity-50 disabled:cursor-not-allowed">
                                <span x-show="!isLoading">Create Account</span>
                                <span x-show="isLoading" class="flex items-center">
                                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Creating Account...
                                </span>
                            </button>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Alpine.js Data --}}
<script>
function authModal() {
    return {
        isOpen: false,
        currentTab: 'login',
        isLoading: false,
        loginForm: {
            email: '',
            password: '',
            remember: false
        },
        registerForm: {
            name: '',
            email: '',
            password: '',
            password_confirmation: ''
        },
        loginErrors: {},
        registerErrors: {},

        openModal(tab = 'login') {
            this.currentTab = tab;
            this.isOpen = true;
            this.clearErrors();
            document.body.classList.add('overflow-hidden');
        },

        closeModal() {
            this.isOpen = false;
            document.body.classList.remove('overflow-hidden');
            this.resetForms();
        },

        switchTab(tab) {
            this.currentTab = tab;
            this.clearErrors();
        },

        clearErrors() {
            this.loginErrors = {};
            this.registerErrors = {};
        },

        resetForms() {
            this.loginForm = {
                email: '',
                password: '',
                remember: false
            };
            this.registerForm = {
                name: '',
                email: '',
                password: '',
                password_confirmation: ''
            };
            this.clearErrors();
        },

        async submitLogin() {
            this.isLoading = true;
            this.clearErrors();

            try {
                const formData = new FormData();
                formData.append('email', this.loginForm.email);
                formData.append('password', this.loginForm.password);
                formData.append('remember', this.loginForm.remember);
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

                const response = await fetch('/login', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (response.ok) {
                    window.showToast('Welcome back! Login successful.', 'success');
                    setTimeout(() => {
                        window.location.href = data.redirect || '/';
                    }, 1000);
                } else {
                    if (data.errors) {
                        this.loginErrors = data.errors;
                    } else {
                        window.showToast(data.message || 'Login failed. Please try again.', 'error');
                    }
                }
            } catch (error) {
                console.error('Login error:', error);
                window.showToast('An error occurred. Please try again.', 'error');
            } finally {
                this.isLoading = false;
            }
        },

        async submitRegister() {
            this.isLoading = true;
            this.clearErrors();

            try {
                const formData = new FormData();
                formData.append('name', this.registerForm.name);
                formData.append('email', this.registerForm.email);
                formData.append('password', this.registerForm.password);
                formData.append('password_confirmation', this.registerForm.password_confirmation);
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

                const response = await fetch('/register', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (response.ok) {
                    window.showToast('Account created successfully! Welcome to Bookty!', 'success');
                    setTimeout(() => {
                        window.location.href = data.redirect || '/';
                    }, 1000);
                } else {
                    if (data.errors) {
                        this.registerErrors = data.errors;
                    } else {
                        window.showToast(data.message || 'Registration failed. Please try again.', 'error');
                    }
                }
            } catch (error) {
                console.error('Registration error:', error);
                window.showToast('An error occurred. Please try again.', 'error');
            } finally {
                this.isLoading = false;
            }
        }
    }
}
</script>
