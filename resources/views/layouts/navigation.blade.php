<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-12 sm:h-14 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    
                    @if(Auth::user()->is_admin || Auth::user()->is_supervisor)
                    <x-nav-link :href="route('clinical-rotations.index')" :active="request()->routeIs('clinical-rotations.*')">
                        {{ __('Clinical Rotations') }}
                    </x-nav-link>
                    @endif
                    
                    <x-nav-link :href="route('incidents.index')" :active="request()->routeIs('incidents.*')">
                        {{ __('Incidents') }}
                    </x-nav-link>
                    
                    <x-nav-link :href="route('weekly-reflections.index')" :active="request()->routeIs('weekly-reflections.*')">
                        {{ __('Weekly Reflections') }}
                    </x-nav-link>
                    
                    <x-nav-link :href="route('learning-logs.index')" :active="request()->routeIs('learning-logs.*')">
                        {{ __('Learning Logs') }}
                    </x-nav-link>
                    
                    @if(Auth::user()->is_admin)
                    <x-nav-link :href="route('broadcasts.index')" :active="request()->routeIs('broadcasts.*')">
                        {{ __('Broadcast Messages') }}
                    </x-nav-link>
                    <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.*') || request()->routeIs('students.*') || request()->routeIs('supervisors.*')">
                        {{ __('User Management') }}
                    </x-nav-link>
                    <x-nav-link :href="route('activity-logs.index')" :active="request()->routeIs('activity-logs.*')">
                        {{ __('Activity Logs') }}
                    </x-nav-link>
                    @endif
                    
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                {{ __('Log Out') }}
                            </button>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            
            @if(Auth::user()->is_admin || Auth::user()->is_supervisor)
            <x-responsive-nav-link :href="route('clinical-rotations.index')" :active="request()->routeIs('clinical-rotations.*')">
                {{ __('Clinical Rotations') }}
            </x-responsive-nav-link>
            @endif
            
            <x-responsive-nav-link :href="route('incidents.index')" :active="request()->routeIs('incidents.*')">
                {{ __('Incidents') }}
            </x-responsive-nav-link>
            
            <x-responsive-nav-link :href="route('weekly-reflections.index')" :active="request()->routeIs('weekly-reflections.*')">
                {{ __('Weekly Reflections') }}
            </x-responsive-nav-link>
            
            <x-responsive-nav-link :href="route('learning-logs.index')" :active="request()->routeIs('learning-logs.*')">
                {{ __('Learning Logs') }}
            </x-responsive-nav-link>
            
            @if(Auth::user()->is_admin)
            <x-responsive-nav-link :href="route('broadcasts.index')" :active="request()->routeIs('broadcasts.*')">
                {{ __('Broadcast Messages') }}
            </x-responsive-nav-link>
            
            <div class="pt-2 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ __('User Management') }}</div>
                </div>
                <div class="mt-2 space-y-1">
                    <x-responsive-nav-link :href="route('students.index')" :active="request()->routeIs('students.*')">
                        {{ __('Students') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')">
                        {{ __('All Users') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('activity-logs.index')" :active="request()->routeIs('activity-logs.*')">
                        {{ __('Activity Logs') }}
                    </x-responsive-nav-link>
                </div>
            </div>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full px-4 py-2 text-left text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100 focus:outline-none focus:text-gray-800 focus:bg-gray-100 transition duration-150 ease-in-out">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
