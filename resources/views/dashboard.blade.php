<x-main-layout>
    <div class="pt-24 pb-12 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto min-h-screen">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-white">Dashboard Admin</h1>
            <div class="flex items-center gap-4">
                <span class="text-gray-400">Halo, {{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-red-600/20 hover:bg-red-600 text-red-500 hover:text-white px-4 py-2 rounded-lg transition text-sm font-bold border border-red-600/50">
                        Keluar
                    </button>
                </form>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
            <div class="glass p-6 rounded-2xl">
                <div class="text-gray-400 text-sm">Total Laporan</div>
                <div class="text-3xl font-bold text-white">{{ $stats['total'] }}</div>
            </div>
            <div class="glass p-6 rounded-2xl border-l-4 border-yellow-500">
                <div class="text-gray-400 text-sm">Menunggu</div>
                <div class="text-3xl font-bold text-yellow-500">{{ $stats['pending'] }}</div>
            </div>
            <div class="glass p-6 rounded-2xl border-l-4 border-blue-500">
                <div class="text-gray-400 text-sm">Diproses</div>
                <div class="text-3xl font-bold text-blue-500">{{ $stats['process'] }}</div>
            </div>
            <div class="glass p-6 rounded-2xl border-l-4 border-green-500">
                <div class="text-gray-400 text-sm">Selesai</div>
                <div class="text-3xl font-bold text-green-500">{{ $stats['done'] }}</div>
            </div>
        </div>

        <!-- Complaints Table -->
        <div class="glass-dark rounded-3xl overflow-hidden border border-white/5">
            <div class="p-6 border-b border-gray-700">
                <h2 class="text-xl font-bold text-white">Daftar Laporan Masuk</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-gray-300">
                    <thead class="bg-gray-800/50 text-xs uppercase text-gray-400">
                        <tr>
                            <th class="px-6 py-4">Tiket & Tanggal</th>
                            <th class="px-6 py-4">Pelapor</th>
                            <th class="px-6 py-4">Masalah</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        @foreach($complaints as $c)
                        <tr class="hover:bg-white/5 transition">
                            <td class="px-6 py-4">
                                <div class="font-mono font-bold text-white">{{ $c->ticket_id }}</div>
                                <div class="text-xs text-gray-500">{{ $c->created_at->format('d M Y') }}</div>
                            </td>
                            <td class="px-6 py-4">
                                @if($c->is_anonymous)
                                    <span class="px-2 py-1 bg-gray-700 rounded text-xs text-gray-300">Anonim</span>
                                @else
                                    <div class="font-bold text-white">{{ $c->student_name }}</div>
                                    <div class="text-xs text-gray-500">{{ $c->student_class }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-white truncate w-48">{{ $c->title }}</div>
                                <div class="text-xs text-gray-400">{{ $c->category->name }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-bold
                                    {{ $c->status == 'pending' ? 'bg-yellow-500/20 text-yellow-500' : '' }}
                                    {{ $c->status == 'process' ? 'bg-blue-500/20 text-blue-500' : '' }}
                                    {{ $c->status == 'done' ? 'bg-green-500/20 text-green-500' : '' }}
                                    {{ $c->status == 'rejected' ? 'bg-red-500/20 text-red-500' : '' }}
                                ">
                                    {{ strtoupper($c->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('complaints.show', $c->ticket_id) }}" class="text-blue-400 hover:text-blue-300 text-sm font-bold">Lihat</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-6">
                {{ $complaints->links() }}
            </div>
        </div>
    </div>
</x-main-layout>
