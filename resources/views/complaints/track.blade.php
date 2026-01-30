<x-main-layout>
    <div class="pt-32 pb-20 min-h-screen">
        <div class="max-w-3xl mx-auto px-6">
            <h1 class="text-4xl font-bold text-center mb-10">Cek Status Laporan</h1>
            
            <div class="glass p-8 rounded-3xl mb-10">
                <form action="{{ route('complaints.track') }}" method="GET" class="flex gap-4">
                    <input type="text" name="ticket_id" placeholder="Masukkan ID Tiket (Contoh: T-2024...)" class="flex-1 bg-gray-800/50 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-red-500 transition" value="{{ request('ticket_id') }}">
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-8 py-3 rounded-xl font-bold transition">
                        Cari
                    </button>
                </form>
            </div>

            @if(session('error'))
                <div class="bg-red-500/10 border border-red-500/50 text-red-500 p-4 rounded-xl text-center mb-10">
                    {{ session('error') }}
                </div>
            @endif

            @if(isset($complaint))
                <div class="glass-dark p-8 rounded-3xl border border-white/5 animate-fade-in-up">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <div class="text-sm text-gray-400 mb-1">Tiket ID</div>
                            <div class="text-2xl font-mono font-bold">{{ $complaint->ticket_id }}</div>
                        </div>
                        <div class="px-4 py-2 rounded-full text-sm font-bold 
                            {{ $complaint->status == 'pending' ? 'bg-yellow-500/20 text-yellow-500' : '' }}
                            {{ $complaint->status == 'process' ? 'bg-blue-500/20 text-blue-500' : '' }}
                            {{ $complaint->status == 'done' ? 'bg-green-500/20 text-green-500' : '' }}
                            {{ $complaint->status == 'rejected' ? 'bg-red-500/20 text-red-500' : '' }}
                        ">
                            {{ strtoupper($complaint->status) }}
                        </div>
                    </div>

                    <h2 class="text-2xl font-bold mb-4">{{ $complaint->title }}</h2>
                    <p class="text-gray-300 mb-6 whitespace-pre-line">{{ $complaint->body }}</p>

                    @if($complaint->responses->count() > 0)
                        <div class="mt-8 pt-8 border-t border-gray-700">
                            <h3 class="text-lg font-bold mb-4">Tanggapan Admin/Guru</h3>
                            @foreach($complaint->responses as $response)
                                <div class="bg-gray-800/50 p-4 rounded-xl mb-4">
                                    <div class="flex items-center gap-2 mb-2">
                                        <div class="font-bold text-red-400">{{ $response->user->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $response->created_at->diffForHumans() }}</div>
                                    </div>
                                    <p class="text-gray-300">{{ $response->body }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="mt-8 pt-8 border-t border-gray-700 text-center text-gray-500 italic">
                            Belum ada tanggapan. Mohon menunggu.
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</x-main-layout>
