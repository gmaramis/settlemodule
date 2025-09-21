<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-900">
                    Welcome back, {{ Auth::user()->name }}! 👋
                </h2>
                <p class="text-gray-600 mt-1">Here's what's happening with your clinical rotations today</p>
            </div>
            <div class="flex items-center space-x-3">
                <div class="text-right">
                    <p class="text-sm text-gray-500">Current Time</p>
                    <p class="text-lg font-semibold text-gray-900" id="current-time">{{ now()->format('H:i') }}</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                    <span class="text-white font-bold text-lg">{{ substr(Auth::user()->name, 0, 1) }}</span>
                </div>
            </div>
        </div>
    </x-slot>

    <style>
        /* Custom styles to override any conflicting CSS */
        .stats-card {
            background: linear-gradient(135deg, var(--card-color-1) 0%, var(--card-color-2) 100%) !important;
            color: white !important;
        }
        
        .stats-card .card-title {
            color: var(--title-color) !important;
        }
        
        .stats-card .card-number {
            color: white !important;
        }
        
        .stats-card .card-subtitle {
            color: var(--subtitle-color) !important;
        }
        
        .stats-card svg {
            color: white !important;
        }
        
        /* Blue card */
        .stats-card.blue {
            --card-color-1: #3b82f6;
            --card-color-2: #1d4ed8;
            --title-color: #dbeafe;
            --subtitle-color: #dbeafe;
        }
        
        /* Green card */
        .stats-card.green {
            --card-color-1: #10b981;
            --card-color-2: #047857;
            --title-color: #d1fae5;
            --subtitle-color: #d1fae5;
        }
        
        /* Purple card */
        .stats-card.purple {
            --card-color-1: #8b5cf6;
            --card-color-2: #7c3aed;
            --title-color: #e9d5ff;
            --subtitle-color: #e9d5ff;
        }
        
        /* Orange card */
        .stats-card.orange {
            --card-color-1: #f97316;
            --card-color-2: #ea580c;
            --title-color: #fed7aa;
            --subtitle-color: #fed7aa;
        }
    </style>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Active Rotations Card -->
                <div class="stats-card blue rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="card-title text-sm font-medium">Active Rotations</p>
                            <p class="card-number text-3xl font-bold">{{ $stats['active_rotations'] }}</p>
                            <p class="card-subtitle text-xs mt-1">Currently ongoing</p>
                        </div>
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Completed Rotations Card -->
                <div class="stats-card green rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="card-title text-sm font-medium">Completed</p>
                            <p class="card-number text-3xl font-bold">{{ $stats['completed_rotations'] }}</p>
                            <p class="card-subtitle text-xs mt-1">Successfully finished</p>
                        </div>
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Learning Logs Card -->
                <div class="stats-card purple rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="card-title text-sm font-medium">Learning Logs</p>
                            <p class="card-number text-3xl font-bold">{{ $stats['learning_logs'] }}</p>
                            <p class="card-subtitle text-xs mt-1">Knowledge captured</p>
                        </div>
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Reflections Card -->
                <div class="stats-card orange rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="card-title text-sm font-medium">Reflections</p>
                            <p class="card-number text-3xl font-bold">{{ $stats['submitted_reflections'] }}</p>
                            <p class="card-subtitle text-xs mt-1">Weekly insights</p>
                        </div>
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Current Rotation Info -->
            @if($currentRotation)
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-8">
                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-6 py-4">
                    <h3 class="text-xl font-bold text-white">Current Rotation</h3>
                    <p class="text-indigo-100 text-sm">{{ $currentRotation->rotation_name }}</p>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Department</p>
                            <p class="font-semibold text-gray-900">{{ $currentRotation->department }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Rotation</p>
                            <p class="font-semibold text-gray-900">
                                {{ $currentRotation->rotation_title }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Progress</p>
                            <div class="flex items-center space-x-2">
                                <div class="flex-1 bg-gray-200 rounded-full h-2">
                                    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 h-2 rounded-full" style="width: {{ $currentRotation->progress_percentage }}%"></div>
                                </div>
                                <span class="text-sm font-medium text-gray-900">{{ number_format($currentRotation->progress_percentage, 1) }}%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Sidebar -->
                <div class="lg:col-span-3 space-y-6">
                    <!-- Progress Overview -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-emerald-500 to-teal-600 px-6 py-4">
                            <h3 class="text-lg font-bold text-white">Progress Overview</h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                <div>
                                    <div class="flex justify-between text-sm mb-2">
                                        <span class="text-gray-600">Clinical Rotations</span>
                                        <span class="font-medium">0%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-gradient-to-r from-emerald-500 to-teal-600 h-2 rounded-full" style="width: 0%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between text-sm mb-2">
                                        <span class="text-gray-600">Learning Goals</span>
                                        <span class="font-medium">0%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-gradient-to-r from-blue-500 to-purple-600 h-2 rounded-full" style="width: 0%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between text-sm mb-2">
                                        <span class="text-gray-600">Reflections</span>
                                        <span class="font-medium">0%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-gradient-to-r from-orange-500 to-red-600 h-2 rounded-full" style="width: 0%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-gray-700 to-gray-800 px-6 py-4">
                            <h3 class="text-lg font-bold text-white">Recent Activity</h3>
                        </div>
                        <div class="p-6">
                            @if($recentActivity->count() > 0)
                                <div class="space-y-3">
                                    @foreach($recentActivity as $activity)
                                    <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                        <div class="flex-shrink-0">
                                            @if($activity['type'] === 'Incident')
                                                <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                                                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                                    </svg>
                                                </div>
                                            @else
                                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate">{{ $activity['title'] }}</p>
                                            <p class="text-xs text-gray-500">{{ $activity['type'] }} • {{ $activity['date']->format('M d, Y') }}</p>
                                        </div>
                                        <a href="{{ $activity['url'] }}" class="text-blue-600 hover:text-blue-800 text-xs font-medium">View</a>
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <p class="text-gray-500 text-sm">No recent activity</p>
                                    <p class="text-gray-400 text-xs mt-1">Start by creating your first entry</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Quick Tips -->
                    <div class="bg-gradient-to-br from-yellow-400 to-orange-500 rounded-2xl p-6 text-white">
                        <div class="flex items-center space-x-3 mb-3">
                            <div class="w-8 h-8 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                </svg>
                            </div>
                            <h4 class="font-bold">Quick Tip</h4>
                        </div>
                        <p class="text-sm text-yellow-100">Regular reflections help you track your learning progress and identify areas for improvement. Try to write at least one reflection per week!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for real-time clock -->
    <script>
        function updateTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('en-US', { 
                hour12: false, 
                hour: '2-digit', 
                minute: '2-digit' 
            });
            document.getElementById('current-time').textContent = timeString;
        }
        
        // Update time immediately and then every minute
        updateTime();
        setInterval(updateTime, 60000);
    </script>
</x-app-layout>
