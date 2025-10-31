<div class="min-h-screen bg-overlay py-4 sm:py-6 lg:py-8 px-3 sm:px-4 lg:px-8" 
     x-data="familyDashboardManager()" 
     x-init="init()">

    <!-- Header Section -->
    <div class="max-w-7xl mx-auto mb-6 sm:mb-8">
        <div class="glass-card rounded-2xl sm:rounded-3xl p-4 sm:p-6 lg:p-8 hover-lift slide-in">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 sm:gap-6">
                <div class="flex items-center space-x-3 sm:space-x-6 w-full sm:w-auto">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-purple-400 to-purple-500 rounded-xl sm:rounded-2xl flex items-center justify-center shadow-xl flex-shrink-0">
                        <svg class="w-8 h-8 sm:w-10 sm:h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>   
                    </div>
                    <div class="min-w-0 flex-1">
                        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-yellow-400 mb-1 sm:mb-2 leading-tight">
                            <span class="text-white">Family</span> Dashboard
                        </h1>
                        <p class="text-2xl text-blue-200 mt-1">Welcome Back, 
                            <span class="text-2xl font-extrabold text-yellow-400">{{ auth()->user()->name ?? 'Guest User' }}</span>!
                        </p>
                    </div>
                </div>
                <div class="text-left sm:text-right w-full sm:w-auto">
                    <div class="text-2xl sm:text-3xl font-bold text-yellow-400" x-text="currentTime"></div>
                    <div class="text-blue-200 text-sm sm:text-base" x-text="currentDate"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons and Stats -->
    <div class="max-w-7xl mx-auto mb-6">
        <div class="flex flex-col sm:flex-row gap-4"">
            <!-- Edit Limits Button -->
            <a href="{{ route('family.editlimitsandrestrictions') }}" 
               class="glass-card hover-lift rounded-xl px-4 py-3 transition-all duration-300 group inline-flex items-center space-x-3">
                <div class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200 flex-shrink-0">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                    </svg>
                </div>
                <span class="text-white font-semibold text-base">Edit Limits & Restrictions</span>
            </a>

            @if ($hasFamilyMember && $charges->isNotEmpty())
                <!-- Total Charges Card -->
                <div class="glass-card rounded-xl px-4 py-3 flex items-center space-x-3">
                    <div class="w-8 h-8 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <div>
                        <span class="text-blue-200 text-xs block">Total Charges</span>
                        <span class="text-white font-semibold text-lg">{{ $charges->count() }} records</span>
                    </div>
                </div>

                <!-- Total Amount Card -->
                <div class="glass-card rounded-xl px-4 py-3 flex items-center space-x-3">
                    <div class="w-8 h-8 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>                          
                    </div>
                    <div>
                        <span class="text-blue-200 text-xs block">Total Amount</span>
                        <span class="text-white font-semibold text-lg">₱{{ number_format($charges->sum('price'), 2) }}</span>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @if (!$hasFamilyMember)
        <!-- No Family Warning -->
        <div class="max-w-7xl mx-auto mb-6">
            <div class="glass-card rounded-2xl p-6 border-l-4 border-yellow-400">
                <div class="flex items-start">
                    <svg class="w-6 h-6 text-yellow-400 mr-3 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-1.996-1.333-2.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <div>
                        <p class="font-bold text-yellow-400 text-lg mb-2">No Family Found</p>
                        <p class="text-blue-200 mb-2">It looks like your user account is not currently linked to a family account. Please complete your family registration.</p>
                        <p class="text-sm text-blue-300">Debug Info: User ID {{ auth()->id() }} has no record in family_members table.</p>
                    </div>
                </div>
            </div>
        </div>
        
        @else
        <!-- Filter and Search Section -->
        <div class="max-w-7xl mx-auto mb-6">
            <div class="glass-card rounded-2xl p-4 sm:p-6 hover-lift">
                <h3 class="text-lg font-bold text-white mb-4 flex items-center">
                    <div class="w-8 h-8 bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                    </div>
                    Filter & Search Charges
                </h3>
                
                <!-- Your filter inputs here (keep the same) -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Search Input -->
                    <div class="md:col-span-1">
                        <label for="search" class="block text-sm font-medium text-blue-200 mb-2">Search</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-blue-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="text" 
                                   wire:model.live.debounce.300ms="search" 
                                   id="search"
                                   class="glass-input rounded-xl pl-10 pr-3 py-2 w-full text-white placeholder-blue-300 focus:outline-none"
                                   placeholder="Description, department...">
                        </div>
                    </div>
    
                    <!-- Month Dropdown -->
                    <div>
                        <label for="selectedMonth" class="block text-sm font-medium text-blue-200 mb-2">Month</label>
                        <select wire:model.live="selectedMonth" id="selectedMonth"
                                class="glass-input rounded-xl py-2 px-3 w-full text-white focus:outline-none">
                            <option value="" class="text-white">All Months</option>
                            @foreach([
                                1 => 'January',
                                2 => 'February', 
                                3 => 'March',
                                4 => 'April',
                                5 => 'May',
                                6 => 'June',
                                7 => 'July',
                                8 => 'August',
                                9 => 'September',
                                10 => 'October',
                                11 => 'November',
                                12 => 'December'
                            ] as $monthNum => $monthName)
                                <option value="{{ $monthNum }}" class="text-white  ">{{ $monthName }}</option>
                            @endforeach
                        </select>
                    </div>
    
                    <!-- Year Dropdown -->
                    <div>
                        <label for="selectedYear" class="block text-sm font-medium text-blue-200 mb-2">Year</label>
                        <select wire:model.live="selectedYear" id="selectedYear"
                                class="glass-input rounded-xl py-2 px-3 w-full text-white focus:outline-none">
                            <option value="" class="text-white">All Years</option>
                            @for ($y = now()->year; $y >= 2020; $y--)
                                <option value="{{ $y }}" class="text-white">{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
    
                    <!-- Day Dropdown -->
                    <div>
                        <label for="selectedDay" class="block text-sm font-medium text-blue-200 mb-2">Day</label>
                        <select wire:model.live="selectedDay" id="selectedDay"
                                class="glass-input rounded-xl py-2 px-3 w-full text-white focus:outline-none">
                            <option value="" class="text-white">All Days</option>
                            @for ($d = 1; $d <= 31; $d++)
                                <option value="{{ $d }}" class="text-white">{{ $d }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
    
                <!-- Active Filters Indicator -->
                @if($search || $selectedMonth || $selectedYear || $selectedDay)
                    <div class="mt-4 flex flex-wrap gap-2 items-center">
                        @if($search)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-white/20 text-blue-200">
                                <span>Search: "{{ $search }}"</span>
                                <button wire:click="$set('search', '')" class="ml-2 text-blue-300 hover:text-white">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </span>
                        @endif
                        @if($selectedMonth)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-white/20 text-blue-200">
                                <span>Month: {{ \Carbon\Carbon::create()->month((int)$selectedMonth)->format('F') }}</span>
                                <button wire:click="$set('selectedMonth', '')" class="ml-2 text-blue-300 hover:text-white">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </span>
                        @endif
                        @if($selectedYear)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-white/20 text-blue-200">
                                <span>Year: {{ $selectedYear }}</span>
                                <button wire:click="$set('selectedYear', '')" class="ml-2 text-blue-300 hover:text-white">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </span>
                        @endif
                        @if($selectedDay)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-white/20 text-blue-200">
                                <span>Day: {{ $selectedDay }}</span>
                                <button wire:click="$set('selectedDay', '')" class="ml-2 text-blue-300 hover:text-white">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </span>
                        @endif
                        
                        <!-- Clear All Filters Button -->
                        <button wire:click="clearFilters" 
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-500/20 text-red-300 border border-red-400/30 hover:bg-red-500/30 transition">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Clear All
                        </button>
                    </div>
                @endif
            </div>
        </div>
    
        <!-- Charges Table Section -->
        <div class="max-w-7xl mx-auto">
            <div class="glass-card rounded-2xl overflow-hidden hover-lift">
                <div class="p-4 sm:p-6 border-b border-white/20">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                        <h2 class="text-xl sm:text-2xl font-bold text-white flex items-center">
                            <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                </svg>
                            </div>
                            Charges for <span class="text-yellow-400 px-1.5">{{ $familyName }}</span>
                        </h2>
                        <div class="text-blue-200 text-sm">
                            @if(method_exists($charges, 'total'))
                                {{ $charges->total() }} records
                            @else
                                {{ $charges->count() }} charges found
                            @endif
                        </div>
                    </div>
                </div>
    
               <!-- Table Content - Show table OR no charges message -->
                    @if($charges->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-white/10">
                                <tr>
                                    <th class="px-4 py-5 text-left text-xs font-medium text-blue-200 uppercase tracking-wider">ID</th>
                                    <th class="px-4 py-5 text-left text-xs font-medium text-blue-200 uppercase tracking-wider">Date</th>
                                    <th class="px-4 py-5 text-left text-xs font-medium text-blue-200 uppercase tracking-wider">Description</th>
                                    <th class="px-4 py-5 text-left text-xs font-medium text-blue-200 uppercase tracking-wider">Amount</th>
                                    <th class="px-4 py-5 text-left text-xs font-medium text-blue-200 uppercase tracking-wider">Department</th>
                                    <th class="px-4 py-5 text-left text-xs font-medium text-blue-200 uppercase tracking-wider">Family Member</th>
                                    <th class="px-4 py-5 text-left text-xs font-medium text-blue-200 uppercase tracking-wider">Staff</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/10">
                                @foreach ($charges as $charge)
                                    <tr class="hover:bg-white/5 transition-colors">
                                        <td class="px-4 py-5 whitespace-nowrap text-sm text-white font-medium">{{ $charge->id }}</td>
                                        <td class="px-4 py-5 whitespace-nowrap text-sm text-blue-200">{{ $charge->created_at->format('M d, Y') }}</td>
                                        <td class="px-4 py-5 text-sm text-white max-w-xs truncate">{{ $charge->description }}</td>
                                        <td class="px-4 py-5 whitespace-nowrap text-sm text-green-400 font-semibold">₱{{ number_format($charge->price, 2) }}</td>
                                        <td class="px-4 py-5 whitespace-nowrap text-sm text-white">{{ $charge->department->name }}</td>
                                        <td class="px-4 py-5 whitespace-nowrap text-sm text-blue-200">{{ $charge->member->name }}</td>
                                        <td class="px-4 py-5 whitespace-nowrap text-sm text-blue-200">{{ $charge->user->name }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="p-4 sm:p-6 border-t border-white/20 bg-white/5">
                        {{ $charges->links() }}
                    @else
                    <!-- No Charges Message - Inside the table card -->
                    <div class="p-12 text-center">
                        <svg class="w-20 h-20 text-blue-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <p class="text-blue-200 text-xl font-semibold mb-2">No charges found</p>
                        @if ($search || $selectedMonth || $selectedYear || $selectedDay)
                            <p class="text-blue-300 text-sm mb-4">No charges match your current filter criteria. Try adjusting your filters.</p>
                            <button wire:click="clearFilters" 
                                    class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg transition">
                                Clear All Filters
                            </button>
                        @else
                            <p class="text-blue-300 text-sm">Charges for your family account will appear here once they are created</p>
                        @endif
                    </div>
                    @endif
            </div>
        </div>
    @endif


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

        select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%23bfdbfe' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.75rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
        }

        select option {
            background-color: white !important;
            color: black !important;
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

            .glass-card {
                border-width: 1px;
                background: rgba(255, 255, 255, 0.12);
            }

            table {
                font-size: 0.875rem;
            }
            
            th, td {
                padding: 0.5rem 0.75rem;
            }
        }

        [x-cloak] { 
            display: none !important; 
        }
    </style>

    <script>
        function familyDashboardManager() {
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