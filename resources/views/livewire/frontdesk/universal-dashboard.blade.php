<div class="min-h-screen bg-overlay py-4 sm:py-6 lg:py-8 px-3 sm:px-4 lg:px-8">
    <!-- Header Section -->
    <div class="max-w-7xl mx-auto mb-6 sm:mb-8">
        <div class="glass-card rounded-2xl sm:rounded-3xl p-4 sm:p-6 lg:p-8 hover-lift slide-in">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 sm:gap-6">
                <div class="flex items-center space-x-3 sm:space-x-6 w-full sm:w-auto">
                    <div
                        class="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-xl sm:rounded-2xl flex items-center justify-center shadow-xl flex-shrink-0">
                        <svg class="w-8 h-8 sm:w-10 sm:h-10 text-blue-900" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m0 0h4M9 7h6m-6 4h6m-2 8h.01">
                            </path>
                        </svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-white mb-1 sm:mb-2 leading-tight">
                            <span class="block sm:inline">CPAC </span>
                            <span
                                class="text-yellow-400">{{ auth()->user()->department->name ?? 'Unknown Department' }}</span>
                        </h2>
                        <p class="text-blue-200 text-base sm:text-lg lg:text-xl">Welcome back, <span
                                class="font-semibold text-yellow-300">{{ auth()->user()->name }}</span>!</p>
                    </div>
                </div>
                <div class="text-left sm:text-right w-full sm:w-auto">
                    <div class="text-2xl sm:text-3xl font-bold text-yellow-400" id="current-time"></div>
                    <div class="text-blue-200 text-sm sm:text-base" id="current-date"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- RFID Scan Modal (Initial Modal) -->
    <div x-data="{ showModal: $wire.entangle('showRfidModal') }" x-show="showModal" x-cloak x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-90"
        class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-60 backdrop-blur-sm p-4">
        <div
            class="glass-card p-6 sm:p-8 lg:p-10 rounded-2xl sm:rounded-3xl shadow-2xl max-w-md w-full mx-auto hover-lift">
            <div class="text-center mb-6 sm:mb-8">
                <div
                    class="mx-auto w-20 h-20 sm:w-24 sm:h-24 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center mb-4 sm:mb-6 pulse-animation">
                    <svg class="w-10 h-10 sm:w-12 sm:h-12 text-white" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h2 class="text-2xl sm:text-3xl font-bold text-white mb-2 sm:mb-3">Welcome!</h2>
                <p class="text-blue-200 text-base sm:text-lg">Please scan your RFID card to continue</p>
            </div>

            <div class="mb-6 sm:mb-8">
                <label for="rfid_code_modal"
                    class="block text-white font-semibold mb-2 sm:mb-3 text-base sm:text-lg">Scan RFID Code</label>
                <input wire:model.live.debounce.300ms="rfid_code" id="rfid_code_modal" type="text"
                    class="w-full glass-input rounded-lg sm:rounded-xl px-4 sm:px-6 py-3 sm:py-4 text-white placeholder-blue-200 text-center text-lg sm:text-xl font-semibold focus:outline-none"
                    placeholder="Scan your RFID card here..." autofocus>
            </div>

            <div class="space-y-3 sm:space-y-4">
                <button wire:click="openManualEntry"
                    class="w-full gradient-button text-white px-4 sm:px-6 py-3 sm:py-4 rounded-lg sm:rounded-xl font-bold text-base sm:text-lg transition-all duration-200 hover:shadow-xl">
                    Manual Charge Entry
                </button>
                <button wire:click="showRfidModal = false"
                    class="w-full bg-gradient-to-r from-red-600 to-red-700 text-white px-4 sm:px-6 py-3 sm:py-4 rounded-lg sm:rounded-xl hover:from-red-700 hover:to-red-800 transition-all duration-200 font-bold text-base sm:text-lg hover:shadow-xl">
                    Cancel
                </button>
                <p class="text-xs sm:text-sm text-blue-200 text-center mt-3">Click Manual Entry if you don't have an
                    RFID card</p>
            </div>
        </div>
    </div>

    <!-- RFID Not Found Modal -->
    <div x-data="{ showModal: @entangle('rfidNotFound') }" x-show="showModal" x-cloak x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-90"
        class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-60 backdrop-blur-sm p-4">
        <div class="glass-card p-6 sm:p-8 rounded-2xl sm:rounded-3xl shadow-2xl max-w-md w-full mx-auto">
            <div class="text-center mb-6">
                <div
                    class="mx-auto w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-red-500 to-red-600 rounded-full flex items-center justify-center mb-4 sm:mb-6">
                    <svg class="w-8 h-8 sm:w-10 sm:h-10 text-white" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.728-.833-2.498 0L3.316 16.5c-.77.833.192 2.5 1.732 2.5z">
                        </path>
                    </svg>
                </div>
                <h2 class="text-xl sm:text-2xl font-bold text-white mb-2 sm:mb-3">RFID Not Recognized</h2>
                <p class="text-blue-200 mb-4 sm:mb-6 text-base sm:text-lg">The RFID code you scanned is not registered
                    in the system.</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                <button wire:click="closeRfidNotFoundModal"
                    class="flex-1 bg-gradient-to-r from-blue-600 to-blue-700 text-white px-4 py-3 rounded-lg sm:rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-200 font-semibold text-base">
                    Try Again
                </button>
                <button wire:click="openManualEntry"
                    class="flex-1 gradient-button text-white px-4 py-3 rounded-lg sm:rounded-xl font-semibold transition-all duration-200 hover:shadow-xl text-base">
                    Manual Entry
                </button>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="max-w-7xl mx-auto mb-6 sm:mb-8">
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('frontdesk.chargemanagement', ['department' => $department->id]) }}"
                class="glass-card hover-lift rounded-xl sm:rounded-2xl p-4 sm:p-6 transition-all duration-300 group w-full sm:w-auto">
                <div class="flex items-center space-x-3 sm:space-x-4">
                    <div
                        class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg sm:rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-200 flex-shrink-0">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                            </path>
                        </svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h3 class="text-white font-bold text-base sm:text-lg">Manage Charges</h3>
                        <p class="text-blue-200 text-sm">View and edit existing charges</p>
                    </div>
                </div>
            </a>

            <button wire:click="$set('showRfidModal',true)"
                class="glass-card hover-lift rounded-xl sm:rounded-2xl p-4 sm:p-6 transition-all duration-300 group w-full sm:w-auto">
                <div class="flex items-center space-x-3 sm:space-x-4">
                    <div
                        class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-lg sm:rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-200 flex-shrink-0">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </div>
                    <div class="min-w-0 items- text-left flex-1">
                        <div class="flex-col items-start">
                            <h3 class="text-white font-bold text-base sm:text-lg">Create Charges</h3>
                            <p class="text-blue-200 text-sm">Add new charges to the system</p>
                        </div>
                    </div>
                </div>
            </button>
        </div>
    </div>

