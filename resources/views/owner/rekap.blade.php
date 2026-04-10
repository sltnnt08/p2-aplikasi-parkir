@extends('layouts.app')

@section('title', 'Rekap Transaksi - Owner')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-semibold tracking-tight text-[#191c1e]">Rekap Transaksi</h1>
            <p class="text-sm text-[#64748b] mt-1">Laporan rinci transaksi parkir</p>
        </div>
        <a href="{{ route('owner.dashboard') }}" class="px-6 py-2.5 bg-[#f2f4f7] text-[#191c1e] text-sm font-semibold rounded-lg hover:bg-[#e2e8f0] transition-colors">
            ← Kembali ke Dashboard
        </a>
    </div>

    <!-- Filter Card -->
    <div class="bg-white rounded-lg shadow-[0px_12px_32px_rgba(30,41,59,0.06)] p-6">
        <form method="GET" action="{{ route('owner.rekap') }}" class="flex flex-col sm:flex-row gap-4 items-end">
            <div>
                <label for="start_date" class="block text-sm font-semibold text-[#191c1e] mb-2">Tanggal Mulai</label>
                <input
                    type="date"
                    id="start_date"
                    name="start_date"
                    value="{{ request('start_date') }}"
                    class="px-4 py-2.5 rounded-lg bg-[#f2f4f7] text-[#191c1e] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0058be] focus:ring-opacity-30 transition-all"
                >
            </div>
            <div>
                <label for="end_date" class="block text-sm font-semibold text-[#191c1e] mb-2">Tanggal Akhir</label>
                <input
                    type="date"
                    id="end_date"
                    name="end_date"
                    value="{{ request('end_date') }}"
                    class="px-4 py-2.5 rounded-lg bg-[#f2f4f7] text-[#191c1e] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0058be] focus:ring-opacity-30 transition-all"
                >
            </div>
            <div class="flex gap-2">
                <button
                    type="submit"
                    class="px-6 py-2.5 bg-gradient-to-r from-[#0058be] to-[#3B82F6] text-white text-sm font-semibold rounded-lg hover:shadow-[0px_12px_32px_rgba(0,88,190,0.15)] active:scale-95 transition-all duration-200"
                >
                    Filter
                </button>
                @if(request('start_date') || request('end_date'))
                    <a
                        href="{{ route('owner.rekap') }}"
                        class="px-6 py-2.5 bg-[#f2f4f7] text-[#191c1e] text-sm font-semibold rounded-lg hover:bg-[#e2e8f0] transition-colors"
                    >
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Summary Card -->
    @if($transaksis->count() > 0)
        <div class="bg-gradient-to-r from-[#0058be] to-[#3B82F6] rounded-lg shadow-[0px_12px_32px_rgba(30,41,59,0.06)] p-6 text-white">
            <p class="text-sm text-[rgba(255,255,255,0.8)] uppercase tracking-wider font-semibold">Total Pendapatan</p>
            <p class="text-4xl font-bold mt-2">Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
            <p class="text-xs text-[rgba(255,255,255,0.7)] mt-3">Dari {{ $transaksis->count() }} transaksi</p>
        </div>
    @endif

    <!-- Transactions Table -->
    <div class="bg-white rounded-lg shadow-[0px_12px_32px_rgba(30,41,59,0.06)]">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-[#f2f4f7] border-b border-[rgba(194,198,214,0.15)]">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-[#64748b] uppercase tracking-wider">Plat Nomor</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-[#64748b] uppercase tracking-wider">Area</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-[#64748b] uppercase tracking-wider">Waktu Masuk</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-[#64748b] uppercase tracking-wider">Waktu Keluar</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-[#64748b] uppercase tracking-wider">Durasi</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-[#64748b] uppercase tracking-wider">Biaya</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[rgba(194,198,214,0.1)]">
                    @forelse($transaksis as $transaksi)
                        <tr class="hover:bg-[#f9fafb] transition-colors">
                            <td class="px-6 py-4">
                                <code class="text-sm font-semibold bg-[#f2f4f7] px-2 py-1 rounded text-[#0c4a6e]">{{ $transaksi->kendaraan->plat_nomor }}</code>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-[#dbeafe] text-[#0c4a6e]">
                                    {{ $transaksi->areaParkir->nama_area }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-[#191c1e]">{{ $transaksi->waktu_masuk->format('d/m/Y H:i') }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-[#191c1e]">{{ $transaksi->waktu_keluar->format('d/m/Y H:i') }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm font-semibold text-[#191c1e]">{{ $transaksi->durasi_jam }} jam</p>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <p class="text-sm font-bold text-[#0058be]">Rp {{ number_format($transaksi->biaya_total, 0, ',', '.') }}</p>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center">
                                <p class="text-[#64748b]">Belum ada data transaksi</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
