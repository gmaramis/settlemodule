<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Settle Medical') }}</title>
        <link rel="icon" type="image/x-icon" href="{{ asset('images/logos/logo_settle.ico') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <!-- Footer -->
        <x-footer />

        <!-- Toast Messages -->
        @if(session('profile_completion_reminder'))
            <div id="profile-toast" class="fixed top-4 right-4 bg-blue-500 text-white px-6 py-4 rounded-lg shadow-lg z-50 max-w-sm">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium">
                            Profile belum lengkap!
                        </p>
                        <p class="text-xs mt-1">
                            Silakan lengkapi informasi profile Anda untuk pengalaman yang lebih baik.
                        </p>
                        <div class="mt-2">
                            <a href="{{ route('profile.edit') }}" class="text-xs bg-white text-blue-500 px-3 py-1 rounded hover:bg-gray-100 transition duration-200">
                                Update Profile
                            </a>
                            <button onclick="closeToast()" class="text-xs ml-2 text-blue-200 hover:text-white">
                                Dismiss
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Scripts Stack -->
        @stack('scripts')
        
        <script>
            function closeToast() {
                document.getElementById('profile-toast').style.display = 'none';
            }
            
            // Auto-hide toast after 10 seconds
            @if(session('profile_completion_reminder'))
                setTimeout(function() {
                    const toast = document.getElementById('profile-toast');
                    if (toast) {
                        toast.style.display = 'none';
                    }
                }, 10000);
            @endif
        </script>
    </body>
</html>
