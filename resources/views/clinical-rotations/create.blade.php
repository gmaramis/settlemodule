<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-4 sm:space-y-0">
            <div class="text-center sm:text-left">
                <h2 class="font-bold text-2xl sm:text-3xl text-gray-900 leading-tight">
                    🏥 Create Clinical Rotation
                </h2>
                <p class="text-sm sm:text-base text-gray-600 mt-1">Start your clinical learning journey</p>
            </div>
            <a href="{{ route('clinical-rotations.index') }}" 
               class="inline-flex items-center justify-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-all duration-200 transform hover:scale-105">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span class="hidden sm:inline">Back to List</span>
                <span class="sm:hidden">Back</span>
            </a>
        </div>
    </x-slot>

    <div class="py-4 sm:py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center animate-fade-in">
                    <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Main Card -->
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-3xl transform hover:scale-[1.02] transition-all duration-300">
                <!-- Header with Gradient -->
                <div class="bg-gradient-to-br from-blue-500 via-indigo-600 to-purple-700 px-4 sm:px-6 py-8 sm:py-12 relative overflow-hidden">
                    <!-- Background Pattern -->
                    <div class="absolute inset-0 opacity-10">
                        <div class="absolute top-0 left-0 w-full h-full" style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.1"%3E%3Ccircle cx="30" cy="30" r="4"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
                    </div>
                    
                    <div class="relative z-10 flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-6">
                        <!-- Icon -->
                        <div class="bg-white bg-opacity-20 p-4 sm:p-6 rounded-2xl transform rotate-3 hover:rotate-0 transition-transform duration-300">
                            <svg class="w-8 h-8 sm:w-12 sm:h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        
                        <!-- Text Content -->
                        <div class="text-center sm:text-left">
                            <h3 class="text-xl sm:text-2xl lg:text-3xl font-bold text-white mb-2">
                                Clinical Rotation Setup
                            </h3>
                            <p class="text-blue-100 text-sm sm:text-base">
                                Enter your rotation details below to get started
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Form Content -->
                <div class="p-6 sm:p-8 lg:p-12">
                    <form method="POST" action="{{ route('clinical-rotations.store') }}" class="space-y-6 sm:space-y-8">
                        @csrf

                        <!-- Rotation Title -->
                        <div class="space-y-3 sm:space-y-4">
                            <label for="rotation_title" class="block text-sm sm:text-base font-semibold text-gray-700">
                                <span class="flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Rotation Title
                                    <span class="text-red-500 ml-1">*</span>
                                </span>
                            </label>
                            
                            <div class="relative group">
                                <input type="text" 
                                       id="rotation_title" 
                                       name="rotation_title" 
                                       value="{{ old('rotation_title') }}" 
                                       required
                                       class="w-full px-4 sm:px-6 py-3 sm:py-4 border-2 border-gray-200 rounded-xl sm:rounded-2xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 text-gray-700 text-sm sm:text-base group-hover:border-blue-300">
                                
                                <!-- Input Icon -->
                                <div class="absolute inset-y-0 right-0 flex items-center pr-4">
                                    <svg class="w-5 h-5 text-gray-400 group-focus-within:text-blue-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </div>
                            </div>
                            
                            <x-input-error :messages="$errors->get('rotation_title')" class="mt-1" />
                            
                            <!-- Help Text -->
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 sm:p-4">
                                <p class="text-xs sm:text-sm text-blue-800 flex items-start">
                                    <svg class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>💡 <strong>Tip:</strong> Enter the department name (e.g., "Ilmu Bedah", "Ilmu Anak", "Ilmu Penyakit Dalam")</span>
                                </p>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4 pt-6 sm:pt-8 border-t border-gray-100">
                            <a href="{{ route('clinical-rotations.index') }}" 
                               class="inline-flex items-center justify-center px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-all duration-200 transform hover:scale-105 hover:shadow-md">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="inline-flex items-center justify-center px-8 py-3 sm:py-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 hover:-translate-y-0.5 transition-all duration-200 text-sm sm:text-base">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Create Rotation
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Help Section -->
            <div class="mt-6 sm:mt-8 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-2xl p-4 sm:p-6 transform hover:scale-[1.02] transition-all duration-300">
                <div class="flex flex-col sm:flex-row items-start space-y-4 sm:space-y-0 sm:space-x-4">
                    <div class="bg-blue-100 p-3 rounded-xl flex-shrink-0">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-semibold text-blue-900 mb-3 text-sm sm:text-base">💡 Quick Tips</h4>
                        <ul class="text-xs sm:text-sm text-blue-800 space-y-2">
                            <li class="flex items-start">
                                <span class="text-blue-500 mr-2">•</span>
                                <span>Enter the department name where you'll be rotating</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-blue-500 mr-2">•</span>
                                <span>Example: "Ilmu Bedah", "Ilmu Anak", "Ilmu Penyakit Dalam"</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-blue-500 mr-2">•</span>
                                <span>You can add more details later in the rotation settings</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Additional Info Cards -->
            <div class="mt-6 sm:mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                <!-- Card 1 -->
                <div class="bg-white border border-gray-200 rounded-xl p-4 sm:p-6 shadow-sm hover:shadow-md transition-all duration-300">
                    <div class="flex items-center mb-3">
                        <div class="bg-green-100 p-2 rounded-lg">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h5 class="font-semibold text-gray-900 ml-3 text-sm sm:text-base">Simple Setup</h5>
                    </div>
                    <p class="text-xs sm:text-sm text-gray-600">Just one field to get started with your clinical rotation</p>
                </div>

                <!-- Card 2 -->
                <div class="bg-white border border-gray-200 rounded-xl p-4 sm:p-6 shadow-sm hover:shadow-md transition-all duration-300">
                    <div class="flex items-center mb-3">
                        <div class="bg-blue-100 p-2 rounded-lg">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path>
                            </svg>
                        </div>
                        <h5 class="font-semibold text-gray-900 ml-3 text-sm sm:text-base">Flexible</h5>
                    </div>
                    <p class="text-xs sm:text-sm text-gray-600">Add more details and settings after creation</p>
                </div>

                <!-- Card 3 -->
                <div class="bg-white border border-gray-200 rounded-xl p-4 sm:p-6 shadow-sm hover:shadow-md transition-all duration-300 sm:col-span-2 lg:col-span-1">
                    <div class="flex items-center mb-3">
                        <div class="bg-purple-100 p-2 rounded-lg">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h5 class="font-semibold text-gray-900 ml-3 text-sm sm:text-base">Quick Start</h5>
                    </div>
                    <p class="text-xs sm:text-sm text-gray-600">Get your rotation up and running in seconds</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom CSS for animations -->
    <style>
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-fade-in {
            animation: fade-in 0.5s ease-out;
        }
        
        /* Smooth transitions for all interactive elements */
        * {
            transition: all 0.2s ease-in-out;
        }
        
        /* Custom focus styles */
        input:focus {
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }
        
        /* Hover effects for cards */
        .hover\:scale-\[1\.02\]:hover {
            transform: scale(1.02);
        }
    </style>
</x-app-layout>