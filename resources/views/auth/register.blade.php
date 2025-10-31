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
                <h2 class="text-xl font-bold text-center mb-4 text-yellow-400">CPAC Departments Registration</h2>
                
                <x-validation-errors class="mb-4 bg-red-500/20 border border-red-500/30 rounded-lg p-3 text-sm" />

                <form method="POST" action="{{ route('register') }}" class="space-y-3">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-medium text-blue-100 mb-1">Full Name</label>
                        <input id="name" 
                               name="name" 
                               type="text" 
                               value="{{ old('name') }}"
                               required
                               autofocus
                               autocomplete="name"
                               class="w-full bg-white/10 border border-white/20 rounded-lg py-2 px-3 text-sm text-white placeholder-blue-300 focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400/50 focus:bg-white/20 transition">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-blue-100 mb-1">Email</label>
                        <input id="email" 
                               name="email" 
                               type="email" 
                               value="{{ old('email') }}"
                               required
                               autocomplete="email"
                               class="w-full bg-white/10 border border-white/20 rounded-lg py-2 px-3 text-sm text-white placeholder-blue-300 focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400/50 focus:bg-white/20 transition">
                    </div>

                    <div>
                        <label for="department_id" class="block text-sm font-medium text-blue-100 mb-1">Department</label>
                        <select id="department_id" 
                                name="department_id" 
                                required
                                class="w-full bg-white/10 border border-white/20 rounded-lg py-2 px-3 text-sm text-white placeholder-blue-300 focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400/50 focus:bg-white/20 transition pr-8">
                            <option value="" class="text-blue-900">-- Select Department --</option>
                            @foreach(\App\Models\Department::all() as $department)
                                <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }} class="text-white">
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-blue-100 mb-1">Password</label>
                        <input id="password" 
                               name="password" 
                               type="password" 
                               required
                               autocomplete="new-password"
                               class="w-full bg-white/10 border border-white/20 rounded-lg py-2 px-3 text-sm text-white placeholder-blue-300 focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400/50 focus:bg-white/20 transition">
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-blue-100 mb-1">Confirm Password</label>
                        <input id="password_confirmation" 
                               name="password_confirmation" 
                               type="password" 
                               required
                               autocomplete="new-password"
                               class="w-full bg-white/10 border border-white/20 rounded-lg py-2 px-3 text-sm text-white placeholder-blue-300 focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400/50 focus:bg-white/20 transition">
                    </div>

                    @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                        <div class="mt-2">
                            <div class="flex items-start">
                                <div class="flex items-center h-4">
                                    <input id="terms" 
                                           name="terms" 
                                           type="checkbox"
                                           required
                                           class="h-3 w-3 text-yellow-400 focus:ring-yellow-400 border-white/30 rounded bg-white/10">
                                </div>
                                <div class="ms-2">
                                    <label for="terms" class="text-xs text-blue-100">
                                        {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                                'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="text-yellow-300 hover:underline">'.__('Terms').'</a>',
                                                'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="text-yellow-300 hover:underline">'.__('Policy').'</a>',
                                        ]) !!}
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="pt-2">
                        <button type="submit" 
                                class="w-full bg-yellow-400 hover:bg-yellow-300 text-blue-900 py-2 px-4 rounded-lg font-semibold text-sm transition-colors focus:outline-none focus:ring-1 focus:ring-yellow-400 focus:ring-offset-1 focus:ring-offset-blue-900/50">
                            Register
                        </button>
                    </div>
                </form>

                <div class="mt-4 pt-3 border-t border-white/20 text-center text-xs text-blue-200">
                    <p>Already registered? <a href="{{ route('login') }}" class="text-yellow-300 hover:underline">Sign in</a></p>
                </div>
            </div>

            <div class="mt-4 text-center text-medium font-light text-blue-300">
                <p>CREDiT @ Central Philippine Adventist College</p>
            </div>
        </div>
    </div>

</body>
</html>