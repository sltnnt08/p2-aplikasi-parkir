@extends('layouts.app')

@section('title', 'Petugas Dashboard')

@section('content')
<div class="space-y-8">
    <!-- Editorial Header -->
    <div class="flex items-end justify-between">
        <div>
            <h1 class="text-4xl font-black text-gray-900 mb-2">Manajemen Transaksi Parkir</h1>
            <p class="text-gray-600">Kelola kendaraan masuk dan keluar, serta proses transaksi parkir.</p>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Kendaraan Masuk Hari Ini -->
        <div class="bg-white rounded-2xl p-8 shadow-[0px_12px_32px_0px_rgba(30,41,59,0.04)] border border-[rgba(194,198,214,0.1)]">
            <div class="flex items-start justify-between mb-6">
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Kendaraan Parkir Hari Ini</p>
                </div>
                <div class="p-2 bg-[rgba(0,88,190,0.1)] rounded-lg">
                    <svg class="w-5 h-5 text-[#0058be]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
            </div>
            <p class="text-5xl font-black text-gray-900">{{ $todayParked ?? 0 }}</p>
        </div>

        <!-- Kendaraan Aktif -->
        <div class="bg-white rounded-2xl p-8 shadow-[0px_12px_32px_0px_rgba(30,41,59,0.04)] border border-[rgba(194,198,214,0.1)]">
            <div class="flex items-start justify-between mb-6">
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Slot Tersedia</p>
                </div>
                <div class="p-2 bg-[rgba(16,185,129,0.1)] rounded-lg">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <p class="text-5xl font-black text-gray-900">245</p>
        </div>
    </div>

    <!-- Transaction Management -->
    <div>
        <h2 class="text-xl font-bold text-gray-900 mb-4">Operasional Parkir</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Kendaraan Masuk -->
            <a href="{{ route('petugas.transaksi.masuk') }}" class="group p-8 bg-white rounded-2xl shadow-[0px_12px_32px_0px_rgba(30,41,59,0.04)] border border-[rgba(194,198,214,0.1)] hover:shadow-[0px_12px_32px_0px_rgba(16,185,129,0.1)] hover:border-emerald-300 transition-all transform hover:scale-105 active:scale-95">
                <div class="flex items-start justify-between mb-4">
                    <div class="p-4 bg-emerald-50 rounded-xl group-hover:bg-emerald-100 transition-colors">
                        <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Kendaraan Masuk</h3>
                <p class="text-gray-600 mb-4">Daftarkan kendaraan yang masuk ke area parkir</p>
                <div class="flex items-center text-emerald-600 font-semibold">
                    <span>Mulai Scanning</span>
                    <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                </div>
            </a>

            <!-- Kendaraan Keluar -->
            <a href="{{ route('petugas.transaksi.keluar') }}" class="group p-8 bg-white rounded-2xl shadow-[0px_12px_32px_0px_rgba(30,41,59,0.04)] border border-[rgba(194,198,214,0.1)] hover:shadow-[0px_12px_32px_0px_rgba(239,68,68,0.1)] hover:border-red-300 transition-all transform hover:scale-105 active:scale-95">
                <div class="flex items-start justify-between mb-4">
                    <div class="p-4 bg-red-50 rounded-xl group-hover:bg-red-100 transition-colors">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m7-7H5"></path></svg>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Kendaraan Keluar</h3>
                <p class="text-gray-600 mb-4">Proses pembayaran dan pengeluaran kendaraan</p>
                <div class="flex items-center text-red-600 font-semibold">
                    <span>Lanjutkan Proses</span>
                    <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                </div>
            </a>
        </div>
    </div>

    <!-- Quick Guide -->
    <div class="bg-gradient-to-r from-[#0058be]/5 to-[#2170e4]/5 border border-[#0058be]/20 rounded-2xl p-6">
        <div class="flex items-start gap-4">
            <svg class="w-6 h-6 text-[#0058be] flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zm-11-1a1 1 0 11-2 0 1 1 0 012 0zm3 0a1 1 0 11-2 0 1 1 0 012 0zm3 0a1 1 0 11-2 0 1 1 0 012 0z" clip-rule="evenodd"></path></svg>
            <div>
                <h3 class="font-semibold text-gray-900 mb-1">Panduan Singkat</h3>
                <p class="text-sm text-gray-600">
                    Gunakan barcode scanner untuk mempercepat proses. Pastikan setiap kendaraan terekam dengan benar untuk transaksi yang akurat.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
