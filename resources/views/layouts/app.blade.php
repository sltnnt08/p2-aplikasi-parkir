<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Urban Mobility Suite')</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-[#f7f9fc] text-[#191c1e]">
    <div class="flex min-h-screen">
        <!-- Sidebar Navigation -->
        <aside class="fixed left-0 top-0 h-screen w-60 bg-[#1E293B] shadow-[0px_12px_32px_0px_rgba(30,41,59,0.06)] z-40">
            <div class="flex flex-col h-full p-6">
                <!-- Brand Logo -->
                <div class="mb-10 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-[#3b82f6] to-[#2170e4] flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <h1 class="text-xl font-bold text-white tracking-tight">Urban Mobility</h1>
                </div>

                <!-- Navigation Items -->
                <nav class="flex-1 space-y-1">
                    <!-- Dashboard - Visible for all roles -->
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-[#94a3b8] hover:text-white hover:bg-[rgba(255,255,255,0.1)] transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-[rgba(59,130,246,0.2)] text-white border-r-4 border-[#3b82f6]' : '' }}">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9m-9 11l4-2m-9-2l4 2m0-5L9 7m4 6l4-2m4 5V7m0 0L12 3m0 0L3 9"></path></svg>
                            <span class="font-medium">Dashboard</span>
                        </a>
                    @elseif(Auth::user()->role === 'petugas')
                        <a href="{{ route('petugas.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-[#94a3b8] hover:text-white hover:bg-[rgba(255,255,255,0.1)] transition-colors {{ request()->routeIs('petugas.dashboard') ? 'bg-[rgba(59,130,246,0.2)] text-white border-r-4 border-[#3b82f6]' : '' }}">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9m-9 11l4-2m-9-2l4 2m0-5L9 7m4 6l4-2m4 5V7m0 0L12 3m0 0L3 9"></path></svg>
                            <span class="font-medium">Dashboard</span>
                        </a>
                    @elseif(Auth::user()->role === 'owner')
                        <a href="{{ route('owner.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-[#94a3b8] hover:text-white hover:bg-[rgba(255,255,255,0.1)] transition-colors {{ request()->routeIs('owner.dashboard') ? 'bg-[rgba(59,130,246,0.2)] text-white border-r-4 border-[#3b82f6]' : '' }}">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9m-9 11l4-2m-9-2l4 2m0-5L9 7m4 6l4-2m4 5V7m0 0L12 3m0 0L3 9"></path></svg>
                            <span class="font-medium">Dashboard</span>
                        </a>
                    @endif

                    <!-- Admin Menus - Only for admin role -->
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.users') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-[#94a3b8] hover:text-white hover:bg-[rgba(255,255,255,0.1)] transition-colors {{ request()->routeIs('admin.users*') ? 'bg-[rgba(59,130,246,0.2)] text-white border-r-4 border-[#3b82f6]' : '' }}">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 12H9m6 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="font-medium">Manajemen User</span>
                        </a>

                        <a href="{{ route('admin.tarifs') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-[#94a3b8] hover:text-white hover:bg-[rgba(255,255,255,0.1)] transition-colors {{ request()->routeIs('admin.tarifs*') ? 'bg-[rgba(59,130,246,0.2)] text-white border-r-4 border-[#3b82f6]' : '' }}">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="font-medium">Tarif</span>
                        </a>

                        <a href="{{ route('admin.areas') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-[#94a3b8] hover:text-white hover:bg-[rgba(255,255,255,0.1)] transition-colors {{ request()->routeIs('admin.areas*') ? 'bg-[rgba(59,130,246,0.2)] text-white border-r-4 border-[#3b82f6]' : '' }}">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span class="font-medium">Area</span>
                        </a>

                        <a href="{{ route('admin.kendaraans') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-[#94a3b8] hover:text-white hover:bg-[rgba(255,255,255,0.1)] transition-colors {{ request()->routeIs('admin.kendaraans*') ? 'bg-[rgba(59,130,246,0.2)] text-white border-r-4 border-[#3b82f6]' : '' }}">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            <span class="font-medium">Kendaraan</span>
                        </a>

                        <a href="{{ route('admin.logs') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-[#94a3b8] hover:text-white hover:bg-[rgba(255,255,255,0.1)] transition-colors {{ request()->routeIs('admin.logs*') ? 'bg-[rgba(59,130,246,0.2)] text-white border-r-4 border-[#3b82f6]' : '' }}">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <span class="font-medium">Laporan</span>
                        </a>
                    @endif

                    <!-- Transaksi - For admin and petugas -->
                    @if(Auth::user()->role === 'admin' || Auth::user()->role === 'petugas')
                        <a href="{{ route('petugas.transaksi.masuk') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-[#94a3b8] hover:text-white hover:bg-[rgba(255,255,255,0.1)] transition-colors {{ request()->routeIs('petugas.transaksi*') ? 'bg-[rgba(59,130,246,0.2)] text-white border-r-4 border-[#3b82f6]' : '' }}">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="font-medium">Transaksi</span>
                        </a>
                    @endif

                    <!-- Rekap Transaksi - Only for owner -->
                    @if(Auth::user()->role === 'owner')
                        <a href="{{ route('owner.rekap') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-[#94a3b8] hover:text-white hover:bg-[rgba(255,255,255,0.1)] transition-colors {{ request()->routeIs('owner.rekap*') ? 'bg-[rgba(59,130,246,0.2)] text-white border-r-4 border-[#3b82f6]' : '' }}">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <span class="font-medium">Rekap Transaksi</span>
                        </a>
                    @endif
                </nav>

                <!-- User Profile Section -->
                <div class="border-t border-[#0f172a] pt-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-bold text-sm">
                            {{ strtoupper(substr(Auth::user()->nama_lengkap, 0, 1)) }}
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-white truncate">{{ Auth::user()->nama_lengkap }}</p>
                            <p class="text-xs text-[#64748b] truncate capitalize">{{ Auth::user()->role }}</p>
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
                            <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                    </div>

                    <!-- Right Section -->
                    <div class="flex items-center gap-4 ml-4">
                        <button class="p-2 hover:bg-[#f2f4f7] rounded-full transition-colors">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        </button>
                        <button class="p-2 hover:bg-[#f2f4f7] rounded-full transition-colors">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </button>

                        <div class="w-px h-8 bg-[rgba(194,198,214,0.3)]"></div>

                        <div class="text-right">
                            <p class="text-sm font-semibold text-gray-900">Urban Mobility Suite</p>
                        </div>

                        <!-- Logout Button -->
                        <form method="POST" action="{{ route('logout') }}" class="ml-4">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-red-500/10 text-red-600 hover:bg-red-500/20 rounded-lg text-sm font-medium transition-colors">
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
