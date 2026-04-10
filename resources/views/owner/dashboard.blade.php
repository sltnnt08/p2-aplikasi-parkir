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
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
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
                    <svg class="w-5 h-5 text-[#0058be]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                </div>
            </div>
            <div class="space-y-3">
                <p class="text-4xl font-black text-gray-900">Rp {{ number_format($monthIncome ?? 0, 0, ',', '.') }}</p>
                <div class="flex items-center gap-2">
                    <span class="px-2 py-1 bg-emerald-50 text-emerald-700 text-xs font-bold rounded">+18%</span>
                    <span class="text-xs text-gray-500">vs bulan sebelumnya</span>
                </div>
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
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
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
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
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
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <p class="text-3xl font-black text-gray-900">78%</p>
        </div>
    </div>

    <!-- Reports Section -->
    <div>
        <h2 class="text-xl font-bold text-gray-900 mb-4">Laporan</h2>
        <div class="grid grid-cols-1 gap-4">
            <a href="{{ route('owner.rekap') }}" class="group p-6 bg-white rounded-2xl shadow-[0px_12px_32px_0px_rgba(30,41,59,0.04)] border border-[rgba(194,198,214,0.1)] hover:shadow-[0px_12px_32px_0px_rgba(0,88,190,0.1)] hover:border-[#0058be] transition-all transform hover:scale-105 active:scale-95 flex items-center justify-between">
                <div class="flex items-start gap-4">
                    <div class="p-3 bg-purple-50 rounded-lg group-hover:bg-purple-100 transition-colors">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-1">Rekap Transaksi</h3>
                        <p class="text-sm text-gray-600">Lihat detail laporan transaksi parkir mingguan atau bulanan</p>
                    </div>
                </div>
                <svg class="w-6 h-6 text-gray-400 group-hover:text-[#0058be] transition-colors transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
            </a>
        </div>
    </div>

    <!-- Quick Stats Info -->
    <div class="bg-gradient-to-r from-[#0058be]/5 to-[#2170e4]/5 border border-[#0058be]/20 rounded-2xl p-6">
        <div class="flex items-start gap-4">
            <svg class="w-6 h-6 text-[#0058be] flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zm-11-1a1 1 0 11-2 0 1 1 0 012 0zm3 0a1 1 0 11-2 0 1 1 0 012 0zm3 0a1 1 0 11-2 0 1 1 0 012 0z" clip-rule="evenodd"></path></svg>
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
