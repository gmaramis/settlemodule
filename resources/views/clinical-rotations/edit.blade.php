<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Clinical Rotation
            </h2>
            <a href="{{ route('clinical-rotations.show', $clinicalRotation) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Details
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('clinical-rotations.update', $clinicalRotation) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Rotation Name -->
                            <div class="md:col-span-2">
                                <label for="rotation_name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Rotation Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="rotation_name" name="rotation_name" 
                                    value="{{ old('rotation_title', $clinicalRotation->rotation_title) }}" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <x-input-error :messages="$errors->get('rotation_name')" class="mt-2" />
                            </div>


                            <!-- Supervisor Name -->
                            <div>
                                <label for="supervisor_name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Supervisor Name
                                </label>
                                <input type="text" id="supervisor_name" name="supervisor_name" 
                                    value="{{ old('supervisor_name', $clinicalRotation->supervisor_name) }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <x-input-error :messages="$errors->get('supervisor_name')" class="mt-2" />
                            </div>

                            <!-- Supervisor Email -->
                            <div>
                                <label for="supervisor_email" class="block text-sm font-medium text-gray-700 mb-2">
                                    Supervisor Email
                                </label>
                                <input type="email" id="supervisor_email" name="supervisor_email" 
                                    value="{{ old('supervisor_email', $clinicalRotation->supervisor_email) }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <x-input-error :messages="$errors->get('supervisor_email')" class="mt-2" />
                            </div>

                            <!-- Rotation Title -->
                            <div>
                                <label for="rotation_title" class="block text-sm font-medium text-gray-700 mb-2">
                                    Rotation Title <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="rotation_title" name="rotation_title" 
                                    value="{{ old('rotation_title', $clinicalRotation->rotation_title) }}" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <x-input-error :messages="$errors->get('rotation_title')" class="mt-2" />
                            </div>

                            <!-- Total Hours -->
                            <div>
                                <label for="total_hours" class="block text-sm font-medium text-gray-700 mb-2">
                                    Total Hours
                                </label>
                                <input type="number" id="total_hours" name="total_hours" 
                                    value="{{ old('total_hours', $clinicalRotation->total_hours) }}" min="0" step="1"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <x-input-error :messages="$errors->get('total_hours')" class="mt-2" />
                            </div>

                            <!-- Status -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                    Status <span class="text-red-500">*</span>
                                </label>
                                <select id="status" name="status" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="scheduled" {{ old('status', $clinicalRotation->status) == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                    <option value="active" {{ old('status', $clinicalRotation->status) == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="completed" {{ old('status', $clinicalRotation->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ old('status', $clinicalRotation->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>

                            <!-- Description -->
                            <div class="md:col-span-2">
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                    Description
                                </label>
                                <textarea id="description" name="description" rows="4"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">{{ old('description', $clinicalRotation->description) }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>

                            <!-- Learning Objectives -->
                            <div class="md:col-span-2">
                                <label for="learning_objectives" class="block text-sm font-medium text-gray-700 mb-2">
                                    Learning Objectives
                                </label>
                                <textarea id="learning_objectives" name="learning_objectives" rows="4"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">{{ old('learning_objectives', $clinicalRotation->learning_objectives) }}</textarea>
                                <x-input-error :messages="$errors->get('learning_objectives')" class="mt-2" />
                            </div>

                            <!-- Evaluation Score -->
                            <div>
                                <label for="evaluation_score" class="block text-sm font-medium text-gray-700 mb-2">
                                    Evaluation Score (0-10)
                                </label>
                                <input type="number" id="evaluation_score" name="evaluation_score" 
                                    value="{{ old('evaluation_score', $clinicalRotation->evaluation_score) }}" min="0" max="10" step="0.1"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <x-input-error :messages="$errors->get('evaluation_score')" class="mt-2" />
                            </div>

                            <!-- Evaluation Comments -->
                            <div>
                                <label for="evaluation_comments" class="block text-sm font-medium text-gray-700 mb-2">
                                    Evaluation Comments
                                </label>
                                <textarea id="evaluation_comments" name="evaluation_comments" rows="3"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">{{ old('evaluation_comments', $clinicalRotation->evaluation_comments) }}</textarea>
                                <x-input-error :messages="$errors->get('evaluation_comments')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex justify-end space-x-4 mt-8">
                            <a href="{{ route('clinical-rotations.show', $clinicalRotation) }}" 
                                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Cancel
                            </a>
                            <button type="submit" 
                                class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                                Update Clinical Rotation
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