<!-- Manual Entry Section -->
@if ($showManualEntry)
    <div class="max-w-7xl mx-auto mb-6 sm:mb-8">
        <div class="glass-card rounded-2xl sm:rounded-3xl p-4 sm:p-6 lg:p-8 hover-lift">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 sm:mb-8 gap-4">
                <h3 class="text-xl sm:text-2xl font-bold text-white flex items-center">
                    <div
                        class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center mr-3 sm:mr-4 flex-shrink-0">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                            </path>
                        </svg>
                    </div>
                    Manual Charge Entry
                </h3>
                <button wire:click="resetToRfidScan"
                    class="text-yellow-400 hover:text-yellow-300 font-semibold text-base sm:text-lg transition-colors duration-200 flex items-center whitespace-nowrap">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to RFID Scan
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                <div class="relative">
                    <label class="block text-white font-semibold mb-2 sm:mb-3 text-base sm:text-lg">Search
                        Family</label>
                    <input wire:model.live.debounce.300ms="family_search" type="text"
                        class="w-full glass-input rounded-lg sm:rounded-xl px-4 sm:px-6 py-3 sm:py-4 text-white placeholder-blue-200 focus:outline-none text-base sm:text-lg"
                        placeholder="Type family name to search..." autocomplete="off">

                    <!-- Family Search Dropdown -->
                    @if ($showFamilyDropdown && count($filteredFamilies) > 0)
                        <div
                            class="absolute z-10 w-full glass-card border border-white/30 rounded-lg sm:rounded-xl shadow-2xl mt-2 max-h-60 overflow-y-auto">
                            @foreach ($filteredFamilies as $family)
                                <button
                                    wire:click="selectFamily({{ $family->id }}, '{{ $family->family_name }}')"
                                    class="w-full px-4 sm:px-6 py-3 sm:py-4 text-left text-white hover:bg-white/20 transition-colors duration-200 first:rounded-t-lg first:sm:rounded-t-xl last:rounded-b-lg last:sm:rounded-b-xl">
                                    <p class="font-medium text-base">{{ $family->family_name }}</p>
                                    <p class="text-xs sm:text-sm text-blue-200">Family ID: {{ $family->id }}</p>
                                </button>
                            @endforeach
                        </div>
                    @elseif($showFamilyDropdown && !empty($family_search) && count($filteredFamilies) == 0)
                        <div
                            class="absolute z-10 w-full glass-card border border-white/30 rounded-lg sm:rounded-xl shadow-xl mt-2">
                            <div class="px-4 sm:px-6 py-3 sm:py-4 text-blue-200 text-sm sm:text-base">
                                No families found matching "{{ $family_search }}"
                            </div>
                        </div>
                    @endif
                </div>

                @if ($selected_family_id)
                    <div>
                        <label class="block text-white font-semibold mb-2 sm:mb-3 text-base sm:text-lg">Select
                            Member</label>
                        <div class="relative">
                            <select wire:model.lazy="selected_member_id"
                                class="w-full glass-input rounded-lg sm:rounded-xl pl-4 pr-12 py-3 sm:py-4 text-white focus:outline-none text-base sm:text-lg appearance-none bg-white/20">
                                <option value="" class="text-black">-- Choose Member --</option>
                                @foreach ($familyMembers as $fm)
                                    @php
                                        // Calculate rule, limit, and status for display in the option text
                                        $rule = $fm->rules->firstWhere('department_id', auth()->user()->department_id);
                                        $spending_limit_text = $rule && $rule->spending_limit !== null ? '₱' . number_format($rule->spending_limit, 2) : 'None';
                                        $status_text = $rule && $rule->is_restricted ? 'Restricted' : 'Allowed';
                                    @endphp
                                    <option value="{{ $fm->id }}" class="text-black">
                                        {{ $fm->name }} 
                                    </option>
                                @endforeach
                            </select>
                            <!-- Custom dropdown indicator to maintain styling -->
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-white/70">
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endif

