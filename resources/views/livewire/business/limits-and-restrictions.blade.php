<div class="min-h-screen bg-overlay py-4 sm:py-6 lg:py-8 px-3 sm:px-4 lg:px-8" 
     x-data="limitsRestrictionsManager()" 
     x-init="init()"
     @click.away="closeDropdown()">

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
                            <span class="text-yellow-400">Limits</span> & <span class="text-yellow-400">Restrictions</span>
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
    <div class="max-w-7xl mx-auto mb-6 sm:mb-8">
        <div class="flex flex-col sm:flex-row gap-4">
            <a href="{{ route('business.managefamiliespage') }}" 
               class="glass-card hover-lift rounded-xl p-4 transition-all duration-300 group">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200 flex-shrink-0">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </div>
                    <span class="text-white font-semibold text-lg">Back to Family Management</span>
                </div>
            </a>
        </div>
    </div>

    

    <!-- Toast Messages -->
    <div class="max-w-7xl mx-auto mb-6">
        <div x-show="showToast" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform translate-x-full"
             x-transition:enter-end="opacity-100 transform translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform translate-x-0"
             x-transition:leave-end="opacity-0 transform translate-x-full"
             class="glass-card rounded-xl p-4 border-l-4 mb-4"
             :class="toastType === 'success' ? 'border-green-400' : 'border-red-400'">
            <div class="flex items-center">
                <svg x-show="toastType === 'success'" class="w-6 h-6 text-green-400 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <svg x-show="toastType === 'error'" class="w-6 h-6 text-red-400 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                <span class="text-white font-semibold" x-text="toastMessage"></span>
            </div>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="max-w-7xl mx-auto">
        <div class="glass-card rounded-2xl sm:rounded-3xl overflow-hidden hover-lift">
            <div class="p-4 sm:p-6 lg:p-8 border-b border-white/20">
                <h3 class="text-xl sm:text-2xl font-bold text-white flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    Member Department Rules Editor
                </h3>
            </div>

            <div class="p-4 sm:p-6 lg:p-8">
                <!-- Search with Dropdown -->
                <div class="mb-8 relative" @click.away="$wire.closeDropdown()">
                    <label class="block text-sm font-semibold text-blue-200 mb-3">Search Member</label>
                    <div class="relative">
                        <input type="text" 
                               wire:model.live.debounce.300ms="limitSearch"
                               placeholder="Type member name or family name..."
                               class="glass-input rounded-xl px-4 py-3 pr-12 w-full text-white placeholder-blue-200 focus:outline-none"
                               @focus="$wire.set('showDropdown', {{ $showDropdown ? 'true' : 'false' }})">
                        
                        @if($selectedMember)
                            <button wire:click="clearSelection" 
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-blue-200 hover:text-white transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        @else
                            <svg class="absolute right-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        @endif
                    </div>

                    <!-- Dropdown Results -->
                    @if($showDropdown && $searchResults->isNotEmpty())
                        <div class="absolute top-full left-0 right-0 mt-2 glass-card rounded-xl border border-white/20 max-h-64 overflow-y-auto z-50">
                            @foreach($searchResults as $result)
                                <button wire:click="selectMember({{ $result->id }})"
                                        class="w-full px-4 py-3 text-left hover:bg-white/10 transition-colors border-b border-white/10 last:border-b-0">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <div class="text-white font-medium">{{ $result->name }}</div>
                                            <div class="text-blue-200 text-sm">{{ $result->family->family_name }}</div>
                                        </div>
                                        <div class="text-xs text-blue-300 bg-white/10 px-2 py-1 rounded">
                                            {{ $result->role === 'head' ? 'Head' : 'Member' }}
                                        </div>
                                    </div>
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Content Based on Selection -->
                @if(!$selectedMember)
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 text-blue-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <p class="text-blue-200 text-lg font-medium mb-2">Select a member to get started</p>
                        <p class="text-blue-300 text-sm">Search for a member or family name above to manage their department rules.</p>
                    </div>
                @else
                    <!-- Selected Member Info -->
                    <div class="glass-card bg-white/5 rounded-xl p-4 mb-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-white font-bold text-lg">{{ $selectedMember->name }}</h4>
                                    <p class="text-blue-200 text-sm">{{ $selectedMember->family->family_name }} • {{ ucfirst($selectedMember->role) }}</p>
                                </div>
                            </div>
                            <span class="bg-orange-400 text-blue-900 px-3 py-1 rounded-lg text-sm font-bold">
                                {{ count($departments) }} Departments
                            </span>
                        </div>
                    </div>

                    <!-- Vertical Department Rules -->
                    <div class="space-y-4">
                        @foreach($departments as $dept)
                            <div class="glass-card bg-white/5 rounded-xl p-4 sm:p-6">
                                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                                    <!-- Department Name -->
                                    <div class="flex-shrink-0 sm:w-40">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-lg flex items-center justify-center">
                                                <span class="text-white font-bold text-xs">{{ substr($dept->name, 0, 1) }}</span>
                                            </div>
                                            <h5 class="text-white font-semibold text-base">{{ $dept->name }}</h5>
                                        </div>
                                    </div>

                                    <!-- Controls -->
                                    <div class="flex-1 grid grid-cols-1 sm:grid-cols-3 gap-4 items-center">
                                        <!-- Spending Limit -->
                                        <div class="space-y-1">
                                            <label class="block text-xs text-blue-200 font-medium">Spending Limit</label>
                                            <input type="number" 
                                                   step="0.01" 
                                                   placeholder="0.00"
                                                   wire:model.defer="limits.{{ $dept->id }}.spending_limit"
                                                   :disabled="{{ $restrictions[$dept->id] ?? false ? 'true' : 'false' }}"
                                                   class="glass-input rounded-lg px-3 py-2 w-full text-white text-sm placeholder-blue-200 focus:outline-none disabled:opacity-50 disabled:cursor-not-allowed">
                                        </div>

                                        <!-- Original Limit -->
                                        <div class="space-y-1">
                                            <label class="block text-xs text-blue-200 font-medium">Original Limit</label>
                                            <input type="number" 
                                                   step="0.01" 
                                                   placeholder="0.00"
                                                   wire:model.defer="limits.{{ $dept->id }}.original_limit"
                                                   :disabled="{{ $restrictions[$dept->id] ?? false ? 'true' : 'false' }}"
                                                   class="glass-input rounded-lg px-3 py-2 w-full text-white text-sm placeholder-blue-200 focus:outline-none disabled:opacity-50 disabled:cursor-not-allowed">
                                        </div>

                                        <!-- Restriction Toggle -->
                                        <div class="space-y-1">
                                            <label class="block text-xs text-blue-200 font-medium">Department Access</label>
                                            <div class="flex items-center space-x-3">
                                                <label class="inline-flex items-center cursor-pointer">
                                                    <input type="checkbox" 
                                                           wire:change="updateRestriction({{ $dept->id }}, $event.target.checked)"
                                                           @checked($restrictions[$dept->id] ?? false)
                                                           class="sr-only peer">
                                                    <div class="relative w-11 h-6 bg-white/20 rounded-full peer peer-focus:ring-4 peer-focus:ring-red-300/25 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-red-600">
                                                    </div>
                                                </label>
                                                <span class="text-xs font-medium" 
                                                      :class="{{ $restrictions[$dept->id] ?? false ? "'text-red-400'" : "'text-green-400'" }}">
                                                    {{ $restrictions[$dept->id] ?? false ? 'Restricted' : 'Allowed' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Save Button -->
                    <div class="mt-8 flex justify-end">
                        <button wire:click="saveChanges"
                                class="px-8 py-3 bg-gradient-to-r from-orange-600 to-orange-700 text-white rounded-xl hover:from-orange-700 hover:to-orange-800 transition font-semibold shadow-lg flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Save Rules for {{ $selectedMember->name }}</span>
                        </button>
                    </div>
                @endif
            </div>
        </div>
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
        function limitsRestrictionsManager() {
            return {
                // Time and date
                currentTime: '',
                currentDate: '',
                
                // Toast notifications
                showToast: false,
                toastMessage: '',
                toastType: 'success',

                init() {
                    this.updateTime();
                    setInterval(() => {
                        this.updateTime();
                    }, 1000);

                    // Listen for Livewire events
                    this.$wire.on('rulesSaved', () => {
                        this.showToastNotification('Rules updated successfully!', 'success');
                    });

                    this.$wire.on('error', (message) => {
                        this.showToastNotification(message, 'error');
                    });
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
                },

                showToastNotification(message, type = 'success') {
                    this.toastMessage = message;
                    this.toastType = type;
                    this.showToast = true;
                    
                    setTimeout(() => {
                        this.showToast = false;
                    }, 5000);
                },

                closeDropdown() {
                    this.$wire.call('closeDropdown');
                }
            }
        }
    </script>
</div>