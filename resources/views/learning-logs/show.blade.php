<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight" style="color: #111827 !important;">
                    {{ __('Learning Log') }}
                </h2>
                <p class="mt-1 text-sm text-gray-600" style="color: #4b5563 !important;">
                    {{ $learningLog->topic_keyword }} - {{ $learningLog->date->format('M d, Y') }}
                </p>
            </div>
            <div class="mt-4 sm:mt-0 flex space-x-2">
                <a href="{{ route('learning-logs.index') }}" 
                    class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Learning Logs
                </a>
                @can('update', $learningLog)
                    <a href="{{ route('learning-logs.edit', $learningLog) }}" 
                        class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit
                    </a>
                @endcan
                @can('delete', $learningLog)
                    <button onclick="confirmDelete('{{ route('learning-logs.destroy', $learningLog) }}', 'learning log')" 
                        class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Delete
                    </button>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
                <!-- Header -->
                <div class="bg-green-600 px-6 py-8" style="background: linear-gradient(to right, #059669, #10b981) !important;">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h3 class="text-2xl font-bold text-white mb-2" style="color: white !important;">
                                {{ $learningLog->topic_keyword }}
                            </h3>
                            <p class="text-green-100" style="color: #d1fae5 !important;">
                                Learning Log - {{ $learningLog->date->format('M d, Y') }}
                            </p>
                        </div>
                        <div class="mt-4 sm:mt-0">
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-white bg-opacity-20 text-white">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $learningLog->logged_at->format('M d, Y') }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="p-6 sm:p-8 space-y-6">
                    <!-- Clinical Rotation -->
                    <!-- Clinical Rotation -->
                    @if($learningLog->clinicalRotation)
                        <div class="bg-gray-50 p-6 rounded-xl">
                            <h4 class="text-lg font-semibold text-gray-900 mb-2" style="color: #111827 !important;">Clinical Rotation</h4>
                            <div class="flex items-center space-x-2">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    {{ $learningLog->clinicalRotation->rotation_title }}
                                </span>
                            </div>
                        </div>
                    @endif

                    <!-- What I Learned -->
                    <div class="bg-yellow-50 border border-yellow-200 p-6 rounded-xl">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4" style="color: #111827 !important;">
                            <span class="inline-flex items-center">
                                <svg class="w-5 h-5 mr-2 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" clip-rule="evenodd"></path>
                                </svg>
                                What I Learned
                            </span>
                        </h4>
                        <div class="prose max-w-none">
                            <p class="text-gray-700 leading-relaxed whitespace-pre-wrap" style="color: #374151 !important;">
                                {{ $learningLog->what_learned }}
                            </p>
                        </div>
                    </div>

                    <!-- Learning Insights -->
                    <div class="bg-green-50 border border-green-200 p-6 rounded-xl">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4" style="color: #111827 !important;">
                            <span class="inline-flex items-center">
                                <svg class="w-5 h-5 mr-2 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                                Learning Insights
                            </span>
                        </h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="bg-white p-4 rounded-lg border border-green-200">
                                <h5 class="font-medium text-gray-900 mb-2" style="color: #111827 !important;">Topic/Keyword</h5>
                                <p class="text-sm text-gray-600" style="color: #4b5563 !important;">{{ $learningLog->topic_keyword }}</p>
                            </div>
                            <div class="bg-white p-4 rounded-lg border border-green-200">
                                <h5 class="font-medium text-gray-900 mb-2" style="color: #111827 !important;">Learning Date</h5>
                                <p class="text-sm text-gray-600" style="color: #4b5563 !important;">{{ $learningLog->date->format('M d, Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Info -->
                    <div class="border-t border-gray-200 pt-6">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between text-sm text-gray-500" style="color: #6b7280 !important;">
                            <div>
                                <p>Created by {{ $learningLog->user->name }}</p>
                                <p>Created {{ $learningLog->created_at->format('M d, Y \a\t g:i A') }}</p>
                            </div>
                            <div class="mt-2 sm:mt-0">
                                <p>Logged {{ $learningLog->logged_at->format('M d, Y \a\t g:i A') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function confirmDelete(url, itemName) {
            if (confirm(`Are you sure you want to delete this ${itemName}? This action cannot be undone.`)) {
                // Create a form and submit it
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = url;
                
                // Add CSRF token
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = csrfToken;
                form.appendChild(csrfInput);
                
                // Add method override for DELETE
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                form.appendChild(methodInput);
                
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
    @endpush
</x-app-layout>
