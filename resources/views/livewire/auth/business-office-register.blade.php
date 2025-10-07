<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business Office Registration | CREDiT @ CPAC</title>
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
    </style>
</head>
<body class="bg-overlay min-h-screen flex flex-col text-white font-sans antialiased">

    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="w-full max-w-md">
            {{-- Logo --}}
            <div class="text-center mb-6">
                <img src="{{ asset('images/cpac_logo_with_name.png') }}" 
                     alt="Central Philippine Adventist College Logo" 
                     class="w-48 mx-auto mb-4">
                <h1 class="text-3xl font-bold text-yellow-400">CREDiT</h1>
                <p class="text-blue-200 text-lg">Business Office Registration</p>
            </div>

            {{-- Card --}}
            <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-xl shadow-xl overflow-hidden p-6">
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
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                            <option value="">Select Staff Type</option>
                            <option value="limits">Limits Staff (Bookkeeper/ Accountant)</option>
                            <option value="reports">Reports Staff</option>
                        </select>
                        @error('business_role') <span class="text-red-500 text-xs">Already has an account</span> @enderror
                    </div>

                    <div class="flex items-center justify-between pt-4">
                        <a href="{{ route('login') }}" 
                           class="text-blue-200 hover:text-yellow-300 text-sm font-medium transition-colors">
                            Already registered?
                        </a>

                        <button type="submit" 
                                class="bg-yellow-400 hover:bg-yellow-300 text-blue-900 px-6 py-2 rounded-lg font-semibold transition-colors flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd" />
                                <path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z" />
                            </svg>
                            Register (Business Office)
                        </button>
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