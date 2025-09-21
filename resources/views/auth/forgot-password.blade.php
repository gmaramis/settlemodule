<x-guest-layout>
    <div class="min-h-screen bg-white flex items-center justify-center py-0 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-0">
            <!-- Logo dan Branding -->
            <div class="text-center">
                <!-- Logo -->
                <img src="{{ asset('images/logos/logo_settle.png') }}" alt="Settle Medical" class="h-60 w-60 mx-auto object-contain mb-0">
                
                <!-- Branding Text -->
                <div class="mb-0">
                    <h1 class="text-4xl font-bold tracking-tight mb-0">
                        SETTLE
                    </h1>
                    <p class="text-lg leading-relaxed">
                        <span class="text-black">System Thinking & Learning</span>
                        <br>
                        <span class="text-yellow-500 font-semibold">From Error</span>
                    </p>
                </div>

                <h2 class="text-2xl font-bold text-gray-900 mb-2">
                    Lupa Password?
                </h2>
                <p class="text-gray-600 text-sm leading-relaxed">
                    Jangan khawatir! Masukkan email Anda dan kami akan mengirimkan link reset password untuk membuat password baru.
                </p>
    </div>

            <!-- Form Card -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
    <!-- Session Status -->
                @if (session('status'))
                    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
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

                <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                            Email Address
                        </label>
                        <div class="relative">
                            <input 
                                id="email" 
                                type="email" 
                                name="email" 
                                value="{{ old('email') }}" 
                                required 
                                autofocus
                                class="w-full px-4 py-3 border rounded-lg transition-colors duration-200 focus:ring-2 {{ $errors->has('email') ? 'border-red-300 focus:ring-red-500 focus:border-red-500' : 'border-blue-200/50 focus:ring-blue-500 focus:border-blue-500' }}"
                                placeholder="Masukkan email Anda"
                            />
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                </svg>
                            </div>
                        </div>
                        @error('email')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit" 
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg shadow-lg hover:shadow-xl transform hover:scale-[1.02] transition-all duration-200 flex items-center justify-center">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            Kirim Link Reset Password
                        </button>
                    </div>
                </form>

                <!-- Back to Login -->
                <div class="mt-6 text-center">
                    <a href="{{ route('login') }}" 
                       class="inline-flex items-center text-sm text-gray-600 hover:text-blue-600 transition-colors duration-200">
                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali ke Login
                    </a>
                </div>
        </div>

            <!-- Footer -->
            <div class="text-center">
                <p class="text-xs text-gray-500">
                    © {{ date('Y') }} Settle Medical. Sistem Manajemen Rotasi Klinis.
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>
