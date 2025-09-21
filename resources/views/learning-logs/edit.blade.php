<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight" style="color: #111827 !important;">
                    {{ __('Edit Learning Log') }}
                </h2>
                <p class="mt-1 text-sm text-gray-600" style="color: #4b5563 !important;">
                    {{ $learningLog->topic_keyword }} - {{ $learningLog->date->format('M d, Y') }}
                </p>
            </div>
            <div class="mt-4 sm:mt-0">
                <a href="{{ route('learning-logs.show', $learningLog) }}" 
                    class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Learning Log
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
                <div class="bg-green-600 px-6 py-8" style="background: linear-gradient(to right, #059669, #10b981) !important;">
                    <h3 class="text-2xl font-bold text-white mb-2" style="color: white !important;">Edit Learning Log</h3>
                    <p class="text-green-100" style="color: #d1fae5 !important;">
                        Update your learning log for {{ $learningLog->date->format('M d, Y') }}
                    </p>
                </div>
                
                <div class="p-6 sm:p-8">
                    <form method="POST" action="{{ route('learning-logs.update', $learningLog) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Date -->
                        <div class="space-y-4">
                            <div class="border-l-4 border-green-500 pl-4">
                                <h4 class="text-lg font-semibold text-gray-900" style="color: #111827 !important;">Date</h4>
                                <p class="text-sm text-gray-600" style="color: #4b5563 !important;">When did this learning occur?</p>
                            </div>

                            <div class="bg-gray-50 p-6 rounded-xl">
                                <label for="date" class="block text-sm font-semibold text-gray-700 mb-2" style="color: #374151 !important;">
                                    Date <span class="text-red-500" style="color: #ef4444 !important;">*</span>
                                </label>
                                <input id="date" type="date" name="date" 
                                    value="{{ old('date', $learningLog->date->format('Y-m-d')) }}" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200">
                                <x-input-error :messages="$errors->get('date')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Clinical Rotation (Optional) -->
                        <div class="space-y-4">
                            <div class="border-l-4 border-blue-500 pl-4">
                                <h4 class="text-lg font-semibold text-gray-900" style="color: #111827 !important;">Clinical Rotation</h4>
                                <p class="text-sm text-gray-600" style="color: #4b5563 !important;">Select the clinical rotation for this learning log</p>
                            </div>

                            <div class="bg-gray-50 p-6 rounded-xl">
                                <label for="clinical_rotation_id" class="block text-sm font-semibold text-gray-700 mb-2" style="color: #374151 !important;">
                                    Clinical Rotation <span class="text-red-500" style="color: #ef4444 !important;">*</span>
                                </label>
                                <select id="clinical_rotation_id" name="clinical_rotation_id" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200">
                                    <option value="">Select Clinical Rotation</option>
                                    @foreach($rotations as $rotation)
                                        <option value="{{ $rotation->id }}" {{ old('clinical_rotation_id', $learningLog->clinical_rotation_id) == $rotation->id ? 'selected' : '' }}>
                                            {{ $rotation->rotation_title }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('clinical_rotation_id')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Topic/Keyword -->
                        <div class="space-y-4">
                            <div class="border-l-4 border-purple-500 pl-4">
                                <h4 class="text-lg font-semibold text-gray-900" style="color: #111827 !important;">Topic/Keyword</h4>
                                <p class="text-sm text-gray-600" style="color: #4b5563 !important;">What was the main topic or keyword for this learning?</p>
                            </div>

                            <div class="bg-gray-50 p-6 rounded-xl">
                                <label for="topic_keyword" class="block text-sm font-semibold text-gray-700 mb-2" style="color: #374151 !important;">
                                    Topic/Keyword <span class="text-red-500" style="color: #ef4444 !important;">*</span>
                                </label>
                                <input id="topic_keyword" type="text" name="topic_keyword" 
                                    value="{{ old('topic_keyword', $learningLog->topic_keyword) }}" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200"
                                    placeholder="e.g., Patient Safety, Medication Administration, Communication Skills, etc.">
                                <x-input-error :messages="$errors->get('topic_keyword')" class="mt-2" />
                                <p class="mt-2 text-sm text-gray-500" style="color: #6b7280 !important;">
                                    💡 Keep it short and specific - this helps with searching later
                                </p>
                            </div>
                        </div>

                        <!-- What I Learned -->
                        <div class="space-y-4">
                            <div class="border-l-4 border-yellow-500 pl-4">
                                <h4 class="text-lg font-semibold text-gray-900" style="color: #111827 !important;">What I Learned</h4>
                                <p class="text-sm text-gray-600" style="color: #4b5563 !important;">Describe your "Aha!" moment or key learning</p>
                            </div>

                            <div class="bg-yellow-50 border border-yellow-200 p-6 rounded-xl">
                                <label for="what_learned" class="block text-sm font-semibold text-gray-700 mb-2" style="color: #374151 !important;">
                                    What I Learned <span class="text-red-500" style="color: #ef4444 !important;">*</span>
                                </label>
                                <textarea id="what_learned" name="what_learned" rows="6" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200 resize-none"
                                    placeholder="Describe your key learning, insight, or "Aha!" moment. What was the most important thing you learned today?">{{ old('what_learned', $learningLog->what_learned) }}</textarea>
                                <x-input-error :messages="$errors->get('what_learned')" class="mt-2" />
                                
                                <!-- Learning Tips -->
                                <div class="mt-4 p-4 bg-yellow-100 border border-yellow-300 rounded-lg">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <svg class="h-6 w-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <h3 class="text-sm font-bold text-yellow-800 mb-2">
                                                💡 Learning Log Tips
                                            </h3>
                                            <div class="text-sm text-yellow-700">
                                                <ul class="list-disc list-inside space-y-1">
                                                    <li>Focus on one key learning per entry</li>
                                                    <li>Include specific examples or situations</li>
                                                    <li>Note how this learning applies to patient safety</li>
                                                    <li>Keep it concise but meaningful</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex flex-col sm:flex-row items-center justify-between space-y-4 sm:space-y-0 sm:space-x-4 pt-8 border-t border-gray-200">
                            <div class="flex items-center text-sm text-gray-500" style="color: #6b7280 !important;">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                                Fields marked with <span class="text-red-500" style="color: #ef4444 !important;">*</span> are required
                            </div>
                            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-4 w-full sm:w-auto">
                                <a href="{{ route('learning-logs.show', $learningLog) }}" 
                                    class="inline-flex items-center justify-center px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Cancel
                                </a>
                                <button type="submit" 
                                    class="inline-flex items-center justify-center px-8 py-3 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5"
                                    style="color: white !important; background-color: #059669 !important;">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: white;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Update Learning Log
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
