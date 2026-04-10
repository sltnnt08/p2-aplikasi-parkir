@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="space-y-8">
    <!-- Editorial Header -->
    <div class="flex items-end justify-between">
        <div>
            <h1 class="text-4xl font-black text-gray-900 mb-2">Dashboard Admin</h1>
            <p class="text-gray-600">Selamat datang kembali. Kelola sistem manajemen parkir Parkirin dari sini.</p>
        </div>
        <a href="{{ route('admin.users') }}" class="px-6 py-3 bg-linear-to-r from-[#0058be] to-[#2170e4] text-white font-bold rounded-xl hover:shadow-lg transition-all transform hover:scale-105 active:scale-95">
            + Tambah Data
        </a>
    </div>

    <!-- Quick Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Total Users -->
        <div class="bg-white rounded-2xl p-6 shadow-[0px_12px_32px_0px_rgba(30,41,59,0.04)] border border-[rgba(194,198,214,0.1)]">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Total User</p>
                </div>
                <div class="p-2 bg-[rgba(0,88,190,0.1)] rounded-lg">
                    <iconify-icon icon="mdi:account" class="w-5 h-5 text-[#0058be]"></iconify-icon>
                </div>
            </div>
            <div class="space-y-3">
                <p class="text-5xl font-black text-gray-900">{{ $totalUsers ?? 0 }}</p>
                <p class="text-xs text-gray-500">Pengguna aktif sistem</p>
            </div>
        </div>

        <!-- Total Petugas -->
        <div class="bg-white rounded-2xl p-6 shadow-[0px_12px_32px_0px_rgba(30,41,59,0.04)] border border-[rgba(194,198,214,0.1)]">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Total Petugas</p>
                </div>
                <div class="p-2 bg-[rgba(16,185,129,0.1)] rounded-lg">
                    <iconify-icon icon="mdi:account-plus" class="w-5 h-5 text-emerald-600"></iconify-icon>
                </div>
            </div>
            <div class="space-y-3">
                <p class="text-5xl font-black text-gray-900">{{ $totalPetugas ?? 0 }}</p>
                <div>
                    <p class="text-xs text-gray-500">Petugas aktif terdaftar</p>
                </div>
            </div>
        </div>

        <!-- Total Owner -->
        <div class="bg-white rounded-2xl p-6 shadow-[0px_12px_32px_0px_rgba(30,41,59,0.04)] border border-[rgba(194,198,214,0.1)]">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Total Owner</p>
                </div>
                <div class="p-2 bg-[rgba(245,158,11,0.1)] rounded-lg">
                    <iconify-icon icon="mdi:office-building" class="w-5 h-5 text-amber-600"></iconify-icon>
                </div>
            </div>
            <div class="space-y-3">
                <p class="text-5xl font-black text-gray-900">{{ $totalOwner ?? 0 }}</p>
                <div>
                    <p class="text-xs text-gray-500">Akun owner aktif</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Management Cards -->
    <div>
        <h2 class="text-xl font-bold text-gray-900 mb-4">Menu Manajemen</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <!-- Users Management -->
            <a href="{{ route('admin.users') }}" class="group p-6 bg-white rounded-2xl shadow-[0px_12px_32px_0px_rgba(30,41,59,0.04)] border border-[rgba(194,198,214,0.1)] hover:shadow-[0px_12px_32px_0px_rgba(0,88,190,0.1)] hover:border-[#0058be] transition-all transform hover:scale-105 active:scale-95">
                <div class="flex items-start justify-between mb-3">
                    <div class="p-3 bg-blue-50 rounded-lg group-hover:bg-blue-100 transition-colors">
                        <iconify-icon icon="mdi:account-cog" class="w-6 h-6 text-blue-600"></iconify-icon>
                    </div>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-1">Manajemen User</h3>
                <p class="text-sm text-gray-600">Kelola akun pengguna dan hak akses</p>
            </a>

            <!-- Tariffs Management -->
            <a href="{{ route('admin.tarifs') }}" class="group p-6 bg-white rounded-2xl shadow-[0px_12px_32px_0px_rgba(30,41,59,0.04)] border border-[rgba(194,198,214,0.1)] hover:shadow-[0px_12px_32px_0px_rgba(0,88,190,0.1)] hover:border-[#0058be] transition-all transform hover:scale-105 active:scale-95">
                <div class="flex items-start justify-between mb-3">
                    <div class="p-3 bg-emerald-50 rounded-lg group-hover:bg-emerald-100 transition-colors">
                        <iconify-icon icon="mdi:cash-multiple" class="w-6 h-6 text-emerald-600"></iconify-icon>
                    </div>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-1">Manajemen Tarif</h3>
                <p class="text-sm text-gray-600">Atur harga dan paket parkir</p>
            </a>

            <!-- Areas Management -->
            <a href="{{ route('admin.areas') }}" class="group p-6 bg-white rounded-2xl shadow-[0px_12px_32px_0px_rgba(30,41,59,0.04)] border border-[rgba(194,198,214,0.1)] hover:shadow-[0px_12px_32px_0px_rgba(0,88,190,0.1)] hover:border-[#0058be] transition-all transform hover:scale-105 active:scale-95">
                <div class="flex items-start justify-between mb-3">
                    <div class="p-3 bg-purple-50 rounded-lg group-hover:bg-purple-100 transition-colors">
                        <iconify-icon icon="mdi:map-marker-radius" class="w-6 h-6 text-purple-600"></iconify-icon>
                    </div>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-1">Manajemen Area</h3>
                <p class="text-sm text-gray-600">Kelola lokasi dan kapasitas parkir</p>
            </a>

            <!-- Vehicles Management -->
            <a href="{{ route('admin.kendaraans') }}" class="group p-6 bg-white rounded-2xl shadow-[0px_12px_32px_0px_rgba(30,41,59,0.04)] border border-[rgba(194,198,214,0.1)] hover:shadow-[0px_12px_32px_0px_rgba(0,88,190,0.1)] hover:border-[#0058be] transition-all transform hover:scale-105 active:scale-95">
                <div class="flex items-start justify-between mb-3">
                    <div class="p-3 bg-amber-50 rounded-lg group-hover:bg-amber-100 transition-colors">
                        <iconify-icon icon="mdi:flash" class="w-6 h-6 text-amber-600"></iconify-icon>
                    </div>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-1">Manajemen Kendaraan</h3>
                <p class="text-sm text-gray-600">Kelola tipe dan data kendaraan</p>
            </a>

            <!-- Transactions -->
            <a href="#" class="group p-6 bg-white rounded-2xl shadow-[0px_12px_32px_0px_rgba(30,41,59,0.04)] border border-[rgba(194,198,214,0.1)] hover:shadow-[0px_12px_32px_0px_rgba(0,88,190,0.1)] hover:border-[#0058be] transition-all transform hover:scale-105 active:scale-95">
                <div class="flex items-start justify-between mb-3">
                    <div class="p-3 bg-cyan-50 rounded-lg group-hover:bg-cyan-100 transition-colors">
                        <iconify-icon icon="mdi:information-outline" class="w-6 h-6 text-cyan-600"></iconify-icon>
                    </div>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-1">Transaksi Parkir</h3>
                <p class="text-sm text-gray-600">Monitor transaksi dan pembayaran</p>
            </a>

            <!-- Logs -->
            <a href="{{ route('admin.logs') }}" class="group p-6 bg-white rounded-2xl shadow-[0px_12px_32px_0px_rgba(30,41,59,0.04)] border border-[rgba(194,198,214,0.1)] hover:shadow-[0px_12px_32px_0px_rgba(0,88,190,0.1)] hover:border-[#0058be] transition-all transform hover:scale-105 active:scale-95">
                <div class="flex items-start justify-between mb-3">
                    <div class="p-3 bg-red-50 rounded-lg group-hover:bg-red-100 transition-colors">
                        <iconify-icon icon="mdi:file-document-outline" class="w-6 h-6 text-red-600"></iconify-icon>
                    </div>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-1">Log Aktivitas</h3>
                <p class="text-sm text-gray-600">Lihat riwayat akses dan perubahan</p>
            </a>
        </div>
    </div>
</div>
@endsection
