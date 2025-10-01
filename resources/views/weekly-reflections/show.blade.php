<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight" style="color: #111827 !important;">
                    {{ __('Weekly Reflection') }}
                </h2>
                <p class="mt-1 text-sm text-gray-600" style="color: #4b5563 !important;">
                    Week of {{ $weeklyReflection->week_start_date->format('M d, Y') }}
                </p>
            </div>
            <div class="mt-4 sm:mt-0 flex space-x-2">
                <a href="{{ route('weekly-reflections.index') }}" 
                    class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Reflections
                </a>
                @can('update', $weeklyReflection)
                    <a href="{{ route('weekly-reflections.edit', $weeklyReflection) }}" 
                        class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit
                    </a>
                @endcan
                @can('delete', $weeklyReflection)
                    <button onclick="confirmDelete('{{ route('weekly-reflections.destroy', $weeklyReflection) }}', 'weekly reflection')" 
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
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
                <!-- Header -->
                <div class="bg-blue-600 px-6 py-8" style="background: linear-gradient(to right, #2563eb, #7c3aed) !important;">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h3 class="text-2xl font-bold text-white mb-2" style="color: white !important;">
                                Weekly Reflection
                            </h3>
                            <p class="text-indigo-100" style="color: #e0e7ff !important;">
                                {{ $weeklyReflection->week_start_date->format('M d') }} - {{ $weeklyReflection->week_end_date->format('M d, Y') }}
                            </p>
                        </div>
                        <div class="mt-4 sm:mt-0">
                            @if($weeklyReflection->submitted)
                                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Submitted
                                </span>
                            @else
                                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                    </svg>
                                    Draft
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="p-6 sm:p-8 space-y-8">
                    <!-- Clinical Rotation -->
                    <!-- Clinical Rotation -->
                    @if($weeklyReflection->clinicalRotation)
                        <div class="bg-gray-50 p-6 rounded-xl">
                            <h4 class="text-lg font-semibold text-gray-900 mb-2" style="color: #111827 !important;">Clinical Rotation</h4>
                            <div class="flex items-center space-x-2">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    {{ str_replace('Rotasi ', '', $weeklyReflection->clinicalRotation->rotation_title) }}
                                </span>
                            </div>
                        </div>
                    @endif

                    <!-- What went well this week in terms of quality and safety -->
                    <div class="bg-green-50 border border-green-200 p-6 rounded-xl">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4" style="color: #111827 !important;">
                            <span class="inline-flex items-center">
                                <svg class="w-5 h-5 mr-2 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                What went well this week in terms of quality and safety?
                            </span>
                        </h4>
                        <p class="text-gray-700 leading-relaxed" style="color: #374151 !important;">
                            {{ $weeklyReflection->what_went_well_quality_safety }}
                        </p>
                    </div>

                    <!-- What could I have done better? -->
                    <div class="bg-yellow-50 border border-yellow-200 p-6 rounded-xl">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4" style="color: #111827 !important;">
                            <span class="inline-flex items-center">
                                <svg class="w-5 h-5 mr-2 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                </svg>
                                What could I have done better?
                            </span>
                        </h4>
                        <p class="text-gray-700 leading-relaxed" style="color: #374151 !important;">
                            {{ $weeklyReflection->what_could_do_better }}
                        </p>
                    </div>

                    <!-- What did I learn about safe healthcare system this week? -->
                    <div class="bg-blue-50 border border-blue-200 p-6 rounded-xl">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4" style="color: #111827 !important;">
                            <span class="inline-flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                                What did I learn about safe healthcare system this week?
                            </span>
                        </h4>
                        <p class="text-gray-700 leading-relaxed" style="color: #374151 !important;">
                            {{ $weeklyReflection->what_learned_safe_healthcare }}
                        </p>
                    </div>

                    <!-- Goals for next week -->
                    <div class="bg-purple-50 border border-purple-200 p-6 rounded-xl">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4" style="color: #111827 !important;">
                            <span class="inline-flex items-center">
                                <svg class="w-5 h-5 mr-2 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.293l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z" clip-rule="evenodd"></path>
                                </svg>
                                Goals for next week
                            </span>
                        </h4>
                        <p class="text-gray-700 leading-relaxed" style="color: #374151 !important;">
                            {{ $weeklyReflection->goals_for_next_week }}
                        </p>
                    </div>

                    <!-- Supervisor Comments (if any) -->
                    @if($weeklyReflection->supervisor_comments)
                        <div class="bg-gray-50 border border-gray-200 p-6 rounded-xl">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4" style="color: #111827 !important;">
                                <span class="inline-flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 13V5a2 2 0 00-2-2H4a2 2 0 00-2 2v8a2 2 0 002 2h3l3 3 3-3h3a2 2 0 002-2zM5 7a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1zm1 3a1 1 0 100 2h3a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                    </svg>
                                    Supervisor Comments
                                </span>
                            </h4>
                            <p class="text-gray-700 leading-relaxed" style="color: #374151 !important;">
                                {{ $weeklyReflection->supervisor_comments }}
                            </p>
                            @if($weeklyReflection->supervisor_reviewed_at)
                                <p class="text-sm text-gray-500 mt-2" style="color: #6b7280 !important;">
                                    Reviewed on {{ $weeklyReflection->supervisor_reviewed_at->format('M d, Y \a\t g:i A') }}
                                </p>
                            @endif
                        </div>
                    @endif

                    <!-- Footer Info -->
                    <div class="border-t border-gray-200 pt-6">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between text-sm text-gray-500" style="color: #6b7280 !important;">
                            <div>
                                <p>Created by {{ $weeklyReflection->user->name }}</p>
                                <p>Created {{ $weeklyReflection->created_at->format('M d, Y \a\t g:i A') }}</p>
                            </div>
                            @if($weeklyReflection->submitted_at)
                                <div class="mt-2 sm:mt-0">
                                    <p>Submitted {{ $weeklyReflection->submitted_at->format('M d, Y \a\t g:i A') }}</p>
                                </div>
                            @endif
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
