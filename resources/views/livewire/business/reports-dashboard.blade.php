<div class="min-h-screen bg-overlay py-4 sm:py-6 lg:py-8 px-3 sm:px-4 lg:px-8" 
     x-data="reportsDashboardManager()" 
     x-init="init()">

    <!-- Header Section -->
    <div class="max-w-7xl mx-auto mb-6 sm:mb-8">
        <div class="glass-card rounded-2xl sm:rounded-3xl p-4 sm:p-6 lg:p-8 hover-lift slide-in">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 sm:gap-6">
                <div class="flex items-center space-x-3 sm:space-x-6 w-full sm:w-auto">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-xl sm:rounded-2xl flex items-center justify-center shadow-xl flex-shrink-0">
                        <svg class="w-8 h-8 sm:w-10 sm:h-10 text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-white mb-1 sm:mb-2 leading-tight">
                            <span class="text-yellow-400">Reports</span> Dashboard
                        </h2>
                        <p class="text-blue-200 text-base sm:text-lg lg:text-xl">Analytics & Monthly Charge Processing</p>
                    </div>
                </div>
                <div class="text-left sm:text-right w-full sm:w-auto">
                    <div class="text-2xl sm:text-3xl font-bold text-yellow-400" x-text="currentTime"></div>
                    <div class="text-blue-200 text-sm sm:text-base" x-text="currentDate"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    <div class="max-w-7xl mx-auto mb-6">
        @if (session()->has('success'))
            <div class="glass-card rounded-xl p-4 border-l-4 border-green-400 mb-4">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-green-400 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span class="text-white font-semibold">{{ session('success') }}</span>
                </div>
            </div>
        @endif
        
        @if (session()->has('error'))
            <div class="glass-card rounded-xl p-4 border-l-4 border-red-400 mb-4">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-red-400 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    <span class="text-white font-semibold">{{ session('error') }}</span>
                </div>
            </div>
        @endif
    </div>

    <!-- PRIORITY SECTION: Confirmations & Monthly Reports -->
    <div class="max-w-7xl mx-auto mb-8">
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
            
            <!-- Pending Confirmations -->
            <div class="glass-card rounded-2xl overflow-hidden hover-lift">
                @if($showConfirmationShade)
                    <div class="p-4 sm:p-6 min-h-[700px] bg-gradient-to-br from-yellow-500/20 to-orange-500/20 border-b border-white/20">
                        <h3 class="text-xl sm:text-2xl font-bold text-white mb-4 flex items-center">
                            <div class="w-10 h-10 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.728-.833-2.498 0L3.316 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                            </div>
                            Awaiting Confirmation
                        </h3>
                        
                        <div class="space-y-4">
                            <p class="text-blue-200 mb-2 text-base sm:text-lg">
                                <span class="font-bold text-xl text-yellow-400">{{ $pendingChargesCount }}</span> charges prepared across departments awaiting final processing.
                            </p>
                            
                            @if($departmentsWithPreparedCharges->isNotEmpty())
                                <div class="space-y-3">
                                    <h4 class="font-semibold text-white text-base">Departments with prepared charges:</h4>
                                    <div class="max-h-100 overflow-y-auto pr-2 custom-scrollbar space-y-2">
                                        @foreach($departmentsWithPreparedCharges as $deptSummary)
                                            <div class="flex items-center justify-between py-2 px-3 bg-white/10 rounded-lg text-sm">
                                                <span class="text-white font-medium">{{ $deptSummary->name }}</span>
                                                <span class="text-yellow-400 font-bold text-base">{{ $deptSummary->count }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if(count($departmentsWithoutPreparedCharges) > 0)
                                <div class="glass-card bg-red-500/10 border border-red-400/30 rounded-lg p-3">
                                    <h4 class="font-semibold text-white text-sm mb-2">Pending departments:</h4>
                                    <div class="max-h-1000 overflow-y-auto custom-scrollbar">
                                        @foreach($departmentsWithoutPreparedCharges as $deptName)
                                            <div class="text-sm text-white py-1">• {{ $deptName }}</div>
                                        @endforeach
                                    </div>
                                    <p class="mt-2 text-sm text-red-300">Consider waiting for all departments before confirming globally.</p>
                                </div>
                            @endif

                            <button wire:click="showFinalConfirmation"
                                class="w-full px-6 py-4 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl hover:from-green-700 hover:to-green-800 transition font-semibold shadow-lg hover-lift text-base">
                                <span wire:loading.remove>Review & Confirm All</span>
                                <span wire:loading class="flex items-center justify-center">
                                    <svg class="animate-spin h-5 w-5 mr-2 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Loading...
                                </span>
                            </button>
                        </div>
                    </div>
                @else
                <div class="p-4 sm:p-6 flex items-center justify-center min-h-[700px] bg-gradient-to-br from-green-500/20 to-emerald-500/20 rounded-lg">
                    <div class="text-center flex flex-col items-center justify-center">
                        <h3 class="text-xl sm:text-3xl font-bold text-white mb-3 flex items-center justify-center">
                            <div class="w-10 h-10 bg-gradient-to-br from-green-400 to-emerald-500 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            All Clear!
                        </h3>
                        <h4 class="text-xl text-green-200">All departmental charges processed.</h4>
                        @if($lastProcessedDate)
                            <div class="mt-3 text-sm text-green-300">
                                Last processing: {{ \Carbon\Carbon::parse($lastProcessedDate)->format('M j, Y g:i A') }}
                            </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>

            <!-- Monthly Charges Report -->
            <div class="glass-card rounded-2xl overflow-hidden hover-lift">
                <div class="p-4 sm:p-6 border-b border-white/20">
                    @if(is_null($selectedDepartment))
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2 sm:gap-0">
                            <h3 class="text-xl sm:text-2xl font-bold text-white">Monthly Report Summary</h3>
                            <div class="text-lg sm:text-xl font-bold text-green-400">
                                Total: ₱{{ number_format($chargesReport->flatten()->sum('total_charges'), 2) }}
                            </div>
                        </div>
                    @else
                        <h3 class="text-xl sm:text-2xl font-bold text-white">{{ $departments->firstWhere('id', $selectedDepartment)->name }} Report</h3>
                    @endif
                </div>
                
                <div class="p-4 sm:p-6">
                    <!-- Search and Filters -->
                    <div class="space-y-4 mb-6">
                        <input type="text" wire:model.live.debounce.300ms="search"
                            placeholder="Search families or departments..."
                            class="w-full glass-input rounded-lg px-4 py-3 text-white placeholder-blue-200 focus:outline-none text-sm">
                        
                        <div class="grid grid-cols-2 gap-3">
                            <select wire:model.live="month" class="glass-input rounded-lg px-3 py-3 text-white text-sm focus:outline-none">
                                @foreach([
                                        1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
                                        5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
                                        9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
                                    ] as $value => $label)
                                    <option value="{{ $value }}" @selected($month == $value) class="bg-gray-800">{{ $label }}</option>
                                @endforeach
                            </select>
                            
                            <select wire:model.live="year" class="glass-input rounded-lg px-3 py-3 text-white text-sm focus:outline-none">
                                @foreach(range(now()->year, 2020) as $y)
                                    <option value="{{ $y }}" @selected($year == $y) class="bg-gray-800">{{ $y }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Department Filter -->
                    <div class="flex flex-wrap gap-2 mb-6 max-h-100 overflow-y-auto custom-scrollbar">
                        <button wire:click="$set('selectedDepartment', null)" 
                                class="px-3 py-2 rounded-lg text-sm font-medium transition {{ is_null($selectedDepartment) ? 'bg-purple-600 text-white' : 'bg-white/20 text-blue-200 hover:bg-white/30' }}">
                            All
                        </button>
                        @foreach($departments as $department)
                            <button wire:click="$set('selectedDepartment', {{ $department->id }})" 
                                    class="px-3 py-2 rounded-lg text-sm font-medium transition {{ $selectedDepartment == $department->id ? 'bg-purple-600 text-white' : 'bg-white/20 text-blue-200 hover:bg-white/30' }}">
                                {{ $department->name }}
                            </button>
                        @endforeach
                    </div>

                    <!-- Report Content -->
                    @if($chargesReport->isEmpty())
                        <div class="text-center py-8 text-blue-200">
                            <svg class="w-12 h-12 text-blue-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <p class="text-base">No charges found for selected filters</p>
                        </div>
                    @else
                        <div class="max-h-80 overflow-y-auto custom-scrollbar space-y-4">
                            @foreach($chargesReport as $departmentId => $departmentCharges)
                                <div class="glass-card bg-white/5 rounded-lg overflow-hidden">
                                    <div class="bg-white/10 px-4 py-3 flex justify-between items-center">
                                        <h4 class="font-medium text-white text-sm">
                                            {{ $departments->firstWhere('id', $departmentId)->name }}
                                        </h4>
                                        <div class="text-sm font-bold text-purple-400">
                                            ₱{{ number_format($departmentCharges->sum('total_charges'), 2) }}
                                        </div>
                                    </div>

                                    <div class="p-3 space-y-2">
                                        @foreach($departmentCharges as $charge)
                                            <div class="flex justify-between items-center py-2 hover:bg-white/5 rounded transition-colors">
                                                <div class="min-w-0 flex-1">
                                                    <div class="font-medium text-white text-sm truncate">{{ $charge->family_name }}</div>
                                                    <div class="text-xs text-blue-200">{{ $charge->account_code }}</div>
                                                </div>
                                                <div class="text-sm font-bold text-white ml-2">
                                                    ₱{{ number_format($charge->total_charges, 2) }}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- FINANCIAL ANALYTICS SECTION -->
    <div class="max-w-7xl mx-auto">
        <div class="glass-card rounded-2xl sm:rounded-3xl p-4 sm:p-6 lg:p-8 hover-lift mb-8" wire:ignore>
            <h3 class="text-2xl sm:text-3xl font-bold text-white mb-6 flex items-center">
                <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                Financial Analytics
            </h3>

            <!-- Featured Chart: Monthly Charges by Department - Full Width -->
            <div class="glass-card rounded-2xl p-6 hover-lift mb-8" wire:ignore>
                <h4 class="text-xl sm:text-2xl font-bold text-white mb-6 flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                    Monthly Charges by Department
                </h4>
                <div class="h-80 sm:h-96 lg:h-[400px]">
                    <canvas id="departmentLinesChart" class="w-full h-full"></canvas>
                </div>
            </div>

            <!-- Other Charts Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                <!-- Monthly Charges -->
                <div class="glass-card rounded-xl p-6 hover-lift" wire:ignore>
                    <h4 class="text-lg font-bold text-white mb-4 flex items-center">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        Total Monthly Charges (₱)
                    </h4>
                    <div class="h-64">
                        <canvas id="monthlyChargesChart" class="w-full h-full"></canvas>
                    </div>
                </div>

                <!-- Top 5 Families -->
                <div class="glass-card rounded-xl p-6 hover-lift" wire:ignore>
                    <h4 class="text-lg font-bold text-white mb-4 flex items-center">
                        <div class="w-8 h-8 bg-gradient-to-br from-green-400 to-green-600 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                            </svg>
                        </div>
                        Top 5 Families This Month
                    </h4>
                    <div class="h-64">
                        <canvas id="topFamiliesChart" class="w-full h-full"></canvas>
                    </div>
                </div>

                <!-- Department Distribution -->
                <div class="glass-card rounded-xl p-6 hover-lift" wire:ignore>
                    <h4 class="text-lg font-bold text-white mb-4 flex items-center">
                        <div class="w-8 h-8 bg-gradient-to-br from-purple-400 to-purple-600 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                            </svg>
                        </div>
                        Department Charge Distribution
                    </h4>
                    <div class="h-64">
                        <canvas id="departmentChargesChart" class="w-full h-full"></canvas>
                    </div>
                </div>

                <!-- Restrictions Chart -->
                <div class="glass-card rounded-xl p-6 hover-lift" wire:ignore>
                    <h4 class="text-lg font-bold text-white mb-4 flex items-center">
                        <div class="w-8 h-8 bg-gradient-to-br from-red-400 to-red-600 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L5.636 5.636"></path>
                            </svg>
                        </div>
                        Restrictions per Member
                    </h4>
                    <div class="h-64">
                        <canvas id="restrictionsChart" class="w-full h-full"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Final Confirmation Modal -->
    @if($showFinalConfirmationModal)
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4" x-show="showConfirmationModal" x-transition>
            <div class="glass-card rounded-2xl shadow-2xl w-full max-w-5xl max-h-[90vh] overflow-y-auto">
                <div class="p-6">
                    <h2 class="text-xl sm:text-2xl font-bold mb-4 text-white">Confirm & Process Charges</h2>
                    
                    <div class="space-y-4 mb-6">
                        <p class="text-blue-200 text-base">You are about to finalize <span class="font-bold text-purple-400">{{ $pendingChargesCount }}</span> charges currently awaiting processing.</p>
                        
                        @if($departmentsWithPreparedCharges->isNotEmpty())
                            <div class="glass-card bg-yellow-500/10 border border-yellow-400/30 rounded-lg p-3">
                                <p class="font-semibold mb-2 text-yellow-400 text-sm">Departments with prepared charges:</p>
                                <div class="max-h-32 overflow-y-auto custom-scrollbar space-y-1">
                                    @foreach($departmentsWithPreparedCharges as $deptSummary)
                                        <div class="flex justify-between items-center text-sm">
                                            <span class="text-white">{{ $deptSummary->name }}</span>
                                            <span class="text-yellow-400 font-bold">{{ $deptSummary->count }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if(count($departmentsWithoutPreparedCharges) > 0)
                            <div class="glass-card bg-red-500/10 border border-red-400/30 rounded-lg p-3">
                                <p class="font-semibold mb-2 text-red-400 text-sm">Departments without prepared charges:</p>
                                <div class="max-h-100 overflow-y-auto custom-scrollbar">
                                    @foreach($departmentsWithoutPreparedCharges as $deptName)
                                        <div class="text-sm text-red-300 py-0.5">• {{ $deptName }}</div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        
                        <div class="glass-card bg-blue-500/10 border border-blue-400/30 rounded-lg p-3">
                            <p class="font-semibold text-blue-400 text-sm mb-2">This action will:</p>
                            <ul class="text-sm text-blue-200 space-y-1">
                                <li>• Mark {{ $pendingChargesCount }} charges as processed</li>
                                <li>• Send email reports to family heads</li>
                                <li>• Reset applicable spending limits</li>
                                <li>• Generate Excel export</li>
                            </ul>
                        </div>
                        
                        <div class="glass-card bg-white/5 rounded-lg p-3">
                            <p class="font-semibold text-white text-sm mb-3">Email recipients:</p>
                            <div class="mb-3">
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="checkbox" wire:model.live="selectAll" class="form-checkbox h-4 w-4 text-purple-600 rounded focus:ring-purple-500 bg-white/20 border-white/30">
                                    <span class="ml-2 text-sm text-white font-medium">Select All</span>
                                </label>
                            </div>

                            <div class="space-y-2 max-h-40 overflow-y-auto custom-scrollbar">
                                @forelse($this->potentialRecipients as $recipient)
                                    <label class="inline-flex items-center w-full cursor-pointer">
                                        <input type="checkbox" wire:model.defer="selectedRecipients" value="{{ $recipient->email }}" class="form-checkbox h-3 w-3 text-purple-600 rounded focus:ring-purple-500 bg-white/20 border-white/30">
                                        <span class="ml-3 text-sm text-blue-200">{{ $recipient->name }} ({{ $recipient->email }})</span>
                                    </label>
                                @empty
                                    <p class="text-sm text-red-400">No accounting staff found.</p>
                                @endforelse
                            </div>

                            @error('selectedRecipients')
                                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex flex-col-reverse sm:flex-row justify-end gap-3">
                        <button wire:click="$set('showFinalConfirmationModal', false)"
                            class="w-full sm:w-auto px-5 py-3 glass-card bg-white/10 text-blue-200 rounded-xl hover:bg-white/20 transition font-medium">
                            Cancel
                        </button>
                        <button wire:click="confirmAndProcessReports"
                            class="w-full sm:w-auto px-5 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl hover:from-green-700 hover:to-green-800 transition font-semibold shadow-lg"
                            wire:loading.attr="disabled">
                            <span wire:loading.remove>Confirm & Process</span>
                            <span wire:loading class="flex items-center justify-center">
                                <svg class="animate-spin h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Processing...
                            </span>
                        </button>
                    </div>
                </div>
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
            border-color: rgba(168, 85, 247, 0.8);
            box-shadow: 0 0 0 3px rgba(168, 85, 247, 0.2);
        }
        
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        .items-center {
    align-items: center; /* Vertically centers content */
}
.justify-center {
    justify-content: center; /* Horizontally centers content */
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

        .text-yellow-400 {
            color: #fbbf24 !important;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.4);
        }

        .text-green-400 {
            color: #34d399 !important;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.4);
        }

        .text-purple-400 {
            color: #c084fc !important;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.4);
        }

        .text-red-400 {
            color: #f87171 !important;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.4);
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
        }

        /* Improved button focus states for accessibility */
        button:focus, input:focus, select:focus {
            outline: 2px solid rgba(168, 85, 247, 0.8);
            outline-offset: 2px;
        }

        [x-cloak] { 
            display: none !important; 
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function reportsDashboardManager() {
            return {
                // Time and date
                currentTime: '',
                currentDate: '',
                showConfirmationModal: @entangle('showFinalConfirmationModal'),

                init() {
                    this.updateTime();
                    setInterval(() => {
                        this.updateTime();
                    }, 1000);

                    // Initialize charts
                    this.renderAllCharts();

                    // Listen for Livewire events
                    window.addEventListener('chartsUpdated', () => {
                        this.renderAllCharts();
                    });

                    window.addEventListener('reportConfirmed', () => {
                        this.renderAllCharts();
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

                renderAllCharts() {
                    let charts = {};

                    const chartOptions = {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'bottom',
                                labels: {
                                    font: {
                                        size: 12,
                                        family: 'Inter, sans-serif'
                                    },
                                    color: 'rgba(255, 255, 255, 0.9)',
                                    padding: 20
                                }
                            }
                        },
                        animation: {
                            duration: 1000,
                            easing: 'easeOutQuart'
                        },
                        scales: {
                            x: {
                                ticks: {
                                    color: 'rgba(255, 255, 255, 0.8)',
                                    font: {
                                        size: 11
                                    }
                                },
                                grid: {
                                    color: 'rgba(255, 255, 255, 0.1)'
                                }
                            },
                            y: {
                                ticks: {
                                    color: 'rgba(255, 255, 255, 0.8)',
                                    font: {
                                        size: 11
                                    }
                                },
                                grid: {
                                    color: 'rgba(255, 255, 255, 0.1)'
                                }
                            }
                        }
                    };

                    function createOrUpdateChart(id, type, data, options) {
                        if (charts[id]) {
                            charts[id].destroy();
                        }
                        const ctx = document.getElementById(id);
                        if (ctx) {
                            charts[id] = new Chart(ctx, {
                                type: type,
                                data: data,
                                options: options
                            });
                        }
                    }

                    // Monthly Charges Chart
                    createOrUpdateChart('monthlyChargesChart', 'bar', @json($monthlyChargesChart), {
                        ...chartOptions,
                        scales: {
                            ...chartOptions.scales,
                            y: { ...chartOptions.scales.y, beginAtZero: true }
                        }
                    });

                    // Top Families Chart
                    createOrUpdateChart('topFamiliesChart', 'bar', @json($topFamiliesChart), {
                        ...chartOptions,
                        scales: {
                            ...chartOptions.scales,
                            y: { ...chartOptions.scales.y, beginAtZero: true }
                        }
                    });

                    // Department Charges Chart
                    createOrUpdateChart('departmentChargesChart', 'doughnut', @json($departmentChargesChart), {
                        ...chartOptions,
                        plugins: {
                            ...chartOptions.plugins,
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        let label = context.label || '';
                                        if (label) {
                                            label += ': ';
                                        }
                                        if (context.parsed !== null) {
                                            label += new Intl.NumberFormat('en-PH', { style: 'currency', currency: 'PHP' }).format(context.parsed);
                                        }
                                        return label;
                                    }
                                }
                            }
                        }
                    });

                    // Restrictions Chart
                    createOrUpdateChart('restrictionsChart', 'doughnut', @json($restrictionsChart), {
                        ...chartOptions,
                        plugins: {
                            ...chartOptions.plugins,
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        let label = context.label || '';
                                        if (label) {
                                            label += ': ';
                                        }
                                        if (context.parsed !== null) {
                                            label += context.parsed + ' members';
                                        }
                                        return label;
                                    }
                                }
                            }
                        }
                    });

                    // Department Lines Chart (Featured)
                    createOrUpdateChart('departmentLinesChart', 'line', @json($departmentLinesChart), {
                        ...chartOptions,
                        scales: {
                            ...chartOptions.scales,
                            y: { ...chartOptions.scales.y, beginAtZero: true }
                        },
                        elements: {
                            line: {
                                tension: 0.4
                            },
                            point: {
                                radius: 4,
                                hoverRadius: 6
                            }
                        }
                    });
                }
            }
        }
    </script>
</div>