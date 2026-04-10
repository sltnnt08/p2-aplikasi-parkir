<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Urban Mobility Suite</title>
    @vite('resources/css/app.css')
</head>
<body class="min-h-screen flex items-center justify-center px-6 py-8 relative overflow-hidden" style="background: linear-gradient(90deg, rgb(247, 249, 252) 0%, rgb(247, 249, 252) 100%)">
    <!-- Decorative Background Elements -->
    <div class="absolute -top-32 -left-24 w-96 h-96 bg-[rgba(0,88,190,0.05)] rounded-full blur-3xl"></div>
    <div class="absolute -bottom-32 -right-24 w-96 h-96 bg-[rgba(213,224,248,0.2)] rounded-full blur-3xl"></div>

    <div class="relative z-10 w-full max-w-md">
        <!-- Brand Header -->
        <div class="text-center mb-12">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-gradient-to-br from-[#0058be] to-[#2170e4] text-white font-bold text-lg mb-4 shadow-[0px_10px_15px_-3px_rgba(0,88,190,0.2)]">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </div>
            <h1 class="text-2xl font-black text-gray-900 tracking-tight">Urban Mobility Suite</h1>
        </div>

        <!-- Login Card -->
        <div class="bg-white rounded-3xl shadow-[0px_12px_32px_0px_rgba(30,41,59,0.06)] border border-[rgba(194,198,214,0.15)] p-12 space-y-8">
            <!-- Header -->
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-3">Selamat Datang</h2>
                <p class="text-gray-600 text-sm leading-relaxed">Silakan masukkan kredensial administrator Anda untuk mengakses panel manajemen parkir.</p>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Username Field -->
                <div>
                    <label for="username" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Username</label>
                    <div class="relative">
                        <svg class="absolute left-4 top-3.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 01-5 0V12m0 0v-1.5a2.5 2.5 0 015 0v1.5m0 0v1.5a2.5 2.5 0 01-5 0v-1.5"></path></svg>
                        <input
                            type="text"
                            id="username"
                            name="username"
                            value="{{ old('username') }}"
                            placeholder="Contoh: admin_urban"
                            class="w-full pl-12 pr-4 py-3 rounded-xl bg-[#e6e8eb] border-0 text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#0058be] transition-all"
                            required
                        >
                    </div>
                    @error('username')
                        <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label for="password" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Password</label>
                        <a href="#" class="text-xs font-bold text-[#0058be] hover:text-[#0052a3] transition-colors">Lupa Password?</a>
                    </div>
                    <div class="relative">
                        <svg class="absolute left-4 top-3.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="••••••••"
                            class="w-full pl-12 pr-12 py-3 rounded-xl bg-[#e6e8eb] border-0 text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#0058be] transition-all"
                            required
                        >
                        <button type="button" class="absolute right-4 top-3.5 text-gray-400 hover:text-gray-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-4.803m5.596-3.856a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0z"></path></svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Error Message -->
                @if($errors->any() && !$errors->has('username') && !$errors->has('password'))
                    <div class="p-4 bg-[rgba(255,218,214,0.4)] border border-[rgba(186,26,26,0.1)] rounded-xl flex gap-3">
                        <svg class="w-5 h-5 text-[#93000a] flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                        <div class="text-sm text-[#93000a]">
                            @foreach($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Submit Button -->
                <button
                    type="submit"
                    class="w-full py-3.5 bg-gradient-to-r from-[#0058be] to-[#2170e4] text-white font-bold rounded-xl hover:shadow-[0px_10px_15px_-3px_rgba(0,88,190,0.2)] transition-all transform hover:scale-105 active:scale-95 flex items-center justify-center gap-2 shadow-[0px_10px_15px_-3px_rgba(0,88,190,0.2)]"
                >
                    <span>Masuk</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                </button>
            </form>

            <!-- Footer -->
            <div class="border-t border-[rgba(194,198,214,0.1)] pt-6">
                <div class="text-center">
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Urban Mobility Suite v4.2.0 • © 2024 Systems Inc
                    </p>
                </div>
            </div>
        </div>

        <!-- System Status -->
        <div class="mt-8 flex items-center justify-center gap-8 text-xs font-bold uppercase tracking-wider opacity-60">
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                <span class="text-gray-700">Server Aktif</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                <span class="text-gray-700">Database Aman</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                <span class="text-gray-700">Sesi Terenkripsi</span>
            </div>
        </div>
    </div>
</body>
</html>
