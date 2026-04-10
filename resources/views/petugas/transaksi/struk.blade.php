@extends('layouts.app')

@section('title', 'Struk Parkir')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-3xl font-semibold tracking-tight text-[#191c1e]">Struk Parkir</h1>
        <p class="text-sm text-[#64748b] mt-1">Detail transaksi parkir kendaraan</p>
    </div>

    <!-- Struk Card -->
    <div class="max-w-2xl">
        <div class="bg-white rounded-lg shadow-[0px_12px_32px_rgba(30,41,59,0.06)] p-8 border border-[rgba(194,198,214,0.15)]">
            <!-- Header -->
            <div class="border-b border-[rgba(194,198,214,0.15)] pb-6 mb-6 text-center">
                <h2 class="text-2xl font-bold text-[#191c1e]">STRUK PARKIR</h2>
                <p class="text-xs text-[#64748b] mt-1">Parkirin - Sistem Manajemen Parkir</p>
            </div>

            <!-- Transaction Details -->
            <div class="space-y-6 mb-6">
                <!-- Vehicle Info -->
                <div class="bg-[#f2f4f7] rounded-lg p-4">
                    <p class="text-xs text-[#64748b] uppercase tracking-wider font-semibold mb-1">Plat Nomor</p>
                    <p class="text-2xl font-bold text-[#191c1e]">{{ $transaksi->kendaraan->plat_nomor }}</p>
                </div>

                <!-- Time Info -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-[#64748b] uppercase tracking-wider font-semibold mb-2">Waktu Masuk</p>
                        <p class="text-sm font-semibold text-[#191c1e]">{{ $transaksi->waktu_masuk->format('d/m/Y H:i:s') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-[#64748b] uppercase tracking-wider font-semibold mb-2">Waktu Keluar</p>
                        <p class="text-sm font-semibold text-[#191c1e]">{{ $transaksi->waktu_keluar->format('d/m/Y H:i:s') }}</p>
                    </div>
                </div>

                <!-- Duration and Rate -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-[#64748b] uppercase tracking-wider font-semibold mb-2">Durasi</p>
                        <p class="text-sm font-semibold text-[#191c1e]">{{ $transaksi->durasi_jam }} jam</p>
                    </div>
                    <div>
                        <p class="text-xs text-[#64748b] uppercase tracking-wider font-semibold mb-2">Tarif Per Jam</p>
                        <p class="text-sm font-semibold text-[#191c1e]">Rp {{ number_format($transaksi->tarif->tarif_per_jam, 0, ',', '.') }}</p>
                    </div>
                </div>

                <!-- Area -->
                <div>
                    <p class="text-xs text-[#64748b] uppercase tracking-wider font-semibold mb-2">Area Parkir</p>
                    <p class="text-sm font-semibold text-[#191c1e]">{{ $transaksi->areaParkir->nama_area }}</p>
                </div>
            </div>

            <!-- Total Amount -->
            <div class="bg-gradient-to-r from-[#0058be] to-[#3B82F6] rounded-lg p-6 text-white mb-6">
                <p class="text-xs uppercase tracking-wider font-semibold mb-2 opacity-90">Total Biaya</p>
                <p class="text-4xl font-bold">Rp {{ number_format($transaksi->biaya_total, 0, ',', '.') }}</p>
            </div>

            <!-- Footer -->
            <div class="border-t border-[rgba(194,198,214,0.15)] pt-6 text-center space-y-3">
                <p class="text-xs text-[#64748b]">Terima kasih telah menggunakan layanan kami.</p>
                <p class="text-xs text-[#94a3b8]">Struk ini adalah bukti pembayaran yang sah</p>
                <p class="text-xs text-[#94a3b8]">{{ now()->format('d/m/Y H:i:s') }}</p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-6 flex gap-3">
            <button
                onclick="window.print()"
                class="flex-1 py-2.5 px-6 bg-[#f2f4f7] text-[#191c1e] text-sm font-semibold rounded-lg hover:bg-[#e2e8f0] transition-colors"
            >
                🖨 Cetak Struk
            </button>
            <a
                href="{{ route('petugas.dashboard') }}"
                class="flex-1 py-2.5 px-6 bg-gradient-to-r from-[#0058be] to-[#3B82F6] text-white text-sm font-semibold rounded-lg hover:shadow-[0px_12px_32px_rgba(0,88,190,0.15)] transition-all text-center"
            >
                Selesai
            </a>
        </div>
    </div>
</div>

<style>
    @media print {
        body {
            background: white;
        }
        button, a:not(.print-only) {
            display: none;
        }
    }
</style>
@endsection
