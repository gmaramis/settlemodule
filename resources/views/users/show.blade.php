<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                User Details
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('users.edit', $user) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                    Edit User
                </a>
                <a href="{{ route('users.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back to Users
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Basic Information -->
                        <div class="md:col-span-2">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                            <p class="text-sm text-gray-900 bg-gray-50 p-3 rounded">{{ $user->name }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <p class="text-sm text-gray-900 bg-gray-50 p-3 rounded">{{ $user->email }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                            <p class="text-sm text-gray-900 bg-gray-50 p-3 rounded">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if($user->role === 'admin') bg-red-100 text-red-800
                                    @elseif($user->role === 'supervisor') bg-blue-100 text-blue-800
                                    @else bg-green-100 text-green-800
                                    @endif">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <p class="text-sm text-gray-900 bg-gray-50 p-3 rounded">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Student ID</label>
                            <p class="text-sm text-gray-900 bg-gray-50 p-3 rounded">{{ $user->student_id ?? 'N/A' }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                            <p class="text-sm text-gray-900 bg-gray-50 p-3 rounded">{{ $user->phone ?? 'N/A' }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date of Birth</label>
                            <p class="text-sm text-gray-900 bg-gray-50 p-3 rounded">{{ $user->date_of_birth ? $user->date_of_birth->format('d/m/Y') : 'N/A' }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Last Login</label>
                            <p class="text-sm text-gray-900 bg-gray-50 p-3 rounded">{{ $user->last_login_at ? $user->last_login_at->format('d/m/Y H:i') : 'Never' }}</p>
                        </div>

                        <!-- Academic Information -->
                        <div class="md:col-span-2">
                            <h3 class="text-lg font-medium text-gray-900 mb-4 mt-6">Academic Information</h3>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Institution</label>
                            <p class="text-sm text-gray-900 bg-gray-50 p-3 rounded">{{ $user->institution ?? 'N/A' }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Program</label>
                            <p class="text-sm text-gray-900 bg-gray-50 p-3 rounded">{{ $user->program ?? 'N/A' }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Year of Study</label>
                            <p class="text-sm text-gray-900 bg-gray-50 p-3 rounded">{{ $user->year_of_study ? 'Year ' . $user->year_of_study : 'N/A' }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Specialization</label>
                            <p class="text-sm text-gray-900 bg-gray-50 p-3 rounded">{{ $user->specialization ?? 'N/A' }}</p>
                        </div>

                        <!-- Emergency Contact -->
                        <div class="md:col-span-2">
                            <h3 class="text-lg font-medium text-gray-900 mb-4 mt-6">Emergency Contact</h3>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Emergency Contact Name</label>
                            <p class="text-sm text-gray-900 bg-gray-50 p-3 rounded">{{ $user->emergency_contact_name ?? 'N/A' }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Emergency Contact Phone</label>
                            <p class="text-sm text-gray-900 bg-gray-50 p-3 rounded">{{ $user->emergency_contact_phone ?? 'N/A' }}</p>
                        </div>

                        <!-- Additional Information -->
                        <div class="md:col-span-2">
                            <h3 class="text-lg font-medium text-gray-900 mb-4 mt-6">Additional Information</h3>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Bio</label>
                            <p class="text-sm text-gray-900 bg-gray-50 p-3 rounded">{{ $user->bio ?? 'N/A' }}</p>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Medical Notes</label>
                            <p class="text-sm text-gray-900 bg-gray-50 p-3 rounded">{{ $user->medical_notes ?? 'N/A' }}</p>
                        </div>

                        <!-- Account Information -->
                        <div class="md:col-span-2">
                            <h3 class="text-lg font-medium text-gray-900 mb-4 mt-6">Account Information</h3>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Created At</label>
                            <p class="text-sm text-gray-900 bg-gray-50 p-3 rounded">{{ $user->created_at->format('d/m/Y H:i') }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Updated At</label>
                            <p class="text-sm text-gray-900 bg-gray-50 p-3 rounded">{{ $user->updated_at->format('d/m/Y H:i') }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email Verified</label>
                            <p class="text-sm text-gray-900 bg-gray-50 p-3 rounded">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $user->email_verified_at ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $user->email_verified_at ? 'Verified' : 'Not Verified' }}
                                </span>
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email Verified At</label>
                            <p class="text-sm text-gray-900 bg-gray-50 p-3 rounded">{{ $user->email_verified_at ? $user->email_verified_at->format('d/m/Y H:i') : 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
