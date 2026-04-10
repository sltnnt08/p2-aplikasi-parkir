@extends('layouts.app')

@section('title', 'Owner Dashboard')

@section('content')
<div class="space-y-8">
    <!-- Editorial Header -->
    <div class="flex items-end justify-between">
        <div>
            <h1 class="text-4xl font-black text-gray-900 mb-2">Dashboard Pemilik</h1>
            <p class="text-gray-600">Pantau pendapatan parkir dan dapatkan insight bisnis Anda secara real-time.</p>
        </div>
    </div>

    <!-- Revenue Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Pendapatan Hari Ini -->
        <div class="bg-white rounded-2xl p-8 shadow-[0px_12px_32px_0px_rgba(30,41,59,0.04)] border border-[rgba(194,198,214,0.1)]">
            <div class="flex items-start justify-between mb-6">
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Pendapatan Hari Ini</p>
                </div>
                <div class="p-2 bg-[rgba(34,197,94,0.1)] rounded-lg">
                    <iconify-icon icon="mdi:cash" class="w-5 h-5 text-emerald-600"></iconify-icon>
                </div>
            </div>
            <div class="space-y-3">
                <p class="text-4xl font-black text-gray-900">Rp {{ number_format($todayIncome ?? 0, 0, ',', '.') }}</p>
                <p class="text-xs text-gray-500">dari {{ $todayTransactions ?? 0 }} transaksi</p>
            </div>
        </div>

        <!-- Pendapatan Bulan Ini -->
        <div class="bg-white rounded-2xl p-8 shadow-[0px_12px_32px_0px_rgba(30,41,59,0.04)] border border-[rgba(194,198,214,0.1)]">
            <div class="flex items-start justify-between mb-6">
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Pendapatan Bulan Ini</p>
                </div>
                <div class="p-2 bg-[rgba(0,88,190,0.1)] rounded-lg">
                    <iconify-icon icon="mdi:chart-bar" class="w-5 h-5 text-[#0058be]"></iconify-icon>
                </div>
            </div>
            <div class="space-y-3">
                <p class="text-4xl font-black text-gray-900">Rp {{ number_format($monthIncome ?? 0, 0, ',', '.') }}</p>
                <p class="text-xs text-gray-500">Akumulasi bulan berjalan</p>
            </div>
        </div>
    </div>

    <!-- Additional Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Total Transaksi -->
        <div class="bg-white rounded-2xl p-6 shadow-[0px_12px_32px_0px_rgba(30,41,59,0.04)] border border-[rgba(194,198,214,0.1)]">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Total Transaksi Bulan Ini</p>
                </div>
                <div class="p-2 bg-[rgba(59,130,246,0.1)] rounded-lg">
                    <iconify-icon icon="mdi:flash" class="w-5 h-5 text-blue-600"></iconify-icon>
                </div>
            </div>
            <p class="text-3xl font-black text-gray-900">{{ $monthTransactions ?? 0 }}</p>
        </div>

        <!-- Rata-rata Pendapatan -->
        <div class="bg-white rounded-2xl p-6 shadow-[0px_12px_32px_0px_rgba(30,41,59,0.04)] border border-[rgba(194,198,214,0.1)]">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Rata-rata per Transaksi</p>
                </div>
                <div class="p-2 bg-[rgba(99,102,241,0.1)] rounded-lg">
                    <iconify-icon icon="mdi:calculator-variant-outline" class="w-5 h-5 text-indigo-600"></iconify-icon>
                </div>
            </div>
            <p class="text-3xl font-black text-gray-900">Rp {{ number_format(($monthIncome ?? 0) / max(($monthTransactions ?? 1), 1), 0, ',', '.') }}</p>
        </div>

        <!-- Occupancy Rate -->
        <div class="bg-white rounded-2xl p-6 shadow-[0px_12px_32px_0px_rgba(30,41,59,0.04)] border border-[rgba(194,198,214,0.1)]">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Tingkat Okupansi</p>
                </div>
                <div class="p-2 bg-[rgba(245,158,11,0.1)] rounded-lg">
                    <iconify-icon icon="mdi:check-decagram" class="w-5 h-5 text-amber-600"></iconify-icon>
                </div>
            </div>
            <p class="text-3xl font-black text-gray-900">{{ $occupancyRate ?? 0 }}%</p>
        </div>
    </div>

    <!-- Reports Section -->
    <div>
        <h2 class="text-xl font-bold text-gray-900 mb-4">Laporan</h2>
        <div class="grid grid-cols-1 gap-4">
            <a href="{{ route('owner.rekap') }}" class="group p-6 bg-white rounded-2xl shadow-[0px_12px_32px_0px_rgba(30,41,59,0.04)] border border-[rgba(194,198,214,0.1)] hover:shadow-[0px_12px_32px_0px_rgba(0,88,190,0.1)] hover:border-[#0058be] transition-all transform hover:scale-105 active:scale-95 flex items-center justify-between">
                <div class="flex items-start gap-4">
                    <div class="p-3 bg-purple-50 rounded-lg group-hover:bg-purple-100 transition-colors">
                        <iconify-icon icon="mdi:file-chart-outline" class="w-6 h-6 text-purple-600"></iconify-icon>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-1">Rekap Transaksi</h3>
                        <p class="text-sm text-gray-600">Lihat detail laporan transaksi parkir mingguan atau bulanan</p>
                    </div>
                </div>
                <iconify-icon icon="mdi:arrow-right" class="w-6 h-6 text-gray-400 group-hover:text-[#0058be] transition-colors transform group-hover:translate-x-1"></iconify-icon>
            </a>
        </div>
    </div>

    <!-- Quick Stats Info -->
    <div class="border border-[#0058be]/20 rounded-2xl p-6">
        <div class="flex items-start gap-4">
            <iconify-icon icon="mdi:message-processing" class="w-6 h-6 text-[#0058be] shrink-0 mt-1"></iconify-icon>
            <div>
                <h3 class="font-semibold text-gray-900 mb-1">Data Real-time</h3>
                <p class="text-sm text-gray-600">
                    Semua data pendapatan diperbarui secara real-time. Laporan lengkap tersedia dalam menu Rekap Transaksi untuk analisis mendalam.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
