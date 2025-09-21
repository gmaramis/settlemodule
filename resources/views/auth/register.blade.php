<x-guest-layout>
    <div class="min-h-screen bg-white flex items-center justify-center py-0 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-0">
            <!-- Header Section -->
            <div class="text-center">
                <!-- Logo Section -->
                <img src="{{ asset('images/logos/logo_settle.png') }}" 
                     alt="Settle Medical" 
                     class="h-60 w-60 mx-auto object-contain mb-0">
                
                <!-- Branding Section -->
                <div class="mb-0">
                    <h1 class="text-3xl font-bold text-gray-900 mb-0">
                        SETTLE
                    </h1>
                    <p class="text-lg font-normal text-gray-800 mb-0" style="font-family: 'Poppins', sans-serif; font-size: 25px;">
                        System Thinking & Learning
                    </p>
                    <p class="text-lg font-medium text-yellow-500" style="font-family: 'Poppins', sans-serif; font-size: 25px;">
                        From Error
                    </p>
                </div>
            </div>

            <!-- Register Form Card -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
                <form method="POST" action="{{ route('register') }}" class="space-y-8">
                    @csrf

                    <!-- Name -->
                    <div class="px-2">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-4">
                            Nama Lengkap
                        </label>
                        <input 
                            id="name" 
                            type="text" 
                            name="name" 
                            value="{{ old('name') }}" 
                            required 
                            autofocus
                            autocomplete="name"
                            class="w-full px-6 py-4 border rounded-lg focus:ring-2 transition-colors duration-200 {{ $errors->has('name') ? 'border-red-300 focus:ring-red-500 focus:border-red-500' : 'border-blue-200/50 focus:ring-blue-500 focus:border-blue-500' }}"
                            placeholder="Masukkan nama lengkap Anda"
                        />
                        @error('name')
                            <p class="mt-3 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

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

                    <!-- Phone Number -->
                    <div class="px-2">
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-4">
                            Nomor WhatsApp
                        </label>
                        <input 
                            id="phone" 
                            type="tel" 
                            name="phone" 
                            value="{{ old('phone') }}" 
                            required
                            autocomplete="tel"
                            class="w-full px-6 py-4 border rounded-lg focus:ring-2 transition-colors duration-200 {{ $errors->has('phone') ? 'border-red-300 focus:ring-red-500 focus:border-red-500' : 'border-blue-200/50 focus:ring-blue-500 focus:border-blue-500' }}"
                            placeholder="6281234567890 (contoh: 6281234567890)"
                        />
                        @error('phone')
                            <p class="mt-3 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="mt-3 text-xs text-gray-500">
                            Format: 6281234567890 (tanpa +, dimulai dengan 62)
                        </p>
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
                            autocomplete="new-password"
                            class="w-full px-6 py-4 border rounded-lg focus:ring-2 transition-colors duration-200 {{ $errors->has('password') ? 'border-red-300 focus:ring-red-500 focus:border-red-500' : 'border-blue-200/50 focus:ring-blue-500 focus:border-blue-500' }}"
                            placeholder="Masukkan password Anda"
                        />
                        @error('password')
                            <p class="mt-3 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="mt-3 text-xs text-gray-500">
                            Minimal 8 karakter, kombinasi huruf dan angka
                        </p>
                    </div>

                    <!-- Confirm Password -->
                    <div class="px-2">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-4">
                            Konfirmasi Password
                        </label>
                        <input 
                            id="password_confirmation" 
                            type="password" 
                            name="password_confirmation" 
                            required 
                            autocomplete="new-password"
                            class="w-full px-6 py-4 border rounded-lg focus:ring-2 transition-colors duration-200 {{ $errors->has('password_confirmation') ? 'border-red-300 focus:ring-red-500 focus:border-red-500' : 'border-blue-200/50 focus:ring-blue-500 focus:border-blue-500' }}"
                            placeholder="Ulangi password Anda"
                        />
                        @error('password_confirmation')
                            <p class="mt-3 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="px-2 pt-4">
                        <button type="submit" 
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-4 px-6 rounded-lg transition-colors duration-200">
                            Daftar Sekarang
                        </button>
                    </div>
                </form>

                <!-- Login Link -->
                <div class="mt-8 text-center px-2">
                    <p class="text-sm text-gray-600">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" 
                           class="font-medium text-blue-600 hover:text-blue-700 transition-colors duration-200">
                            Masuk di sini
                        </a>
                    </p>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center px-4">
                <p class="text-xs text-gray-500">
                    © {{ date('Y') }} Settle Medical. Sistem Manajemen Rotasi Klinis.
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>