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
                    <svg class="w-5 h-5 text-[#0058be]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
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
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM9 19c-4.3 0-8-1.343-8-3s3.582-3 8-3 8 1.343 8 3-3.582 3-8 3z"></path></svg>
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
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
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
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 12H9m6 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-1">Manajemen User</h3>
                <p class="text-sm text-gray-600">Kelola akun pengguna dan hak akses</p>
            </a>

            <!-- Tariffs Management -->
            <a href="{{ route('admin.tarifs') }}" class="group p-6 bg-white rounded-2xl shadow-[0px_12px_32px_0px_rgba(30,41,59,0.04)] border border-[rgba(194,198,214,0.1)] hover:shadow-[0px_12px_32px_0px_rgba(0,88,190,0.1)] hover:border-[#0058be] transition-all transform hover:scale-105 active:scale-95">
                <div class="flex items-start justify-between mb-3">
                    <div class="p-3 bg-emerald-50 rounded-lg group-hover:bg-emerald-100 transition-colors">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-1">Manajemen Tarif</h3>
                <p class="text-sm text-gray-600">Atur harga dan paket parkir</p>
            </a>

            <!-- Areas Management -->
            <a href="{{ route('admin.areas') }}" class="group p-6 bg-white rounded-2xl shadow-[0px_12px_32px_0px_rgba(30,41,59,0.04)] border border-[rgba(194,198,214,0.1)] hover:shadow-[0px_12px_32px_0px_rgba(0,88,190,0.1)] hover:border-[#0058be] transition-all transform hover:scale-105 active:scale-95">
                <div class="flex items-start justify-between mb-3">
                    <div class="p-3 bg-purple-50 rounded-lg group-hover:bg-purple-100 transition-colors">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                    </div>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-1">Manajemen Area</h3>
                <p class="text-sm text-gray-600">Kelola lokasi dan kapasitas parkir</p>
            </a>

            <!-- Vehicles Management -->
            <a href="{{ route('admin.kendaraans') }}" class="group p-6 bg-white rounded-2xl shadow-[0px_12px_32px_0px_rgba(30,41,59,0.04)] border border-[rgba(194,198,214,0.1)] hover:shadow-[0px_12px_32px_0px_rgba(0,88,190,0.1)] hover:border-[#0058be] transition-all transform hover:scale-105 active:scale-95">
                <div class="flex items-start justify-between mb-3">
                    <div class="p-3 bg-amber-50 rounded-lg group-hover:bg-amber-100 transition-colors">
                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-1">Manajemen Kendaraan</h3>
                <p class="text-sm text-gray-600">Kelola tipe dan data kendaraan</p>
            </a>

            <!-- Transactions -->
            <a href="#" class="group p-6 bg-white rounded-2xl shadow-[0px_12px_32px_0px_rgba(30,41,59,0.04)] border border-[rgba(194,198,214,0.1)] hover:shadow-[0px_12px_32px_0px_rgba(0,88,190,0.1)] hover:border-[#0058be] transition-all transform hover:scale-105 active:scale-95">
                <div class="flex items-start justify-between mb-3">
                    <div class="p-3 bg-cyan-50 rounded-lg group-hover:bg-cyan-100 transition-colors">
                        <svg class="w-6 h-6 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-1">Transaksi Parkir</h3>
                <p class="text-sm text-gray-600">Monitor transaksi dan pembayaran</p>
            </a>

            <!-- Logs -->
            <a href="{{ route('admin.logs') }}" class="group p-6 bg-white rounded-2xl shadow-[0px_12px_32px_0px_rgba(30,41,59,0.04)] border border-[rgba(194,198,214,0.1)] hover:shadow-[0px_12px_32px_0px_rgba(0,88,190,0.1)] hover:border-[#0058be] transition-all transform hover:scale-105 active:scale-95">
                <div class="flex items-start justify-between mb-3">
                    <div class="p-3 bg-red-50 rounded-lg group-hover:bg-red-100 transition-colors">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-1">Log Aktivitas</h3>
                <p class="text-sm text-gray-600">Lihat riwayat akses dan perubahan</p>
            </a>
        </div>
    </div>
</div>
@endsection
