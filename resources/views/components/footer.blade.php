<footer class="bg-gradient-to-r from-black via-gray-900 to-black relative overflow-hidden" style="background: linear-gradient(to right, #000000, #111827, #000000) !important;">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-20">
        <div class="absolute top-0 left-0 w-full h-full" style="background-image: url('data:image/svg+xml,%3Csvg width="40" height="40" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.1"%3E%3Cpath d="M20 20c0-5.5-4.5-10-10-10s-10 4.5-10 10 4.5 10 10 10 10-4.5 10-10zm10 0c0-5.5-4.5-10-10-10s-10 4.5-10 10 4.5 10 10 10 10-4.5 10-10z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    </div>
    
    <!-- Glow Effect -->
    <div class="absolute inset-0 bg-gradient-to-t from-transparent via-blue-900/10 to-transparent"></div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <!-- Copyright -->
            <div class="text-sm text-gray-300 mb-4 md:mb-0">
                © {{ date('Y') }} Settle Medical. All rights reserved.
            </div>
            
            <!-- Developer Info -->
            <div class="flex items-center space-x-4 text-sm">
                <span class="text-gray-300">Developed with</span>
                <span class="text-red-400 text-lg animate-pulse">❤️</span>
                <span class="text-gray-300">by</span>
                <a href="mailto:{{ config('developer.email') }}" 
                   class="font-bold text-white hover:text-blue-300 transition-all duration-300 hover:scale-105 bg-blue-600 px-3 py-1 rounded-lg hover:bg-blue-500">
                    {{ config('developer.name') }}
                </a>
                <span class="text-gray-500">•</span>
                <a href="https://wa.me/62{{ substr(config('developer.phone'), 1) }}?text=Halo%20Glenn,%20saya%20tertarik%20dengan%20layanan%20development%20Anda" 
                   class="text-green-400 hover:text-green-300 transition-all duration-300 hover:scale-105 font-medium"
                   target="_blank">
                    WhatsApp
                </a>
                <span class="text-gray-500">•</span>
                <a href="mailto:{{ config('developer.email') }}?subject=Inquiry%20for%20Development" 
                   class="text-blue-400 hover:text-blue-300 transition-all duration-300 hover:scale-105 font-medium">
                    Email
                </a>
            </div>
        </div>
        
        <!-- Bottom accent line -->
        <div class="mt-6 pt-4 border-t border-gray-800">
            <div class="flex justify-center">
                <div class="flex space-x-3">
                    <div class="w-3 h-3 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full animate-pulse shadow-lg shadow-blue-500/50"></div>
                    <div class="w-3 h-3 bg-gradient-to-r from-green-500 to-green-600 rounded-full animate-pulse shadow-lg shadow-green-500/50" style="animation-delay: 0.3s;"></div>
                    <div class="w-3 h-3 bg-gradient-to-r from-purple-500 to-purple-600 rounded-full animate-pulse shadow-lg shadow-purple-500/50" style="animation-delay: 0.6s;"></div>
                    <div class="w-3 h-3 bg-gradient-to-r from-red-500 to-pink-500 rounded-full animate-pulse shadow-lg shadow-red-500/50" style="animation-delay: 0.9s;"></div>
                </div>
            </div>
        </div>
    </div>
</footer>
