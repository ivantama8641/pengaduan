<x-layouts.main>
    <div class="pt-24 pb-12 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 min-h-screen">
        <a href="{{ url()->previous() }}" class="inline-flex items-center text-gray-400 hover:text-white mb-6 transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Kembali
        </a>

        <div class="glass-dark rounded-3xl overflow-hidden border border-white/10 shadow-2xl">
            <!-- Header -->
            <div class="p-8 border-b border-gray-700 bg-gray-800/30">
                <div class="flex justify-between items-start">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <span class="px-3 py-1 bg-gray-700 rounded text-xs font-bold text-gray-300">{{ $complaint->category->name }}</span>
                            <span class="text-sm text-gray-500">{{ $complaint->created_at->format('d M Y, H:i') }}</span>
                        </div>
                        <h1 class="text-3xl font-bold text-white mb-2">{{ $complaint->title }}</h1>
                        <div class="flex items-center gap-2">
                            <span class="text-gray-400 text-sm">Tiket:</span>
                            <span class="font-mono text-red-500 font-bold">{{ $complaint->ticket_id }}</span>
                        </div>
                    </div>
                    <div class="text-right">
                         <span class="px-4 py-2 rounded-full text-sm font-bold block mb-2 text-center
                            {{ $complaint->status == 'pending' ? 'bg-yellow-500/20 text-yellow-500' : '' }}
                            {{ $complaint->status == 'process' ? 'bg-blue-500/20 text-blue-500' : '' }}
                            {{ $complaint->status == 'done' ? 'bg-green-500/20 text-green-500' : '' }}
                            {{ $complaint->status == 'rejected' ? 'bg-red-500/20 text-red-500' : '' }}
                        ">
                            {{ strtoupper($complaint->status) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Body -->
            <div class="p-8">
                <!-- User Info -->
                <div class="flex items-center gap-4 mb-8 bg-gray-800/40 p-4 rounded-xl">
                    <div class="w-12 h-12 bg-gray-700 rounded-full flex items-center justify-center text-xl">👤</div>
                    <div>
                        <div class="font-bold text-white">
                            {{ $complaint->is_anonymous ? 'Anonim' : $complaint->student_name }}
                        </div>
                        <div class="text-sm text-gray-400">
                            {{ $complaint->is_anonymous ? 'Rahasia' : $complaint->student_class }}
                        </div>
                    </div>
                </div>

                <div class="prose prose-invert max-w-none text-gray-300 mb-8">
                    {!! nl2br(e($complaint->body)) !!}
                </div>

                @if($complaint->image)
                    <div class="mb-8">
                        <label class="block text-sm font-bold text-gray-500 mb-2">Bukti Lampiran:</label>
                        <img src="{{ asset('storage/' . $complaint->image) }}" alt="Bukti" class="rounded-xl border border-gray-700 max-h-96 object-cover">
                    </div>
                @endif
            </div>

            <!-- Admin Actions -->
            @auth
            <div class="p-8 border-t border-gray-700 bg-red-900/10">
                <h3 class="text-lg font-bold text-white mb-4">Tindakan Admin</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Update Status -->
                    <div>
                        <form action="{{ route('complaints.status', $complaint->ticket_id) }}" method="POST" class="bg-gray-800/50 p-6 rounded-xl">
                            @csrf
                            <label class="block text-sm font-bold text-gray-400 mb-3">Update Status</label>
                            <div class="flex gap-2">
                                <select name="status" class="flex-1 bg-gray-900 border border-gray-700 rounded-lg px-3 py-2 text-white">
                                    <option value="pending" {{ $complaint->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="process" {{ $complaint->status == 'process' ? 'selected' : '' }}>Diproses</option>
                                    <option value="done" {{ $complaint->status == 'done' ? 'selected' : '' }}>Selesai</option>
                                    <option value="rejected" {{ $complaint->status == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-bold text-sm">Update</button>
                            </div>
                        </form>
                    </div>

                    <!-- Reply -->
                    <div>
                        <form action="{{ route('complaints.reply', $complaint->ticket_id) }}" method="POST" class="bg-gray-800/50 p-6 rounded-xl">
                            @csrf
                            <label class="block text-sm font-bold text-gray-400 mb-3">Beri Tanggapan</label>
                            <textarea name="body" rows="3" class="w-full bg-gray-900 border border-gray-700 rounded-lg px-3 py-2 text-white text-sm mb-3" placeholder="Tulis balasan..."></textarea>
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white w-full py-2 rounded-lg font-bold text-sm">Kirim Tanggapan</button>
                        </form>
                    </div>
                </div>
            </div>
            @endauth

            <!-- Responses List (Public) -->
            <div class="p-8 border-t border-gray-700 bg-gray-900/50">
                <h3 class="text-lg font-bold text-white mb-6">Riwayat Tanggapan</h3>
                
                @forelse($complaint->responses as $response)
                    <div class="flex gap-4 mb-6">
                        <div class="w-10 h-10 rounded-full bg-red-600 flex items-center justify-center text-white font-bold text-sm shrink-0">
                            A
                        </div>
                        <div class="flex-1">
                            <div class="bg-gray-800 rounded-2xl rounded-tl-none p-4 border border-gray-700">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-bold text-red-400">{{ $response->user->name }}</span>
                                    <span class="text-xs text-gray-500">{{ $response->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-gray-300 text-sm">{{ $response->body }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-sm italic">Belum ada tanggapan.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-layouts.main>
