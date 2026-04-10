<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Parkirin')</title>
    <link rel="icon" type="image/svg+xml" href="/storage/parkirin_logo_transparent.svg">
    @vite('resources/css/app.css')
    <script src="https://code.iconify.design/iconify-icon/1.0.8/iconify-icon.min.js"></script>
</head>
<body class="bg-[#f7f9fc] text-[#191c1e]">
    @php
        $currentUser = Auth::user();
        $currentRole = $currentUser?->role;
        $notifications = [];

        foreach (['success', 'error', 'warning', 'info'] as $type) {
            $message = session($type);

            if (is_string($message) && $message !== '') {
                $notifications[] = [
                    'type' => $type,
                    'message' => $message,
                ];
            }
        }

        if ($errors->any()) {
            foreach (array_unique($errors->all()) as $errorMessage) {
                $notifications[] = [
                    'type' => 'error',
                    'message' => $errorMessage,
                ];
            }
        }

        $notifications = collect($notifications)
            ->unique(fn (array $notification): string => $notification['type'].'|'.$notification['message'])
            ->values()
            ->all();
    @endphp

    <div id="notification-box" class="pointer-events-none fixed inset-x-0 top-4 z-50 flex flex-col items-center gap-2 px-3"></div>

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
                        {{-- disini nanti bakal ada search bar, tapi belum di dev --}}
                    </div>

                    <!-- Right Section -->
                    <div class="flex items-center gap-4 ml-4">
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
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <script>
        (function () {
            const notificationBox = document.getElementById('notification-box');

            if (!notificationBox) {
                return;
            }

            const initialNotifications = @json($notifications);

            const variants = {
                info: {
                    classes: 'bg-[#0058be] border-[#1d4ed8] text-white',
                    icon: '<svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                },
                error: {
                    classes: 'bg-[#dc2626] border-[#ef4444] text-white',
                    icon: '<svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                },
                warning: {
                    classes: 'bg-[#f59e0b] border-[#fbbf24] text-[#1f2937]',
                    icon: '<svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>',
                },
                success: {
                    classes: 'bg-[#059669] border-[#10b981] text-white',
                    icon: '<svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                },
            };

            function escapeHtml(text) {
                return text
                    .replaceAll('&', '&amp;')
                    .replaceAll('<', '&lt;')
                    .replaceAll('>', '&gt;')
                    .replaceAll('"', '&quot;')
                    .replaceAll("'", '&#039;');
            }

            function sendNotification(type, message) {
                const variant = variants[type] ?? variants.info;
                const component = document.createElement('div');

                component.className = `pointer-events-auto flex w-full max-w-md items-start gap-3 rounded-xl border px-4 py-3 text-sm font-semibold shadow-[0px_14px_30px_rgba(15,23,42,0.18)] opacity-0 translate-y-2 transition-all duration-300 ${variant.classes}`;
                component.innerHTML = `${variant.icon}<p class="leading-relaxed">${escapeHtml(message)}</p>`;
                notificationBox.appendChild(component);

                requestAnimationFrame(() => {
                    component.classList.remove('opacity-0', 'translate-y-2');
                });

                setTimeout(() => {
                    component.classList.add('opacity-0', '-translate-y-2');
                    component.addEventListener('transitionend', () => component.remove(), { once: true });
                }, 4500);
            }

            window.sendNotification = sendNotification;

            initialNotifications.forEach(({ type, message }) => {
                if (typeof message === 'string' && message.trim() !== '') {
                    sendNotification(type, message);
                }
            });
        })();
    </script>

    @vite('resources/js/app.js')
</body>
</html>
