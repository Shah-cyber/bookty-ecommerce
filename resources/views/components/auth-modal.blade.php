{{-- Authentication Modal Component - Matches Homepage Theme --}}
<div x-data="authModal()" x-show="isOpen" x-cloak @open-auth-modal.document="openModal($event.detail)" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    {{-- Background overlay --}}
    <div class="flex items-center justify-center min-h-screen p-4">
        <div x-show="isOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black/40 backdrop-blur-md transition-all" @click="closeModal()"></div>

        {{-- Modal panel --}}
        <div x-show="isOpen" 
             x-transition:enter="ease-out duration-400" 
             x-transition:enter-start="opacity-0 scale-95" 
             x-transition:enter-end="opacity-100 scale-100" 
             x-transition:leave="ease-in duration-300" 
             x-transition:leave-start="opacity-100 scale-100" 
             x-transition:leave-end="opacity-0 scale-95" 
             class="relative bg-white/30 backdrop-blur-xl rounded-[2.5rem] shadow-[0_18px_45px_rgba(15,23,42,0.35)] w-full max-w-md mx-auto overflow-hidden z-10 border-t border-white/40 transition-all">
            
            {{-- Header - Clean Glass Aesthetic --}}
            <div class="relative pt-10 pb-6 px-10 text-center">
                {{-- Close button --}}
                <button type="button" @click="closeModal()" class="absolute top-5 right-5 z-20 w-8 h-8 flex items-center justify-center rounded-full text-gray-700 hover:text-gray-900 hover:bg-white/20 transition-all duration-300">
                    <span class="sr-only">Close</span>
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" stroke-linecap="round">
                        <path d="M18 6L6 18M6 6l12 12" />
                    </svg>
                </button>
                
                {{-- Content --}}
                <div class="relative z-10">
                    {{-- Logo --}}
                    <div class="inline-block mb-4">
                        <div class="relative flex items-center justify-center w-16 h-16 rounded-2xl bg-white/40 shadow-sm border border-white/60">
                            <img src="{{ asset('images/BooktyL.png') }}" alt="Bookty Logo" class="h-8 w-auto">
                        </div>
                    </div>
                    
                    <h1 class="text-2xl font-bold text-gray-900 mb-1 font-serif tracking-tight">
                        Welcome back
                    </h1>
                    <p class="text-gray-600 text-sm font-medium tracking-wide">Your gateway to endless stories</p>
                </div>
            </div>
            
            {{-- Content area --}}
            <div class="px-8 pb-8">
                {{-- Tab Navigation --}}
                <div class="flex bg-white/20 rounded-xl p-1 mb-6 relative z-10 border border-white/30">
                    <button @click="switchTab('login')" :class="{'bg-white/60 shadow-sm text-gray-900': currentTab === 'login', 'text-gray-600 hover:text-gray-900': currentTab !== 'login'}" class="flex-1 py-2.5 text-sm font-bold rounded-lg transition-all duration-200 focus:outline-none">
                        Sign In
                    </button>
                    <button @click="switchTab('register')" :class="{'bg-white/60 shadow-sm text-gray-900': currentTab === 'register', 'text-gray-600 hover:text-gray-900': currentTab !== 'register'}" class="flex-1 py-2.5 text-sm font-bold rounded-lg transition-all duration-200 focus:outline-none">
                        Sign Up
                    </button>
                </div>

                {{-- Forms Container --}}
             <div class="relative h-[440px] sm:h-[480px] md:h-[520px]">
                    {{-- Login Form --}}
                    <div x-show="currentTab === 'login'" 
                         x-transition:enter="transition ease-out duration-300" 
                         x-transition:enter-start="opacity-0 transform translate-y-4" 
                         x-transition:enter-end="opacity-100 transform translate-y-0" 
                         x-transition:leave="transition ease-in duration-200" 
                         x-transition:leave-start="opacity-100 transform translate-y-0" 
                         x-transition:leave-end="opacity-0 transform -translate-y-4"
                         class="space-y-5">
                        <form @submit.prevent="submitLogin()" id="loginForm" class="space-y-5" novalidate>
                            @csrf
                            {{-- Email --}}
                            <div>
                                <label for="login_email" class="block text-sm font-semibold text-gray-800 mb-2">Email Address</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                        </svg>
                                    </div>
                                    <input type="email" id="login_email" name="email" x-model="loginForm.email" required @input="validateLoginEmail()" oninvalid="this.setCustomValidity(' ')" oninput="this.setCustomValidity('')"
                                           class="w-full pl-10 pr-4 py-3 bg-white/50 border border-white/60 rounded-xl focus:bg-white/80 focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10 transition-all duration-200 placeholder-gray-500"
                                           placeholder="Enter your email">
                                </div>
                                <p x-show="loginErrors.email" x-text="loginErrors.email" class="mt-2 text-sm text-red-500"></p>
                            </div>

                            {{-- Password --}}
                            <div>
                                <label for="login_password" class="block text-sm font-semibold text-gray-800 mb-2">Password</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                        </svg>
                                    </div>
                                    <input type="password" id="login_password" name="password" x-model="loginForm.password" required minlength="8" maxlength="12" @input="validateLoginPassword()"
                                           class="w-full pl-10 pr-4 py-3 bg-white/50 border border-white/60 rounded-xl focus:bg-white/80 focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10 transition-all duration-200 placeholder-gray-500"
                                           placeholder="Enter your password">
                                </div>
                                <p x-show="loginErrors.password" x-text="loginErrors.password" class="mt-2 text-sm text-red-500"></p>
                            </div>

                            {{-- Remember Me & Forgot Password --}}
                            <div class="flex items-center justify-between text-sm">
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" id="remember_me" name="remember" x-model="loginForm.remember" 
                                           class="h-4 w-4 text-gray-900 focus:ring-gray-900 border-gray-300 rounded bg-white/50">
                                    <span class="ml-2 text-gray-700">Remember me</span>
                                </label>
                                <a href="#" class="text-gray-700 hover:text-gray-900 font-medium">Forgot password?</a>
                            </div>

                            {{-- Submit Button - matches homepage CTA (bg-gray-900) --}}
                            <button type="submit" :disabled="isLoading" 
                                    class="w-full bg-gray-900 hover:bg-black text-white font-bold py-3 px-4 rounded-full shadow-lg hover:shadow-xl hover:scale-[1.02] transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none disabled:hover:scale-100">
                                <span x-show="!isLoading" class="flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                    </svg>
                                    Sign In
                                </span>
                                <span x-show="isLoading" class="flex items-center justify-center">
                                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Signing In...
                                </span>
                            </button>
                            
                            {{-- Divider --}}
                            <div class="relative">
                                <div class="absolute inset-0 flex items-center">
                                    <div class="w-full border-t border-gray-300/50"></div>
                                </div>
                                <div class="relative flex justify-center text-xs">
                                    <span class="px-4 bg-transparent text-gray-500 font-medium backdrop-blur-sm rounded">OR CONTINUE WITH</span>
                                </div>
                            </div>
                            
                            {{-- Google Login Button --}}
                            <a href="{{ route('auth.google') }}" 
                               class="w-full flex items-center justify-center px-4 py-3 bg-white/70 border border-white/60 rounded-full text-gray-700 font-bold hover:bg-white hover:border-white focus:outline-none focus:ring-2 focus:ring-gray-900/10 transition-all duration-200 group shadow-sm">
                                <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform duration-200" viewBox="0 0 24 24">
                                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                                </svg>
                                Continue with Google
                            </a>
                        </form>
                        </div>

                    {{-- Register Form --}}
                    <div x-show="currentTab === 'register'" 
                         x-transition:enter="transition ease-out duration-300" 
                         x-transition:enter-start="opacity-0 transform translate-y-4" 
                         x-transition:enter-end="opacity-100 transform translate-y-0" 
                         x-transition:leave="transition ease-in duration-200" 
                         x-transition:leave-start="opacity-100 transform translate-y-0" 
                         x-transition:leave-end="opacity-0 transform -translate-y-4"
                         class="space-y-4">
                        <form @submit.prevent="submitRegister()" id="registerForm" class="space-y-4" novalidate>
                            @csrf
                            {{-- Name --}}
                            <div>
                                <label for="register_name" class="block text-sm font-semibold text-gray-900 mb-2">Full Name</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    <input type="text" id="register_name" name="name" x-model="registerForm.name" required @input="validateRegisterName()"
                                           class="w-full pl-10 pr-4 py-3 bg-white border border-gray-200 rounded-xl focus:bg-white focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10 transition-all duration-200"
                                           placeholder="Enter your full name">
                                </div>
                                <p x-show="registerErrors.name" x-text="registerErrors.name" class="mt-2 text-sm text-red-500"></p>
                            </div>

                            {{-- Email --}}
                            <div>
                                <label for="register_email" class="block text-sm font-semibold text-gray-900 mb-2">Email Address</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                        </svg>
                                    </div>
                                    <input type="email" id="register_email" name="email" x-model="registerForm.email" required @input="validateRegisterEmail()" oninvalid="this.setCustomValidity(' ')" oninput="this.setCustomValidity('')"
                                           class="w-full pl-10 pr-4 py-3 bg-white border border-gray-200 rounded-xl focus:bg-white focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10 transition-all duration-200"
                                           placeholder="Enter your email">
                                </div>
                                <p x-show="registerErrors.email" x-text="registerErrors.email" class="mt-2 text-sm text-red-500"></p>
                            </div>

                            {{-- Password --}}
                            <div>
                                <label for="register_password" class="block text-sm font-semibold text-gray-900 mb-2">Password</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                        </svg>
                                    </div>
                                    <input type="password" id="register_password" name="password" x-model="registerForm.password" required minlength="8" maxlength="12" @input="validateRegisterPassword()"
                                           class="w-full pl-10 pr-4 py-3 bg-white border border-gray-200 rounded-xl focus:bg-white focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10 transition-all duration-200"
                                           placeholder="Create a password">
                                </div>
                                <p x-show="registerErrors.password" x-text="registerErrors.password" class="mt-2 text-sm text-red-500"></p>
                            </div>

                            {{-- Confirm Password --}}
                            <div>
                                <label for="register_password_confirmation" class="block text-sm font-semibold text-gray-900 mb-2">Confirm Password</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <input type="password" id="register_password_confirmation" name="password_confirmation" x-model="registerForm.password_confirmation" required minlength="8" maxlength="12" @input="validateRegisterPasswordConfirmation()"
                                           class="w-full pl-10 pr-4 py-3 bg-white border border-gray-200 rounded-xl focus:bg-white focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10 transition-all duration-200"
                                           placeholder="Confirm your password">
                                </div>
                                <p x-show="registerErrors.password_confirmation" x-text="registerErrors.password_confirmation" class="mt-2 text-sm text-red-500"></p>
                            </div>

                            {{-- Submit Button - matches homepage CTA --}}
                            <button type="submit" :disabled="isLoading" 
                                    class="w-full bg-gray-900 hover:bg-black text-white font-bold py-3 px-4 rounded-full shadow-lg hover:shadow-xl hover:scale-[1.02] transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none disabled:hover:scale-100">
                                <span x-show="!isLoading" class="flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                    </svg>
                                    Create Account
                                </span>
                                <span x-show="isLoading" class="flex items-center justify-center">
                                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Creating Account...
                                </span>
                            </button>
                            
                            {{-- Divider --}}
                            <div class="relative">
                                <div class="absolute inset-0 flex items-center">
                                    <div class="w-full border-t border-gray-200"></div>
                                </div>
                                <div class="relative flex justify-center text-xs">
                                    <span class="px-4 bg-white text-gray-500 font-medium">OR CONTINUE WITH</span>
                                </div>
                            </div>
                            
                            {{-- Google Login Button --}}
                            <a href="{{ route('auth.google') }}" 
                               class="w-full flex items-center justify-center px-4 py-3 bg-white border border-gray-200 rounded-full text-gray-700 font-bold hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-900/10 transition-all duration-200 group">
                                <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform duration-200" viewBox="0 0 24 24">
                                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                                </svg>
                                Continue with Google
                            </a>
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

        validateLoginEmail() {
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (this.loginForm.email && !emailPattern.test(this.loginForm.email)) {
                this.loginErrors.email = 'Please enter a valid email address.';
            } else {
                delete this.loginErrors.email;
            }
        },

        validateLoginPassword() {
            const allowedPassword = /^[A-Za-z0-9@_&$]{8,12}$/;
            if (this.loginForm.password && !allowedPassword.test(this.loginForm.password)) {
                this.loginErrors.password = 'Password must be 8–12 chars; only letters, numbers, and @ _ & $ are allowed.';
            } else {
                delete this.loginErrors.password;
            }
        },

        async submitLogin() {
            this.isLoading = true;
            this.clearErrors();

            // Client-side validation
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            const allowedPassword = /^[A-Za-z0-9@_&$]{8,12}$/; // only letters, numbers and @ _ & $
            if (!emailPattern.test(this.loginForm.email)) {
                this.loginErrors.email = 'Please enter a valid email address.';
            }
            if (!this.loginForm.password || !allowedPassword.test(this.loginForm.password)) {
                this.loginErrors.password = 'Password must be 8–12 chars; only letters, numbers, and @ _ & $ are allowed.';
            }
            if (Object.keys(this.loginErrors).length > 0) {
                this.isLoading = false;
                return;
            }

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

            // Client-side validation
            const namePattern = /^[A-Za-z\s]+$/;
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            const allowedPassword = /^[A-Za-z0-9@_&$]{8,12}$/; // only letters, numbers and @ _ & $

            if (!namePattern.test(this.registerForm.name)) {
                this.registerErrors.name = 'Name can contain letters and spaces only.';
            }
            if (!emailPattern.test(this.registerForm.email)) {
                this.registerErrors.email = 'Please enter a valid email address.';
            }
            if (!this.registerForm.password || !allowedPassword.test(this.registerForm.password)) {
                this.registerErrors.password = 'Password must be 8–12 chars; only letters, numbers, and @ _ & $ are allowed.';
            }
            if (this.registerForm.password_confirmation !== this.registerForm.password) {
                this.registerErrors.password_confirmation = 'Passwords do not match.';
            }
            if (Object.keys(this.registerErrors).length > 0) {
                this.isLoading = false;
                return;
            }

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
