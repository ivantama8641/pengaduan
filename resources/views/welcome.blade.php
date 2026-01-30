<x-layouts.main>
    <!-- Hero Section -->
    <div class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <h1 class="text-5xl md:text-7xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-white via-gray-200 to-gray-400 mb-6 drop-shadow-sm">
                Sampaikan Aspirasi Anda<br>Demi <span class="text-red-500">Kemajuan Sekolah</span>
            </h1>
            <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-400 mb-10">
                Layanan pengaduan siswa SMK Telkom Lampung. Aman, Rahasia, dan Transparan.
            </p>
            
            <div class="flex justify-center gap-6">
                <a href="#form-section" class="bg-red-600 hover:bg-red-700 text-white text-lg px-8 py-4 rounded-full font-semibold transition transform hover:scale-105 shadow-xl shadow-red-600/20">
                    Buat Pengaduan
                </a>
                <a href="{{ route('complaints.track') }}" class="glass hover:bg-white/10 text-white text-lg px-8 py-4 rounded-full font-semibold transition backdrop-blur-md">
                    Cek Status Tiket
                </a>
            </div>

            <!-- Stats -->
            <div class="mt-20 grid grid-cols-1 md:grid-cols-3 gap-8 max-w-4xl mx-auto">
                <div class="glass p-6 rounded-2xl text-center">
                    <div class="text-4xl font-bold text-white mb-2">{{ $counts['total'] }}</div>
                    <div class="text-gray-400 text-sm uppercase tracking-wider">Total Laporan</div>
                </div>
                <div class="glass p-6 rounded-2xl text-center">
                    <div class="text-4xl font-bold text-yellow-500 mb-2">{{ $counts['pending'] }}</div>
                    <div class="text-gray-400 text-sm uppercase tracking-wider">Sedang/Belum Diproses</div>
                </div>
                <div class="glass p-6 rounded-2xl text-center">
                    <div class="text-4xl font-bold text-green-500 mb-2">{{ $counts['done'] }}</div>
                    <div class="text-gray-400 text-sm uppercase tracking-wider">Selesai</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Section -->
    <div id="form-section" class="py-20 bg-black/20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="glass-dark rounded-3xl p-8 md:p-12 shadow-2xl border border-white/5 relative overflow-hidden">
                <!-- Decoration -->
                <div class="absolute top-0 right-0 w-64 h-64 bg-red-600/10 rounded-full blur-[80px] -translate-y-1/2 translate-x-1/2"></div>

                <h2 class="text-3xl font-bold text-white mb-8 text-center">Formulir Pengaduan</h2>
                
                <form action="{{ route('complaints.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Identity (Optional) -->
                        <div class="md:col-span-2">
                             <div class="flex items-center gap-4 mb-4">
                                <label class="text-sm text-gray-400">Identitas Pelapor:</label>
                                <div class="flex items-center gap-2">
                                    <input type="radio" name="is_anonymous" value="0" id="not_anon" checked class="text-red-600 focus:ring-red-600 bg-gray-700 border-gray-600">
                                    <label for="not_anon" class="text-white text-sm">Siswa (Tulis Nama)</label>
                                </div>
                                <div class="flex items-center gap-2">
                                    <input type="radio" name="is_anonymous" value="1" id="is_anon" class="text-red-600 focus:ring-red-600 bg-gray-700 border-gray-600">
                                    <label for="is_anon" class="text-white text-sm">Anonim (Rahasia)</label>
                                </div>
                             </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Nama Lengkap</label>
                            <input type="text" name="student_name" class="w-full bg-gray-800/50 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-red-500 transition placeholder-gray-600" placeholder="Contoh: Budi Santoso">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Kelas / Jurusan</label>
                            <input type="text" name="student_class" class="w-full bg-gray-800/50 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-red-500 transition placeholder-gray-600" placeholder="Contoh: XI RPL 2">
                        </div>
                        
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-400 mb-2">Email / No. HP (Untuk info status)</label>
                            <input type="text" name="guest_email" class="w-full bg-gray-800/50 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-red-500 transition placeholder-gray-600" placeholder="email@sekolah.id atau 0812...">
                        </div>
                    </div>

                    <div class="border-t border-gray-800 my-6"></div>

                    <!-- Complaint Details -->
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Kategori Laporan <span class="text-red-500">*</span></label>
                        <select name="category_id" class="w-full bg-gray-800/50 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-red-500 transition">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Judul Laporan <span class="text-red-500">*</span></label>
                        <input type="text" name="title" required class="w-full bg-gray-800/50 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-red-500 transition placeholder-gray-600" placeholder="Singkat dan jelas">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Isi Laporan <span class="text-red-500">*</span></label>
                        <textarea name="body" required rows="5" class="w-full bg-gray-800/50 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-red-500 transition placeholder-gray-600" placeholder="Jelaskan detail masalahnya..."></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Bukti Foto (Opsional)</label>
                        <div class="flex items-center justify-center w-full">
                            <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-700 border-dashed rounded-xl cursor-pointer bg-gray-800/30 hover:bg-gray-800/50 transition">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                    </svg>
                                    <p class="text-sm text-gray-500"><span class="font-semibold">Klik untuk upload</span> atau drag and drop</p>
                                    <p class="text-xs text-gray-500">SVG, PNG, JPG (MAX. 2MB)</p>
                                </div>
                                <input id="dropzone-file" type="file" name="image" class="hidden" />
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-4 rounded-xl shadow-lg shadow-red-600/30 transition transform hover:scale-[1.01]">
                        Kirim Laporan
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-layouts.main>
