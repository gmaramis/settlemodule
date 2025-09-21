<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Incident Report') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Edit Incident Report</h3>
                        <p class="text-sm text-gray-600">
                            Update the incident report details below. Remember to maintain patient privacy and focus on system analysis.
                        </p>
                    </div>

                    <form method="POST" action="{{ route('incidents.update', $incident) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Date & Time -->
                        <div>
                            <x-input-label for="incident_date" :value="__('Date & Time of Incident')" />
                            <x-text-input id="incident_date" class="block mt-1 w-full" type="datetime-local" 
                                name="incident_date" :value="old('incident_date', $incident->incident_date->format('Y-m-d\TH:i'))" required />
                            <x-input-error :messages="$errors->get('incident_date')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-500">Please do not include any patient identifiers</p>
                        </div>


                        <!-- Department -->
                        <div>
                            <x-input-label for="department" :value="__('Clinical Rotation / Department')" />
                            <select id="department" name="department" required
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">Select Department</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department }}" {{ old('department', $incident->department) == $department ? 'selected' : '' }}>
                                        {{ $department }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('department')" class="mt-2" />
                        </div>

                        <!-- Type of Event -->
                        <div>
                            <x-input-label for="event_type" :value="__('Type of Event')" />
                            <select id="event_type" name="event_type" required
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">Select Event Type</option>
                                @foreach($eventTypes as $eventType)
                                    <option value="{{ $eventType }}" {{ old('event_type', $incident->event_type) == $eventType ? 'selected' : '' }}>
                                        {{ $eventType }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('event_type')" class="mt-2" />
                        </div>

                        <!-- Event Type Explanation -->
                        <div>
                            <x-input-label for="event_type_explanation" :value="__('Event Type Explanation (Optional)')" />
                            <textarea id="event_type_explanation" name="event_type_explanation" rows="3"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                placeholder="Provide additional explanation for the selected event type...">{{ old('event_type_explanation', $incident->event_type_explanation) }}</textarea>
                            <x-input-error :messages="$errors->get('event_type_explanation')" class="mt-2" />
                        </div>

                        <!-- What Happened -->
                        <div>
                            <x-input-label for="what_happened" :value="__('What Happened?')" />
                            <textarea id="what_happened" name="what_happened" rows="6" required
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                placeholder="Provide a detailed description of what happened. Include timeline, sequence of events, and context. DO NOT include any patient identifiers, names, or personal information.">{{ old('what_happened', $incident->what_happened) }}</textarea>
                            <x-input-error :messages="$errors->get('what_happened')" class="mt-2" />
                            <div class="mt-2 p-3 bg-red-50 border border-red-200 rounded-md">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-red-800">
                                            Privacy Warning
                                        </h3>
                                        <div class="mt-2 text-sm text-red-700">
                                            <p>DO NOT include any Protected Health Information (PHI) such as:</p>
                                            <ul class="list-disc list-inside mt-1">
                                                <li>Patient names, initials, or identifiers</li>
                                                <li>Medical record numbers</li>
                                                <li>Social security numbers</li>
                                                <li>Specific dates of birth</li>
                                                <li>Addresses or phone numbers</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Why Did It Happen -->
                        <div>
                            <x-input-label for="why_did_it_happen" :value="__('Why Did It Happen? (System Analysis)')" />
                            <textarea id="why_did_it_happen" name="why_did_it_happen" rows="6" required
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                placeholder="This is the key section for system analysis. Consider the Swiss Cheese Model and WHO concepts. Analyze the root causes, system failures, and contributing factors. Focus on system-level issues rather than individual blame.">{{ old('why_did_it_happen', $incident->why_did_it_happen) }}</textarea>
                            <x-input-error :messages="$errors->get('why_did_it_happen')" class="mt-2" />
                            <div class="mt-2 p-3 bg-blue-50 border border-blue-200 rounded-md">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-blue-800">
                                            System Analysis Guidance
                                        </h3>
                                        <div class="mt-2 text-sm text-blue-700">
                                            <p>Consider these frameworks:</p>
                                            <ul class="list-disc list-inside mt-1">
                                                <li><strong>Swiss Cheese Model:</strong> Multiple layers of defense with holes that aligned</li>
                                                <li><strong>WHO Patient Safety:</strong> System factors, human factors, and organizational factors</li>
                                                <li><strong>Root Cause Analysis:</strong> Why did each contributing factor exist?</li>
                                                <li><strong>System Thinking:</strong> Focus on processes, not people</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Contributing Factors -->
                        <div>
                            <x-input-label for="contributing_factors" :value="__('Contributing Factors')" />
                            <div class="mt-2 grid grid-cols-2 gap-2">
                                @foreach($contributingFactors as $factor)
                                    <label class="flex items-center">
                                        <input type="checkbox" name="contributing_factors[]" value="{{ $factor }}"
                                            {{ in_array($factor, old('contributing_factors', $incident->contributing_factors ?? [])) ? 'checked' : '' }}
                                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                        <span class="ml-2 text-sm text-gray-700">{{ $factor }}</span>
                                    </label>
                                @endforeach
                            </div>
                            <x-input-error :messages="$errors->get('contributing_factors')" class="mt-2" />
                        </div>

                        <!-- Outcome -->
                        <div>
                            <x-input-label for="outcome" :value="__('What Was the Outcome?')" />
                            <select id="outcome" name="outcome" required
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">Select Outcome</option>
                                @foreach($outcomes as $outcome)
                                    <option value="{{ $outcome }}" {{ old('outcome', $incident->outcome) == $outcome ? 'selected' : '' }}>
                                        {{ $outcome }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('outcome')" class="mt-2" />
                        </div>

                        <!-- Prevention Suggestions -->
                        <div>
                            <x-input-label for="prevention_suggestions" :value="__('What Could Prevent It? (Suggestions for Improvement)')" />
                            <textarea id="prevention_suggestions" name="prevention_suggestions" rows="4"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                placeholder="Suggest specific improvements, policy changes, training needs, or system modifications that could prevent similar incidents in the future.">{{ old('prevention_suggestions', $incident->prevention_suggestions) }}</textarea>
                            <x-input-error :messages="$errors->get('prevention_suggestions')" class="mt-2" />
                        </div>

                        <!-- Status (for supervisors/admins) -->
                        @can('update', $incident)
                            @if(auth()->user()->is_supervisor || auth()->user()->is_admin)
                                <div>
                                    <x-input-label for="status" :value="__('Status')" />
                                    <select id="status" name="status" 
                                        class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                        <option value="reported" {{ old('status', $incident->status) == 'reported' ? 'selected' : '' }}>Reported</option>
                                        <option value="under_review" {{ old('status', $incident->status) == 'under_review' ? 'selected' : '' }}>Under Review</option>
                                        <option value="resolved" {{ old('status', $incident->status) == 'resolved' ? 'selected' : '' }}>Resolved</option>
                                        <option value="closed" {{ old('status', $incident->status) == 'closed' ? 'selected' : '' }}>Closed</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('status')" class="mt-2" />
                                </div>
                            @endif
                        @endcan

                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('incidents.show', $incident) }}" 
                                class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Cancel
                            </a>
                            <x-primary-button>
                                {{ __('Update Incident Report') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
