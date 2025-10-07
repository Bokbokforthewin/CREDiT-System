<div class="min-h-screen bg-overlay py-4 sm:py-6 lg:py-8 px-3 sm:px-4 lg:px-8" 
     x-data="fullChargeViewManager()" 
     x-init="init()">

    <!-- Header Section -->
    <div class="max-w-7xl mx-auto mb-6 sm:mb-8">
        <div class="glass-card rounded-2xl sm:rounded-3xl p-4 sm:p-6 lg:p-8 hover-lift slide-in">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 sm:gap-6">
                <div class="flex items-center space-x-3 sm:space-x-6 w-full sm:w-auto">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-xl sm:rounded-2xl flex items-center justify-center shadow-xl flex-shrink-0">
                        <svg class="w-8 h-8 sm:w-10 sm:h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-white mb-1 sm:mb-2 leading-tight">
                            <span class="text-yellow-400">Full Charges</span> Overview
                        </h1>
                        <p class="text-blue-200 text-base sm:text-lg">Complete transaction history and analytics</p>
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
            <a href="{{ route('admin.dashboard') }}" 
               class="glass-card hover-lift rounded-xl p-4 transition-all duration-300 group inline-flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200 flex-shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </div>
                <span class="text-white font-semibold text-lg">Back to Dashboard</span>
            </a>

            <!-- Summary Stats -->
            {{-- <div class="glass-card rounded-xl p-4 flex items-center space-x-3 flex-1 sm:flex-initial">
                <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <div>
                    <span class="text-blue-200 text-sm">Showing</span>
                    <span class="text-white font-semibold text-lg ml-1">{{ $charges->total() }}</span>
                    <span class="text-blue-200 text-sm ml-1">records</span>
                </div>
            </div> --}}
        </div>
    </div>

    <!-- Enhanced Filter and Search Section -->
    <div class="max-w-7xl mx-auto mb-8">
        <div class="glass-card rounded-2xl p-4 sm:p-6 hover-lift">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
                <h3 class="text-xl font-bold text-white flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z"></path>
                        </svg>
                    </div>
                    Filter & Search
                </h3>

                <!-- Quick Clear Filters Button -->
                <button @click="clearAllFilters()" 
                        x-show="hasActiveFilters()"
                        x-transition
                        class="glass-card bg-white/10 hover:bg-white/20 rounded-lg px-4 py-2 text-sm font-medium text-blue-200 hover:text-white transition-all duration-300">
                    Clear All Filters
                </button>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4">
                <!-- Enhanced Search Input -->
                <div class="lg:col-span-2">
                    <label for="search" class="block text-sm font-medium text-blue-200 mb-2">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-blue-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input type="text" wire:model.live.debounce.300ms="search" id="search"
                               class="glass-input rounded-xl pl-10 pr-10 py-3 w-full text-white placeholder-blue-300 focus:outline-none"
                               placeholder="Family, description, staff...">
                        <!-- Clear search button -->
                        <button x-show="$wire.search" 
                                @click="$wire.set('search', '')"
                                x-transition
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-blue-300 hover:text-white">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Department Filter -->
                <div>
                    <label for="selectedDepartmentFilter" class="block text-sm font-medium text-blue-200 mb-2">
                        Department
                    </label>
                    <select id="selectedDepartmentFilter" wire:model.live="selectedDepartmentFilter"
                            class="glass-input rounded-xl py-3 px-3 w-full text-white focus:outline-none">
                        <option value="" class="text-gray-800">All Departments</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}" class="text-gray-800">{{ $dept->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Month Dropdown -->
                <div>
                    <label for="selectedMonth" class="block text-sm font-medium text-blue-200 mb-2">Month</label>
                    <select wire:model.live="selectedMonth" id="selectedMonth"
                            class="glass-input rounded-xl py-3 px-3 w-full text-white focus:outline-none">
                        @for ($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" class="text-gray-800">{{ \Carbon\Carbon::create()->month((int) $m)->format('F') }}</option>
                        @endfor
                    </select>
                </div>

                <!-- Year Dropdown -->
                <div>
                    <label for="selectedYear" class="block text-sm font-medium text-blue-200 mb-2">Year</label>
                    <select wire:model.live="selectedYear" id="selectedYear"
                            class="glass-input rounded-xl py-3 px-3 w-full text-white focus:outline-none">
                        @for ($y = now()->year; $y >= 2020; $y--)
                            <option value="{{ $y }}" class="text-gray-800">{{ $y }}</option>
                        @endfor
                    </select>
                </div>
            </div>

            <!-- Enhanced Active Filters Display -->
            <div x-show="hasActiveFilters()" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform scale-95"
                 x-transition:enter-end="opacity-100 transform scale-100"
                 class="mt-6 pt-4 border-t border-white/20">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-sm font-medium text-blue-200">Active Filters:</span>
                    <span class="text-xs text-blue-300" x-text="`${activeFilters().length} filter${activeFilters().length === 1 ? '' : 's'} applied`"></span>
                </div>
                <div class="flex flex-wrap gap-2">
                    <template x-for="filter in activeFilters()">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium glass-card bg-white/20 text-white border border-white/20">
                            <span x-text="filter"></span>
                            <button @click="removeFilter(filter)" 
                                    class="ml-2 text-blue-300 hover:text-white transition-colors">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </span>
                    </template>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Charges Table -->
    <div class="max-w-7xl mx-auto">
        <div class="glass-card rounded-2xl overflow-hidden hover-lift">
            <div class="p-4 sm:p-6 border-b border-white/20">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <h2 class="text-xl sm:text-2xl font-bold text-white flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center mr-4">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01"></path>
                            </svg>
                        </div>
                        Charges Overview
                    </h2>
                    
                    <!-- Results summary -->
                    <div class="glass-card bg-white/10 rounded-lg px-3 py-2">
                        <span class="text-blue-200 text-sm">Total: </span>
                        <span class="text-white font-bold">{{ $charges->total() }}</span>
                        @if($charges->total() > 0)
                            <span class="text-blue-200 text-sm ml-2">
                                (Page {{ $charges->currentPage() }} of {{ $charges->lastPage() }})
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            @if ($charges->isEmpty())
                <div class="p-12 text-center">
                    <div class="glass-card bg-white/5 rounded-2xl p-8 max-w-md mx-auto">
                        <svg class="w-20 h-20 text-blue-300 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        @if ($search || $selectedDepartmentFilter || $selectedMonth !== (int)now()->month || $selectedYear !== (int)now()->year)
                            <h3 class="text-white text-xl font-semibold mb-2">No charges found</h3>
                            <p class="text-blue-200 mb-4">No results match your current filter criteria</p>
                            <button @click="clearAllFilters()" 
                                    class="glass-card bg-blue-600/80 hover:bg-blue-600 rounded-lg px-6 py-3 text-white font-medium transition-all duration-300">
                                Clear All Filters
                            </button>
                        @else
                            <h3 class="text-white text-xl font-semibold mb-2">No charges yet</h3>
                            <p class="text-blue-200">Charges will appear here once they are created</p>
                        @endif
                    </div>
                </div>
            @else
                <!-- Mobile Card View -->
                <div class="block md:hidden">
                    <div class="p-4 space-y-4">
                        @foreach ($charges as $charge)
                            <div class="glass-card bg-white/5 rounded-xl p-4 hover:bg-white/10 transition-colors">
                                <div class="flex justify-between items-start mb-3">
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-white font-medium truncate">{{ $charge->description }}</h4>
                                        <p class="text-blue-200 text-sm mt-1">{{ $charge->member->full_name ?? 'N/A' }}</p>
                                        <p class="text-blue-300 text-xs">{{ $charge->member->family->family_name ?? 'N/A' }}</p>
                                    </div>
                                    <div class="text-right flex-shrink-0 ml-4">
                                        <div class="text-green-400 font-bold text-lg">₱{{ number_format($charge->price, 2) }}</div>
                                        @if($charge->status === 'Processed')
                                            <span class="inline-flex text-xs font-semibold px-2 py-1 rounded-full bg-green-400/20 text-green-400">
                                                Processed
                                            </span>
                                        @elseif($charge->status === 'Awaiting Processing')
                                            <span class="inline-flex text-xs font-semibold px-2 py-1 rounded-full bg-yellow-400/20 text-yellow-400">
                                                Awaiting
                                            </span>
                                        @else
                                            <span class="inline-flex text-xs font-semibold px-2 py-1 rounded-full bg-blue-400/20 text-blue-400">
                                                Pending
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <span class="text-blue-200">Date:</span>
                                        <span class="text-white ml-1">{{ \Carbon\Carbon::parse($charge->charge_datetime)->format('M d, Y') }}</span>
                                    </div>
                                    <div>
                                        <span class="text-blue-200">Dept:</span>
                                        <span class="text-white ml-1">{{ $charge->department->name ?? 'N/A' }}</span>
                                    </div>
                                    <div>
                                        <span class="text-blue-200">Staff:</span>
                                        <span class="text-white ml-1">{{ $charge->user->name ?? 'N/A' }}</span>
                                    </div>
                                    <div>
                                        <span class="text-blue-200">ID:</span>
                                        <span class="text-white ml-1">#{{ $charge->id }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Desktop Table View -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-white/10">
                            <tr>
                                <th class="px-4 py-4 text-left text-xs font-semibold text-blue-200 uppercase tracking-wider">ID</th>
                                <th class="px-4 py-4 text-left text-xs font-semibold text-blue-200 uppercase tracking-wider">Date</th>
                                <th class="px-4 py-4 text-left text-xs font-semibold text-blue-200 uppercase tracking-wider">Description</th>
                                <th class="px-4 py-4 text-left text-xs font-semibold text-blue-200 uppercase tracking-wider">Price</th>
                                <th class="px-4 py-4 text-left text-xs font-semibold text-blue-200 uppercase tracking-wider">Family Member</th>
                                <th class="px-4 py-4 text-left text-xs font-semibold text-blue-200 uppercase tracking-wider">Department</th>
                                <th class="px-4 py-4 text-left text-xs font-semibold text-blue-200 uppercase tracking-wider">Staff</th>
                                <th class="px-4 py-4 text-left text-xs font-semibold text-blue-200 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/10">
                            @foreach ($charges as $charge)
                                <tr class="hover:bg-white/5 transition-colors">
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-white">#{{ $charge->id }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-white">{{ \Carbon\Carbon::parse($charge->charge_datetime)->format('M d, Y') }}</td>
                                    <td class="px-4 py-4 text-sm text-white max-w-xs">
                                        <div class="truncate" title="{{ $charge->description }}">{{ $charge->description }}</div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-green-400 font-bold">₱{{ number_format($charge->price, 2) }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-white">
                                        <div class="max-w-xs">
                                            <div class="truncate font-medium">{{ $charge->member->full_name ?? 'N/A' }}</div>
                                            @if($charge->member->family ?? false)
                                                <div class="text-xs text-blue-200 truncate">{{ $charge->member->family->family_name }}</div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-white">{{ $charge->department->name ?? 'N/A' }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-blue-200">{{ $charge->user->name ?? 'N/A' }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        @if($charge->status === 'Processed')
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-400/20 text-green-400 border border-green-400/30">
                                                Processed
                                            </span>
                                        @elseif($charge->status === 'Awaiting Processing')
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-400/20 text-yellow-400 border border-yellow-400/30">
                                                Awaiting Processing
                                            </span>
                                        @else
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-800/20 text-blue-400 border border-blue-400/30">
                                                Pending
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
            <div class="p-6 border-t border-white/20 bg-white/5">{{ $charges->links() }}</div>
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
            border-color: rgba(251, 191, 36, 0.8);
            box-shadow: 0 0 0 3px rgba(251, 191, 36, 0.2);
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

        /* Custom select styling */
        select.glass-input {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%23ffffff' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.75rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
        }

        /* Custom scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }

        /* Enhanced text contrast */
        .text-white {
            color: #ffffff !important;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
        }

        .text-blue-200 {
            color: #bfdbfe !important;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
        }

        .text-blue-300 {
            color: #93c5fd !important;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
        }

        .text-yellow-400 {
            color: #fbbf24 !important;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.4);
        }

        .text-green-400 {
            color: #34d399 !important;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.4);
        }

        /* Mobile optimizations */
        @media (max-width: 768px) {
            .hover-lift:hover {
                transform: none;
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            }
            
            button, a, select, input {
                min-height: 44px;
            }

            .glass-card {
                border-width: 1px;
                background: rgba(255, 255, 255, 0.12);
            }

            /* Improve mobile table spacing */
            table th, table td {
                padding: 0.75rem 0.5rem;
            }
        }

        /* Improved button focus states for accessibility */
        button:focus, input:focus, select:focus {
            outline: 2px solid rgba(251, 191, 36, 0.8);
            outline-offset: 2px;
        }

        [x-cloak] { 
            display: none !important; 
        }
    </style>

    <script>
        function fullChargeViewManager() {
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
                },

                hasActiveFilters() {
                    return this.activeFilters().length > 0;
                },

                activeFilters() {
                    const filters = [];
                    
                    // Search filter
                    if (this.$wire.search && this.$wire.search.trim()) {
                        filters.push(`Search: "${this.$wire.search.trim()}"`);
                    }
                    
                    // Department filter
                    if (this.$wire.selectedDepartmentFilter) {
                        const deptSelect = document.getElementById('selectedDepartmentFilter');
                        const selectedOption = deptSelect.querySelector(`option[value="${this.$wire.selectedDepartmentFilter}"]`);
                        if (selectedOption) {
                            filters.push(`Dept: ${selectedOption.textContent}`);
                        }
                    }
                    
                    // Month filter - only show if different from current month
                    const currentMonth = new Date().getMonth() + 1;
                    if (this.$wire.selectedMonth && this.$wire.selectedMonth !== currentMonth) {
                        const monthNames = ['January', 'February', 'March', 'April', 'May', 'June',
                                          'July', 'August', 'September', 'October', 'November', 'December'];
                        filters.push(`Month: ${monthNames[this.$wire.selectedMonth - 1]}`);
                    }
                    
                    // Year filter - only show if different from current year
                    const currentYear = new Date().getFullYear();
                    if (this.$wire.selectedYear && this.$wire.selectedYear !== currentYear) {
                        filters.push(`Year: ${this.$wire.selectedYear}`);
                    }
                    
                    return filters;
                },

                removeFilter(filterText) {
                    const filterType = filterText.split(':')[0].trim();
                    
                    switch(filterType) {
                        case 'Search':
                            this.$wire.set('search', '');
                            break;
                        case 'Dept':
                            this.$wire.set('selectedDepartmentFilter', '');
                            break;
                        case 'Month':
                            this.$wire.set('selectedMonth', new Date().getMonth() + 1);
                            break;
                        case 'Year':
                            this.$wire.set('selectedYear', new Date().getFullYear());
                            break;
                    }
                },

                clearAllFilters() {
                    this.$wire.set('search', '');
                    this.$wire.set('selectedDepartmentFilter', '');
                    this.$wire.set('selectedMonth', new Date().getMonth() + 1);
                    this.$wire.set('selectedYear', new Date().getFullYear());
                }
            }
        }
    </script>
</div>