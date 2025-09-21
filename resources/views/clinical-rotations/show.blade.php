<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $clinicalRotation->rotation_title }}
            </h2>
            <div class="flex space-x-2">
                @can('update', $clinicalRotation)
                <a href="{{ route('clinical-rotations.edit', $clinicalRotation) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                    Edit
                </a>
                @endcan
                @if($clinicalRotation->status === 'scheduled' && auth()->user()->can('update', $clinicalRotation))
                <form method="POST" action="{{ route('clinical-rotations.start', $clinicalRotation) }}" class="inline">
                    @csrf
                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        Start Rotation
                    </button>
                </form>
                @endif
                @if($clinicalRotation->status === 'active' && auth()->user()->can('update', $clinicalRotation))
                <form method="POST" action="{{ route('clinical-rotations.complete', $clinicalRotation) }}" class="inline">
                    @csrf
                    <button type="submit" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                        Complete Rotation
                    </button>
                </form>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Information -->
                <div class="lg:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Rotation Details</h3>
                            <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Student</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $clinicalRotation->user->name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Department</dt>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Supervisor</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $clinicalRotation->supervisor_name ?? 'Not specified' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Supervisor Email</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $clinicalRotation->supervisor_email ?? 'Not specified' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Rotation Details</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $clinicalRotation->rotation_title }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Total Hours</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $clinicalRotation->total_hours ?? 'Not specified' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                                    <dd class="mt-1">
                                        @php
                                            $statusClasses = match($clinicalRotation->status) {
                                                'scheduled' => 'bg-blue-100 text-blue-800',
                                                'active' => 'bg-green-100 text-green-800',
                                                'completed' => 'bg-gray-100 text-gray-800',
                                                default => 'bg-red-100 text-red-800'
                                            };
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClasses }}">
                                            {{ ucfirst($clinicalRotation->status) }}
                                        </span>
                                    </dd>
                                </div>
                                @if($clinicalRotation->evaluation_score)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Evaluation Score</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $clinicalRotation->evaluation_score }}/10</dd>
                                </div>
                                @endif
                            </dl>
                        </div>
                    </div>

                    @if($clinicalRotation->description)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Description</h3>
                            <p class="text-sm text-gray-900 whitespace-pre-wrap">{{ $clinicalRotation->description }}</p>
                        </div>
                    </div>
                    @endif

                    @if($clinicalRotation->learning_objectives)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Learning Objectives</h3>
                            <p class="text-sm text-gray-900 whitespace-pre-wrap">{{ $clinicalRotation->learning_objectives }}</p>
                        </div>
                    </div>
                    @endif

                    @if($clinicalRotation->evaluation_comments)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Evaluation Comments</h3>
                            <p class="text-sm text-gray-900 whitespace-pre-wrap">{{ $clinicalRotation->evaluation_comments }}</p>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Progress -->
                    @if($clinicalRotation->status === 'active')
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Progress</h3>
                            <div class="w-full bg-gray-200 rounded-full h-2 mb-2">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $clinicalRotation->progress_percentage }}%"></div>
                            </div>
                            <p class="text-sm text-gray-600">{{ number_format($clinicalRotation->progress_percentage, 1) }}% complete</p>
                        </div>
                    </div>
                    @endif

                    <!-- Quick Stats -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Stats</h3>
                            <dl class="space-y-3">
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-500">Incidents</dt>
                                    <dd class="text-sm font-medium text-gray-900">{{ $clinicalRotation->incidents->count() }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-500">Reflections</dt>
                                    <dd class="text-sm font-medium text-gray-900">{{ $clinicalRotation->weeklyReflections->count() }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-500">Learning Logs</dt>
                                    <dd class="text-sm font-medium text-gray-900">{{ $clinicalRotation->learningLogs->count() }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
                            <div class="space-y-2">
                                <a href="{{ route('incidents.create', ['clinical_rotation_id' => $clinicalRotation->id]) }}" class="block w-full text-center bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded text-sm">
                                    Report Incident
                                </a>
                                <a href="{{ route('weekly-reflections.create', ['clinical_rotation_id' => $clinicalRotation->id]) }}" class="block w-full text-center bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded text-sm">
                                    Add Reflection
                                </a>
                                <a href="{{ route('learning-logs.create', ['clinical_rotation_id' => $clinicalRotation->id]) }}" class="block w-full text-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm">
                                    Add Learning Log
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
