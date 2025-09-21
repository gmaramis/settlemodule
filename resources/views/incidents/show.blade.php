<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Incident Report Details') }}
            </h2>
            <div class="flex space-x-2">
                @can('update', $incident)
                    <a href="{{ route('incidents.edit', $incident) }}" 
                        class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 focus:bg-yellow-700 active:bg-yellow-900 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Edit Report
                    </a>
                @endcan
                <a href="{{ route('incidents.index') }}" 
                    class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Back to List
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Header Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-3">Basic Information</h3>
                            <dl class="space-y-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Date & Time</dt>
                                    <dd class="text-sm text-gray-900">{{ $incident->incident_date->format('F d, Y \a\t H:i') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Department</dt>
                                    <dd class="text-sm text-gray-900">{{ $incident->department }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Reported By</dt>
                                    <dd class="text-sm text-gray-900">{{ $incident->user->name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Reported On</dt>
                                    <dd class="text-sm text-gray-900">{{ $incident->created_at->format('F d, Y \a\t H:i') }}</dd>
                                </div>
                            </dl>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-3">Classification</h3>
                            <dl class="space-y-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Event Type</dt>
                                    <dd class="text-sm text-gray-900">{{ $incident->event_type }}</dd>
                                </div>
                                @if($incident->event_type_explanation)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Event Type Explanation</dt>
                                        <dd class="text-sm text-gray-900">{{ $incident->event_type_explanation }}</dd>
                                    </div>
                                @endif
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Outcome</dt>
                                    <dd class="text-sm">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($incident->outcome === 'No harm') bg-green-100 text-green-800
                                            @elseif($incident->outcome === 'Minor Harm') bg-yellow-100 text-yellow-800
                                            @else bg-red-100 text-red-800
                                            @endif">
                                            {{ $incident->outcome }}
                                        </span>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                                    <dd class="text-sm">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($incident->status === 'reported') bg-blue-100 text-blue-800
                                            @elseif($incident->status === 'under_review') bg-yellow-100 text-yellow-800
                                            @elseif($incident->status === 'resolved') bg-green-100 text-green-900
                                            @else bg-gray-100 text-gray-800
                                            @endif">
                                            {{ ucfirst(str_replace('_', ' ', $incident->status)) }}
                                        </span>
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <!-- What Happened -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-3">What Happened?</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-900 whitespace-pre-wrap">{{ $incident->what_happened }}</p>
                        </div>
                    </div>

                    <!-- Why Did It Happen -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Why Did It Happen? (System Analysis)</h3>
                        <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                            <p class="text-sm text-gray-900 whitespace-pre-wrap">{{ $incident->why_did_it_happen }}</p>
                        </div>
                    </div>

                    <!-- Contributing Factors -->
                    @if($incident->contributing_factors && count($incident->contributing_factors) > 0)
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-3">Contributing Factors</h3>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="flex flex-wrap gap-2">
                                    @foreach($incident->contributing_factors as $factor)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                                            {{ $factor }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Prevention Suggestions -->
                    @if($incident->prevention_suggestions)
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-3">Prevention Suggestions</h3>
                            <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                                <p class="text-sm text-gray-900 whitespace-pre-wrap">{{ $incident->prevention_suggestions }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Actions -->
                    <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                        <div class="flex space-x-2">
                            @can('update', $incident)
                                <a href="{{ route('incidents.edit', $incident) }}" 
                                    class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 focus:bg-yellow-700 active:bg-yellow-900 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Edit Report
                                </a>
                            @endcan
                            @can('delete', $incident)
                                <form method="POST" action="{{ route('incidents.destroy', $incident) }}" 
                                    class="inline" onsubmit="return confirm('Are you sure you want to delete this incident report?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                        class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        Delete Report
                                    </button>
                                </form>
                            @endcan
                        </div>
                        <a href="{{ route('incidents.index') }}" 
                            class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
