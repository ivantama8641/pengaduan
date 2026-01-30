<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pengaduan SMK Telkom Lampung</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .bg-grid {
            background-size: 40px 40px;
            background-image: linear-gradient(to right, rgba(255, 255, 255, 0.05) 1px, transparent 1px),
                              linear-gradient(to bottom, rgba(255, 255, 255, 0.05) 1px, transparent 1px);
        }
    </style>
</head>
<body class="antialiased bg-gray-900 text-white min-h-screen relative overflow-x-hidden selection:bg-red-500 selection:text-white">
    
    <!-- Background Elements -->
    <div class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
        <div class="absolute top-[-10%] right-[-5%] w-[500px] h-[500px] bg-red-600/20 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-[-10%] left-[-5%] w-[500px] h-[500px] bg-blue-600/10 rounded-full blur-[120px]"></div>
        <div class="absolute w-full h-full bg-grid"></div>
    </div>

    @include('layouts.navbar')

    <main class="w-full">
        {{ $slot }}
    </main>

    <footer class="py-6 text-center text-gray-500 text-sm glass-dark mt-20">
        &copy; {{ date('Y') }} SMK Telkom Lampung. All rights reserved.
    </footer>

    @livewireScripts
</body>
</html>
