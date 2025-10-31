<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | CREDiT @ CPAC</title>
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
            <div class="text-center mb-4">
                <img src="{{ asset('images/cpac_logo_with_name.png') }}" 
                     alt="Central Philippine Adventist College Logo" 
                     class="w-48 mx-auto mb-2">
                <h1 class="text-3xl font-bold text-yellow-400">CREDiT</h1>
                <p class="text-blue-200 text-sm">Departmental Charging System</p>
            </div>

            {{-- Card --}}
            <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-xl shadow-xl overflow-hidden p-6">
                <h2 class="text-xl font-bold text-center mb-4 text-yellow-400">Sign In</h2>
                
                <x-validation-errors class="mb-4 bg-red-500/20 border border-red-500/30 rounded-lg p-3 text-sm" />

                @session('status')
                    <div class="mb-4 bg-green-500/20 border border-green-500/30 rounded-lg p-3 text-sm text-green-100 text-center">
                        {{ $value }}
                    </div>
                @endsession

                <form method="POST" action="{{ route('login') }}" class="space-y-3">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-medium text-blue-100 mb-1">Email</label>
                        <input id="email" 
                               name="email" 
                               type="email" 
                               value="{{ old('email') }}"
                               required
                               autofocus
                               autocomplete="username"
                               class="w-full bg-white/10 border border-white/20 rounded-lg py-2 px-3 text-sm text-white placeholder-blue-300 focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400/50 focus:bg-white/20 transition">
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-blue-100 mb-1">Password</label>
                        <input id="password" 
                               name="password" 
                               type="password" 
                               required
                               autocomplete="current-password"
                               class="w-full bg-white/10 border border-white/20 rounded-lg py-2 px-3 text-sm text-white placeholder-blue-300 focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400/50 focus:bg-white/20 transition">
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            {{-- <input id="remember_me" 
                                   name="remember" 
                                   type="checkbox"
                                   class="h-3 w-3 text-yellow-400 focus:ring-yellow-400 border-white/30 rounded bg-white/10">
                            <label for="remember_me" class="ms-2 text-xs text-blue-100">Remember me</label> --}}
                        </div>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" 
                               class="text-xs text-blue-200 hover:text-yellow-300 transition-colors">
                                Forgot password?
                            </a>
                        @endif
                    </div>

                    <div class="pt-2">
                        <button type="submit" 
                                class="w-full bg-yellow-400 hover:bg-yellow-300 text-blue-900 py-2 px-4 rounded-lg font-semibold text-sm transition-colors focus:outline-none focus:ring-1 focus:ring-yellow-400 focus:ring-offset-1 focus:ring-offset-blue-900/50">
                            Log in
                        </button>
                    </div>
                </form>

                {{-- Footer --}}
                <div class="mt-4 pt-3 border-t border-white/20 text-center text-xs text-blue-200">
                    <p>Need an account? <a href="{{ route('family.register') }}" class="text-yellow-300 hover:underline">Register</a></p>
                </div>
            </div>

            {{-- Copyright --}}
            <footer class="mt-4 text-center text-medium font-light text-blue-300">
                <p>CREDiT @ Central Philippine Adventist College</p>
            </footer>
        </div>
    </div>

</body>
</html>