<!-- Removed the redundant Member Information card that was here -->

@if ($member)
    <!-- Charge Details with Highly Visible Member Status/Limit -->
    <div class="max-w-7xl mx-auto mb-6 sm:mb-8">
        <div class="glass-card rounded-2xl sm:rounded-3xl p-4 sm:p-6 lg:p-8 hover-lift">
            <!-- Header Section -->
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-6 sm:mb-8">
                <div class="flex items-center">
                    <div
                        class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center mr-3 sm:mr-4 flex-shrink-0">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <span class="text-xl sm:text-2xl font-bold text-white">Charge Details for </span>
                        <span class="text-xl sm:text-2xl font-bold text-yellow-300">{{ $member->name }}</span>
                        <p class="text-blue-200 text-sm sm:text-base mt-1">{{ $member->role }}</p>
                    </div>
                </div>

                <!-- Member Status & Limit - ENHANCED VISIBILITY -->
                @php
                    $rule = $member->rules->firstWhere('department_id', auth()->user()->department_id);
                    $is_restricted = $rule && $rule->is_restricted;
                    $spending_limit_text = $rule && $rule->spending_limit !== null ? '₱' . number_format($rule->spending_limit, 2) : 'None';
                    $status_text = $is_restricted ? 'Restricted' : 'Allowed';
                @endphp
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4 sm:gap-6 w-full lg:w-auto">
                    
                    <!-- Status Badge -->
                    <div class="flex-1 min-w-0 p-3 sm:p-8 rounded-xl text-center shadow-lg transform transition-all duration-300 {{ $is_restricted ? 'bg-red-900/40 border border-red-500/50 hover:shadow-red-500/30' : 'bg-green-900/40 border border-green-500/50 hover:shadow-green-500/30' }}">
                        <span class="text-white font-medium text-xs sm:text-sm uppercase tracking-wider block opacity-70 mb-1">Status</span>
                        <span class="text-xl sm:text-2xl font-extrabold block {{ $is_restricted ? 'text-red-400' : 'text-green-400' }}">
                            {{ $status_text }}
                        </span>
                    </div>

                    <!-- Spending Limit Display -->
                    <div class="flex-1 min-w-0 p-3 sm:p-6 rounded-xl text-center shadow-lg bg-blue-900/40 border border-blue-500/50 transform transition-all duration-300 hover:shadow-blue-500/30">
                        <span class="text-white font-medium text-xs sm:text-sm uppercase tracking-wider block opacity-70 mb-1">Spending Limit</span>
                        <span class="text-xl sm:text-2xl font-extrabold text-blue-300 block">
                            {{ $spending_limit_text }}
                        </span>
                    </div>
                </div>
                <!-- End Member Status & Limit -->
            </div>

            <!-- Charge Inputs -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 mb-6 sm:mb-8">
                <div>
                    <label class="block text-white font-semibold mb-2 sm:mb-3 text-base sm:text-lg">Description</label>
                    <input wire:model="description" type="text"
                        class="w-full glass-input rounded-lg sm:rounded-xl px-4 sm:px-6 py-3 sm:py-4 text-white placeholder-blue-200 focus:outline-none text-base sm:text-lg"
                        placeholder="Enter charge description">
                </div>

                <div>
                    <label class="block text-white font-semibold mb-2 sm:mb-3 text-base sm:text-lg">Price (₱)</label>
                    <input wire:model="price" type="number" step="0.01"
                        class="w-full glass-input rounded-lg sm:rounded-xl px-4 sm:px-6 py-3 sm:py-4 text-white placeholder-blue-200 focus:outline-none text-base sm:text-lg"
                        placeholder="0.00">
                </div>
            </div>

            <!-- Submit Button -->
            <div class="text-center">
                <button wire:click="submitCharge"
                    class="w-full sm:w-auto px-8 sm:px-12 py-3 sm:py-4 bg-gradient-to-r from-purple-600 to-purple-700 text-white rounded-lg sm:rounded-xl hover:from-purple-700 hover:to-purple-800 transition-all duration-200 font-bold text-lg sm:text-xl shadow-xl hover:shadow-2xl transform hover:scale-105">
                    Submit Charge
                </button>
            </div>
        </div>
    </div>
