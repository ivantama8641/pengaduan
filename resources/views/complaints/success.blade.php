<x-layouts.main>
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="glass-dark p-10 rounded-3xl text-center max-w-lg w-full border border-green-500/30 shadow-2xl shadow-green-900/20">
            <div class="w-20 h-20 bg-green-500/20 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            
            <h1 class="text-3xl font-bold text-white mb-2">Laporan Terkirim!</h1>
            <p class="text-gray-400 mb-8">Terima kasih telah melapor. Simpan ID tiket ini untuk memantau status laporan Anda.</p>
            
            <div class="bg-black/40 p-6 rounded-xl border border-gray-700 mb-8 relative group">
                <div class="text-sm text-gray-500 mb-1">Tiket ID Anda</div>
                <div class="text-3xl font-mono font-bold text-white tracking-wider select-all">{{ $complaint->ticket_id }}</div>
            </div>
            
            <div class="flex flex-col gap-3">
                <a href="{{ route('complaints.track', ['ticket_id' => $complaint->ticket_id]) }}" class="bg-red-600 hover:bg-red-700 text-white py-3 rounded-xl font-bold transition">
                    Lacak Status Sekarang
                </a>
                <a href="{{ route('home') }}" class="text-gray-400 hover:text-white py-2 transition">
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</x-layouts.main>
