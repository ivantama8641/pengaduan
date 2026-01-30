<nav class="fixed w-full z-50 transition-all duration-300 backdrop-blur-md bg-gray-900/60 border-b border-white/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <div class="flex items-center gap-3">
                <!-- Logo Placeholer -->
                <div class="w-10 h-10 bg-red-600 rounded-lg flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-red-600/30">
                    T
                </div>
                <span class="font-bold text-xl tracking-tight">Suara<span class="text-red-500">Telkom</span></span>
            </div>
            
            <div class="hidden md:block">
                <div class="ml-10 flex items-baseline space-x-8">
                    <a href="{{ route('home') }}" class="hover:text-red-400 transition px-3 py-2 rounded-md font-medium">Beranda</a>
                    <a href="{{ route('complaints.track') }}" class="hover:text-red-400 transition px-3 py-2 rounded-md font-medium">Cari Tiket</a>
                    <a href="#faq" class="hover:text-red-400 transition px-3 py-2 rounded-md font-medium">FAQ</a>
                </div>
            </div>
            
            <div>
                @auth
                    <a href="{{ url('/dashboard') }}" class="bg-red-600 hover:bg-red-700 text-white px-5 py-2.5 rounded-full font-medium transition shadow-lg shadow-red-600/30">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-gray-300 hover:text-white px-3 py-2 rounded-md font-medium mr-2">
                        Masuk
                    </a>
                    <a href="#form-section" class="bg-white text-gray-900 hover:bg-gray-100 px-5 py-2.5 rounded-full font-medium transition shadow-lg shadow-white/10">
                        Lapor!
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>
