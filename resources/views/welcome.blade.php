<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CREDiT System | CPAC</title>
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

        /* Mobile optimizations */
        @media (max-width: 640px) {
            .bg-overlay {
                background-attachment: scroll;
            }
        }
    </style>
</head>
<body class="bg-overlay min-h-screen flex flex-col text-white font-sans antialiased">

    {{-- Top Navigation --}}
    <nav class="px-4 py-4 sm:px-6 sm:py-5 lg:px-12">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 sm:gap-0">
            <div class="text-center sm:text-left">
                <h1 class="text-4xl sm:text-5xl lg:text-7xl font-bold tracking-tight">
                    <span class="text-yellow-400">CREDiT</span>
                </h1>
                <p class="text-blue-200 text-sm sm:text-base lg:text-lg font-medium mt-1">Charging Records & Entry System</p>
            </div>
            <div class="flex items-center space-x-3 sm:space-x-6">
                <a href="{{ route('login') }}" 
                   class="bg-white/10 hover:bg-white/30 backdrop-blur-md border border-white/20 px-4 sm:px-6 py-2 sm:py-3 rounded-full font-bold text-sm sm:text-base lg:text-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-blue-900">
                    Login
                </a>
                <a href="{{ route('register') }}" 
                   class="bg-yellow-400 hover:bg-yellow-300 text-blue-900 px-4 sm:px-6 py-2 sm:py-3 rounded-full font-bold text-sm sm:text-base lg:text-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-blue-900">
                    Register
                </a>
            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    <main class="flex-grow flex flex-col lg:flex-row justify-center items-center px-4 sm:px-6 lg:px-20 py-6 sm:py-8 gap-8 sm:gap-10 lg:gap-20">
        {{-- Left Section: Logo + Quote --}}
        <div class="text-center lg:text-left max-w-lg lg:max-w-2xl flex flex-col items-center lg:items-start w-full">
            
            <blockquote class="mb-6 sm:mb-8">
                <p class="italic text-xl sm:text-2xl lg:text-3xl xl:text-4xl text-blue-100 leading-tight font-medium px-2 sm:px-0">
                    "In the world, but not of the world."
                </p>
                <footer class="mt-3 sm:mt-4 text-blue-200 text-right text-sm sm:text-base lg:text-lg px-2 sm:px-0">
                    — Central Philippine Adventist College
                </footer>
            </blockquote>
            
            <div class="hidden lg:block mt-8 lg:mt-12 w-full">
                <div class="flex items-center space-x-4 bg-white/10 backdrop-blur-sm p-5 rounded-xl border border-white/10">
                    <div class="text-yellow-400 flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <p class="text-lg text-blue-100">
                        Fast, reliable, and accountable transaction system for CPAC departments
                    </p>
                </div>
            </div>
        </div>

        {{-- Right Section: Welcome Card --}}
        <div class="bg-white/10 backdrop-blur-md border border-white/20 p-6 sm:p-8 lg:p-10 rounded-2xl sm:rounded-3xl shadow-2xl max-w-xl w-full transition-all duration-300 hover:shadow-blue-900/40">
            <div class="mb-6 sm:mb-8">
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold mb-3 sm:mb-4 text-yellow-300">Welcome to CREDiT</h2>
                <div class="w-16 sm:w-20 h-1 sm:h-1.5 bg-yellow-400 rounded-full mb-4 sm:mb-6"></div>
                <p class="text-blue-100 leading-relaxed text-sm sm:text-base lg:text-lg">
                    This innovative platform streamlines departmental charge entries across CPAC. Designed for both frontdesk staff and administrators, CREDiT provides a transparent and efficient system for all transactions with RFID technology.
                </p>
            </div>

            <div class="space-y-3 sm:space-y-4 lg:space-y-5 mb-8 sm:mb-10">
                <div class="flex items-start space-x-3 sm:space-x-4">
                    <div class="text-yellow-400 mt-0.5 sm:mt-1 flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <p class="text-sm sm:text-base lg:text-lg text-blue-100">RFID-powered digital charging system</p>
                </div>
                <div class="flex items-start space-x-3 sm:space-x-4">
                    <div class="text-yellow-400 mt-0.5 sm:mt-1 flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <p class="text-sm sm:text-base lg:text-lg text-blue-100">Real-time transaction tracking and reporting</p>
                </div>
                <div class="flex items-start space-x-3 sm:space-x-4">
                    <div class="text-yellow-400 mt-0.5 sm:mt-1 flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <p class="text-sm sm:text-base lg:text-lg text-blue-100">Secure and fully accountable system</p>
                </div>
            </div>

            {{-- Manager info --}}
            <div class="mt-8 sm:mt-10 pt-6 sm:pt-8 border-t border-white/20 flex items-center gap-3 sm:gap-4 lg:gap-5">
                <img src="{{ asset('images/meme.png') }}" 
                     alt="CPAC Logo" 
                     class="w-12 h-12 sm:w-14 sm:h-14 rounded-full border-2 border-yellow-400 object-cover flex-shrink-0">
                <div>
                    <p class="font-semibold text-base sm:text-lg lg:text-xl">Lowell Rich Bernardino</p>
                    <p class="text-blue-200 text-sm sm:text-base lg:text-lg">CREDiT System Developer</p>
                </div>
            </div>
        </div>
    </main>

    {{-- Footer --}}
    <footer class="text-center py-6 sm:py-8 text-blue-300 text-sm sm:text-base lg:text-lg px-4">
        <p class="italic">Empowering departments through digital stewardship</p>
        <p class="mt-2 font-bold">CREDiT @ Central Philippine Adventist College</p>
    </footer>

</body>
</html>