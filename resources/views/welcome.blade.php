<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Settle Medical - Sistem Manajemen Rotasi Klinis</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logos/logo_settle.jpeg') }}">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            body { font-family: 'Inter', sans-serif; }
            .gradient-text { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        </style>
    @endif
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50">
    <!-- Navigation -->
    <nav class="bg-white/80 backdrop-blur-md shadow-sm border-b border-gray-200/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('images/logos/logo_settle.jpeg') }}" alt="Settle Medical" class="h-10 w-10 rounded-lg shadow-sm object-cover">
                    <div>
                        <h1 class="text-xl font-bold gradient-text">Settle Medical</h1>
                        <p class="text-xs text-gray-500">Sistem Manajemen Rotasi Klinis</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-medium rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                            </svg>
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 text-gray-600 hover:text-blue-600 font-medium transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                            </svg>
                            Masuk
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-medium rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                </svg>
                                Daftar
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-50 via-white to-indigo-50">
            <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23667eea" fill-opacity="0.05"%3E%3Ccircle cx="30" cy="30" r="2"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-50"></div>
        </div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="text-center">
                <!-- Logo -->
                <div class="flex justify-center mb-8">
                    <div class="relative">
                        <img src="{{ asset('images/logos/logo_settle.jpeg') }}" alt="Settle Medical Logo" class="h-32 w-32 rounded-2xl shadow-2xl border-4 border-white object-cover">
                        <div class="absolute inset-0 rounded-2xl bg-gradient-to-r from-blue-600/20 to-indigo-600/20"></div>
                    </div>
                </div>
                
                <!-- Title -->
                <h1 class="text-5xl md:text-6xl font-bold text-gray-900 mb-6">
                    <span class="gradient-text">Settle Medical</span>
                </h1>
                
                <!-- Subtitle -->
                <p class="text-xl md:text-2xl text-gray-600 mb-8 max-w-3xl mx-auto leading-relaxed">
                    Sistem Manajemen Rotasi Klinis untuk Fakultas Kedokteran
                    <br>
                    <span class="text-lg text-gray-500">Sam Ratulangi University</span>
                </p>
                
                <!-- Description -->
                <div class="max-w-4xl mx-auto mb-12">
                    <div class="bg-white/70 backdrop-blur-sm rounded-2xl p-8 shadow-xl border border-white/50">
                        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Selamat Datang di Sistem Manajemen Rotasi Klinis</h2>
                        <p class="text-gray-600 leading-relaxed mb-6">
                            Settle Medical adalah platform digital yang dirancang khusus untuk memudahkan pengelolaan rotasi klinis mahasiswa kedokteran. 
                            Dengan sistem yang terintegrasi, Anda dapat mengelola jadwal rotasi, melacak progress pembelajaran, dan memastikan pengalaman klinis yang optimal.
                        </p>
                        
                        <!-- Features -->
                        <div class="grid md:grid-cols-3 gap-6 mt-8">
                            <div class="text-center p-4">
                                <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                </div>
                                <h3 class="font-semibold text-gray-800 mb-2">Manajemen Rotasi</h3>
                                <p class="text-sm text-gray-600">Kelola jadwal rotasi klinis dengan mudah dan efisien</p>
                            </div>
                            
                            <div class="text-center p-4">
                                <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-teal-500 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                                <h3 class="font-semibold text-gray-800 mb-2">Tracking Progress</h3>
                                <p class="text-sm text-gray-600">Pantau kemajuan pembelajaran mahasiswa secara real-time</p>
                            </div>
                            
                            <div class="text-center p-4">
                                <div class="w-16 h-16 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </div>
                                <h3 class="font-semibold text-gray-800 mb-2">Evaluasi Terpadu</h3>
                                <p class="text-sm text-gray-600">Sistem evaluasi komprehensif untuk pembelajaran klinis</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                            </svg>
                            Buka Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                            </svg>
                            Masuk ke Sistem
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="inline-flex items-center px-8 py-4 bg-white text-blue-600 font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 border-2 border-blue-600">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                </svg>
                                Daftar Sekarang
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid md:grid-cols-4 gap-8">
                <div class="md:col-span-2">
                    <div class="flex items-center space-x-3 mb-4">
                        <img src="{{ asset('images/logos/logo_settle.jpeg') }}" alt="Settle Medical" class="h-12 w-12 rounded-lg shadow-sm object-cover">
                        <div>
                            <h3 class="text-xl font-bold gradient-text">Settle Medical</h3>
                            <p class="text-sm text-gray-500">Sistem Manajemen Rotasi Klinis</p>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-4 max-w-md">
                        Platform digital terintegrasi untuk pengelolaan rotasi klinis mahasiswa kedokteran Fakultas Kedokteran Sam Ratulangi University.
                    </p>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-900 mb-4">Menu Utama</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ url('/dashboard') }}" class="text-gray-600 hover:text-blue-600 transition-colors duration-200">Dashboard</a></li>
                        <li><a href="{{ url('/clinical-rotations') }}" class="text-gray-600 hover:text-blue-600 transition-colors duration-200">Rotasi Klinis</a></li>
                        <li><a href="{{ url('/students') }}" class="text-gray-600 hover:text-blue-600 transition-colors duration-200">Mahasiswa</a></li>
                        <li><a href="{{ url('/users') }}" class="text-gray-600 hover:text-blue-600 transition-colors duration-200">Manajemen User</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-900 mb-4">Kontak</h4>
                    <ul class="space-y-2 text-gray-600">
                        <li>📧 medicalsettle@gmail.com</li>
                        <li>🏥 Fakultas Kedokteran</li>
                        <li>🎓 Sam Ratulangi University</li>
                        <li>📍 Manado, Sulawesi Utara</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-200 mt-8 pt-8 text-center">
                <p class="text-gray-500 text-sm">
                    © {{ date('Y') }} Settle Medical. Semua hak dilindungi undang-undang.
                    <br>
                    Dikembangkan untuk Fakultas Kedokteran Sam Ratulangi University.
                </p>
            </div>
        </div>
    </footer>
</body>
</html>


