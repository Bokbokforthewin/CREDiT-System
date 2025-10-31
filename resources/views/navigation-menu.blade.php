<nav x-data="{ open: false, profileOpen: false }" class="bg-gradient-to-r from-blue-900 via-blue-800 to-blue-900 border-b border-blue-700 shadow-lg">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16 md:h-20">
            <!-- Logo and Hamburger -->
            <div class="flex items-center">
                <!-- Mobile menu button -->
                {{-- <div class="flex-shrink-0 flex items-center md:hidden mr-2">
                    <button @click="open = !open" 
                            class="inline-flex items-center justify-center p-2 rounded-md text-blue-200 hover:text-yellow-300 hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-yellow-400 transition duration-200">
                        <span class="sr-only">Open main menu</span>
                        <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin极狐="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                 --}}
                <!-- Logo Section -->
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                    <img src="{{ asset('images/cpac logo.png') }}" 
                         alt="CPAC Logo" 
                         class="h-10 w-10 md:h-12 md:w-12">
                    <div>
                        <h1 class="text-xl md:text-2xl font-bold text-yellow-400 tracking-tight">CREDiT</h1>
                        <p class="text-blue-200 text-xs md:text-sm font-medium hidden sm:block">Charging Records System</p>
                    </div>
                </a>
            </div>

            <!-- User Profile Section -->
            <div class="flex items-center">
                <!-- User Profile Dropdown -->
                <div class="ms-3 relative">
                    <div x-data="{ open: false }" class="relative" x-cloak>
                        <!-- Trigger Button -->
                        <button @click="open = !open" 
                                class="flex justify-center items-center bg-white/20 backdrop-blur-sm hover:bg-white/30 px-1.5 py-1.5 md:px-4 md:py-2 rounded-full border border-white/20 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:ring-offset-2 focus:ring-offset-blue-900">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                {{-- <img class="h-8 w-8 md:h-10 md:w-10 rounded-full object-cover border-2 border-yellow-400" 
                                     src="{{ Auth::user()->profile_photo_url }}" 
                                     alt="{{ Auth::user()->name }}" /> --}}
                            @else
                                <div class="h-8 w-8 md:h-10 md:w-10 rounded-full bg-yellow-400 flex items-center justify-center ">
                                    <span class="text-blue-900 font-bold text-sm md:text-lg">{{ substr(Auth::user()->name ?? 'Unknown User', 0, 1) }}</span>
                                </div>
                            @endif
                            <div class="text-left hidden md:block lg:px-3">
                                <p class="text-white font-semibold text-lg">{{ Auth::user()->name ?? 'Unknown User' }}</p>
                                <p class="text-blue-200 text-sm">{{ Auth::user()->email ?? 'Unknown User' }}</p>
                            </div>
                            <svg class="h-4 w-4 md:h-5 md:w-5 text-blue-200 transition-transform duration-200 hidden" 
                                 :class="{'rotate-180': open}"
                                 xmlns="http://www.w3.org/2000/svg" 
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 极狐l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" 
                             @click.away="open = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform scale-95"
                             x-transition:enter-end="opacity-100 transform scale-100"
                             x-transition:leave极狐="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 transform scale-100"
                             x-transition:leave-end="opacity-0 transform scale-95"
                             class="absolute right-0 mt-2 w-48 md:w-72 bg-white/95 backdrop-blur-md border border-white/20 rounded-2xl shadow-2xl z-50 overflow-hidden">
                            
                            <!-- Account Management Header -->
                            <div class="px-4 py-3 md:px-6 md:py-4 bg-blue-900/20 border-b border-blue-100/20">
                                <p class="text-xs md:text-sm font-semibold text-blue-900 uppercase tracking-wide">Manage Account</p>
                            </div>

                            <!-- Profile Link -->
                            <a href="{{ route('profile.show') }}" 
                               class="flex items-center px-4 py-3 md:px-6 md:py-4 text-blue-900 hover:bg-blue-50 transition-colors duration-200 group">
                               <div class="w-8 h-8 sm:w-10 sm:h-10 flex items-center">
                                <svg class="h-5 w-5 md:h-6 md:w-6 mr-2 md:mr-3 text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                                <div>
                                    <p class="font-semibold text-base md:text-lg">Profile</p>
                                    <p class="text-xs md:text-sm text-blue-600">Manage account settings</p>
                                </div>
                            </a>

                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                <a href="{{ route('api-tokens.index') }}" 
                                   class="flex items-center px-4 py-3 md:px-6 md:py-4 text-blue-900 hover:bg-blue-50 transition-colors duration-200 group">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:h-6 md:w-6 mr-2 md:mr-3 text-blue-600 group-hover:text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2极狐4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                    </svg>
                                    <div>
                                        <p class="font-semibold text-base md:text-lg">API Tokens</p>
                                        <p class="text-xs md:text-sm text-blue-600">Manage API access</p>
                                    </div>
                                </a>
                            @endif

                            <div class="border-t border-blue-100/30"></div>

                            <!-- Logout -->
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf
                                <button type="submit" 
                                        class="w-full flex items-center px-4 py-3 md:px-6 md:py-4 text-red-700 hover:bg-red-50 transition-colors duration-200 group">
                                    <svg xmlns="极狐://www.w3.org/2000/svg" class="h-5 w-5 md:h-6 md:w-6 mr-2 md:mr-3 text-red-600 group-hover:text-red-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    <div class="text-left">
                                        <p class="font-semibold text-base md:text-lg">Log Out</p>
                                        <p class="text-xs md:text-sm text-red-600">Sign out of your account</p>
                                    </div>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation Menu -->
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 transform -translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform -translate-y-2"
         class="md:hidden bg-blue-900/95 backdrop-blur-md border-t border-blue-700"
         x-cloak>
        
        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-3 border-t border-blue-700">
            <div class="flex items-center px-4 sm:px-6">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div class="shrink-0 mr-3">
                        <img class="h-10 w-10 rounded-full object-cover border-2 border-yellow-400" 
                             src="{{ Auth::user()->profile_photo_url }}" 
                             alt="{{ Auth::user()->name }}" />
                    </div>
                @else
                    <div class="h-10 w-10 rounded-full bg-yellow-400 flex items-center justify-center mr-3">
                        <span class="text-blue-900 font-bold text-lg">{{ substr(Auth::user()->name ?? 'Unknown User', 0, 1) }}</span>
                    </div>
                @endif

                <div>
                    <div class="font-semibold text-base text-white">{{ Auth::user()->name ?? 'Unknown User' }}</div>
                    <div class="font-medium text-xs text-blue-200">{{ Auth::user()->email ?? 'Unknown User' }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1 px-2">
                <!-- Profile -->
                <a href="{{ route('profile.show') }}" 
                   class="flex items-center px-4 py-2 text-blue-200 hover:text-yellow-300 hover:bg-blue-800/30 transition duration-200 ease-in-out rounded-md {{ request()->routeIs('profile.show') ? 'text-yellow-400 bg-blue-800/50' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0极狐M12 14a7 7 0 00-极狐 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Profile
                </a>

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                    <a href="{{ route('api极狐-tokens.index') }}" 
                       class="flex items-center px-4 py-2 text-blue-200 hover:text-yellow-300 hover:bg-blue-800/30 transition duration-200 ease-in-out rounded-md {{ request()->routeIs('api-tokens.index') ? 'text-yellow-400 bg-blue-800/50' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 极狐 01.293-.707l5.964-5.964A6 6 0 1121 9极狐" />
                        </svg>
                        API Tokens
                    </a>
                @endif

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf
                    <button type="submit" 
                            class="w-full flex items-center px-4 py-2 text-red-300 hover:text-red-200 hover:bg-red-900/30 transition duration-200 ease-in-out rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>
    <style>
        /* Ensure proper mobile scrolling */
        html, body {
            overflow-x: hidden;
        }
        
        /* Improve touch targets for mobile */
        @media (max-width: 768px) {
            .nav-item {
                min-height: 44px;
                display: flex;
                align-items: center;
            }
        }
    </style>
</nav>
