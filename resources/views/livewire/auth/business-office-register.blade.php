<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | CREDiT @ CPAC</title>
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
        <div class="w-full max-w-md">
            {{-- Logo --}}
            <div class="text-center mb-4">
                <img src="{{ asset('images/cpac_logo_with_name.png') }}" 
                     alt="Central Philippine Adventist College Logo" 
                     class="w-48 mx-auto mb-2">
                <h1 class="text-3xl font-bold text-yellow-400">CREDiT</h1>
                <p class="text-blue-200 text-sm">Departmental Charging System</p>
            </div>

            {{-- Card --}}
            <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-xl shadow-xl overflow-hidden p-6">
                <h2 class="text-xl font-bold text-center mb-4 text-yellow-400">Register an Account</h2>
                @if(session('success'))
                    <div class="mb-6 bg-green-500/20 border border-green-500/30 rounded-lg p-4 text-green-100 text-center">
                        {{ session('success') }}
                    </div>
                @endif

                <x-validation-errors class="mb-6 bg-red-500/20 border border-red-500/30 rounded-lg p-4" />

                <form wire:submit.prevent="register" class="space-y-4">
                    <div>
                        <label for="name" class="block text-blue-100 font-medium mb-2">Full Name</label>
                        <input id="name" 
                               type="text" 
                               wire:model.defer="name"
                               required
                               autofocus
                               class="w-full bg-white/10 border border-white/20 rounded-lg py-2 px-3 text-white placeholder-blue-300 focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400/50 focus:bg-white/20 transition">
                    </div>

                    <div>
                        <label for="email" class="block text-blue-100 font-medium mb-2">Email Address</label>
                        <input id="email" 
                               type="email" 
                               wire:model.defer="email"
                               required
                               class="w-full bg-white/10 border border-white/20 rounded-lg py-2 px-3 text-white placeholder-blue-300 focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400/50 focus:bg-white/20 transition">
                    </div>

                    <div>
                        <label for="password" class="block text-blue-100 font-medium mb-2">Password</label>
                        <input id="password" 
                               type="password" 
                               wire:model.defer="password"
                               required
                               class="w-full bg-white/10 border border-white/20 rounded-lg py-2 px-3 text-white placeholder-blue-300 focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400/50 focus:bg-white/20 transition">
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-blue-100 font-medium mb-2">Confirm Password</label>
                        <input id="password_confirmation" 
                               type="password" 
                               wire:model.defer="password_confirmation"
                               required
                               class="w-full bg-white/10 border border-white/20 rounded-lg py-2 px-3 text-white placeholder-blue-300 focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400/50 focus:bg-white/20 transition">
                    </div>

                    <div class="mt-4">
                        <label for="business_role" class="block text-sm font-medium text-white mb-1">
                            Staff Type
                        </label>
                        <select
                            wire:model="business_role"
                            id="business_role"
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-sm border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                            <option value="">Select Staff Type</option>
                            <option value="limits">Limits Staff (Bookkeeper/ Accountant)</option>
                            <option value="reports">Reports Staff</option>
                        </select>
                        @error('business_role') <span class="text-red-500 text-xs">Already has an account</span> @enderror
                    </div>

                    <button type="submit" 
                                class="w-full bg-yellow-400 hover:bg-yellow-300 text-blue-900 px-6 py-2 rounded-lg font-semibold text-sm transition-colors flex items-center justify-flex justify-center gap-2">
                            Register (Business Office)
                        </button>

                    <div class="mt-4 pt-3 border-t border-white/20 text-center text-xs text-blue-200">
                        <p>Already registered?
                        <a href="{{ route('login') }}" 
                        class="text-yellow-300 hover:underline">Sign in</a>
                        </p>

                    </div>
                </form>
            </div>

            {{-- Footer --}}
            <div class="mt-6 text-center text-blue-300 text-sm">
                <p>CREDiT @ Central Philippine Adventist College</p>
            </div>
        </div>
    </div>

</body>
</html>