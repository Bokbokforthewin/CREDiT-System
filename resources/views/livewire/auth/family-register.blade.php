<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Family Register | CREDiT @ CPAC</title>
    <link rel="icon" href="{{ asset('images/cpac logo.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .bg-overlay {
            background-image: url("{{ asset('images/bg_cpac.png') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%23bfdbfe' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.75rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            background-color: rgba(255, 255, 255, 0.1) !important;
        }

        select option {
            background-color: rgb(12, 46, 96);
            color: white;
        }
    </style>
</head>

<body class="bg-overlay min-h-screen flex flex-col text-white font-sans antialiased">

    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="w-full max-w-xl">
            {{-- Logo --}}
            <div class="text-center mb-4">
                <img src="{{ asset('images/cpac_logo_with_name.png') }}" 
                     alt="Central Philippine Adventist College Logo" 
                     class="w-48 mx-auto mb-2">
                <h1 class="text-3xl font-bold text-yellow-400">CREDiT</h1>
                <p class="text-blue-200 text-sm">Departmental Charging System</p>
            </div>

            {{-- Card --}}
            <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-xl shadow-xl overflow-hidden p-6 py-8">
                <h2 class="text-2xl font-bold text-center mb-2 text-yellow-400">CPAC Employee Registration</h2>

                <!-- Success/Error Message Display -->
                @if (session()->has('success'))
                    <div class="bg-green-500/20 border border-green-500/30 text-green-300 px-4 py-3 rounded-lg mb-4 flex items-center"
                        role="alert">
                        <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="block sm:inline text-sm">{{ session('success') }}</span>
                    </div>
                @endif

                <form wire:submit.prevent="register">
                    <!-- User Account Details Section -->
                    <div class="mb-6 pb-6 border-b border-white/20">
                        <h3 class="text-lg font-bold text-yellow-300 mb-4 flex items-center">
                            <div class="w-8 h-8 bg-yellow-400/20 rounded-lg flex items-center justify-center mr-2">
                                <span class="text-yellow-400 font-bold">1</span>
                            </div>
                            User Account Details (The Head)
                        </h3>

                        <!-- Name -->
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-blue-100 mb-1">Full Name</label>
                            <input type="text" 
                                   id="name" 
                                   wire:model.defer="name"
                                   class="w-full bg-white/10 border border-white/20 rounded-lg py-2 px-3 text-sm text-white placeholder-blue-300 focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400/50 focus:bg-white/20 transition">
                            @error('name')
                                <div class="flex items-center mt-1">
                                    <svg class="w-4 h-4 text-red-400 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p class="text-red-400 text-xs">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-blue-100 mb-1">Email Address</label>
                            <input type="email" 
                                   id="email" 
                                   wire:model.defer="email"
                                   class="w-full bg-white/10 border border-white/20 rounded-lg py-2 px-3 text-sm text-white placeholder-blue-300 focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400/50 focus:bg-white/20 transition">
                            @error('email')
                                <div class="flex items-center mt-1">
                                    <svg class="w-4 h-4 text-red-400 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p class="text-red-400 text-xs">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-4">
                            <label for="password" class="block text-sm font-medium text-blue-100 mb-1">Password</label>
                            <input type="password" 
                                   id="password" 
                                   wire:model.defer="password"
                                   class="w-full bg-white/10 border border-white/20 rounded-lg py-2 px-3 text-sm text-white placeholder-blue-300 focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400/50 focus:bg-white/20 transition"
                                   placeholder="********">
                            @error('password')
                                <div class="flex items-center mt-1">
                                    <svg class="w-4 h-4 text-red-400 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p class="text-red-400 text-xs">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>

                        <!-- Password Confirmation -->
                        <div class="mb-4">
                            <label for="password_confirmation" class="block text-sm font-medium text-blue-100 mb-1">Confirm Password</label>
                            <input type="password" 
                                   id="password_confirmation" 
                                   wire:model.defer="password_confirmation"
                                   class="w-full bg-white/10 border border-white/20 rounded-lg py-2 px-3 text-sm text-white placeholder-blue-300 focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400/50 focus:bg-white/20 transition"
                                   placeholder="********">
                        </div>
                    </div>

                    <!-- Family Details Section -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-yellow-300 mb-4 flex items-center">
                            <div class="w-8 h-8 bg-yellow-400/20 rounded-lg flex items-center justify-center mr-2">
                                <span class="text-yellow-400 font-bold">2</span>
                            </div>
                            Family Unit Details
                        </h3>

                        <!-- Family Name -->
                        <div class="mb-4">
                            <label for="family_name" class="block text-sm font-medium text-blue-100 mb-1">Family Name</label>
                            <input type="text" 
                                   id="family_name" 
                                   wire:model.defer="family_name"
                                   class="w-full bg-white/10 border border-white/20 rounded-lg py-2 px-3 text-sm text-white placeholder-blue-300 focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400/50 focus:bg-white/20 transition">
                            @error('family_name')
                                <div class="flex items-center mt-1">
                                    <svg class="w-4 h-4 text-red-400 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p class="text-red-400 text-xs">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>

                        <!-- Account Code -->
                        <div class="mb-4">
                            <label for="account_code" class="block text-sm font-medium text-blue-100 mb-1">Unique Account Code</label>
                            <input type="text" 
                                   id="account_code" 
                                   wire:model.defer="account_code"
                                   class="w-full bg-white/10 border border-white/20 rounded-lg py-2 px-3 text-sm text-white placeholder-blue-300 focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400/50 focus:bg-white/20 transition">
                            @error('account_code')
                                <div class="flex items-center mt-1">
                                    <svg class="w-4 h-4 text-red-400 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p class="text-red-400 text-xs">{{ $message }}</p>
                                </div>
                            @enderror
                            <p class="text-xs text-blue-300 mt-1 flex items-start">
                                <svg class="w-3 h-3 mr-1 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                This code must be unique and is used for internal tracking.
                            </p>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <button type="submit"
                                class="w-full bg-yellow-400 hover:bg-yellow-300 text-blue-900 py-2.5 px-4 rounded-lg font-semibold text-sm transition-colors focus:outline-none focus:ring-1 focus:ring-yellow-400 focus:ring-offset-1 focus:ring-offset-blue-900/50 flex items-center justify-center"
                                wire:loading.attr="disabled" 
                                wire:target="register">
                            <span wire:loading.remove wire:target="register" class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                </svg>
                                Register Account & Family
                            </span>
                            <span wire:loading wire:target="register" class="flex items-center">
                                <svg class="animate-spin h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Registering... Please Wait
                            </span>
                        </button>
                    </div>

                    <div class="mt-4 pt-3 border-t border-white/20 text-center text-xs text-blue-200">
                        <p>Already Registered? <a href="{{ route('login') }}" class="text-yellow-300 hover:underline">Sign in</a></p>
                    </div>

                </form>
            </div>

            <div class="mt-4 text-center text-medium font-light text-blue-300">
                <p>CREDiT @ Central Philippine Adventist College</p>
            </div>
        </div>
    </div>

</body>

</html>