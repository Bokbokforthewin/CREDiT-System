<div class="min-h-screen bg-overlay py-4 sm:py-6 lg:py-8 px-3 sm:px-4 lg:px-8" 
     x-data="auditManager()" 
     x-init="init()">

    <!-- Header Section -->
    <div class="max-w-7xl mx-auto mb-6 sm:mb-8">
        <div class="glass-card rounded-2xl sm:rounded-3xl p-4 sm:p-6 lg:p-8 hover-lift slide-in">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 sm:gap-6">
                <div class="flex items-center space-x-3 sm:space-x-6 w-full sm:w-auto">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-purple-400 to-purple-500 rounded-xl sm:rounded-2xl flex items-center justify-center shadow-xl flex-shrink-0">
                        <svg class="w-8 h-8 sm:w-10 sm:h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-white mb-1 sm:mb-2 leading-tight">
                            <span class="text-yellow-400">System Audit Log</span>
                        </h1>
                        <p class="text-blue-200 text-base sm:text-lg">Comprehensive history of all critical system actions</p>
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
            <a href="{{ route('business.dashboard') }}" 
                class="glass-card hover-lift rounded-xl px-4 sm:px-6 py-3 sm:py-4 text-white flex items-center justify space-x-3 transition-all duration-300 group w-full sm:w-auto">
                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </div>
                <span class="text-white font-semibold text-lg">Back to Dashboard</span>
            </a>

            <!-- Summary Stats -->
            <div class="glass-card rounded-xl px-4 py-3 flex items-center space-x-3">
                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <div>
                    <span class="text-blue-200 text-xs">Total Records</span>
                    <span class="text-white font-semibold text-lg ml-1">{{ $logs->total() }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter and Search Section -->
    <div class="max-w-7xl mx-auto mb-6">
        <div class="glass-card rounded-2xl p-4 sm:p-6 hover-lift">
            <h3 class="text-lg font-bold text-white mb-4 flex items-center">
                <div class="w-8 h-8 bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z"></path>
                    </svg>
                </div>
                Filter & Search Audit Logs
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search Input -->
                <div class="md:col-span-1">
                    <label for="search" class="block text-sm font-medium text-blue-200 mb-2">Search User/Action</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-blue-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input type="text" wire:model.live.debounce.300ms="filters.search" id="search"
                               class="glass-input rounded-xl pl-10 pr-3 py-2 w-full text-white placeholder-blue-300 focus:outline-none"
                               placeholder="E.g., John Smith, updated">
                    </div>
                </div>

                <!-- Action Type Dropdown -->
                <div>
                    <label for="action_type" class="block text-sm font-medium text-blue-200 mb-2">Filter by Action</label>
                    <select wire:model.live="filters.action_type" id="action_type"
                            class="glass-input rounded-xl py-2 px-3 w-full text-white focus:outline-none">
                        <option value="" class="text-gray-800">All Actions</option>
                        <option value="created" class="text-gray-800">Created</option>
                        <option value="updated" class="text-gray-800">Updated</option>
                        <option value="deleted" class="text-gray-800">Deleted</option>
                        <option value="processed" class="text-gray-800">Processed (Charge)</option>
                        <option value="spending_limit_updated" class="text-gray-800">Limit Changed</option>
                        <option value="csv_report_sent" class="text-gray-800">CSV Report Sent</option>
                        <option value="charges_confirmed" class="text-gray-800">Confirmed Charges</option>
                        <option value="charges_prepared" class="text-gray-800">Prepared Charges</option>
                    </select>
                </div>

                <!-- Model Type Dropdown -->
                <div>
                    <label for="model_type" class="block text-sm font-medium text-blue-200 mb-2">Filter by Entity</label>
                    <select wire:model.live="filters.model_type" id="model_type"
                            class="glass-input rounded-xl py-2 px-3 w-full text-white focus:outline-none">
                        <option value="" class="text-gray-800">All Entities</option>
                        @foreach ($availableModels as $model)
                            <option value="{{ $model }}" class="text-gray-800">{{ $model }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Reset Button -->
                <div class="flex items-end">
                    <button @click="$wire.set('filters.search', ''); $wire.set('filters.action_type', ''); $wire.set('filters.model_type', '')"
                            class="w-full glass-card hover-lift rounded-xl px-4 py-2 transition-all duration-300 inline-flex items-center justify-center space-x-2">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        <span class="text-white font-semibold text-sm">Reset Filters</span>
                    </button>
                </div>
            </div>

            <!-- Active Filters Indicator -->
            <div x-show="hasActiveFilters()" x-transition class="mt-4 flex flex-wrap gap-2">
                <template x-for="filter in activeFilters()">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-white/20 text-blue-200">
                        <span x-text="filter"></span>
                        <button @click="removeFilter(filter)" class="ml-2 text-blue-300 hover:text-white">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </span>
                </template>
            </div>
        </div>
    </div>

    <!-- Audit Log Table -->
    <div class="max-w-7xl mx-auto">
        <div class="glass-card rounded-2xl overflow-hidden hover-lift">
            <div class="p-4 sm:p-6 border-b border-white/20">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <h2 class="text-xl sm:text-2xl font-bold text-white flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center mr-4">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        Audit History
                    </h2>
                    <div class="text-blue-200 text-sm">
                        {{ $logs->total() }} records found
                    </div>
                </div>
            </div>

            @if ($logs->isEmpty())
                <div class="p-8 text-center text-blue-200">
                    <svg class="w-16 h-16 text-blue-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-lg mb-2">No audit logs found</p>
                    <p class="text-sm">Try adjusting your search or filter parameters</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-white/10">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-blue-200 uppercase tracking-wider">Timestamp</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-blue-200 uppercase tracking-wider">Action By</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-blue-200 uppercase tracking-wider">Action</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-blue-200 uppercase tracking-wider">Entity Type & ID</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-blue-200 uppercase tracking-wider">Details</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/10">
                            @foreach ($logs as $log)
                                <tr class="hover:bg-white/5 transition-colors @if ($log->action === 'deleted') bg-red-500/10 @elseif($log->action === 'created') bg-green-500/10 @endif">
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-white">
                                        {{ $log->created_at->format('M d, Y') }}<br>
                                        <span class="text-blue-200 text-xs">{{ $log->created_at->format('g:i A') }}</span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-white font-semibold">
                                        {{ $log->user->name ?? 'System' }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        @if($log->action === 'created')
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-400/20 text-green-400 border border-green-400/30">
                                                Created
                                            </span>
                                        @elseif($log->action === 'updated')
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-400/20 text-blue-400 border border-blue-400/30">
                                                Updated
                                            </span>
                                        @elseif($log->action === 'deleted')
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-400/20 text-red-400 border border-red-400/30">
                                                Deleted
                                            </span>
                                        @elseif($log->action === 'charges_confirmed')
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-400/20 text-purple-400 border border-purple-400/30">
                                                Charges Confirmed
                                            </span>
                                        @elseif($log->action === 'charges_prepared')
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-400/20 text-indigo-400 border border-indigo-400/30">
                                                Charges Prepared
                                            </span>
                                        @elseif($log->action === 'csv_report_sent')
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-400/20 text-yellow-400 border border-yellow-400/30">
                                                CSV Report Sent
                                            </span>
                                        @else
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-400/20 text-orange-400 border border-orange-400/30">
                                                {{ str_replace('_', ' ', Str::title($log->action)) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-white">
                                        @if ($log->action == 'charges_confirmed' || $log->action == 'csv_report_sent' || $log->action == 'charges_prepared')
                                            <span class="font-bold text-yellow-400">Audit</span>
                                            <span class="text-blue-200 text-xs block">(ID: {{ $log->id }})</span>
                                        @else
                                            <span class="font-bold text-yellow-400">{{ str_replace('App\Models\\', '', $log->auditable_type) }}</span>
                                            <span class="text-blue-200 text-xs block">(ID: {{ $log->auditable_id }})</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-sm text-white max-w-md">
                                        @if ($log->action === 'updated' || Str::contains($log->action, 'updated'))
                                            <div class="space-y-1">
                                                <span class="font-bold text-yellow-400">Changes:</span>
                                                <ul class="list-disc list-inside space-y-1 text-blue-200">
                                                    @foreach (($log->new_values ?? []) as $key => $newValue)
                                                        @if(isset($log->old_values[$key]) && $key !== 'updated_at' && $key !== 'created_at')
                                                            <li class="text-xs">
                                                                <span class="text-blue-300">{{ Str::title($key) }}:</span>
                                                                <span class="line-through text-red-400">{{ $log->old_values[$key] }}</span>
                                                                →
                                                                <span class="text-green-400 font-medium">{{ $newValue }}</span>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @elseif ($log->action === 'created')
                                            <span class="text-green-400 font-bold">New record created</span>
                                        @elseif ($log->action === 'deleted')
                                            <span class="text-red-400 font-bold">Record permanently deleted</span>
                                        @else
                                            <div class="space-y-1">
                                                <span class="font-bold text-yellow-400">{{ Str::title($log->action) }} Details:</span>
                                                <pre class="text-xs bg-white/10 p-2 rounded mt-1 max-h-32 overflow-auto text-blue-200">{{ json_encode($log->new_values, JSON_PRETTY_PRINT) }}</pre>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="p-6 border-t border-white/20 bg-white/5">{{ $logs->links() }}</div>
            @endif
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
        function auditManager() {
            return {
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
                    
                    if (this.$wire.filters.search) {
                        filters.push(`Search: "${this.$wire.filters.search}"`);
                    }
                    
                    if (this.$wire.filters.action_type) {
                        filters.push(`Action: ${this.$wire.filters.action_type}`);
                    }
                    
                    if (this.$wire.filters.model_type) {
                        filters.push(`Entity: ${this.$wire.filters.model_type}`);
                    }
                    
                    return filters;
                },

                removeFilter(filterText) {
                    const filterType = filterText.split(':')[0].trim();
                    
                    switch(filterType) {
                        case 'Search':
                            this.$wire.set('filters.search', '');
                            break;
                        case 'Action':
                            this.$wire.set('filters.action_type', '');
                            break;
                        case 'Entity':
                            this.$wire.set('filters.model_type', '');
                            break;
                    }
                }
            }
        }
    </script>
</div>