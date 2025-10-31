<div class="min-h-screen bg-overlay py-4 sm:py-6 lg:py-8 px-3 sm:px-4 lg:px-8" 
     x-data="familyManager()" 
     x-init="init()">

     <div class="max-w-7xl mx-auto mb-6 sm:mb-8">
        <div class="glass-card rounded-2xl sm:rounded-3xl p-4 sm:p-6 lg:p-8 hover-lift slide-in">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 sm:gap-6">
                <div class="flex items-center space-x-3 sm:space-x-6 w-full sm:w-auto">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-xl sm:rounded-2xl flex items-center justify-center shadow-xl flex-shrink-0">
                        <svg class="w-8 h-8 sm:w-10 sm:h-10 text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-white mb-1 sm:mb-2 leading-tight">
                            <span class="text-yellow-400">Family</span> Management
                        </h1>
                        <p class="text-blue-200 text-base sm:text-lg">Manage families and member relationships</p>
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
        <div class="flex flex-col sm:flex-row gap-4 justify-between">
            <div class="flex flex-col sm:flex-row gap-3 flex-wrap">
                <a href="{{ route('business.dashboard') }}" 
                   class="glass-card hover-lift rounded-xl px-4 sm:px-6 py-3 sm:py-4 text-white flex items-center justify space-x-3 transition-all duration-300 group w-full sm:w-auto">
                    <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </div>
                    <span class="font-semibold text-base sm:text-lg">Back to Dashboard</span>
                </a>
                
                <button wire:click="openAddModal"
                        @click="showAddModal = true"
                        class="glass-card hover-lift rounded-xl px-4 sm:px-6 py-3 sm:py-4 text-white flex items-center justify space-x-3 transition-all duration-300 group w-full sm:w-auto">
                    <div class="w-8 h-8 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </div>
                    <span class="font-semibold text-base sm:text-lg">Add Family</span>
                </button>
                
                {{-- <button wire:click="openLimitEditor"
                        @click="showLimitModal = true"
                        class="glass-card hover-lift rounded-xl px-4 sm:px-6 py-3 sm:py-4 text-white flex items-center justify-center space-x-3 transition-all duration-300 group w-full sm:w-auto">
                    <div class="w-8 h-8 bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <span class="font-semibold text-base sm:text-lg">Edit Limits & Restrictions</span>
                </button> --}}

                <a href="{{ route('business.limitsandrestrictions') }}" 
                class="glass-card hover-lift rounded-xl px-4 sm:px-6 py-3 sm:py-4 text-white flex items-center justify space-x-3 transition-all duration-300 group w-full sm:w-auto">
                <div class="w-8 h-8 bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <span class="font-semibold text-base sm:text-lg">Edit Limits & Restrictions</span>
            </a>
            
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="max-w-7xl mx-auto mb-6">
            <div class="glass-card rounded-xl p-4 border-l-4 border-green-400">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-green-400 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span class="text-white font-semibold">{{ session('message') }}</span>
                </div>
            </div>
        </div>
    @endif

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

    <!-- Search and Filters -->
    <div class="max-w-7xl mx-auto mb-6">
        <div class="glass-card rounded-2xl p-4 sm:p-6 hover-lift">
            <div class="flex flex-col gap-4">
                <div class="w-full">
                    <input type="text" 
                            wire:model.live.debounce.300ms="search"
                           wire:keydown.enter="applySearch"
                           placeholder="Search family name..." 
                           class="glass-input rounded-xl px-4 py-3 w-full text-white placeholder-blue-200 focus:outline-none">
                </div>
                <div class="flex flex-wrap gap-1 sm:gap-2">
                    @foreach (range('A', 'Z') as $char)
                        <button wire:click="$set('letter', '{{ $char }}')"
                                class="px-2 sm:px-3 py-1 sm:py-2 rounded-lg text-sm font-medium transition {{ $letter === $char ? 'bg-blue-500 text-white' : 'bg-white/20 text-blue-200 hover:bg-white/30' }}">
                            {{ $char }}
                        </button>
                    @endforeach
                    <button wire:click="$set('letter', '')"
                            class="px-2 sm:px-3 py-1 sm:py-2 rounded-lg text-sm font-medium transition {{ $letter === '' ? 'bg-blue-500 text-white' : 'bg-white/20 text-blue-200 hover:bg-white/30' }}">
                        All
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Family List -->
    <div class="max-w-7xl mx-auto">
        <div class="glass-card rounded-2xl sm:rounded-3xl overflow-hidden hover-lift">
            <div class="p-4 sm:p-6 lg:p-8 border-b border-white/20">
                <h3 class="text-xl sm:text-2xl font-bold text-white flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    Family Directory
                </h3>
            </div>

            <div class="p-4 sm:p-6 lg:p-8">
                @if($families->isEmpty())
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 text-blue-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <p class="text-blue-200 text-lg font-medium mb-2">No families found</p>
                        <p class="text-blue-300 text-sm">Create your first family to get started</p>
                    </div>
                @else
                    <!-- Mobile Card View -->
                    <div class="block sm:hidden space-y-4">
                        @foreach($families as $family)
                            <div class="glass-card rounded-xl p-4 hover-lift">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                                            <span class="text-white font-bold text-sm">{{ $family->id }}</span>
                                        </div>
                                        <div>
                                            <h4 class="text-white font-semibold text-base">{{ $family->family_name }}</h4>
                                            <p class="text-blue-200 text-xs">Code: {{ $family->account_code }}</p>
                                        </div>
                                    </div>
                                    <div class="bg-yellow-400 text-blue-900 px-2 py-1 rounded-lg text-xs font-bold">{{ $family->members->count() }} members</div>
                                </div>
                                <div class="flex flex-wrap gap-2">
                                    <button wire:click="openShowMembersModal({{ $family->id }})"
                                            @click="showMemberModal = true"
                                            class="px-3 py-1 bg-green-600/20 text-green-400 rounded-lg hover:bg-green-600/30 transition text-sm font-medium">
                                        View Members
                                    </button>
                                    <button wire:click="openEditModal({{ $family->id }})"
                                            @click="showEditModal = true"
                                            class="px-3 py-1 bg-indigo-600/20 text-indigo-400 rounded-lg hover:bg-indigo-600/30 transition text-sm font-medium">
                                        Edit
                                    </button>
                                    <button wire:click="confirmDelete({{ $family->id }})"
                                            @click="showDeleteModal = true"
                                            class="px-3 py-1 bg-red-600/20 text-red-400 rounded-lg hover:bg-red-600/30 transition text-sm font-medium">
                                        Delete
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Desktop Table View -->
                    <div class="hidden sm:block overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-white/5">
                                <tr>
                                    <th class="px-6 py-4 text-blue-200 uppercase text-xs font-semibold tracking-wider">Family Name</th>
                                    <th class="px-6 py-4 text-blue-200 uppercase text-xs font-semibold tracking-wider">Account Code</th>
                                    <th class="px-6 py-4 text-blue-200 uppercase text-xs font-semibold tracking-wider">Members</th>
                                    <th class="px-6 py-4 text-blue-200 uppercase text-xs font-semibold tracking-wider text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/10">
                                @foreach($families as $family)
                                    <tr class="hover:bg-white/5 transition-colors duration-200">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center mr-3">
                                                    <span class="text-white font-bold text-sm">{{ $family->id }}</span>
                                                </div>
                                                <span class="text-white font-medium text-base">{{ $family->family_name }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-blue-200 font-medium">{{ $family->account_code }}</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="bg-yellow-400 text-blue-900 px-2 py-1 rounded-lg text-xs font-bold">{{ $family->members->count() }} members</span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex items-center justify-end space-x-2">
                                                <button wire:click="openShowMembersModal({{ $family->id }})"
                                                        @click="showMemberModal = true"
                                                        class="px-4 py-2 bg-green-600/20 text-green-400 rounded-lg hover:bg-green-600/30 transition font-medium">
                                                    View Members
                                                </button>
                                                <button wire:click="openEditModal({{ $family->id }})"
                                                        @click="showEditModal = true"
                                                        class="px-4 py-2 bg-indigo-800/40 text-indigo-400 rounded-lg hover:bg-indigo-600 transition font-medium">
                                                    Edit
                                                </button>
                                                <button wire:click="confirmDelete({{ $family->id }})"
                                                        @click="showDeleteModal = true"
                                                        class="px-4 py-2 bg-red-600/20 text-red-400 rounded-lg hover:bg-red-600/30 transition font-medium">
                                                    Delete
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="p-4 border-t border-white/20">{{ $families->links() }}</div>
                @endif
            </div>
        </div>
    </div>

    <!-- Add Family Modal -->
    @if ($showAddModal)
        <div x-show="showAddModal" 
             x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-90"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-90"
             class="fixed inset-0 flex items-center justify-center bg-black/60 backdrop-blur-sm z-50 p-4">
            <div class="glass-card rounded-2xl sm:rounded-3xl p-6 sm:p-8 w-full max-w-md mx-auto hover-lift">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl sm:text-2xl font-bold text-white">Add New Family</h2>
                </div>

                <div class="space-y-4 mb-6">
                    <div>
                        <label class="block text-sm font-semibold text-blue-200 mb-3">Family Name</label>
                        <input type="text"
                               wire:model.defer="newFamilyName"
                               class="w-full glass-input rounded-xl px-4 py-3 text-white placeholder-blue-200 focus:outline-none text-base"
                               placeholder="Enter family name...">
                        @error('newFamilyName')
                            <div class="flex items-center mt-2">
                                <svg class="w-4 h-4 text-red-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-red-400 text-sm">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-blue-200 mb-3">Account Code</label>
                        <input type="text"
                               wire:model.defer="newAccountCode"
                               class="w-full glass-input rounded-xl px-4 py-3 text-white placeholder-blue-200 focus:outline-none text-base"
                               placeholder="Enter account code...">
                        @error('newAccountCode')
                            <div class="flex items-center mt-2">
                                <svg class="w-4 h-4 text-red-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-red-400 text-sm">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-blue-200 mb-3">Head of the family Name:</label>
                        <input type="text"
                               wire:model.defer="newMemberName"
                               class="w-full glass-input rounded-xl px-4 py-3 text-white placeholder-blue-200 focus:outline-none text-base"
                               placeholder="Enter Head of the Family Name...">
                        @error('newAccountCode')
                            <div class="flex items-center mt-2">
                                <svg class="w-4 h-4 text-red-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-red-400 text-sm">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-blue-200 mb-3">Email Address</label>
                        <input type="text"
                               wire:model.defer="newMemberEmail"
                               class="w-full glass-input rounded-xl px-4 py-3 text-white placeholder-blue-200 focus:outline-none text-base"
                               placeholder="Enter Email Address...">
                        @error('newAccountCode')
                            <div class="flex items-center mt-2">
                                <svg class="w-4 h-4 text-red-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-red-400 text-sm">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-blue-200 mb-3">RFID Code</label>
                        <input type="text"
                               wire:model.defer="newMemberRfid"
                               class="w-full glass-input rounded-xl px-4 py-3 text-white placeholder-blue-200 focus:outline-none text-base"
                               placeholder="Enter RFID Code...">
                        @error('newAccountCode')
                            <div class="flex items-center mt-2">
                                <svg class="w-4 h-4 text-red-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-red-400 text-sm">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>
                    <div>
                        <h1 class="block text-medium font-semibold text-blue-200 mb-3">Note: Password will be the Default Password, ask Family Head to Change Passowrd for their account</h1>
                    </div>
                </div>

                <div class="flex flex-col-reverse sm:flex-row justify-end gap-3">
                    <button wire:click="$set('showAddModal', false)" 
                            class="w-full sm:w-auto px-6 py-3 glass-card bg-white/10 text-blue-200 rounded-xl hover:bg-white/20 transition font-semibold">
                        Cancel
                    </button>
                    <button wire:click="saveNewFamily"
                            class="w-full sm:w-auto px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl hover:from-green-700 hover:to-green-800 transition font-semibold shadow-lg">
                        Save
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- View Members Modal -->
    @if ($showMemberModal)
        <div x-show="showMemberModal" 
             x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-90"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-90"
             class="fixed inset-0 flex items-center justify-center bg-black/60 backdrop-blur-sm z-50 p-4">
            <div class="glass-card rounded-2xl sm:rounded-3xl p-6 sm:p-8 w-full max-w-md mx-auto hover-lift max-h-[80vh] overflow-y-auto">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-white">Members of {{ $selectedFamily->family_name }}</h2>
                            <p class="text-blue-200 text-sm">Code: {{ $selectedFamily->account_code }}</p>
                        </div>
                    </div>
                    <button wire:click="$set('showMemberModal', false)" class="text-blue-200 hover:text-white">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <div class="space-y-3">
                    @foreach ($selectedFamily->members as $member)
                        <div class="glass-card bg-white/5 rounded-xl p-4">
                            <div class="font-medium text-white mb-2">{{ $member->name }}</div>
                            <div class="text-sm text-blue-200 mb-1">
                                <span class="font-medium">Email:</span> {{ $member->email }}
                            </div>
                            <div class="text-sm text-blue-200 mb-2">
                                <span class="font-medium">RFID:</span> {{ $member->rfid_code }}
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="px-3 py-1 rounded-full text-xs font-medium {{ $member->role === 'head' ? 'bg-blue-500 text-white' : 'bg-white/20 text-blue-200' }}">
                                    {{ ucfirst($member->role) }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-6 flex justify-end">
                    <button wire:click="$set('showMemberModal', false)"
                            class="px-6 py-3 glass-card bg-white/10 text-blue-200 rounded-xl hover:bg-white/20 transition font-semibold">
                        Close
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Edit Family Modal -->
    @if ($editModal)
        <div x-show="showEditModal" 
             x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-90"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-90"
             class="fixed inset-0 flex items-center justify-center bg-black/60 backdrop-blur-sm z-50 p-4">
            <div class="glass-card rounded-2xl sm:rounded-3xl p-6 sm:p-8 w-full max-w-4xl mx-auto hover-lift max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl sm:text-2xl font-bold text-white">Edit Family</h2>
                    </div>
                    <button wire:click="$set('editModal', false)" class="text-blue-200 hover:text-white">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="block text-sm font-semibold text-blue-200 mb-3">Family Name</label>
                        <input type="text"
                               wire:model="familyName"
                               class="w-full glass-input rounded-xl px-4 py-3 text-white placeholder-blue-200 focus:outline-none text-base"
                               placeholder="Enter family name...">
                        @error('familyName')
                            <div class="flex items-center mt-2">
                                <svg class="w-4 h-4 text-red-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-red-400 text-sm">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-blue-200 mb-3">Account Code</label>
                        <input type="text"
                               wire:model="accountCode"
                               class="w-full glass-input rounded-xl px-4 py-3 text-white placeholder-blue-200 focus:outline-none text-base"
                               placeholder="Enter account code...">
                        @error('accountCode')
                            <div class="flex items-center mt-2">
                                <svg class="w-4 h-4 text-red-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-red-400 text-sm">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="mb-6">
                    <button wire:click="addMemberField"
                            class="glass-card hover-lift rounded-xl px-4 py-3 text-white flex items-center space-x-3 transition-all duration-300 group">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </div>
                        <span class="font-semibold">Add Member</span>
                    </button>
                </div>

                @error('familyMembers')
                    <div class="mb-4 glass-card bg-red-500/10 border border-red-400/30 rounded-xl p-4">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-red-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-red-400 font-medium">Oops, RFID cannot be Duplicated</span>
                        </div>
                    </div>
                @enderror

                <div class="space-y-4 mb-6">
                    @foreach ($familyMembers as $index => $member)
                        <div class="glass-card bg-white/5 rounded-xl p-4">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                <div>
                                    <label class="block text-xs text-blue-200 mb-2">Name</label>
                                    <input type="text" 
                                           wire:model="familyMembers.{{ $index }}.name"
                                           class="w-full glass-input rounded-lg px-3 py-2 text-white placeholder-blue-200 focus:outline-none text-sm"
                                           placeholder="Enter name...">
                                    @error("familyMembers.$index.name")
                                        <span class="text-red-400 text-xs mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-xs text-blue-200 mb-2">Email</label>
                                    <input type="email" 
                                           wire:model="familyMembers.{{ $index }}.email"
                                           class="w-full glass-input rounded-lg px-3 py-2 text-white placeholder-blue-200 focus:outline-none text-sm"
                                           placeholder="Enter email...">
                                    @error("familyMembers.$index.email")
                                        <span class="text-red-400 text-xs mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-xs text-blue-200 mb-2">RFID</label>
                                    <input type="text" 
                                           wire:model="familyMembers.{{ $index }}.rfid"
                                           class="w-full glass-input rounded-lg px-3 py-2 text-white placeholder-blue-200 focus:outline-none text-sm"
                                           placeholder="Enter RFID...">
                                    @error("familyMembers.$index.rfid")
                                        <span class="text-red-400 text-xs mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            @php
                                $isHead = $member['role'] === 'head';
                                $hasHead = collect($familyMembers)->contains('role', 'head');
                            @endphp

                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="checkbox" 
                                               wire:click="toggleHead({{ $index }})"
                                               class="sr-only peer"
                                               @checked($isHead)
                                               @disabled($hasHead && !$isHead)>
                                        <div class="relative w-11 h-6 bg-white/20 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                        </div>
                                    </label>
                                    <span class="text-xs {{ $hasHead && !$isHead ? 'text-blue-300' : 'text-blue-200' }}">
                                        {{ $isHead ? 'Head' : 'Member' }}
                                    </span>
                                </div>
                                
                                <button @click="confirmRemoveMember({{ $index }}, '{{ $member['name'] ?? '' }}')"
                                        class="p-2 bg-red-600/20 text-red-400 rounded-lg hover:bg-red-600/30 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>

                            <input type="hidden" name="familyMembers[{{ $index }}][id]" value="{{ $member['id'] }}">
                        </div>
                    @endforeach
                </div>

                @if ($deleteError)
                    <div class="text-red-400 text-sm font-semibold mt-2">
                        {{ $deleteError }}
                    </div>
                @endif

                <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 pt-4 border-t border-white/20">
                    <button wire:click="$set('editModal', false)" 
                            class="w-full sm:w-auto px-6 py-3 glass-card bg-white/10 text-blue-200 rounded-xl hover:bg-white/20 transition font-semibold">
                        Cancel
                    </button>
                    <button wire:click="saveFamilyChanges"
                            class="w-full sm:w-auto px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl hover:from-green-700 hover:to-green-800 transition font-semibold shadow-lg">
                        Save Changes
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Member Delete Confirmation Modal -->
    <div x-show="showMemberDeleteModal" 
         x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-90"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-90"
         class="fixed inset-0 flex items-center justify-center bg-black/60 backdrop-blur-sm z-50 p-4">
        <div class="glass-card rounded-2xl sm:rounded-3xl p-6 sm:p-8 w-full max-w-sm mx-auto hover-lift">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.728-.833-2.498 0L3.316 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <h2 class="text-lg sm:text-xl font-bold text-white">Confirm Member Removal</h2>
            </div>
            
            <p class="text-blue-200 mb-6 text-base leading-relaxed">
                Are you sure you want to remove <strong x-text="memberToDeleteName"></strong> from this family?
            </p>
            
            <div class="flex flex-col-reverse sm:flex-row justify-end gap-3">
                <button @click="showMemberDeleteModal = false; memberDeleteIndex = null; memberToDeleteName = ''"
                        class="w-full sm:w-auto px-6 py-3 glass-card bg-white/10 text-blue-200 rounded-xl hover:bg-white/20 transition font-semibold">
                    Cancel
                </button>
                <button @click="removeMemberConfirmed"
                    class="w-full sm:w-auto px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-xl hover:from-red-700 hover:to-red-800 transition font-semibold shadow-lg">
                    Remove Member
                </button>
            </div>
        </div>
    </div>

    <!-- Family Delete Confirmation Modal -->
    @if ($deleteModal)
        <div x-show="showDeleteModal"
             x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-90"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-90"
             class="fixed inset-0 flex items-center justify-center bg-black/60 backdrop-blur-sm z-50 p-4">
            <div class="glass-card rounded-2xl sm:rounded-3xl p-6 sm:p-8 w-full max-w-sm mx-auto hover-lift">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.728-.833-2.498 0L3.316 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <h2 class="text-lg sm:text-xl font-bold text-white">Confirm Deletion</h2>
                </div>
                
                <p class="text-blue-200 mb-6 text-base leading-relaxed">
                    Are you sure you want to delete the <strong>{{ $selectedFamily->family_name }}</strong> family? This action cannot be undone.
                </p>
                
                <div class="flex flex-col-reverse sm:flex-row justify-end gap-3">
                    <button wire:click="$set('deleteModal', false)"
                            class="w-full sm:w-auto px-6 py-3 glass-card bg-white/10 text-blue-200 rounded-xl hover:bg-white/20 transition font-semibold">
                        Cancel
                    </button>
                    <button wire:click="deleteFamily"
                            class="w-full sm:w-auto px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-xl hover:from-red-700 hover:to-red-800 transition font-semibold shadow-lg">
                        Delete Family
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- <!-- Limits & Restrictions Modal -->
    @if ($showLimitModal)
        <div x-show="showLimitModal" 
             x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-90"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-90"
             class="fixed inset-0 flex items-center justify-center bg-black/60 backdrop-blur-sm z-50 p-4">
            <div class="glass-card rounded-2xl sm:rounded-3xl p-6 sm:p-8 w-full max-w-6xl mx-auto hover-lift max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl sm:text-2xl font-bold text-white">Member Department Rules Editor</h2>
                    </div>
                    <button wire:click="closeLimitModal" class="text-blue-200 hover:text-white">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="flex flex-wrap gap-2 mb-6">
                    <button wire:click="toggleTab('limit')"
                            class="px-4 py-2 rounded-xl font-medium transition {{ $activeTab === 'limit' ? 'bg-blue-600 text-white' : 'bg-white/20 text-blue-200 hover:bg-white/30' }}">
                        Limit
                    </button>
                    <button wire:click="toggleTab('restriction')"
                            class="px-4 py-2 rounded-xl font-medium transition {{ $activeTab === 'restriction' ? 'bg-blue-600 text-white' : 'bg-white/20 text-blue-200 hover:bg-white/30' }}">
                        Restriction
                    </button>
                </div>

                <div class="mb-6">
                    <input type="text" 
                           wire:model.lazy="limitSearch"
                           placeholder="Search member or family name to view members and their department settings."
                           class="glass-input rounded-xl px-4 py-3 w-full text-white placeholder-blue-200 focus:outline-none">
                </div>

                @if (trim($limitSearch) === '')
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 text-blue-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <p class="text-blue-200 text-lg font-medium mb-2">Search to get started</p>
                        <p class="text-blue-300 text-sm">Enter a member or family name in the search box above to view their department settings.</p>
                    </div>
                @else
                    <div class="overflow-x-auto" style="max-height: 60vh; overflow-y: auto;">
                        @if ($activeTab === 'limit')
                            <div class="glass-card bg-white/5 rounded-xl overflow-hidden">
                                <table class="w-full text-sm" style="min-width: {{ 300 + (count($departments) * 150) }}px;">
                                    <thead class="bg-white/10 sticky top-0">
                                        <tr>
                                            <th class="p-4 text-left text-blue-200 font-semibold sticky left-0 bg-white/10 z-10" style="min-width: 250px;">Member \ Department</th>
                                            @foreach ($departments as $dept)
                                                <th class="p-4 text-center text-blue-200 font-semibold whitespace-nowrap" style="min-width: 150px;">{{ $dept->name }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-white/10">
                                        @if ($this->filteredMembers->isEmpty())
                                            <tr>
                                                <td colspan="{{ 1 + count($departments) }}" class="text-center py-8 text-blue-300 italic">
                                                    No member or family name matches your search.
                                                </td>
                                            </tr>
                                        @endif

                                        @foreach ($this->filteredMembers as $member)
                                            <tr class="hover:bg-white/5">
                                                <td class="p-4 font-semibold text-white sticky left-0 bg-white/5 z-10" style="min-width: 250px;">{{ $member->full_name }}</td>
                                                @foreach ($departments as $dept)
                                                    <td class="p-4 text-center" style="min-width: 150px;">
                                                        @if (!($restrictions[$member->id][$dept->id] ?? false))
                                                            <div class="flex flex-col space-y-2">
                                                                <input type="number" 
                                                                       step="0.01" 
                                                                       placeholder="Spending"
                                                                       wire:model.defer="limits.{{ $member->id }}.{{ $dept->id }}.spending_limit"
                                                                       class="glass-input rounded px-2 py-1 w-full text-xs text-white placeholder-blue-200 focus:outline-none">
                                                                <input type="number" 
                                                                       step="0.01" 
                                                                       placeholder="Original"
                                                                       wire:model.defer="limits.{{ $member->id }}.{{ $dept->id }}.original_limit"
                                                                       class="glass-input rounded px-2 py-1 w-full text-xs text-white placeholder-blue-200 focus:outline-none">
                                                            </div>
                                                        @else
                                                            <span class="text-xs text-red-400">Restricted</span>
                                                        @endif
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif

                        @if ($activeTab === 'restriction')
                            <div class="glass-card bg-white/5 rounded-xl overflow-hidden">
                                <table class="w-full text-sm" style="min-width: {{ 300 + (count($departments) * 120) }}px;">
                                    <thead class="bg-white/10 sticky top-0">
                                        <tr>
                                            <th class="p-4 text-left text-blue-200 font-semibold sticky left-0 bg-white/10 z-10" style="min-width: 250px;">Member \ Department</th>
                                            @foreach ($departments as $dept)
                                                <th class="p-4 text-center text-blue-200 font-semibold whitespace-nowrap" style="min-width: 120px;">{{ $dept->name }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-white/10">
                                        @if ($this->filteredMembers->isEmpty())
                                            <tr>
                                                <td colspan="{{ 1 + count($departments) }}" class="text-center py-8 text-blue-300 italic">
                                                    No member or family name matches your search.
                                                </td>
                                            </tr>
                                        @endif

                                        @foreach ($this->filteredMembers as $member)
                                            <tr class="hover:bg-white/5">
                                                <td class="p-4 font-semibold text-white sticky left-0 bg-white/5 z-10" style="min-width: 250px;">{{ $member->full_name }}</td>
                                                @foreach ($departments as $dept)
                                                    <td class="p-4 text-center" style="min-width: 120px;">
                                                        <input type="checkbox"
                                                               wire:model.defer="restrictions.{{ $member->id }}.{{ $dept->id }}"
                                                               class="w-4 h-4 text-red-600 rounded border-gray-300 focus:ring-red-500">
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                @endif

                <div class="mt-6 flex flex-col sm:flex-row justify-between gap-3">
                    <button wire:click="closeLimitModal"
                            class="px-6 py-3 glass-card bg-white/10 text-blue-200 rounded-xl hover:bg-white/20 transition font-semibold">
                        Close
                    </button>
                    <div class="flex flex-col sm:flex-row gap-3">
                        @if ($activeTab === 'limit')
                            <button wire:click="saveLimits"
                                    class="px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl hover:from-green-700 hover:to-green-800 transition font-semibold shadow-lg">
                                Save Limits
                            </button>
                        @endif
                        @if ($activeTab === 'restriction')
                            <button wire:click="saveRestrictions"
                                    class="px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-xl hover:from-red-700 hover:to-red-800 transition font-semibold shadow-lg">
                                Save Restrictions
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif --}}

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
        function familyManager() {
            return {
                // Time and date
                currentTime: '',
                currentDate: '',
                
                // Modal states (synced with Livewire)
                showAddModal: @entangle('showAddModal'),
                showMemberModal: @entangle('showMemberModal'),
                showEditModal: @entangle('editModal'),
                showDeleteModal: @entangle('deleteModal'),
                showMemberDeleteModal: false,
                showLimitModal: @entangle('showLimitModal'),
                
                // Toast notifications
                showToast: false,
                toastMessage: '',
                toastType: 'success',
                
                // Member deletion tracking
                memberDeleteIndex: null,
                memberToDeleteName: '',

                init() {
                    this.updateTime();
                    setInterval(() => {
                        this.updateTime();
                    }, 1000);

                    // Listen for Livewire events
                    this.$wire.on('familySaved', () => {
                        this.showToastNotification('Family saved successfully!', 'success');
                    });

                    this.$wire.on('familyDeleted', () => {
                        this.showToastNotification('Family deleted successfully!', 'success');
                    });

                    this.$wire.on('memberRemoved', () => {
                        this.showToastNotification('Member removed successfully!', 'success');
                    });

                    this.$wire.on('limitsSaved', () => {
                        this.showToastNotification('Limits saved successfully!', 'success');
                    });

                    this.$wire.on('restrictionsSaved', () => {
                        this.showToastNotification('Restrictions saved successfully!', 'success');
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

                confirmRemoveMember(index, memberName) {
                    this.memberDeleteIndex = index;
                    this.memberToDeleteName = memberName;
                    this.showMemberDeleteModal = true;
                },

                removeMemberConfirmed() {
                    if (this.memberDeleteIndex !== null) {
                        this.$wire.call('removeMemberConfirmed', this.memberDeleteIndex);
                        this.showMemberDeleteModal = false;
                        this.memberDeleteIndex = null;
                        this.memberToDeleteName = '';
                    }
                }
            }
        }
    </script>
</div>