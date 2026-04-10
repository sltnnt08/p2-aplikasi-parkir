@extends('layouts.app')

@section('title', 'Kendaraan Keluar')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-semibold tracking-tight text-[#191c1e]">Kendaraan Aktif Parkir</h1>
        <p class="text-sm text-[#64748b] mt-1">Cari plat nomor kendaraan yang akan keluar, lalu proses langsung dari tabel.</p>
    </div>

    <div class="bg-white rounded-lg shadow-[0px_12px_32px_rgba(30,41,59,0.06)] p-6">
        <form method="GET" action="{{ route('petugas.transaksi.keluar') }}" class="flex flex-col sm:flex-row gap-3 sm:items-end">
            <div class="flex-1">
                <label for="search" class="block text-sm font-semibold text-[#191c1e] mb-2">Cari Plat Nomor</label>
                <input
                    type="text"
                    id="search"
                    name="search"
                    value="{{ $searchPlate }}"
                    class="w-full px-4 py-2.5 rounded-lg bg-[#f2f4f7] text-[#191c1e] placeholder-[#94a3b8] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0058be] focus:ring-opacity-30 transition-all"
                    placeholder="Contoh: B 1234 ABC"
                    autofocus
                >
            </div>

            <div class="flex gap-2">
                <button
                    type="submit"
                    class="py-2.5 px-6 bg-linear-to-r from-[#0058be] to-[#3B82F6] text-white text-sm font-semibold rounded-lg hover:shadow-[0px_12px_32px_rgba(0,88,190,0.15)] active:scale-95 transition-all duration-200"
                >
                    Cari
                </button>

                @if($searchPlate !== '')
                    <a
                        href="{{ route('petugas.transaksi.keluar') }}"
                        class="py-2.5 px-6 bg-[#f2f4f7] text-[#191c1e] text-sm font-semibold rounded-lg hover:bg-[#e2e8f0] transition-colors text-center"
                    >
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow-[0px_12px_32px_rgba(30,41,59,0.06)]">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-[#f2f4f7] border-b border-[rgba(194,198,214,0.15)]">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-[#64748b] uppercase tracking-wider">Plat Nomor</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-[#64748b] uppercase tracking-wider">Jenis</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-[#64748b] uppercase tracking-wider">Area</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-[#64748b] uppercase tracking-wider">Waktu Masuk</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-[#64748b] uppercase tracking-wider">Durasi</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-[#64748b] uppercase tracking-wider">Estimasi Biaya</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-[#64748b] uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[rgba(194,198,214,0.1)]">
                    @forelse($activeParkings as $transaksi)
                        @php
                            $durasiMenit = max(1, $transaksi->waktu_masuk->diffInMinutes(now()));
                            $durasiJam = (int) ceil($durasiMenit / 60);
                            $estimasiBiaya = $durasiJam * ($transaksi->tarif?->tarif_per_jam ?? 0);
                        @endphp
                        <tr class="hover:bg-[#f9fafb] transition-colors">
                            <td class="px-6 py-4">
                                <code class="text-sm font-semibold bg-[#f2f4f7] px-2 py-1 rounded text-[#0c4a6e]">{{ $transaksi->kendaraan?->plat_nomor ?? '-' }}</code>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-[#dbeafe] text-[#0c4a6e]">
                                    {{ ucfirst((string) ($transaksi->kendaraan?->jenis_kendaraan ?? '-')) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-[#191c1e]">{{ $transaksi->areaParkir?->nama_area ?? '-' }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-[#191c1e]">{{ $transaksi->waktu_masuk->format('d/m/Y H:i') }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm font-semibold text-[#191c1e]">{{ $durasiJam }} jam</p>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <p class="text-sm font-bold text-[#0058be]">Rp {{ number_format($estimasiBiaya, 0, ',', '.') }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <form method="POST" action="{{ route('petugas.transaksi.process.keluar') }}" onsubmit="return confirm('Proses kendaraan ini keluar sekarang?')">
                                    @csrf
                                    <input type="hidden" name="id_parkir" value="{{ $transaksi->id_parkir }}">
                                    <button
                                        type="submit"
                                        class="px-4 py-2 text-xs font-semibold text-white bg-linear-to-r from-[#ef4444] to-[#f97316] rounded-md hover:shadow-[0px_12px_32px_rgba(239,68,68,0.18)] active:scale-95 transition-all duration-200"
                                    >
                                        Proses Keluar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center">
                                <p class="text-[#64748b]">
                                    {{ $searchPlate !== '' ? 'Kendaraan dengan plat nomor tersebut tidak ditemukan dalam parkir aktif.' : 'Belum ada kendaraan yang sedang parkir.' }}
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($activeParkings->hasPages())
            <div class="px-6 py-4 border-t border-[rgba(194,198,214,0.1)]">
                {{ $activeParkings->links() }}
            </div>
        @endif
    </div>

    <div>
        <a
            href="{{ route('petugas.dashboard') }}"
            class="inline-flex py-2.5 px-6 bg-[#f2f4f7] text-[#191c1e] text-sm font-semibold rounded-lg hover:bg-[#e2e8f0] transition-colors"
        >
            Kembali ke Dashboard
        </a>
    </div>
</div>
@endsection