@endif


    <!-- Charge Confirmation Modal -->
    @if ($showConfirmationModal)
        <div x-data="{ showModal: @entangle('showConfirmationModal') }" x-show="showModal" x-cloak x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90"
            class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-60 backdrop-blur-sm p-4">

            <div
                class="glass-card p-6 sm:p-8 rounded-2xl sm:rounded-3xl shadow-2xl max-w-md w-full mx-auto hover-lift">
                <div class="text-center mb-6">
                    <div
                        class="mx-auto w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 sm:w-10 sm:h-10 text-white" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl sm:text-2xl font-bold text-white mb-2">Confirm Charge</h2>
                    <p class="text-blue-200 text-sm">Please review the charge details below</p>
                </div>

                <!-- Charge Details Display -->
                <div class="glass-card bg-white/5 rounded-xl p-4 mb-6 space-y-3">
                    <div class="flex justify-between">
                        <span class="text-blue-200 font-medium">Date:</span>
                        <span
                            class="text-white text-sm">{{ isset($tempChargeData['charge_datetime']) ? \Carbon\Carbon::parse($tempChargeData['charge_datetime'])->format('M d, Y H:i') : '' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-blue-200 font-medium">Member:</span>
                        <span
                            class="text-white font-semibold">{{ isset($tempChargeData['member']) ? $tempChargeData['member']->name : '' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-blue-200 font-medium">Description:</span>
                        <span class="text-white">{{ $tempChargeData['description'] ?? '' }}</span>
                    </div>
                    <div class="flex justify-between border-t border-white/20 pt-3">
                        <span class="text-blue-200 font-medium text-lg">Total:</span>
                        <span
                            class="text-green-400 font-bold text-xl">₱{{ isset($tempChargeData['price']) ? number_format($tempChargeData['price'], 2) : '0.00' }}</span>
                    </div>
                </div>

                @if ($confirmationType === 'rfid')
                    <!-- RFID Confirmation (Same Member Must Confirm) -->
                    <div class="mb-6">
                        <label class="block text-white font-semibold mb-3">Member RFID Confirmation</label>
                        <p class="text-blue-200 text-sm mb-3">{{ $tempChargeData['member']->name ?? '' }}, please scan
                            your RFID again to confirm this charge.</p>
                        <input wire:model.live.debounce.300ms="confirmationRfidCode" type="text"
                            class="w-full glass-input rounded-xl px-4 py-3 text-white placeholder-blue-200 focus:outline-none text-center"
                            placeholder="Scan your RFID to confirm..." autofocus>
                        @if ($confirmationError)
                            <p class="text-red-400 text-sm mt-2 flex items-center">
                                <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $confirmationError }}
                            </p>
                        @endif
                    </div>

                    <div class="flex gap-3">
                        <button wire:click="cancelConfirmation"
                            class="flex-1 bg-gradient-to-r from-gray-600 to-gray-700 text-white px-4 py-3 rounded-xl hover:from-gray-700 hover:to-gray-800 transition-all duration-200 font-semibold text-sm">
                            Cancel
                        </button>
                        <button wire:click="confirmRfidCharge"
                            class="flex-1 bg-gradient-to-r from-green-600 to-green-700 text-white px-4 py-3 rounded-xl hover:from-green-700 hover:to-green-800 transition-all duration-200 font-semibold">
                            Confirm Charge
                        </button>
                    </div>
                @else
                    <!-- Manual Confirmation -->
                    <div class="mb-6">
                        <p class="text-blue-200 text-center">Please confirm that all details are correct before
                            proceeding.</p>
                    </div>

                    <div class="flex gap-3">
                        <button wire:click="cancelConfirmation"
                            class="flex-1 bg-gradient-to-r from-gray-600 to-gray-700 text-white px-4 py-3 rounded-xl hover:from-gray-700 hover:to-gray-800 transition-all duration-200 font-semibold">
                            Cancel
                        </button>
                        <button wire:click="confirmManualCharge"
                            class="flex-1 bg-gradient-to-r from-green-600 to-green-700 text-white px-4 py-3 rounded-xl hover:from-green-700 hover:to-green-800 transition-all duration-200 font-semibold">
                            Confirm Charge
                        </button>
                    </div>
                @endif
            </div>
        </div>
    @endif

    <!-- Recent Charges -->
    @if (count($charges) > 0)
        <div class="max-w-7xl mx-auto">
            <div class="glass-card rounded-2xl sm:rounded-3xl overflow-hidden hover-lift">
                <div class="p-4 sm:p-6 lg:p-8 border-b border-white/20">
                    <h3 class="text-xl sm:text-2xl font-bold text-white flex items-center">
                        <div
                            class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-lg flex items-center justify-center mr-3 sm:mr-4 flex-shrink-0">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                </path>
                            </svg>
                        </div>
                        <span class="leading-tight">Recent Charges<br class="sm:hidden"><span
                                class="text-base sm:text-lg text-blue-200 font-normal"> (This Family &
                                Department)</span></span>
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-white/5">
                            <tr>
                                <th
                                    class="px-4 sm:px-6 lg:px-8 py-3 sm:py-4 text-left text-xs sm:text-sm font-semibold text-blue-200 uppercase tracking-wider">
                                    Date</th>
                                <th
                                    class="px-4 sm:px-6 lg:px-8 py-3 sm:py-4 text-left text-xs sm:text-sm font-semibold text-blue-200 uppercase tracking-wider">
                                    Description</th>
                                <th
                                    class="px-4 sm:px-6 lg:px-8 py-3 sm:py-4 text-left text-xs sm:text-sm font-semibold text-blue-200 uppercase tracking-wider">
                                    Price</th>
                                <th
                                    class="px-4 sm:px-6 lg:px-8 py-3 sm:py-4 text-left text-xs sm:text-sm font-semibold text-blue-200 uppercase tracking-wider hidden sm:table-cell">
                                    Member</th>
                                <th
                                    class="px-4 sm:px-6 lg:px-8 py-3 sm:py-4 text-left text-xs sm:text-sm font-semibold text-blue-200 uppercase tracking-wider hidden lg:table-cell">
                                    Staff</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/10">
                            @foreach ($charges as $c)
                                <tr class="hover:bg-white/5 transition-colors duration-200">
                                    <td
                                        class="px-4 sm:px-6 lg:px-8 py-4 sm:py-6 whitespace-nowrap text-white font-medium text-sm sm:text-base">
                                        {{ \Carbon\Carbon::parse($c->charge_datetime)->format('M d, Y') }}
                                    </td>
                                    <td class="px-4 sm:px-6 lg:px-8 py-4 sm:py-6 text-white text-sm sm:text-base">
                                        <div class="max-w-xs sm:max-w-sm break-words">{{ $c->description }}</div>
                                        <div class="sm:hidden text-xs text-blue-200 mt-1">{{ $c->member->name }} •
                                            {{ $c->user->name }}</div>
                                    </td>
                                    <td
                                        class="px-4 sm:px-6 lg:px-8 py-4 sm:py-6 whitespace-nowrap text-green-400 font-bold text-base sm:text-lg">
                                        ₱{{ number_format($c->price, 2) }}
                                    </td>
                                    <td
                                        class="px-4 sm:px-6 lg:px-8 py-4 sm:py-6 whitespace-nowrap text-white text-sm sm:text-base hidden sm:table-cell">
                                        {{ $c->member->name }}</td>
                                    <td
                                        class="px-4 sm:px-6 lg:px-8 py-4 sm:py-6 whitespace-nowrap text-blue-200 text-sm sm:text-base hidden lg:table-cell">
                                        {{ $c->user->name }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    <!-- Flash Messages -->
    @if (session()->has('success'))
    <div x-data="{ show: true }" 
         x-show="show"
         x-init="setTimeout(() => show = false, 5000)"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-x-full"
         x-transition:enter-end="opacity-100 transform translate-x-0"
         x-transition:leave="transition ease-in duration-500"
         x-transition:leave-start="opacity-100 transform translate-x-0"
         x-transition:leave-end="opacity-0 transform translate-x-full"
         class="fixed top-4 right-4 z-50 max-w-sm">
        <div class="bg-gradient-to-r from-green-500 to-green-600 text-white px-4 sm:px-6 py-3 sm:py-4 rounded-lg sm:rounded-xl shadow-2xl flex items-center space-x-3">
                <svg class="w-5 h-5 sm:w-6 sm:h-6 flex-shrink-0" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span class="font-semibold text-sm sm:text-base">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if (session()->has('error'))
           <div x-data="{ show: true }" 
         x-show="show"
         x-init="setTimeout(() => show = false, 5000)"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-x-full"
         x-transition:enter-end="opacity-100 transform translate-x-0"
         x-transition:leave="transition ease-in duration-500"
         x-transition:leave-start="opacity-100 transform translate-x-0"
         x-transition:leave-end="opacity-0 transform translate-x-full"
         class="fixed top-4 right-4 z-50 max-w-sm">
                <div class="bg-gradient-to-r from-red-500 to-red-600 text-white px-4 sm:px-6 py-3 sm:py-4 rounded-lg sm:rounded-xl shadow-2xl flex items-center space-x-3">
                <svg class="w-5 h-5 sm:w-6 sm:h-6 flex-shrink-0" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
                <span class="font-semibold text-sm sm:text-base">{{ session('error') }}</span>
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

        .gradient-button {
            background: linear-gradient(135deg, #f59e0b 0%, #f97316 100%);
        }

        .gradient-button:hover {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
        }

        .pulse-animation {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
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

        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.05);
                opacity: 0.9;
            }
        }

        [x-cloak] {
            display: none !important;
        }

        /* Mobile-specific improvements */
        @media (max-width: 640px) {
            .glass-card {
                border-radius: 1rem;
            }

            .hover-lift:hover {
                transform: none;
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            }

            /* Ensure proper spacing on mobile */
            .space-y-3>*+* {
                margin-top: 0.75rem;
            }

            .space-y-4>*+* {
                margin-top: 1rem;
            }
        }

        /* Custom select styling for better mobile experience */
        select.glass-input {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%23ffffff' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.75rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
        }

        /* Improve touch targets for mobile */
        @media (max-width: 640px) {

            button,
            a,
            select,
            input {
                min-height: 44px;
            }
        }

        /* Better table responsiveness */
        @media (max-width: 640px) {
            table {
                font-size: 0.875rem;
            }
        }
    </style>

    <script>
        // Update time and date
        function updateTime() {
            const now = new Date();
            const timeElement = document.getElementById('current-time');
            const dateElement = document.getElementById('current-date');

            if (timeElement) {
                timeElement.textContent = now.toLocaleTimeString('en-US', {
                    hour: '2-digit',
                    minute: '2-digit',
                });
            }

            if (dateElement) {
                dateElement.textContent = now.toLocaleDateString('en-US', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
            }
        }

        // Initialize time display
        updateTime();
        setInterval(updateTime, 1000);

        // // Auto-hide flash messages after 5 seconds
        // document.addEventListener('DOMContentLoaded', function() {
        //     const flashMessages = document.querySelectorAll('[class*="fixed top-4 right-4"]');
        //     flashMessages.forEach(message => {
        //         setTimeout(() => {
        //             message.style.opacity = '0';
        //             message.style.transform = 'translateX(100%)';
        //             setTimeout(() => {
        //                 message.remove();
        //             }, 300);
        //         }, 5000);
        //     });
        // });

        // Improve mobile touch experience
        if ('ontouchstart' in window) {
            document.body.classList.add('touch-device');
        }
    </script>
</div>
