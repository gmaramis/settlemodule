<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight" style="color: #111827 !important;">
                    {{ __('Edit Weekly Reflection') }}
                </h2>
                <p class="mt-1 text-sm text-gray-600" style="color: #4b5563 !important;">
                    Week of {{ $weeklyReflection->week_start_date->format('M d, Y') }}
                </p>
            </div>
            <div class="mt-4 sm:mt-0">
                <a href="{{ route('weekly-reflections.show', $weeklyReflection) }}" 
                    class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Reflection
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
                <div class="bg-blue-600 px-6 py-8" style="background: linear-gradient(to right, #2563eb, #7c3aed) !important;">
                    <h3 class="text-2xl font-bold text-white mb-2" style="color: white !important;">Edit Weekly Reflection</h3>
                    <p class="text-indigo-100" style="color: #e0e7ff !important;">
                        Update your reflection for the week of {{ $weeklyReflection->week_start_date->format('M d') }} - {{ $weeklyReflection->week_end_date->format('M d, Y') }}
                    </p>
                </div>
                
                <div class="p-6 sm:p-8">
                    <form method="POST" action="{{ route('weekly-reflections.update', $weeklyReflection) }}" class="space-y-8">
                        @csrf
                        @method('PUT')

                        <!-- Week Date Range -->
                        <div class="space-y-6">
                            <div class="border-l-4 border-indigo-500 pl-4">
                                <h4 class="text-lg font-semibold text-gray-900" style="color: #111827 !important;">Week Date Range</h4>
                                <p class="text-sm text-gray-600" style="color: #4b5563 !important;">Select the week you are reflecting on</p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="bg-gray-50 p-6 rounded-xl">
                                    <label for="week_start_date" class="block text-sm font-semibold text-gray-700 mb-2" style="color: #374151 !important;">
                                        Week Start Date <span class="text-red-500" style="color: #ef4444 !important;">*</span>
                                    </label>
                                    <input id="week_start_date" type="date" name="week_start_date" 
                                        value="{{ old('week_start_date', $weeklyReflection->week_start_date->format('Y-m-d')) }}" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200">
                                    <x-input-error :messages="$errors->get('week_start_date')" class="mt-2" />
                                </div>

                                <div class="bg-gray-50 p-6 rounded-xl">
                                    <label for="week_end_date" class="block text-sm font-semibold text-gray-700 mb-2" style="color: #374151 !important;">
                                        Week End Date <span class="text-red-500" style="color: #ef4444 !important;">*</span>
                                    </label>
                                    <input id="week_end_date" type="date" name="week_end_date" 
                                        value="{{ old('week_end_date', $weeklyReflection->week_end_date->format('Y-m-d')) }}" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200">
                                    <x-input-error :messages="$errors->get('week_end_date')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <!-- Clinical Rotation -->
                        <div class="space-y-6">
                            <div class="border-l-4 border-purple-500 pl-4">
                                <h4 class="text-lg font-semibold text-gray-900" style="color: #111827 !important;">Clinical Rotation</h4>
                                <p class="text-sm text-gray-600" style="color: #4b5563 !important;">Select the clinical rotation for this reflection</p>
                            </div>

                            <div class="bg-gray-50 p-6 rounded-xl">
                                <label for="clinical_rotation_id" class="block text-sm font-semibold text-gray-700 mb-2" style="color: #374151 !important;">
                                    Clinical Rotation <span class="text-red-500" style="color: #ef4444 !important;">*</span>
                                </label>
                                <select id="clinical_rotation_id" name="clinical_rotation_id" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200">
                                    <option value="">Select Clinical Rotation</option>
                                    @foreach($rotations as $rotation)
                                        <option value="{{ $rotation->id }}" {{ old('clinical_rotation_id', $weeklyReflection->clinical_rotation_id) == $rotation->id ? 'selected' : '' }}>
                                            {{ $rotation->rotation_title }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('clinical_rotation_id')" class="mt-2" />
                            </div>
                        </div>

                        <!-- What went well this week in terms of quality and safety -->
                        <div class="space-y-6">
                            <div class="border-l-4 border-green-500 pl-4">
                                <h4 class="text-lg font-semibold text-gray-900" style="color: #111827 !important;">Quality & Safety Success</h4>
                                <p class="text-sm text-gray-600" style="color: #4b5563 !important;">What went well this week in terms of quality and safety?</p>
                            </div>

                            <div class="bg-green-50 border border-green-200 p-6 rounded-xl">
                                <label for="what_went_well_quality_safety" class="block text-sm font-semibold text-gray-700 mb-2" style="color: #374151 !important;">
                                    What went well this week in terms of quality and safety? <span class="text-red-500" style="color: #ef4444 !important;">*</span>
                                </label>
                                <textarea id="what_went_well_quality_safety" name="what_went_well_quality_safety" rows="6" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 resize-none"
                                    placeholder="Describe the positive aspects of your week related to quality and safety. What did you do well? What processes worked effectively?">{{ old('what_went_well_quality_safety', $weeklyReflection->what_went_well_quality_safety) }}</textarea>
                                <x-input-error :messages="$errors->get('what_went_well_quality_safety')" class="mt-2" />
                            </div>
                        </div>

                        <!-- What could I have done better? -->
                        <div class="space-y-6">
                            <div class="border-l-4 border-yellow-500 pl-4">
                                <h4 class="text-lg font-semibold text-gray-900" style="color: #111827 !important;">Areas for Improvement</h4>
                                <p class="text-sm text-gray-600" style="color: #4b5563 !important;">What could I have done better?</p>
                            </div>

                            <div class="bg-yellow-50 border border-yellow-200 p-6 rounded-xl">
                                <label for="what_could_do_better" class="block text-sm font-semibold text-gray-700 mb-2" style="color: #374151 !important;">
                                    What could I have done better? <span class="text-red-500" style="color: #ef4444 !important;">*</span>
                                </label>
                                <textarea id="what_could_do_better" name="what_could_do_better" rows="6" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 resize-none"
                                    placeholder="Reflect on areas where you could have performed better. What would you do differently next time?">{{ old('what_could_do_better', $weeklyReflection->what_could_do_better) }}</textarea>
                                <x-input-error :messages="$errors->get('what_could_do_better')" class="mt-2" />
                            </div>
                        </div>

                        <!-- What did I learn about safe healthcare system this week? -->
                        <div class="space-y-6">
                            <div class="border-l-4 border-blue-500 pl-4">
                                <h4 class="text-lg font-semibold text-gray-900" style="color: #111827 !important;">Learning About Safe Healthcare</h4>
                                <p class="text-sm text-gray-600" style="color: #4b5563 !important;">What did I learn about safe healthcare system this week?</p>
                            </div>

                            <div class="bg-blue-50 border border-blue-200 p-6 rounded-xl">
                                <label for="what_learned_safe_healthcare" class="block text-sm font-semibold text-gray-700 mb-2" style="color: #374151 !important;">
                                    What did I learn about safe healthcare system this week? <span class="text-red-500" style="color: #ef4444 !important;">*</span>
                                </label>
                                <textarea id="what_learned_safe_healthcare" name="what_learned_safe_healthcare" rows="6" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 resize-none"
                                    placeholder="Share your key learnings about safe healthcare systems, patient safety principles, quality improvement, or any safety protocols you encountered.">{{ old('what_learned_safe_healthcare', $weeklyReflection->what_learned_safe_healthcare) }}</textarea>
                                <x-input-error :messages="$errors->get('what_learned_safe_healthcare')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Goals for next week -->
                        <div class="space-y-6">
                            <div class="border-l-4 border-purple-500 pl-4">
                                <h4 class="text-lg font-semibold text-gray-900" style="color: #111827 !important;">Future Goals</h4>
                                <p class="text-sm text-gray-600" style="color: #4b5563 !important;">Goals for next week</p>
                            </div>

                            <div class="bg-purple-50 border border-purple-200 p-6 rounded-xl">
                                <label for="goals_for_next_week" class="block text-sm font-semibold text-gray-700 mb-2" style="color: #374151 !important;">
                                    Goals for next week <span class="text-red-500" style="color: #ef4444 !important;">*</span>
                                </label>
                                <textarea id="goals_for_next_week" name="goals_for_next_week" rows="4" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 resize-none"
                                    placeholder="Set specific, achievable goals for the upcoming week. Focus on quality, safety, and learning objectives.">{{ old('goals_for_next_week', $weeklyReflection->goals_for_next_week) }}</textarea>
                                <x-input-error :messages="$errors->get('goals_for_next_week')" class="mt-2" />
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
                                <a href="{{ route('weekly-reflections.show', $weeklyReflection) }}" 
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
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Update Weekly Reflection
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
