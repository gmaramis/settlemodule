<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">Welcome to Settle!</h3>
                    <p class="mb-4">Hello, {{ Auth::user()->name }}! You are logged in as a {{ Auth::user()->role }}.</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="p-4 border border-gray-200 rounded-lg">
                            <h4 class="font-medium mb-2">Navigation</h4>
                            <ul class="space-y-2">
                                <li><a href="{{ route('weekly-reflections.index') }}" class="text-blue-600 hover:text-blue-800">View Reflections</a></li>
                                <li><a href="{{ route('learning-logs.index') }}" class="text-blue-600 hover:text-blue-800">View Learning Logs</a></li>
                                <li><a href="{{ route('incidents.index') }}" class="text-blue-600 hover:text-blue-800">View Incidents</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
