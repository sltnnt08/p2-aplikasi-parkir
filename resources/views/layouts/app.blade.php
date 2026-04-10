<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Parkirin')</title>
    @vite('resources/css/app.css')
    <script src="https://code.iconify.design/iconify-icon/1.0.8/iconify-icon.min.js"></script>
</head>
<body class="bg-[#f7f9fc] text-[#191c1e]">
    @php
        $currentUser = Auth::user();
        $currentRole = $currentUser?->role;
    @endphp

    <div class="flex min-h-screen">
        <!-- Sidebar Navigation -->
        <aside class="fixed left-0 top-0 h-screen w-60 bg-[#1E293B] shadow-[0px_12px_32px_0px_rgba(30,41,59,0.06)] z-40">
            <div class="flex flex-col h-full p-6">
                <!-- Brand Logo -->
                <div class="mb-10 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center shrink-0">
                        <img src="/storage/parkirin_logo_transparent.svg" alt="Parkirin" class="w-full h-full object-contain">
                    </div>
                    <h1 class="text-xl font-bold text-white tracking-tight">Parkirin</h1>
                </div>

                <!-- Navigation Items -->
                <nav class="flex-1 space-y-1">
                    @if($currentRole === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-[#94a3b8] hover:text-white hover:bg-[rgba(255,255,255,0.1)] transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-[rgba(59,130,246,0.2)] text-white border-r-4 border-[#3b82f6]' : '' }}">
                            <iconify-icon icon="mdi:home" style="font-size: 1.5rem;"></iconify-icon>
                            <span class="font-medium">Dashboard</span>
                        </a>

                        <a href="{{ route('admin.users') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-[#94a3b8] hover:text-white hover:bg-[rgba(255,255,255,0.1)] transition-colors {{ request()->routeIs('admin.users*') ? 'bg-[rgba(59,130,246,0.2)] text-white border-r-4 border-[#3b82f6]' : '' }}">
                            <iconify-icon icon="mdi:account-multiple" style="font-size: 1.5rem;"></iconify-icon>
                            <span class="font-medium">Manajemen User</span>
                        </a>

                        <a href="{{ route('admin.tarifs') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-[#94a3b8] hover:text-white hover:bg-[rgba(255,255,255,0.1)] transition-colors {{ request()->routeIs('admin.tarifs*') ? 'bg-[rgba(59,130,246,0.2)] text-white border-r-4 border-[#3b82f6]' : '' }}">
                            <iconify-icon icon="mdi:currency-usd" style="font-size: 1.5rem;"></iconify-icon>
                            <span class="font-medium">Tarif</span>
                        </a>

                        <a href="{{ route('admin.areas') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-[#94a3b8] hover:text-white hover:bg-[rgba(255,255,255,0.1)] transition-colors {{ request()->routeIs('admin.areas*') ? 'bg-[rgba(59,130,246,0.2)] text-white border-r-4 border-[#3b82f6]' : '' }}">
                            <iconify-icon icon="mdi:map-marker" style="font-size: 1.5rem;"></iconify-icon>
                            <span class="font-medium">Area</span>
                        </a>

                        <a href="{{ route('admin.kendaraans') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-[#94a3b8] hover:text-white hover:bg-[rgba(255,255,255,0.1)] transition-colors {{ request()->routeIs('admin.kendaraans*') ? 'bg-[rgba(59,130,246,0.2)] text-white border-r-4 border-[#3b82f6]' : '' }}">
                            <iconify-icon icon="mdi:car" style="font-size: 1.5rem;"></iconify-icon>
                            <span class="font-medium">Kendaraan</span>
                        </a>

                        <a href="{{ route('admin.logs') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-[#94a3b8] hover:text-white hover:bg-[rgba(255,255,255,0.1)] transition-colors {{ request()->routeIs('admin.logs*') ? 'bg-[rgba(59,130,246,0.2)] text-white border-r-4 border-[#3b82f6]' : '' }}">
                            <iconify-icon icon="mdi:file-document" style="font-size: 1.5rem;"></iconify-icon>
                            <span class="font-medium">Log Aktivitas</span>
                        </a>
                    @elseif($currentRole === 'petugas')
                        <a href="{{ route('petugas.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-[#94a3b8] hover:text-white hover:bg-[rgba(255,255,255,0.1)] transition-colors {{ request()->routeIs('petugas.dashboard') ? 'bg-[rgba(59,130,246,0.2)] text-white border-r-4 border-[#3b82f6]' : '' }}">
                            <iconify-icon icon="mdi:home" style="font-size: 1.5rem;"></iconify-icon>
                            <span class="font-medium">Dashboard</span>
                        </a>

                        <a href="{{ route('petugas.transaksi.masuk') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-[#94a3b8] hover:text-white hover:bg-[rgba(255,255,255,0.1)] transition-colors {{ request()->routeIs('petugas.transaksi.masuk*') ? 'bg-[rgba(59,130,246,0.2)] text-white border-r-4 border-[#3b82f6]' : '' }}">
                            <iconify-icon icon="mdi:arrow-down-bold-circle" style="font-size: 1.5rem;"></iconify-icon>
                            <span class="font-medium">Kendaraan Masuk</span>
                        </a>

                        <a href="{{ route('petugas.transaksi.keluar') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-[#94a3b8] hover:text-white hover:bg-[rgba(255,255,255,0.1)] transition-colors {{ request()->routeIs('petugas.transaksi.keluar*') ? 'bg-[rgba(59,130,246,0.2)] text-white border-r-4 border-[#3b82f6]' : '' }}">
                            <iconify-icon icon="mdi:arrow-up-bold-circle" style="font-size: 1.5rem;"></iconify-icon>
                            <span class="font-medium">Kendaraan Keluar</span>
                        </a>
                    @elseif($currentRole === 'owner')
                        <a href="{{ route('owner.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-[#94a3b8] hover:text-white hover:bg-[rgba(255,255,255,0.1)] transition-colors {{ request()->routeIs('owner.dashboard') ? 'bg-[rgba(59,130,246,0.2)] text-white border-r-4 border-[#3b82f6]' : '' }}">
                            <iconify-icon icon="mdi:home" style="font-size: 1.5rem;"></iconify-icon>
                            <span class="font-medium">Dashboard</span>
                        </a>

                        <a href="{{ route('owner.rekap') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-[#94a3b8] hover:text-white hover:bg-[rgba(255,255,255,0.1)] transition-colors {{ request()->routeIs('owner.rekap*') ? 'bg-[rgba(59,130,246,0.2)] text-white border-r-4 border-[#3b82f6]' : '' }}">
                            <iconify-icon icon="mdi:file-document" style="font-size: 1.5rem;"></iconify-icon>
                            <span class="font-medium">Rekap Transaksi</span>
                        </a>
                    @endif
                </nav>

                <!-- User Profile Section -->
                <div class="border-t border-[#0f172a] pt-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-linear-to-br from-[#0058be] to-[#2170e4] flex items-center justify-center text-white font-bold text-sm">
                            {{ strtoupper(substr($currentUser->nama_lengkap, 0, 1)) }}
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-white truncate">{{ $currentUser->nama_lengkap }}</p>
                            <p class="text-xs text-[#64748b] truncate capitalize">{{ $currentUser->role }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="ml-60 flex flex-col flex-1">
            <!-- Top Navbar -->
            <header class="sticky top-0 z-30 backdrop-blur-[6px] bg-[rgba(255,255,255,0.7)] border-b border-[rgba(194,198,214,0.15)] px-8 py-4">
                <div class="flex items-center justify-between">
                    <!-- Search Bar -->
                    <div class="flex-1 max-w-md">
                        <div class="relative">
                            <input type="text" placeholder="Cari data..." class="w-full px-4 py-2 pl-10 rounded-lg bg-[#e6e8eb] text-sm focus:outline-none focus:ring-2 focus:ring-[#0058be] focus:ring-opacity-30">
                            <iconify-icon icon="mdi:magnify" class="absolute left-3 top-2.5 text-gray-400" style="font-size: 1.25rem;"></iconify-icon>
                        </div>
                    </div>

                    <!-- Right Section -->
                    <div class="flex items-center gap-4 ml-4">
                        <button class="p-2 hover:bg-[#f2f4f7] rounded-full transition-colors">
                            <iconify-icon icon="mdi:bell" class="text-gray-600" style="font-size: 1.5rem;"></iconify-icon>
                        </button>
                        <button class="p-2 hover:bg-[#f2f4f7] rounded-full transition-colors">
                            <iconify-icon icon="mdi:cog" class="text-gray-600" style="font-size: 1.5rem;"></iconify-icon>
                        </button>

                        <div class="w-px h-8 bg-[rgba(194,198,214,0.3)]"></div>

                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0">
                                <img src="/storage/parkirin_logo_transparent.svg" alt="Parkirin" class="w-full h-full object-contain">
                            </div>
                            <p class="text-sm font-semibold text-gray-900">Parkirin</p>
                        </div>

                        <!-- Logout Button -->
                        <form method="POST" action="{{ route('logout') }}" class="ml-4">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-red-500/10 text-red-600 hover:bg-red-500/20 rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
                                <iconify-icon icon="mdi:logout" style="font-size: 1rem;"></iconify-icon>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-auto">
                <div class="p-8">
                    <!-- Alert Messages -->
                    @if(session('success'))
                        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-lg text-emerald-700 text-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700 text-sm">
                            <ul class="space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    @vite('resources/js/app.js')
</body>
</html>
