<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    {{ __('Report an Incident') }}
                </h2>
                <p class="mt-1 text-sm text-gray-600">
                    System-thinking analysis for patient safety improvement
                </p>
            </div>
            <div class="mt-4 sm:mt-0">
                <a href="{{ route('incidents.index') }}" 
                    class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Reports
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Progress Indicator -->
            <div class="mb-8">
                <div class="flex items-center justify-center space-x-4">
                    <div class="flex items-center">
                        <div class="flex items-center justify-center w-8 h-8 bg-indigo-600 text-white rounded-full text-sm font-medium" style="background-color: #4f46e5 !important; color: white !important;">
                            1
                        </div>
                        <span class="ml-2 text-sm font-medium text-gray-900" style="color: #111827 !important;">Basic Info</span>
                    </div>
                    <div class="flex-1 h-0.5 bg-gray-200"></div>
                    <div class="flex items-center">
                        <div class="flex items-center justify-center w-8 h-8 bg-gray-200 text-gray-600 rounded-full text-sm font-medium" style="background-color: #e5e7eb !important; color: #4b5563 !important;">
                            2
                        </div>
                        <span class="ml-2 text-sm font-medium text-gray-500" style="color: #6b7280 !important;">Details</span>
                    </div>
                    <div class="flex-1 h-0.5 bg-gray-200"></div>
                    <div class="flex items-center">
                        <div class="flex items-center justify-center w-8 h-8 bg-gray-200 text-gray-600 rounded-full text-sm font-medium" style="background-color: #e5e7eb !important; color: #4b5563 !important;">
                            3
                        </div>
                        <span class="ml-2 text-sm font-medium text-gray-500" style="color: #6b7280 !important;">Analysis</span>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
                <div class="bg-blue-600 px-6 py-8" style="background: linear-gradient(to right, #2563eb, #7c3aed) !important;">
                    <h3 class="text-2xl font-bold text-white mb-2" style="color: white !important;">Incident Reporting Form</h3>
                    <p class="text-indigo-100" style="color: #e0e7ff !important;">
                        This form guides system-thinking analysis to improve patient safety and care quality.
                    </p>
                </div>
                
                <div class="p-6 sm:p-8">

                    <form method="POST" action="{{ route('incidents.store') }}" class="space-y-8">
                        @csrf

                        <!-- Section 1: Basic Information -->
                        <div class="space-y-6">
                            <div class="border-l-4 border-indigo-500 pl-4">
                                <h4 class="text-lg font-semibold text-gray-900" style="color: #111827 !important;">Basic Information</h4>
                                <p class="text-sm text-gray-600" style="color: #4b5563 !important;">When and where did the incident occur?</p>
                            </div>

                            <!-- Date & Time -->
                            <div class="bg-gray-50 p-6 rounded-xl">
                                <label for="incident_date" class="block text-sm font-semibold text-gray-700 mb-2" style="color: #374151 !important;">
                                    Date & Time of Incident <span class="text-red-500" style="color: #ef4444 !important;">*</span>
                                </label>
                                <input id="incident_date" type="datetime-local" name="incident_date" 
                                    value="{{ old('incident_date') }}" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200">
                                <x-input-error :messages="$errors->get('incident_date')" class="mt-2" />
                                <p class="mt-2 text-sm text-amber-600 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    Do not include any patient identifiers
                                </p>
                            </div>


                            <!-- Department -->
                            <div class="bg-gray-50 p-6 rounded-xl">
                                <label for="department" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Clinical Rotation / Department <span class="text-red-500">*</span>
                                </label>
                                <select id="department" name="department" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200">
                                    <option value="">Select Department</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department }}" {{ old('department') == $department ? 'selected' : '' }}>
                                            {{ $department }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('department')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Section 2: Event Details -->
                        <div class="space-y-6">
                            <div class="border-l-4 border-purple-500 pl-4">
                                <h4 class="text-lg font-semibold text-gray-900">Event Details</h4>
                                <p class="text-sm text-gray-600">What type of incident occurred?</p>
                            </div>

                            <!-- Type of Event -->
                            <div class="bg-gray-50 p-6 rounded-xl">
                                <label for="event_type" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Type of Event <span class="text-red-500">*</span>
                                </label>
                                <select id="event_type" name="event_type" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200">
                                    <option value="">Select Event Type</option>
                                    @foreach($eventTypes as $eventType)
                                        <option value="{{ $eventType }}" {{ old('event_type') == $eventType ? 'selected' : '' }}>
                                            {{ $eventType }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('event_type')" class="mt-2" />
                            </div>

                            <!-- Event Type Explanation -->
                            <div class="bg-gray-50 p-6 rounded-xl">
                                <label for="event_type_explanation" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Event Type Explanation (Optional)
                                </label>
                                <textarea id="event_type_explanation" name="event_type_explanation" rows="3"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 resize-none"
                                    placeholder="Provide additional explanation for the selected event type...">{{ old('event_type_explanation') }}</textarea>
                                <x-input-error :messages="$errors->get('event_type_explanation')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Section 3: Incident Description -->
                        <div class="space-y-6">
                            <div class="border-l-4 border-red-500 pl-4">
                                <h4 class="text-lg font-semibold text-gray-900">Incident Description</h4>
                                <p class="text-sm text-gray-600">Describe what happened in detail</p>
                            </div>

                            <!-- What Happened -->
                            <div class="bg-red-50 border border-red-200 p-6 rounded-xl">
                                <label for="what_happened" class="block text-sm font-semibold text-gray-700 mb-2">
                                    What Happened? <span class="text-red-500">*</span>
                                </label>
                                <textarea id="what_happened" name="what_happened" rows="6" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 resize-none"
                                    placeholder="Provide a detailed description of what happened. Include timeline, sequence of events, and context. DO NOT include any patient identifiers, names, or personal information.">{{ old('what_happened') }}</textarea>
                                <x-input-error :messages="$errors->get('what_happened')" class="mt-2" />
                                
                                <!-- Enhanced PHI Warning -->
                                <div class="mt-4 p-4 bg-red-100 border border-red-300 rounded-lg">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <svg class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <h3 class="text-sm font-bold text-red-800 mb-2">
                                                🚨 Privacy Warning - No Patient Information
                                            </h3>
                                            <div class="text-sm text-red-700">
                                                <p class="mb-2 font-medium">DO NOT include any Protected Health Information (PHI):</p>
                                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-1 text-xs">
                                                    <div class="flex items-center">
                                                        <span class="w-1.5 h-1.5 bg-red-500 rounded-full mr-2"></span>
                                                        Patient names or initials
                                                    </div>
                                                    <div class="flex items-center">
                                                        <span class="w-1.5 h-1.5 bg-red-500 rounded-full mr-2"></span>
                                                        Medical record numbers
                                                    </div>
                                                    <div class="flex items-center">
                                                        <span class="w-1.5 h-1.5 bg-red-500 rounded-full mr-2"></span>
                                                        Social security numbers
                                                    </div>
                                                    <div class="flex items-center">
                                                        <span class="w-1.5 h-1.5 bg-red-500 rounded-full mr-2"></span>
                                                        Specific dates of birth
                                                    </div>
                                                    <div class="flex items-center">
                                                        <span class="w-1.5 h-1.5 bg-red-500 rounded-full mr-2"></span>
                                                        Addresses or phone numbers
                                                    </div>
                                                    <div class="flex items-center">
                                                        <span class="w-1.5 h-1.5 bg-red-500 rounded-full mr-2"></span>
                                                        Any patient identifiers
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section 4: System Analysis -->
                        <div class="space-y-6">
                            <div class="border-l-4 border-blue-500 pl-4">
                                <h4 class="text-lg font-semibold text-gray-900">System Analysis</h4>
                                <p class="text-sm text-gray-600">Analyze why this incident occurred</p>
                            </div>

                            <!-- Why Did It Happen -->
                            <div class="bg-blue-50 border border-blue-200 p-6 rounded-xl">
                                <label for="why_did_it_happen" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Why Did It Happen? (System Analysis) <span class="text-red-500">*</span>
                                </label>
                                <textarea id="why_did_it_happen" name="why_did_it_happen" rows="6" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 resize-none"
                                    placeholder="This is the key section for system analysis. Consider the Swiss Cheese Model and WHO concepts. Analyze the root causes, system failures, and contributing factors. Focus on system-level issues rather than individual blame.">{{ old('why_did_it_happen') }}</textarea>
                                <x-input-error :messages="$errors->get('why_did_it_happen')" class="mt-2" />
                                
                                <!-- Enhanced System Analysis Guidance -->
                                <div class="mt-4 p-4 bg-blue-100 border border-blue-300 rounded-lg">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <svg class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <h3 class="text-sm font-bold text-blue-800 mb-2">
                                                💡 System Analysis Guidance
                                            </h3>
                                            <div class="text-sm text-blue-700">
                                                <p class="mb-3 font-medium">Consider these frameworks:</p>
                                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                                    <div class="bg-white p-3 rounded-lg border border-blue-200">
                                                        <h4 class="font-semibold text-blue-800 mb-1">🧀 Swiss Cheese Model</h4>
                                                        <p class="text-xs text-blue-600">Multiple layers of defense with holes that aligned</p>
                                                    </div>
                                                    <div class="bg-white p-3 rounded-lg border border-blue-200">
                                                        <h4 class="font-semibold text-blue-800 mb-1">🏥 WHO Patient Safety</h4>
                                                        <p class="text-xs text-blue-600">System, human, and organizational factors</p>
                                                    </div>
                                                    <div class="bg-white p-3 rounded-lg border border-blue-200">
                                                        <h4 class="font-semibold text-blue-800 mb-1">🔍 Root Cause Analysis</h4>
                                                        <p class="text-xs text-blue-600">Why did each contributing factor exist?</p>
                                                    </div>
                                                    <div class="bg-white p-3 rounded-lg border border-blue-200">
                                                        <h4 class="font-semibold text-blue-800 mb-1">⚙️ System Thinking</h4>
                                                        <p class="text-xs text-blue-600">Focus on processes, not people</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section 5: Contributing Factors & Outcome -->
                        <div class="space-y-6">
                            <div class="border-l-4 border-green-500 pl-4">
                                <h4 class="text-lg font-semibold text-gray-900">Contributing Factors & Outcome</h4>
                                <p class="text-sm text-gray-600">Identify factors and assess the impact</p>
                            </div>

                            <!-- Contributing Factors -->
                            <div class="bg-green-50 border border-green-200 p-6 rounded-xl">
                                <label class="block text-sm font-semibold text-gray-700 mb-3">
                                    Contributing Factors
                                </label>
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                                    @foreach($contributingFactors as $factor)
                                        <label class="flex items-center p-3 bg-white rounded-lg border border-green-200 hover:bg-green-100 transition-colors duration-200 cursor-pointer">
                                            <input type="checkbox" name="contributing_factors[]" value="{{ $factor }}"
                                                {{ in_array($factor, old('contributing_factors', [])) ? 'checked' : '' }}
                                                class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                            <span class="ml-3 text-sm font-medium text-gray-700">{{ $factor }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <x-input-error :messages="$errors->get('contributing_factors')" class="mt-2" />
                            </div>

                            <!-- Outcome -->
                            <div class="bg-green-50 border border-green-200 p-6 rounded-xl">
                                <label for="outcome" class="block text-sm font-semibold text-gray-700 mb-2">
                                    What Was the Outcome? <span class="text-red-500">*</span>
                                </label>
                                <select id="outcome" name="outcome" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200">
                                    <option value="">Select Outcome</option>
                                    @foreach($outcomes as $outcome)
                                        <option value="{{ $outcome }}" {{ old('outcome') == $outcome ? 'selected' : '' }}>
                                            {{ $outcome }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('outcome')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Section 6: Prevention & Improvement -->
                        <div class="space-y-6">
                            <div class="border-l-4 border-purple-500 pl-4">
                                <h4 class="text-lg font-semibold text-gray-900">Prevention & Improvement</h4>
                                <p class="text-sm text-gray-600">Suggest ways to prevent similar incidents</p>
                            </div>

                            <!-- Prevention Suggestions -->
                            <div class="bg-purple-50 border border-purple-200 p-6 rounded-xl">
                                <label for="prevention_suggestions" class="block text-sm font-semibold text-gray-700 mb-2">
                                    What Could Prevent It? (Suggestions for Improvement)
                                </label>
                                <textarea id="prevention_suggestions" name="prevention_suggestions" rows="4"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 resize-none"
                                    placeholder="Suggest specific improvements, policy changes, training needs, or system modifications that could prevent similar incidents in the future.">{{ old('prevention_suggestions') }}</textarea>
                                <x-input-error :messages="$errors->get('prevention_suggestions')" class="mt-2" />
                                <p class="mt-2 text-sm text-purple-600 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                    </svg>
                                    Focus on actionable, specific improvements
                                </p>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex flex-col sm:flex-row items-center justify-between space-y-4 sm:space-y-0 sm:space-x-4 pt-8 border-t border-gray-200">
                            <div class="flex items-center text-sm text-gray-500">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                                Fields marked with <span class="text-red-500">*</span> are required
                            </div>
                            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-4 w-full sm:w-auto">
                                <a href="{{ route('incidents.index') }}" 
                                    class="inline-flex items-center justify-center px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Cancel
                                </a>
                                <button type="submit" 
                                    class="inline-flex items-center justify-center px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5"
                                    style="color: white !important; background-color: #2563eb !important;">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: white;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                    </svg>
                                    Submit Incident Report
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Modal (Hidden by default) -->
    <div id="successModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mt-2">Report Submitted!</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500">
                        Your incident report has been submitted successfully. Thank you for helping improve patient safety.
                    </p>
                </div>
                <div class="items-center px-4 py-3">
                    <button onclick="closeModal()" 
                        class="px-4 py-2 bg-indigo-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-300">
                        OK
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function closeModal() {
            document.getElementById('successModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
