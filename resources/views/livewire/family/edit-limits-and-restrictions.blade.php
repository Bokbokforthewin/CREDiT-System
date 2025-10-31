<div class="min-h-screen bg-overlay py-4 sm:py-6 lg:py-8 px-3 sm:px-4 lg:px-8" 
     x-data="editLimitsManager()" 
     x-init="init()">

    <!-- Header Section -->
    <div class="max-w-7xl mx-auto mb-6 sm:mb-8">
        <div class="glass-card rounded-2xl sm:rounded-3xl p-4 sm:p-6 lg:p-8 hover-lift slide-in">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 sm:gap-6">
                <div class="flex items-center space-x-3 sm:space-x-6 w-full sm:w-auto">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-orange-400 to-orange-500 rounded-xl sm:rounded-2xl flex items-center justify-center shadow-xl flex-shrink-0">
                        <svg class="w-8 h-8 sm:w-10 sm:h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-white mb-1 sm:mb-2 leading-tight">
                            <span class="text-yellow-400">Family Limits</span> & <span class="text-yellow-400">Restrictions</span>
                        </h1>
                        <p class="text-blue-200 text-base sm:text-lg">Manage member spending limits and department restrictions</p>
                    </div>
                </div>
                <div class="text-left sm:text-right w-full sm:w-auto">
                    <div class="text-2xl sm:text-3xl font-bold text-yellow-400" x-text="currentTime"></div>
                    <div class="text-blue-200 text-sm sm:text-base" x-text="currentDate"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="max-w-7xl mx-auto mb-6">
        <div class="flex flex-col sm:flex-row gap-4">
            <a href="{{ route('family.family-dashboard') }}" 
               class="glass-card hover-lift rounded-xl px-4 py-3 transition-all duration-300 group inline-flex items-center space-x-3">
                <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200 flex-shrink-0">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </div>
                <span class="text-white font-semibold text-base">Back to Family Dashboard</span>
            </a>
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('success'))
        <div class="max-w-7xl mx-auto mb-6">
            <div class="glass-card rounded-xl p-4 border-l-4 border-green-400" 
                 x-data="{ show: true }" 
                 x-show="show"
                 x-init="setTimeout(() => show = false, 5000)"
                 x-transition>
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-green-400 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-white font-semibold">{{ session('success') }}</span>
                    </div>
                    <button @click="show = false" class="text-blue-200 hover:text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="max-w-7xl mx-auto mb-6">
            <div class="glass-card rounded-xl p-4 border-l-4 border-red-400"
                 x-data="{ show: true }" 
                 x-show="show"
                 x-init="setTimeout(() => show = false, 5000)"
                 x-transition>
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-red-400 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        <span class="text-white font-semibold">{{ session('error') }}</span>
                    </div>
                    <button @click="show = false" class="text-blue-200 hover:text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Member Search Section -->
    <div class="max-w-7xl mx-auto mb-6">
        <div class="glass-card rounded-2xl p-4 sm:p-6 hover-lift">
            <h3 class="text-lg font-bold text-white mb-4 flex items-center">
                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                Search or Select Family Member
            </h3>

            <div class="relative" x-on:click.outside="$wire.closeDropdown()">
                <div class="relative">
                    <input type="text"
                           id="member-search"
                           wire:model.live="limitSearch"
                           placeholder="Start typing a member's name..."
                           class="glass-input rounded-xl px-4 py-3 pr-12 w-full text-white placeholder-blue-200 focus:outline-none">
                    
                    @if($selectedMember)
                        <button wire:click="clearSelection" 
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 px-3 py-1 hover:text-white/80 text-white/50 rounded-lg transition flex items-center space-x-1 text-sm font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    @else
                        <svg class="absolute right-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-blue-200 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    @endif
                </div>

                <!-- Search Dropdown -->
                @if ($showDropdown && $searchResults->isNotEmpty())
                    <div class="absolute z-50 w-full mt-2 glass-card rounded-xl border border-white/30 max-h-64 overflow-y-auto shadow-2xl">
                        @foreach ($searchResults as $member)
                            <button wire:click="selectMember('{{ $member->id }}')"
                                    class="w-full px-4 py-3 text-left hover:bg-white/10 transition-colors border-b border-white/10 last:border-b-0 flex items-center justify-between">
                                <div>
                                    <div class="text-white font-medium">{{ $member->name }}</div>
                                    <div class="text-blue-200 text-sm">{{ $member->family->family_name ?? 'N/A' }}</div>
                                </div>
                                <svg class="w-5 h-5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

    <!-- Rules Form or Empty State -->
    @if ($selectedMember)
        <!-- Selected Member Info -->
        <div class="max-w-7xl mx-auto mb-6 py-6">
            <div class="glass-card bg-white/5 rounded-xl p-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-white font-bold text-lg">{{ $selectedMember->name }}</h4>
                            <p class="text-blue-200 text-sm">Managing department rules</p>
                        </div>
                    </div>
                    <span class="bg-orange-400 text-blue-900 px-3 py-1 rounded-lg text-sm font-bold">
                        {{ count($departments) }} Departments
                    </span>
                </div>
            </div>
        </div>

        <!-- Department Rules Form -->
        <form wire:submit.prevent="saveChanges" class="max-w-7xl mx-auto">
            <div class="rounded-2xl overflow-hidden">

                <div class="p-4 sm:p-1 space-y-4">
                    @foreach ($departments as $dept)
                        @php
                            $isRestricted = $restrictions[$dept->id] ?? false;
                            $spendingLimit = $limits[$dept->id]['spending_limit'] ?? '';
                            $originalLimit = $limits[$dept->id]['original_limit'] ?? '';
                        @endphp
                        
                        <div class="glass-card rounded-xl p-6 {{ $isRestricted ? 'bg-red-500/10' : 'bg-green-500/10' }} border {{ $isRestricted ? 'border-red-500/30' : 'border-green-500/30' }}">
                            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                                <!-- Department Name -->
                                <div class="flex-shrink-0 sm:w-48">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-lg flex items-center justify-center">
                                            <span class="text-white font-bold text-sm">{{ substr($dept->name, 0, 1) }}</span>
                                        </div>
                                        <h3 class="text-white font-semibold text-base">{{ $dept->name }}</h3>
                                    </div>
                                </div>

                                <!-- Controls -->
                                <div class="flex-1 grid grid-cols-1 sm:grid-cols-3 gap-4 w-full">
                                    <!-- Spending Limit -->
                                    <div class="space-y-1">
                                        <label class="block text-xs text-blue-200 font-medium">Spending Limit (Current)</label>
                                        <div class="relative">
                                            <input type="text"
                                                   wire:model.live.debounce.300ms="limits.{{ $dept->id }}.spending_limit"
                                                   placeholder="e.g., 150.00"
                                                   {{ $isRestricted ? 'disabled' : '' }}
                                                   class="glass-input rounded-lg px-3 py-2 pr-8 w-full text-white text-sm placeholder-blue-200 focus:outline-none disabled:opacity-50 disabled:cursor-not-allowed">
                                            <span class="absolute right-3 top-2.5 text-sm {{ $isRestricted ? 'text-blue-300' : 'text-blue-200' }}">₱</span>
                                        </div>
                                    </div>

                                    <!-- Original Limit -->
                                    <div class="space-y-1">
                                        <label class="block text-xs text-blue-200 font-medium">Original Limit (Reference)</label>
                                        <div class="relative">
                                            <input type="text"
                                                   wire:model.live.debounce.300ms="limits.{{ $dept->id }}.original_limit"
                                                   placeholder="e.g., 200.00"
                                                   {{ $isRestricted ? 'disabled' : '' }}
                                                   class="glass-input rounded-lg px-3 py-2 pr-8 w-full text-white text-sm placeholder-blue-200 focus:outline-none disabled:opacity-50 disabled:cursor-not-allowed">
                                            <span class="absolute right-3 top-2.5 text-sm {{ $isRestricted ? 'text-blue-300' : 'text-blue-200' }}">₱</span>
                                        </div>
                                    </div>

                                    <!-- Restriction Toggle -->
                                    <div class="space-y-1">
                                        <label class="block text-xs text-blue-200 font-medium">Department Access</label>
                                        <div class="flex items-center space-x-3">
                                            <button type="button"
                                                    wire:click="updateRestriction({{ $dept->id }}, {{ $isRestricted ? 'false' : 'true' }})"
                                                    class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-transparent {{ $isRestricted ? 'bg-red-600 focus:ring-red-500' : 'bg-white/20 focus:ring-green-500' }}">
                                                <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform {{ $isRestricted ? 'translate-x-6' : 'translate-x-1' }}"></span>
                                            </button>
                                            <span class="text-xs font-medium {{ $isRestricted ? 'text-red-400' : 'text-green-400' }}">
                                                {{ $isRestricted ? 'Restricted' : 'Allowed' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

                <!-- Save Button -->
                <div class="p-4 sm:p-6 border-t border-white/20 flex justify-end">
                    <button type="submit"
                            class="px-8 py-3 bg-gradient-to-r from-orange-600 to-orange-700 text-white rounded-xl hover:from-orange-700 hover:to-orange-800 transition font-semibold shadow-lg flex items-center space-x-2 disabled:opacity-50 disabled:cursor-not-allowed"
                            wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="saveChanges">
                            <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            Save All Changes
                        </span>
                        <span wire:loading wire:target="saveChanges" class="flex items-center">
                            <svg class="w-5 h-5 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Saving...
                        </span>
                    </button>
                </div>
            </div>
        </form>
    @else
        <!-- Empty State -->
        <div class="max-w-7xl mx-auto p-20 text-center">
                <svg class="w-20 h-20 text-blue-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <p class="text-blue-200 text-xl font-semibold mb-2">Select a member to get started</p>
                <p class="text-blue-300 text-sm">Search for a member or family name above to manage their department rules.</p>
        </div>
    @endif
</div>

    <style>
        .bg-overlay {
            background-image: url("{{ asset('images/bg_cpac.png') }}");
            background-attachment: fixed;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .glass-input {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .glass-input:focus {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(251, 146, 60, 0.8);
            box-shadow: 0 0 0 3px rgba(251, 146, 60, 0.2);
        }
        
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }
        
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .slide-in {
            animation: slideInUp 0.6s ease-out;
        }

        /* Mobile optimizations */
        @media (max-width: 640px) {
            .hover-lift:hover {
                transform: none;
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            }
            
            button, a, select, input {
                min-height: 44px;
            }
        }

        [x-cloak] { 
            display: none !important; 
        }
    </style>

    <script>
        function editLimitsManager() {
            return {
                // Time and date
                currentTime: '',
                currentDate: '',

                init() {
                    this.updateTime();
                    setInterval(() => {
                        this.updateTime();
                    }, 1000);
                },

                updateTime() {
                    const now = new Date();
                    this.currentTime = now.toLocaleTimeString('en-US', {
                        hour: '2-digit',
                        minute: '2-digit',
                    });
                    this.currentDate = now.toLocaleDateString('en-US', {
                        weekday: 'long',
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    });
                }
            }
        }
    </script>
</div>