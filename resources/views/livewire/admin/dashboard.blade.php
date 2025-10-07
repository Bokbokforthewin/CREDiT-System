<div class="min-h-screen bg-overlay py-4 sm:py-6 lg:py-8 px-3 sm:px-4 lg:px-8" 
     x-data="{ activeTab: 'overview' }" 
     x-init="init()">

    <!-- Header Section -->
    <div class="max-w-7xl mx-auto mb-6 sm:mb-8">
        <div class="glass-card rounded-2xl sm:rounded-3xl p-4 sm:p-6 lg:p-8 hover-lift slide-in">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 sm:gap-6">
                <div class="flex items-center space-x-3 sm:space-x-6 w-full sm:w-auto">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-orange-400 to-orange-500 rounded-xl sm:rounded-2xl flex items-center justify-center shadow-xl flex-shrink-0">
                        <svg class="w-8 h-8 sm:w-10 sm:h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-white mb-1 sm:mb-2 leading-tight">
                            <span class="text-yellow-400">Admin</span> Dashboard
                        </h1>
                        <p class="text-blue-200 text-base sm:text-lg">Business overview and analytics</p>
                    </div>
                </div>
                <div class="text-left sm:text-right w-full sm:w-auto">
                    <div class="text-2xl sm:text-3xl font-bold text-yellow-400" x-text="currentTime"></div>
                    <div class="text-blue-200 text-sm sm:text-base" x-text="currentDate"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons & Tabs -->
    <div class="max-w-7xl mx-auto mb-6">
        <div class="flex flex-wrap gap-4">
            <a href="{{ route('admin.fullchargeview') }}" 
               class="glass-card hover-lift rounded-xl p-4 py-5 transition-all duration-300 group inline-flex items-center space-x-3">
                <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200 flex-shrink-0">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </div>
                <span class="text-white font-semibold text-lg">Full Charge View</span>
            </a>

            <button @click="activeTab = 'overview'" 
                    :class="activeTab === 'overview' ? 'bg-blue-600/80 text-white' : 'bg-white/20 text-blue-200 hover:bg-white/30'" 
                    class="glass-card rounded-xl px-4 py-3 font-semibold text-lg transition-all duration-300">
                Overview
            </button>

            <button @click="activeTab = 'inactive'" 
                    :class="activeTab === 'inactive' ? 'bg-blue-600/80 text-white' : 'bg-white/20 text-blue-200 hover:bg-white/30'" 
                    class="glass-card rounded-xl px-4 py-3 font-semibold text-lg transition-all duration-300">
                Inactive Families
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="max-w-7xl mx-auto mb-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
            <!-- Monthly Charges Card -->
            <div class="glass-card rounded-xl p-4 sm:p-6 hover-lift h-full">
                <div class="flex items-center space-x-4 h-full">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-blue-200 text-sm font-medium">Monthly Charges</p>
                        <p class="text-white text-xl sm:text-2xl font-bold">₱{{ number_format($monthlyCharges, 2) }}</p>
                    </div>
                </div>
            </div>

            <!-- Today's Transactions Card -->
            <div class="glass-card rounded-xl p-4 sm:p-6 hover-lift h-full">
                <div class="flex items-center space-x-4 h-full">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01"></path>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-blue-200 text-sm font-medium">Today's Transactions</p>
                        <p class="text-white text-xl sm:text-2xl font-bold">{{ $todayTransactions }}</p>
                    </div>
                </div>
            </div>

            <!-- Upcoming Projection Card -->
            <div class="glass-card rounded-xl p-4 sm:p-6 hover-lift h-full">
                <div class="flex items-center space-x-4 h-full">
                    <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-blue-200 text-sm font-medium">Upcoming Projection</p>
                        <p class="text-white text-xl sm:text-2xl font-bold">₱{{ number_format($upcomingProjections, 2) }}</p>
                    </div>
                </div>
            </div>

            <!-- Recent Charged Family Card -->
            @if ($recentChargedFamily)
            <div class="glass-card rounded-xl p-4 sm:p-6 hover-lift h-full">
                <div class="flex items-center space-x-4 h-full">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-blue-200 text-sm font-medium">Recent Family</p>
                        <p class="text-white text-base font-bold truncate">{{ $recentChargedFamily['family_name'] }}</p>
                        <p class="text-purple-400 text-sm font-semibold">₱{{ number_format($recentChargedFamily['amount'], 2) }}</p>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- PRIORITY SECTION: Top & Recent Charges -->
    <div class="max-w-7xl mx-auto mb-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Top Charges Table -->
            <div class="glass-card rounded-2xl overflow-hidden hover-lift h-full flex flex-col">
                <div class="p-4 sm:p-6 border-b border-white/20">
                    <h2 class="text-xl sm:text-2xl font-bold text-white flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg flex items-center justify-center mr-4">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                            </svg>
                        </div>
                        Top Charges This Month
                    </h2>
                </div>
                <div class="p-4 sm:p-6 flex-1 flex flex-col">
                    <div class="overflow-y-auto max-h-100 custom-scrollbar flex-1">
                        <div class="space-y-3">
                            @forelse ($familyChargesPaginated as $family)
                            <div class="flex items-center justify-between py-3 px-4 glass-card bg-white/5 rounded-lg hover:bg-white/10 transition-colors">
                                <div>
                                    <div class="text-white font-medium">{{ $family->family_name }}</div>
                                </div>
                                <div class="text-orange-400 font-bold">{{ number_format($family->total_charges) }}</div>
                            </div>
                            @empty
                                <div class="text-center py-8 text-blue-200">
                                    <svg class="w-12 h-12 text-blue-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <p>No top charges found</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                    @if($familyChargesPaginated->hasPages())
                        <div class="mt-4 pt-4 border-t border-white/20">
                            {{ $familyChargesPaginated->links() }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recent Charges Table -->
            <div class="glass-card rounded-2xl overflow-hidden hover-lift h-full flex flex-col">
                <div class="p-4 sm:p-6 border-b border-white/20">
                    <h2 class="text-xl sm:text-2xl font-bold text-white flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center mr-4">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        Recent Charges
                    </h2>
                </div>
                <div class="p-4 sm:p-6 flex-1">
                    <div class="overflow-y-auto max-h-100 custom-scrollbar">
                        <div class="space-y-3">
                            @forelse ($recentCharges as $charge)
                                <div class="flex items-center justify-between py-3 px-4 glass-card bg-white/5 rounded-lg hover:bg-white/10 transition-colors">
                                    <div>
                                        <div class="text-white font-medium">{{ $charge->family->family_name ?? 'Unknown' }}</div>
                                        <div class="text-blue-200 text-sm">{{ \Carbon\Carbon::parse($charge->created_at)->format('M d, Y') }}</div>
                                    </div>
                                    <div class="text-green-400 font-bold">₱{{ number_format($charge->price, 2) }}</div>
                                </div>
                            @empty
                                <div class="text-center py-8 text-blue-200">
                                    <svg class="w-12 h-12 text-blue-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <p>No recent charges found</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab Content -->
    <div class="max-w-7xl mx-auto">
        <!-- Overview Tab -->
        <div x-show="activeTab === 'overview'" x-transition class="space-y-8">
            <!-- Charts Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Daily Charges Trend -->
                <div class="glass-card rounded-xl p-4 sm:p-6 hover-lift h-full" wire:ignore>
                    <h3 class="text-base font-bold text-white mb-4 flex items-center">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                        Daily Charges
                    </h3>
                    <div class="h-48">
                        <canvas id="monthlyTrendChart" class="w-full h-full"></canvas>
                    </div>
                </div>

                <!-- Department Distribution -->
                <div class="glass-card rounded-xl p-4 sm:p-6 hover-lift h-full" wire:ignore>
                    <h3 class="text-base font-bold text-white mb-4 flex items-center">
                        <div class="w-8 h-8 bg-gradient-to-br from-purple-400 to-purple-600 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                            </svg>
                        </div>
                        Departments
                    </h3>
                    <div class="h-48">
                        <canvas id="departmentDistributionChart" class="w-full h-full"></canvas>
                    </div>
                </div>
                
                <!-- Daily Transactions -->
                <div class="glass-card rounded-xl p-4 sm:p-6 hover-lift h-full" wire:ignore>
                    <h3 class="text-base font-bold text-white mb-4 flex items-center">
                        <div class="w-8 h-8 bg-gradient-to-br from-green-400 to-green-600 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2z"></path>
                            </svg>
                        </div>
                        Transactions
                    </h3>
                    <div class="h-48">
                        <canvas id="dailyTransactionsChart" class="w-full h-full"></canvas>
                    </div>
                </div>

                <!-- Average Per Department -->
                <div class="glass-card rounded-xl p-4 sm:p-6 hover-lift h-full" wire:ignore>
                    <h3 class="text-base font-bold text-white mb-4 flex items-center">
                        <div class="w-8 h-8 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3-3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01"></path>
                            </svg>
                        </div>
                        Average Charge
                    </h3>
                    <div class="h-48">
                        <canvas id="chartAveragePerDepartment" class="w-full h-full"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Inactive Families Tab -->
        <div x-show="activeTab === 'inactive'" x-transition class="space-y-8">
            <!-- Inactive Families Grid -->
            <div class="glass-card rounded-2xl overflow-hidden hover-lift">
                <div class="p-4 sm:p-6 border-b border-white/20">
                    <h2 class="text-xl sm:text-2xl font-bold text-white flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-red-600 rounded-lg flex items-center justify-center mr-4">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        Inactive Families This Month
                    </h2>
                </div>
                <div class="p-4 sm:p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @forelse ($inactiveFamilies as $family)
                            <div class="glass-card bg-white/5 rounded-lg p-4 hover:bg-white/10 transition-colors">
                                <div class="flex items-center">
                                    <span class="mr-3 text-red-400">•</span> 
                                    <span class="text-white font-medium">{{ $family->family_name }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-8 text-blue-200">
                                <svg class="w-12 h-12 text-blue-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                                <p>All families have charges this month. 🎉</p>
                            </div>
                        @endforelse
                    </div>
                </div>
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

        .text-blue-400 {
            color: #60a5fa !important;
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

        .text-orange-400 {
            color: #fb923c !important;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.4);
        }

        .text-yellow-400 {
            color: #fbbf24 !important;
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
            
            button, a {
                min-height: 44px;
            }

            .glass-card {
                border-width: 1px;
                background: rgba(255, 255, 255, 0.12);
            }
        }

        [x-cloak] { 
            display: none !important; 
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function init() {
            // Time and date
            const updateTime = () => {
                const now = new Date();
                const timeElement = document.querySelector('[x-text="currentTime"]');
                const dateElement = document.querySelector('[x-text="currentDate"]');
                
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
            };

            updateTime();
            setInterval(updateTime, 1000);

            // Initialize charts
            renderAllCharts();

            // Listen for updates
            window.addEventListener('chartsUpdated', () => {
                renderAllCharts();
            });
        }

        function renderAllCharts() {
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
                                size: 11,
                                family: 'Inter, sans-serif'
                            },
                            color: 'rgba(255, 255, 255, 0.9)'
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
                                size: 10
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
                                size: 10
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

            // Chart 1: Daily Charges Trend
            createOrUpdateChart('monthlyTrendChart', 'line', {
                labels: {!! json_encode($chartMonthlyTrend->pluck('date')) !!},
                datasets: [{
                    label: '₱ Total per Day',
                    data: {!! json_encode($chartMonthlyTrend->pluck('total')) !!},
                    borderColor: '#60A5FA',
                    backgroundColor: 'rgba(96, 165, 250, 0.2)',
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#60A5FA',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: '#60A5FA'
                }]
            }, {
                ...chartOptions,
                scales: {
                    ...chartOptions.scales,
                    y: { 
                        ...chartOptions.scales.y, 
                        beginAtZero: true,
                        ticks: {
                            ...chartOptions.scales.y.ticks,
                            callback: function(value) {
                                return '₱' + value.toLocaleString();
                            }
                        }
                    }
                },
                plugins: {
                    ...chartOptions.plugins,
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ₱' + context.parsed.y.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                            }
                        }
                    }
                }
            });

            // Chart 2: Department Distribution (Doughnut)
            createOrUpdateChart('departmentDistributionChart', 'doughnut', {
                labels: {!! json_encode($chartDepartmentDistribution->pluck('department_name')) !!},
                datasets: [{
                    data: {!! json_encode($chartDepartmentDistribution->pluck('total')) !!},
                    backgroundColor: ['#F87171', '#34D399', '#60A5FA', '#FBBF24', '#A78BFA', '#EF4444', '#10B981'],
                    hoverOffset: 4
                }]
            }, {
                ...chartOptions,
                scales: { x: { display: false }, y: { display: false } },
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

                    // Chart 3: Daily Transactions Count
                    createOrUpdateChart('dailyTransactionsChart', 'bar', {
                        labels: {!! json_encode($chartDailyTransactions->pluck('date')) !!},
                        datasets: [{
                            label: 'Transactions',
                            data: {!! json_encode($chartDailyTransactions->pluck('total')) !!},
                            backgroundColor: '#34D399',
                            barPercentage: 0.7,
                            categoryPercentage: 0.8
                        }]
                    }, {
                        ...chartOptions,
                        scales: {
                            ...chartOptions.scales,
                            y: { ...chartOptions.scales.y, beginAtZero: true }
                        }
                    });

                    // Chart 4: Average Charge Per Department
                    createOrUpdateChart('chartAveragePerDepartment', 'bar', {
                        labels: @json($chartAveragePerDepartment->pluck('department_name')),
                        datasets: [{
                            label: 'Average Charge (₱)',
                            data: @json($chartAveragePerDepartment->pluck('average')),
                            backgroundColor: '#FBBF24',
                            barPercentage: 0.7,
                            categoryPercentage: 0.8
                        }]
                    }, {
                        ...chartOptions,
                        scales: {
                            ...chartOptions.scales,
                            y: { 
                                ...chartOptions.scales.y, 
                                beginAtZero: true,
                                ticks: {
                                    ...chartOptions.scales.y.ticks,
                                    callback: function(value) {
                                        return '₱' + value.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                                    }
                                }
                            }
                        },
                        plugins: {
                            ...chartOptions.plugins,
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return context.dataset.label + ': ₱' + context.parsed.y.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                                    }
                                }
                            }
                        }
                    });
                }
    </script>
</div>