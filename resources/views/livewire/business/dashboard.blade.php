<div class="min-h-screen bg-overlay py-4 sm:py-6 lg:py-8 px-3 sm:px-4 lg:px-8">
    <!-- Header Section -->
    <div class="max-w-7xl mx-auto mb-6 sm:mb-8">
        <div class="glass-card rounded-2xl sm:rounded-3xl p-4 sm:p-6 lg:p-8 hover-lift slide-in">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 sm:gap-6">
                <div class="flex items-center space-x-3 sm:space-x-6 w-full sm:w-auto">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-xl sm:rounded-2xl flex items-center justify-center shadow-xl flex-shrink-0">
                        <svg class="w-8 h-8 sm:w-10 sm:h-10 text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-white mb-1 sm:mb-2 leading-tight">
                            <span class="text-yellow-400">Business Office</span> Dashboard
                        </h2>
                        <p class="text-blue-200 text-base sm:text-lg lg:text-xl">Financial Analytics & Family Management</p>
                    </div>
                </div>
                <div class="text-left sm:text-right w-full sm:w-auto">
                    <div class="text-2xl sm:text-3xl font-bold text-yellow-400" id="current-time"></div>
                    <div class="text-blue-200 text-sm sm:text-base" id="current-date"></div>
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

    <!-- Action Buttons -->
    <div class="max-w-7xl mx-auto mb-6 sm:mb-8">
        <div class="flex flex-col sm:flex-row gap-4 justify">
            <a href="{{ route('business.departmentmanagement') }}" 
               class="glass-card hover-lift rounded-xl p-4 transition-all duration-300 group">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200 flex-shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m0 0h4M9 7h6m-6 4h6m-2 8h.01"></path>
                        </svg>
                    </div>
                    <span class="text-white font-semibold text-lg">Department Management</span>
                </div>
            </a>

            <a href="{{ route('business.managefamiliespage') }}" 
               class="glass-card hover-lift rounded-xl p-4 transition-all duration-300 group">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200 flex-shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <span class="text-white font-semibold text-lg">Familiy Management</span>
                </div>
            </a>

            <a href="{{ route('business.auditsection') }}" 
                class="glass-card hover-lift rounded-xl px-4 sm:px-6 py-3 sm:py-4 text-white flex items-center justify space-x-3 transition-all duration-300 group w-full sm:w-auto">
                <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200 flex-shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <span class="text-white font-semibold text-lg">Audit Section</span>
            </a>
        </div>
    </div>

    <!-- Search Section -->
    <div class="max-w-7xl mx-auto mb-6 sm:mb-8">
        <div class="glass-card rounded-2xl p-4 sm:p-6 hover-lift">
            <div class="flex items-center space-x-4">
                <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <input type="text" 
                           wire:model="search" 
                           wire:keydown.enter="searchFamily"
                           placeholder="Search family name and press Enter..."
                           class="w-full glass-input rounded-lg px-4 py-3 text-white placeholder-blue-200 focus:outline-none text-base">
                </div>
            </div>
        </div>
    </div>

    <!-- Dashboard Analytics -->
    <div class="max-w-7xl mx-auto mb-8" wire:ignore>
        <div class="glass-card rounded-2xl sm:rounded-3xl p-4 sm:p-6 lg:p-8 hover-lift mb-8">
            <h3 class="text-2xl sm:text-3xl font-bold text-white mb-6 flex items-center">
                <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                Financial Analytics
            </h3>
            
            <!-- Charts Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-4 sm:gap-6">
                
                <!-- Departmental Charge Trends -->
                {{-- <div class="glass-card rounded-xl p-4 sm:p-6 hover-lift">
                    <h4 class="text-lg sm:text-xl font-bold text-white mb-4 flex items-center">
                        <div class="w-8 h-8 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                        <span class="leading-tight">Departmental Charge Trends<br class="sm:hidden"><span class="text-sm font-normal text-blue-200">(Last 6 Months)</span></span>
                    </h4>
                    <div class="h-48 sm:h-64 overflow-x-auto">
                        <canvas id="departmentChargeTrendsChart" class="w-full h-full"></canvas>
                    </div>
                </div> --}}

                <!-- Monthly Charges -->
                <div class="glass-card rounded-xl p-4 sm:p-6 hover-lift">
                    <h4 class="text-lg sm:text-xl font-bold text-white mb-4 flex items-center">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        Total Monthly Charges of all Departments (₱)
                    </h4>
                    <div class="h-48 sm:h-64">
                        <canvas id="monthlyChargesChart" class="w-full h-full"></canvas>
                    </div>
                </div>

                <!-- Top 5 Families -->
                <div class="glass-card rounded-xl p-4 sm:p-6 hover-lift">
                    <h4 class="text-lg sm:text-xl font-bold text-white mb-4 flex items-center">
                        <div class="w-8 h-8 bg-gradient-to-br from-green-400 to-green-600 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                            </svg>
                        </div>
                        Top 5 Families This Month
                    </h4>
                    <div class="h-48 sm:h-64">
                        <canvas id="topFamiliesChart" class="w-full h-full"></canvas>
                    </div>
                </div>

                <!-- Department Distribution -->
                <div class="glass-card rounded-xl p-4 sm:p-6 hover-lift">
                    <h4 class="text-lg sm:text-xl font-bold text-white mb-4 flex items-center">
                        <div class="w-8 h-8 bg-gradient-to-br from-purple-400 to-purple-600 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                            </svg>
                        </div>
                        Department Charge Distribution this Month
                    </h4>
                    <div class="h-48 sm:h-64">
                        <canvas id="departmentChargesChart" class="w-full h-full"></canvas>
                    </div>
                </div>

                <!-- Restrictions Chart -->
                <div class="glass-card rounded-xl p-4 sm:p-6 hover-lift">
                    <h4 class="text-lg sm:text-xl font-bold text-white mb-4 flex items-center">
                        <div class="w-8 h-8 bg-gradient-to-br from-red-400 to-red-600 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L5.636 5.636"></path>
                            </svg>
                        </div>
                        Restrictions per Member
                    </h4>
                    <div class="h-48 sm:h-64">
                        <canvas id="restrictionsChart" class="w-full h-full"></canvas>
                    </div>
                </div>

                <!-- Monthly Charges by Department Chart -->
                <div class="glass-card rounded-xl p-4 sm:p-6 hover-lift sm:col-span-2">
                    <h4 class="text-lg sm:text-xl font-bold text-white mb-4 flex items-center">
                        <div class="w-8 h-8 bg-gradient-to-br from-indigo-400 to-indigo-600 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                            </svg>
                        </div>
                        Monthly Charges by Department
                    </h4>
                    <div class="h-48 sm:h-64">
                        <canvas id="departmentLinesChart" class="w-full h-full"></canvas>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Family Charges Modal -->
    @if($showModal && $family)
        <div class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm flex items-start justify-center pt-4 sm:pt-20 z-50 p-4">
            <div class="glass-card rounded-2xl sm:rounded-3xl shadow-2xl w-full max-w-6xl max-h-[90vh] overflow-hidden">
                <!-- Modal Header -->
                <div class="p-4 sm:p-6 border-b border-white/20">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                        <h3 class="text-xl sm:text-2xl font-bold text-white">
                            Charges for <span class="text-yellow-400">{{ $family->family_name }}</span>
                        </h3>
                        <button wire:click="closeModal" 
                                class="text-white hover:text-red-400 transition-colors duration-200 self-end sm:self-auto">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <!-- Month & Year Filters -->
                    <div class="flex flex-col sm:flex-row gap-4 mt-4">
                        <div class="flex items-center space-x-2">
                            <label class="text-sm font-medium text-blue-200">Month</label>
                            <select wire:model.lazy="selectedMonth" 
                                    class="glass-input rounded-lg px-3 py-2 text-black text-sm appearance-none">
                                @for ($m = 1; $m <= 12; $m++)
                                    <option value="{{ $m }}" @if($selectedYear == now()->year && $m > now()->month) disabled @endif>
                                        {{ \Carbon\Carbon::create()->month((int) $m)->format('F') }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        
                        <div class="flex items-center space-x-2">
                            <label class="text-sm font-medium text-blue-200">Year</label>
                            <select wire:model.lazy="selectedYear" 
                                    class="glass-input rounded-lg px-3 py-2 text-black text-sm appearance-none">
                                @for ($y = now()->year; $y >= 2020; $y--)
                                    <option value="{{ $y }}">{{ $y }}</option>
                                @endfor
                            </select>
                        </div>

                        <div class="flex items-center space-x-2">

                            <h4 class="text-medium sm:text-lg font-bold text-white">
                                Total Charges: <span class="text-yellow-400">₱{{number_format($charges->sum('price'),2) }}</span></h4>

                        </div>
                    </div>
                </div>

                <!-- Modal Content -->
                <div class="p-4 sm:p-6 overflow-y-auto max-h-[60vh]">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-white/5">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-blue-200 uppercase tracking-wider">Date</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-blue-200 uppercase tracking-wider">Description</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-blue-200 uppercase tracking-wider">Price</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-blue-200 uppercase tracking-wider hidden sm:table-cell">Charged By</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-blue-200 uppercase tracking-wider hidden lg:table-cell">Frontdesk Staff</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-blue-200 uppercase tracking-wider hidden lg:table-cell">Department</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/10">
                                @forelse ($charges as $charge)
                                    <tr class="hover:bg-white/5 transition-colors duration-200">
                                        <td class="px-4 py-4 whitespace-nowrap text-white text-sm">{{ \Carbon\Carbon::parse($charge->charge_datetime)->format('Y-m-d') }}</td>
                                        <td class="px-4 py-4 text-white text-sm">
                                            <div class="max-w-xs sm:max-w-sm break-words">{{ $charge->description }}</div>
                                            <div class="sm:hidden text-xs text-blue-200 mt-1">{{ $charge->member->full_name ?? 'N/A' }} • {{ $charge->user->name ?? 'N/A' }}</div>
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-green-400 font-bold text-sm">₱{{ number_format($charge->price, 2) }}</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-white text-sm hidden sm:table-cell">{{ $charge->member->full_name ?? 'N/A' }}</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-blue-200 text-sm hidden lg:table-cell">{{ $charge->user->name ?? 'N/A' }}</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-blue-200 text-sm hidden lg:table-cell">{{ $charge->department->name ?? 'N/A' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-8 text-blue-200">
                                            <div class="flex flex-col items-center">
                                                <svg class="w-12 h-12 text-blue-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                                @if ($selectedYear > now()->year || ($selectedYear == now()->year && $selectedMonth > now()->month))
                                                    <p class="text-lg font-medium">Oops! You're in the future — no charges found yet for {{ \Carbon\Carbon::create()->month((int)$selectedMonth)->format('F') }} {{ $selectedYear }}.</p>
                                                @else
                                                    <p class="text-lg font-medium">No charges found for {{ \Carbon\Carbon::create()->month((int)$selectedMonth)->format('F') }} {{ $selectedYear }}.</p>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
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
    </style>

    <!-- Scripts Section -->
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Time and date functionality
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
        
        updateTime();
        setInterval(updateTime, 1000);

        // Chart functionality - preserved from original
        let charts = {}; // Hold references to each chart

        function renderAllCharts() {
            const chartOptions = { 
                responsive: true, 
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: {
                            color: 'rgba(255, 255, 255, 0.8)',
                            font: {
                                size: 12
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: 'rgba(255, 255, 255, 0.7)',
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
                            color: 'rgba(255, 255, 255, 0.7)',
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

            if (charts.monthlyChargesChart) charts.monthlyChargesChart.destroy();
            charts.monthlyChargesChart = new Chart(document.getElementById('monthlyChargesChart'), {
                type: 'bar',
                data: @json($monthlyChargesChart),
                options: {
                    ...chartOptions,
                    scales: {
                        ...chartOptions.scales,
                        y: {
                            ...chartOptions.scales.y,
                            beginAtZero: true
                        }
                    }
                }
            });

            if (charts.topFamiliesChart) charts.topFamiliesChart.destroy();
            charts.topFamiliesChart = new Chart(document.getElementById('topFamiliesChart'), {
                type: 'bar',
                data: @json($topFamiliesChart),
                options: {
                    ...chartOptions,
                    scales: {
                        ...chartOptions.scales,
                        y: {
                            ...chartOptions.scales.y,
                            beginAtZero: true
                        }
                    }
                }
            });

            if (charts.departmentChargesChart) charts.departmentChargesChart.destroy();
            charts.departmentChargesChart = new Chart(document.getElementById('departmentChargesChart'), {
                type: 'pie',
                data: @json($departmentChargesChart),
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: 'rgba(255, 255, 255, 0.8)',
                                font: {
                                    size: 11
                                }
                            }
                        }
                    }
                }
            });

            if (charts.restrictionsChart) charts.restrictionsChart.destroy();
            charts.restrictionsChart = new Chart(document.getElementById('restrictionsChart'), {
                type: 'doughnut',
                data: @json($restrictionsChart),
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: 'rgba(255, 255, 255, 0.8)',
                                font: {
                                    size: 11
                                }
                            }
                        }
                    }
                }
            });

            if (charts.departmentLinesChart) charts.departmentLinesChart.destroy();
            charts.departmentLinesChart = new Chart(document.getElementById('departmentLinesChart'), {
                type: 'line',
                data: @json($departmentLinesChart),
                options: {
                    ...chartOptions,
                    scales: {
                        ...chartOptions.scales,
                        y: {
                            ...chartOptions.scales.y,
                            beginAtZero: true
                        }
                    }
                }
            });

            if (charts.departmentChargeTrendsChart) charts.departmentChargeTrendsChart.destroy();
            charts.departmentChargeTrendsChart = new Chart(document.getElementById('departmentChargeTrendsChart'), {
                type: 'bar',
                data: @json($departmentChargeTrendChart),
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: 'rgba(255, 255, 255, 0.8)',
                                font: {
                                    size: 11
                                }
                            }
                        },
                    },
                    scales: {
                        x: {
                            stacked: true,
                            ticks: {
                                color: 'rgba(255, 255, 255, 0.7)',
                                font: {
                                    size: 11
                                }
                            },
                            grid: {
                                color: 'rgba(255, 255, 255, 0.1)'
                            }
                        },
                        y: {
                            stacked: true,
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Total Charges (₱)',
                                color: 'rgba(255, 255, 255, 0.8)'
                            },
                            ticks: {
                                color: 'rgba(255, 255, 255, 0.7)',
                                font: {
                                    size: 11
                                }
                            },
                            grid: {
                                color: 'rgba(255, 255, 255, 0.1)'
                            }
                        }
                    }
                }
            });
        }

        document.addEventListener('DOMContentLoaded', renderAllCharts);

        window.addEventListener('chartsUpdated', () => {
            renderAllCharts();
        });

        // Handle resize events for charts
        window.addEventListener('resize', () => {
            Object.values(charts).forEach(chart => {
                if (chart) {
                    chart.resize();
                }
            });
        });
    </script>
    @endpush
</div>