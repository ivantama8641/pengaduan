<x-main-layout>
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="glass-dark p-10 rounded-3xl w-full max-w-md border border-white/10 shadow-2xl">
            <h1 class="text-3xl font-bold text-center text-white mb-8">Login Admin/Guru</h1>
            
            <form method="POST" action="{{ route('login.post') }}" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Email</label>
                    <input type="email" name="email" required autofocus class="w-full bg-gray-800/50 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-red-500 transition" value="{{ old('email') }}">
                    @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Password</label>
                    <input type="password" name="password" required class="w-full bg-gray-800/50 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-red-500 transition">
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center">
                        <input type="checkbox" class="rounded border-gray-700 bg-gray-800 text-red-600 focus:ring-red-500">
                        <span class="ml-2 text-sm text-gray-400">Ingat saya</span>
                    </label>
                </div>

                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-xl transition transform hover:scale-[1.02] shadow-lg shadow-red-600/20">
                    Masuk
                </button>
            </form>
        </div>
    </div>
</x-main-layout>
