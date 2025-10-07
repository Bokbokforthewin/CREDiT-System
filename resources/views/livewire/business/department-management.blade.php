<div class="min-h-screen bg-overlay py-4 sm:py-6 lg:py-8 px-3 sm:px-4 lg:px-8" 
     x-data="departmentManager()" 
     x-init="init()">

    <!-- Header Section -->
    <div class="max-w-7xl mx-auto mb-6 sm:mb-8">
        <div class="glass-card rounded-2xl sm:rounded-3xl p-4 sm:p-6 lg:p-8 hover-lift slide-in">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 sm:gap-6">
                <div class="flex items-center space-x-3 sm:space-x-6 w-full sm:w-auto">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-xl sm:rounded-2xl flex items-center justify-center shadow-xl flex-shrink-0">
                        <svg class="w-8 h-8 sm:w-10 sm:h-10 text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m0 0h4M9 7h6m-6 4h6m-2 8h.01"></path>
                        </svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-white mb-1 sm:mb-2 leading-tight">
                            <span class="text-yellow-400">Department</span> Management
                        </h1>
                        <p class="text-blue-200 text-base sm:text-lg">Manage departments and organizational structure</p>
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
            <div class="flex flex-col sm:flex-row gap-3">
            <a href="{{ route('business.dashboard') }}" 
               class="glass-card hover-lift rounded-xl px-4 sm:px-6 py-3 sm:py-4 text-white flex items-center justify space-x-3 transition-all duration-300 group w-full sm:w-auto">
                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </div>
                <span class="font-semibold text-base sm:text-lg">Back to Dashboard</span>
            </a>
            <button wire:click="openAddDepartmentModal"
                        @click="showAddModal = true"
                        class="glass-card hover-lift rounded-xl px-4 sm:px-6 py-3 sm:py-4 text-white flex items-center justify space-x-3 transition-all duration-300 group w-full sm:w-auto">
                    <div class="w-8 h-8 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </div>
                    <span class="font-semibold text-base sm:text-lg">Add Department</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
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

    <!-- Department List -->
    <div class="max-w-7xl mx-auto">
        <div class="glass-card rounded-2xl sm:rounded-3xl overflow-hidden hover-lift">
            <div class="p-4 sm:p-6 lg:p-8 border-b border-white/20">
                <h3 class="text-xl sm:text-2xl font-bold text-white flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                    </div>
                    Department Directory
                </h3>
            </div>

            <div class="p-4 sm:p-6 lg:p-8">
                @if($departments->isEmpty())
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 text-blue-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m0 0h4M9 7h6m-6 4h6m-2 8h.01"></path>
                        </svg>
                        <p class="text-blue-200 text-lg font-medium mb-2">No departments found</p>
                        <p class="text-blue-300 text-sm">Create your first department to get started</p>
                    </div>
                @else
                    <!-- Mobile Card View -->
                    <div class="block sm:hidden space-y-4">
                        @foreach($departments as $department)
                            <div class="glass-card rounded-xl p-4 hover-lift">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                                            <span class="text-white font-bold text-sm">{{ $department->id }}</span>
                                        </div>
                                        <div>
                                            <h4 class="text-white font-semibold text-base">{{ $department->name }}</h4>
                                            <p class="text-blue-200 text-xs">Department ID: {{ $department->id }}</p>
                                        </div>
                                    </div>
                                    <div class="flex space-x-2">
                                        <button wire:click="editDepartment({{ $department->id }})"
                                                @click="showAddModal = true"
                                                class="p-2 bg-indigo-600/20 text-indigo-400 rounded-lg hover:bg-indigo-600/30 transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </button>
                                        <button wire:click="confirmDelete({{ $department->id }})"
                                                @click="showDeleteModal = true"
                                                class="p-2 bg-red-600/20 text-red-400 rounded-lg hover:bg-red-600/30 transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Desktop Table View -->
                    <div class="hidden sm:block overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-white/5">
                                <tr>
                                    <th class="px-6 py-4 text-blue-200 uppercase text-xs font-semibold tracking-wider">ID</th>
                                    <th class="px-6 py-4 text-blue-200 uppercase text-xs font-semibold tracking-wider">Department Name</th>
                                    <th class="px-6 py-4 text-blue-200 uppercase text-xs font-semibold tracking-wider text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/10">
                                @foreach($departments as $department)
                                    <tr class="hover:bg-white/5 transition-colors duration-200">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center mr-3">
                                                    <span class="text-white font-bold text-sm">{{ $department->id }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-white font-medium text-base">{{ $department->name }}</td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex items-center justify-end space-x-2">
                                                <button wire:click="editDepartment({{ $department->id }})"
                                                        @click="showAddModal = true"
                                                        class="px-4 py-2 bg-indigo-800/40 text-indigo-400 rounded-lg hover:bg-indigo-600 transition font-medium">
                                                    Edit
                                                </button>
                                                <button wire:click="confirmDelete({{ $department->id }})"
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
                @endif
            </div>
        </div>
    </div>

    <!-- Add/Edit Department Modal -->
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m0 0h4M9 7h6m-6 4h6m-2 8h.01"></path>
                    </svg>
                </div>
                <h2 class="text-xl sm:text-2xl font-bold text-white">
                    {{ $editingDepartmentId ? 'Edit Department' : 'Add New Department' }}
                </h2>
            </div>

            <div class="mb-6">
                <label for="departmentName" class="block text-sm font-semibold text-blue-200 mb-3">Department Name</label>
                <input type="text"
                       id="departmentName"
                       wire:model.defer="{{ $editingDepartmentId ? 'editingDepartmentName' : 'newDepartmentName' }}"
                       class="w-full glass-input rounded-xl px-4 py-3 text-white placeholder-blue-200 focus:outline-none text-base"
                       placeholder="Enter department name...">
                @error('newDepartmentName')
                    <div class="flex items-center mt-2">
                        <svg class="w-4 h-4 text-red-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-red-400 text-sm">{{ $message }}</span>
                    </div>
                @enderror
                @error('editingDepartmentName')
                    <div class="flex items-center mt-2">
                        <svg class="w-4 h-4 text-red-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-red-400 text-sm">{{ $message }}</span>
                    </div>
                @enderror
            </div>

            <div class="flex flex-col-reverse sm:flex-row justify-end gap-3">
                <button @click="showAddModal = false; $wire.resetModalState()" 
                        class="w-full sm:w-auto px-6 py-3 glass-card bg-white/10 text-blue-200 rounded-xl hover:bg-white/20 transition font-semibold">
                    Cancel
                </button>
                <button wire:click="{{ $editingDepartmentId ? 'updateDepartment' : 'saveDepartment' }}"
                        @click="handleSave()"
                        class="w-full sm:w-auto px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl hover:from-green-700 hover:to-green-800 transition font-semibold shadow-lg">
                    {{ $editingDepartmentId ? 'Update' : 'Save' }}
                </button>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div x-show="showDeleteModal"
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
                <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.728-.833-2.498 0L3.316 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <h2 class="text-lg sm:text-xl font-bold text-white">Confirm Deletion</h2>
            </div>
            
            <p class="text-blue-200 mb-6 text-base leading-relaxed">Are you sure you want to delete this department? This action cannot be undone and may affect related data.</p>
            
            <div class="flex flex-col-reverse sm:flex-row justify-end gap-3">
                <button @click="showDeleteModal = false; $wire.cancelDelete()"
                        class="w-full sm:w-auto px-6 py-3 glass-card bg-white/10 text-blue-200 rounded-xl hover:bg-white/20 transition font-semibold">
                    Cancel
                </button>
                <button wire:click="deleteDepartment"
                        @click="handleDelete()"
                        class="w-full sm:w-auto px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-xl hover:from-red-700 hover:to-red-800 transition font-semibold shadow-lg">
                    Delete
                </button>
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
        function departmentManager() {
            return {
                // Time and date
                currentTime: '',
                currentDate: '',
                
                // Modal states
                showAddModal: @entangle('showAddDepartmentModal'),
                showDeleteModal: @entangle('showDeleteConfirmationModal'),
                
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
                    this.$wire.on('departmentSaved', () => {
                        this.showToast = false;
                        setTimeout(() => {
                            this.showToastNotification('Department saved successfully!', 'success');
                            this.showAddModal = false;
                        }, 100);
                    });

                    this.$wire.on('departmentDeleted', () => {
                        this.showToast = false;
                        setTimeout(() => {
                            this.showToastNotification('Department deleted successfully!', 'success');
                            this.showDeleteModal = false;
                        }, 100);
                    });

                    this.$wire.on('error', (message) => {
                        this.showToast = false;
                        setTimeout(() => {
                            this.showToastNotification(message, 'error');
                        }, 100);
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

                handleSave() {
                    // Add loading state or additional validation if needed
                    setTimeout(() => {
                        if (!this.showAddModal) {
                            this.showToastNotification('Department saved successfully!', 'success');
                        }
                    }, 500);
                },

                handleDelete() {
                    // Add loading state or additional validation if needed
                    setTimeout(() => {
                        if (!this.showDeleteModal) {
                            this.showToastNotification('Department deleted successfully!', 'success');
                        }
                    }, 500);
                }
            }
        }
    </script>
</div>