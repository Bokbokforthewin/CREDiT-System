<div class="min-h-screen bg-overlay py-4 sm:py-6 lg:py-8 px-3 sm:px-4 lg:px-8" 
     x-data="chargeManagementManager()" 
     x-init="init()">

    <!-- Header Section -->
    <div class="max-w-7xl mx-auto mb-6 sm:mb-8">
        <div class="glass-card rounded-2xl sm:rounded-3xl p-4 sm:p-6 lg:p-8 hover-lift slide-in">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 sm:gap-6">
                <div class="flex items-center space-x-3 sm:space-x-6 w-full sm:w-auto">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-green-400 to-green-500 rounded-xl sm:rounded-2xl flex items-center justify-center shadow-xl flex-shrink-0">
                        <svg class="w-8 h-8 sm:w-10 sm:h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-white mb-1 sm:mb-2 leading-tight">
                            <span class="text-white">Charge <span class="text-yellow-400">Management</span> 
                            <span class="text-blue-200 text-lg block sm:inline">- {{ $department->name }}</span>
                        </h1>
                        <p class="text-blue-200 text-base sm:text-lg">Manage department charges and billing preparation</p>
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
            <a href="{{ route('frontdesk.dashboard', ['department' => $department->id]) }}" 
               class="glass-card hover-lift rounded-xl px-4 py-3 transition-all duration-300 group inline-flex items-center space-x-3">
                <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200 flex-shrink-0">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </div>
                <span class="text-white font-semibold text-lg">Back to Dashboard</span>
            </a>

            <!-- Prepare Charges Button -->
            <button wire:click="confirmPrepareCharges"
                    @if(!$canPrepareCharges) disabled @endif
                    :class="!$canPrepareCharges ? 'opacity-50 cursor-not-allowed' : 'hover-lift'"
                    class="glass-card rounded-xl px-4 py-3 transition-all duration-300 inline-flex items-center space-x-3">
                <div class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <div class="text-left">
                    <span class="text-white font-bold text-xl block">
                        @if($pendingChargesToPrepareCount > 0)
                            Prepare {{ $pendingChargesToPrepareCount }} Charges
                        @else
                            No Charges to Prepare
                        @endif
                    </span>
                    <span class="text-blue-200 text-sm">For billing processing</span>
                </div>
            </button>

            <!-- Summary Stats -->
            <div class="glass-card rounded-xl px-4 py-3 flex items-center space-x-3">
                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <div>
                    <span class="text-blue-200 text-xs">Showing</span>
                    <span class="text-white font-semibold text-lg ml-1">{{ $charges->total() }} records</span>
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
                Filter & Search Charges
            </h3>
            
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
                        <input type="text" wire:model.live.debounce.300ms="search" id="search"
                               class="glass-input rounded-xl pl-10 pr-3 py-2 w-full text-white placeholder-blue-300 focus:outline-none"
                               placeholder="Family, description, staff...">
                    </div>
                </div>

                <!-- Month Dropdown -->
                <div>
                    <label for="selectedMonth" class="block text-sm font-medium text-blue-200 mb-2">Month</label>
                    <select wire:model.live="selectedMonth" id="selectedMonth"
                            class="glass-input rounded-xl py-2 px-3 w-full text-white focus:outline-none">
                        @for ($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" class="text-gray-800">{{ \Carbon\Carbon::create()->month((int) $m)->format('F') }}</option>
                        @endfor
                    </select>
                </div>

                <!-- Year Dropdown -->
                <div>
                    <label for="selectedYear" class="block text-sm font-medium text-blue-200 mb-2">Year</label>
                    <select wire:model.live="selectedYear" id="selectedYear"
                            class="glass-input rounded-xl py-2 px-3 w-full text-white focus:outline-none">
                        @for ($y = now()->year; $y >= 2020; $y--)
                            <option value="{{ $y }}" class="text-gray-800">{{ $y }}</option>
                        @endfor
                    </select>
                </div>

                <!-- Day Dropdown -->
                <div>
                    <label for="selectedDay" class="block text-sm font-medium text-blue-200 mb-2">Day</label>
                    <select wire:model.live="selectedDay" id="selectedDay"
                            class="glass-input rounded-xl py-2 px-3 w-full text-white focus:outline-none">
                        <option value="" class="text-gray-800">All Days</option>
                        @for ($d = 1; $d <= 31; $d++)
                            <option value="{{ $d }}" class="text-gray-800">{{ $d }}</option>
                        @endfor
                    </select>
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

    <!-- Charges Table -->
    <div class="max-w-7xl mx-auto">
        <div class="glass-card rounded-2xl overflow-hidden hover-lift">
            <div class="p-4 sm:p-6 border-b border-white/20">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <h2 class="text-xl sm:text-2xl font-bold text-white flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center mr-4">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M18 12a2 2 0 00-2-2h-2"></path>
                            </svg>
                        </div>
                        Department Charges
                    </h2>
                    <div class="text-blue-200 text-sm">
                        {{ $department->name }} • {{ $charges->total() }} records
                    </div>
                </div>
            </div>

            @if ($charges->isEmpty())
                <div class="p-8 text-center text-blue-200">
                    <svg class="w-16 h-16 text-blue-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    @if ($search || $selectedMonth !== (int)now()->month || $selectedYear !== (int)now()->year || $selectedDay)
                        <p class="text-lg mb-2">No charges found for the current filter criteria</p>
                        <p class="text-sm">Try adjusting your search or filter parameters</p>
                    @else
                        <p class="text-lg mb-2">No charges recorded yet for {{ $department->name }}</p>
                        <p class="text-sm">Charges will appear here once they are created</p>
                    @endif
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-white/10">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-blue-200 uppercase tracking-wider">ID</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-blue-200 uppercase tracking-wider">Date</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-blue-200 uppercase tracking-wider">Description</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-blue-200 uppercase tracking-wider">Price</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-blue-200 uppercase tracking-wider">Family Member</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-blue-200 uppercase tracking-wider">Staff</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-blue-200 uppercase tracking-wider">Status</th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-blue-200 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/10">
                            @foreach ($charges as $charge)
                                <tr class="hover:bg-white/5 transition-colors">
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-white">{{ $charge->id }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-white">{{ \Carbon\Carbon::parse($charge->charge_datetime)->format('M d, Y') }}</td>
                                    <td class="px-4 py-3 text-sm text-white max-w-xs truncate">{{ $charge->description }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-green-400 font-semibold">₱{{ number_format($charge->price, 2) }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-white">
                                        <div>{{ $charge->member->full_name ?? 'N/A' }}</div>
                                        @if($charge->member->family ?? false)
                                            <div class="text-xs text-blue-200">{{ $charge->member->family->family_name }}</div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-blue-200">{{ $charge->user->name ?? 'N/A' }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        @if($charge->status === 'Processed')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-400/20 text-green-400 border border-green-400/30">
                                                Processed
                                            </span>
                                        @elseif($charge->status === 'Awaiting Processing')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-400/20 text-yellow-400 border border-yellow-400/30">
                                                Awaiting Processing
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-400/20 text-blue-400 border border-blue-400/30">
                                                Pending
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            <!-- Edit Button -->
                                            <button wire:click="openEditChargeModal({{ $charge->id }})"
                                                    @if($charge->status !== 'Pending') disabled @endif
                                                    class="px-4 py-2 bg-indigo-800/40 text-indigo-400 rounded-lg hover:bg-indigo-600 transition font-medium 
                                                           @if($charge->status !== 'Pending') opacity-50 cursor-not-allowed @else cursor-pointer @endif">
                                                Edit
                                            </button>
                                    
                                            <!-- Delete Button -->
                                            <button wire:click="confirmDelete({{ $charge->id }})"
                                                    @if($charge->status !== 'Pending') disabled @endif
                                                    class="px-4 py-2 bg-red-600/20 text-red-400 rounded-lg hover:bg-red-600/30 transition font-medium 
                                                           @if($charge->status !== 'Pending') opacity-50 cursor-not-allowed @else cursor-pointer @endif">
                                                Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="p-6 border-t border-white/20 bg-white/5">{{ $charges->links() }}</div>
            @endif
        </div>
    </div>

    <!-- Edit Charge Modal -->
    @if($showEditChargeModal)
        <div class="fixed inset-0 flex items-center justify-center bg-black/50 z-50 p-4" x-data="{ show: true }" x-show="show" x-transition>
            <div class="glass-card rounded-2xl w-full max-w-md p-6 border border-white/20">
                <h2 class="text-2xl font-bold text-white mb-6 flex items-center">
                    <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    Edit Charge
                </h2>

                <div class="mb-4">
                    <label for="editDescription" class="block text-sm font-medium text-blue-200 mb-2">Description</label>
                    <input type="text" id="editDescription" wire:model.defer="editDescription"
                           class="glass-input rounded-xl px-3 py-2 w-full text-white placeholder-blue-300 focus:outline-none">
                    @error('editDescription') <span class="text-red-400 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="mb-6">
                    <label for="editPrice" class="block text-sm font-medium text-blue-200 mb-2">Price</label>
                    <input type="number" step="0.01" id="editPrice" wire:model.defer="editPrice"
                           class="glass-input rounded-xl px-3 py-2 w-full text-white placeholder-blue-300 focus:outline-none">
                    @error('editPrice') <span class="text-red-400 text-sm mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-end space-x-3">
                    <button wire:click="resetEditModal"
                            class="px-5 py-2 bg-white/20 text-white rounded-xl hover:bg-white/30 transition-colors">
                        Cancel
                    </button>
                    <button wire:click="updateCharge"
                            class="px-5 py-2 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl hover:from-blue-700 hover:to-blue-800 transition-colors">
                        Update Charge
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Delete Confirmation Modal -->
    @if($showDeleteConfirmationModal)
        <div class="fixed inset-0 flex items-center justify-center bg-black/50 z-50 p-4" x-data="{ show: true }" x-show="show" x-transition>
            <div class="glass-card rounded-2xl w-full max-w-sm p-6 border border-white/20">
                <h2 class="text-2xl font-bold text-white mb-4 flex items-center">
                    <div class="w-8 h-8 bg-gradient-to-br from-red-500 to-red-600 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </div>
                    Confirm Deletion
                </h2>
                <p class="text-blue-200 mb-6">
                    Are you sure you want to delete this charge?
                    <span class="block mt-2 font-semibold text-red-400">{{ $deletingChargeDetails }}</span>
                    This action cannot be undone.
                </p>
                <div class="flex justify-end space-x-3">
                    <button wire:click="resetDeleteModal"
                            class="px-5 py-2 bg-white/20 text-white rounded-xl hover:bg-white/30 transition-colors">
                        Cancel
                    </button>
                    <button wire:click="deleteCharge"
                            class="px-5 py-2 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-xl hover:from-red-700 hover:to-red-800 transition-colors">
                        Delete Charge
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Prepare Charges Confirmation Modal -->
    @if($showPrepareConfirmationModal)
        <div class="fixed inset-0 flex items-center justify-center bg-black/50 z-50 p-4" x-data="{ show: true }" x-show="show" x-transition>
            <div class="glass-card rounded-2xl w-full max-w-md p-6 border border-white/20">
                <h2 class="text-2xl font-bold text-white mb-4 flex items-center">
                    <div class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    Prepare for Billing
                </h2>
                <p class="text-blue-200 mb-6">
                    You are about to mark <span class="font-bold text-yellow-400">{{ $pendingChargesToPrepareCount }}</span> charges
                    in <span class="font-bold text-yellow-400">{{ $department->name }}</span> as "Awaiting Processing".
                    <br><br>
                    <span class="text-sm">Once prepared, these charges cannot be edited or deleted.</span>
                </p>
                <div class="flex justify-end space-x-3">
                    <button wire:click="$set('showPrepareConfirmationModal', false)"
                            class="px-5 py-2 bg-white/20 text-white rounded-xl hover:bg-white/30 transition-colors">
                        Cancel
                    </button>
                    <button wire:click="prepareChargesForBilling"
                            class="px-5 py-2 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white rounded-xl hover:from-indigo-700 hover:to-indigo-800 transition-colors">
                        Confirm Preparation
                    </button>
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
        function chargeManagementManager() {
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
                    if (this.$wire.search) {
                        filters.push(`Search: "${this.$wire.search}"`);
                    }
                    
                    // Date filters
                    if (this.$wire.selectedMonth !== (new Date()).getMonth() + 1) {
                        const monthName = new Date(2023, this.$wire.selectedMonth - 1).toLocaleString('default', { month: 'long' });
                        filters.push(`Month: ${monthName}`);
                    }
                    
                    if (this.$wire.selectedYear !== (new Date()).getFullYear()) {
                        filters.push(`Year: ${this.$wire.selectedYear}`);
                    }
                    
                    if (this.$wire.selectedDay) {
                        filters.push(`Day: ${this.$wire.selectedDay}`);
                    }
                    
                    return filters;
                },

                removeFilter(filterText) {
                    const filterType = filterText.split(':')[0].trim();
                    
                    switch(filterType) {
                        case 'Search':
                            this.$wire.set('search', '');
                            break;
                        case 'Month':
                            this.$wire.set('selectedMonth', (new Date()).getMonth() + 1);
                            break;
                        case 'Year':
                            this.$wire.set('selectedYear', (new Date()).getFullYear());
                            break;
                        case 'Day':
                            this.$wire.set('selectedDay', '');
                            break;
                    }
                }
            }
        }
    </script>
</div>