<x-guest-layout>
    <div class="min-h-screen bg-white flex">
        <!-- Left Column - Logo and Branding -->
        <div class="hidden lg:flex lg:w-1/2 bg-white items-center justify-center p-8">
            <div class="text-center max-w-md">
                <!-- Logo Section -->
                <img src="{{ asset('images/logos/logo_settle.png') }}" 
                     alt="Settle Medical" 
                     class="h-80 w-80 mx-auto object-contain mb-8">
                
                <!-- Branding Section -->
                <div class="space-y-4">
                    <h1 class="text-5xl font-bold text-gray-900 mb-0">
                        SETTLE
                    </h1>
                    <p class="text-2xl font-normal text-gray-800 mb-0" style="font-family: 'Poppins', sans-serif;">
                        System Thinking & Learning
                    </p>
                    <p class="text-2xl font-medium text-yellow-500" style="font-family: 'Poppins', sans-serif;">
                        From Error
                    </p>
                    <p class="text-lg text-gray-600 mt-6 leading-relaxed">
                        Sistem Manajemen Rotasi Klinis untuk Pendidikan Kedokteran
                    </p>
                </div>
            </div>
        </div>

        <!-- Right Column - Login Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8">
            <div class="w-full max-w-md">
                <!-- Mobile Logo (shown only on mobile) -->
                <div class="lg:hidden text-center mb-8">
                    <img src="{{ asset('images/logos/logo_settle.png') }}" 
                         alt="Settle Medical" 
                         class="h-32 w-32 mx-auto object-contain mb-4">
                    <h1 class="text-2xl font-bold text-gray-900">SETTLE</h1>
                </div>

                <!-- Login Form Card -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8">
                    <!-- Form Title -->
                    <div class="text-center mb-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">
                            Masuk ke Akun Anda
                        </h2>
                        <p class="text-gray-600 text-sm">
                            Silakan masukkan email dan password untuk melanjutkan
                        </p>
                    </div>

                    <!-- Session Status -->
                @if (session('status'))
                    <div class="mb-8 p-6 bg-green-50 border border-green-200 rounded-lg">
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <p class="text-green-800 text-sm font-medium">
                                {{ session('status') }}
                            </p>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-8">
                    @csrf

                    <!-- Email Address -->
                    <div class="px-2">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-4">
                            Email Address
                        </label>
                        <input 
                            id="email" 
                            type="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required 
                            autofocus
                            autocomplete="username"
                            class="w-full px-6 py-4 border rounded-lg focus:ring-2 transition-colors duration-200 {{ $errors->has('email') ? 'border-red-300 focus:ring-red-500 focus:border-red-500' : 'border-blue-200/50 focus:ring-blue-500 focus:border-blue-500' }}"
                            placeholder="Masukkan email Anda"
                        />
                        @error('email')
                            <p class="mt-3 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="px-2">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-4">
                            Password
                        </label>
                        <input 
                            id="password" 
                            type="password" 
                            name="password" 
                            required 
                            autocomplete="current-password"
                            class="w-full px-6 py-4 border rounded-lg focus:ring-2 transition-colors duration-200 {{ $errors->has('password') ? 'border-red-300 focus:ring-red-500 focus:border-red-500' : 'border-blue-200/50 focus:ring-blue-500 focus:border-blue-500' }}"
                            placeholder="Masukkan password Anda"
                        />
                        @error('password')
                            <p class="mt-3 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between px-2">
                        <label for="remember_me" class="inline-flex items-center">
                            <input 
                                id="remember_me" 
                                type="checkbox" 
                                name="remember"
                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            >
                            <span class="ml-3 text-sm text-gray-600">Ingat saya</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" 
                               class="text-sm text-blue-600 hover:text-blue-700 font-medium transition-colors duration-200">
                                Lupa password?
                            </a>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <div class="px-2 pt-4">
                        <button type="submit" 
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-4 px-6 rounded-lg transition-colors duration-200">
                            Masuk
                        </button>
                    </div>
                </form>

                <!-- Register Link -->
                @if (Route::has('register'))
                    <div class="mt-8 text-center px-2">
                        <p class="text-sm text-gray-600">
                            Belum punya akun?
                            <a href="{{ route('register') }}" 
                               class="font-medium text-blue-600 hover:text-blue-700 transition-colors duration-200">
                                Daftar sekarang
                            </a>
                        </p>
                    </div>
                @endif
                </div>

                <!-- Footer -->
                <div class="mt-6 text-center">
                    <p class="text-xs text-gray-500">
                        © {{ date('Y') }} Settle Medical. Sistem Manajemen Rotasi Klinis.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>