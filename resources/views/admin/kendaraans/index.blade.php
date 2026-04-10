@extends('layouts.app')

@section('title', 'Manajemen Kendaraan - Admin')

@section('content')
<div class="space-y-6">
    <!-- Header with Button -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-semibold tracking-tight text-[#191c1e]">Manajemen Kendaraan</h1>
            <p class="text-sm text-[#64748b] mt-1">Kelola data kendaraan yang terdaftar</p>
        </div>
        <a href="{{ route('admin.kendaraans.create') }}" class="px-6 py-2.5 bg-linear-to-r from-[#0058be] to-[#3B82F6] text-white text-sm font-semibold rounded-lg hover:shadow-[0px_12px_32px_rgba(0,88,190,0.15)] active:scale-95 transition-all duration-200">
            + Tambah Kendaraan
        </a>
    </div>

    @foreach($areas as $area)
        <div class="space-y-3">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <h2 class="text-xl font-semibold text-[#191c1e]">{{ $area->nama_area }}</h2>
                    <p class="text-sm text-[#64748b]">Kendaraan sedang parkir: {{ $area->transaksis->count() }}</p>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-[0px_12px_32px_rgba(30,41,59,0.06)]">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-[#f2f4f7] border-b border-[rgba(194,198,214,0.15)]">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-[#64748b] uppercase tracking-wider">Plat Nomor</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-[#64748b] uppercase tracking-wider">Jenis</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-[#64748b] uppercase tracking-wider">Warna</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-[#64748b] uppercase tracking-wider">Pemilik</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-[#64748b] uppercase tracking-wider">Pengguna</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-[#64748b] uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[rgba(194,198,214,0.1)]">
                            @forelse($area->transaksis as $transaksi)
                                @php($kendaraan = $transaksi->kendaraan)

                                @if($kendaraan)
                                    <tr class="hover:bg-[#f9fafb] transition-colors">
                                        <td class="px-6 py-4">
                                            <code class="text-sm font-semibold bg-[#f2f4f7] px-2 py-1 rounded text-[#0c4a6e]">{{ $kendaraan->plat_nomor }}</code>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-[#dbeafe] text-[#0c4a6e]">
                                                {{ ucfirst($kendaraan->jenis_kendaraan) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-sm text-[#191c1e]">{{ ucfirst($kendaraan->warna) }}</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <p class="text-sm text-[#191c1e]">{{ $kendaraan->pemilik }}</p>
                                        </td>
                                        <td class="px-6 py-4">
                                            <p class="text-sm text-[#191c1e]">{{ $kendaraan->user->nama_lengkap ?? 'N/A' }}</p>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex gap-2">
                                                <a href="{{ route('admin.kendaraans.edit', $kendaraan->id_kendaraan) }}" class="px-3 py-1.5 text-xs font-semibold text-[#0058be] hover:bg-[#dbeafe] rounded-md transition-colors">
                                                    Edit
                                                </a>
                                                <form method="POST" action="{{ route('admin.kendaraans.delete', $kendaraan->id_kendaraan) }}" class="inline" onsubmit="return confirm('Yakin ingin menghapus kendaraan ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-3 py-1.5 text-xs font-semibold text-[#dc2626] hover:bg-[#fee2e2] rounded-md transition-colors">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center">
                                        <p class="text-[#64748b]">Belum ada kendaraan yang sedang parkir di area ini.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endforeach

    <div class="space-y-3">
        <div>
            <h2 class="text-xl font-semibold text-[#191c1e]">Belum Parkir</h2>
            <p class="text-sm text-[#64748b]">Kendaraan terdaftar yang tidak sedang parkir di area manapun.</p>
        </div>

        <div class="bg-white rounded-lg shadow-[0px_12px_32px_rgba(30,41,59,0.06)]">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-[#f2f4f7] border-b border-[rgba(194,198,214,0.15)]">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-[#64748b] uppercase tracking-wider">Plat Nomor</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-[#64748b] uppercase tracking-wider">Jenis</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-[#64748b] uppercase tracking-wider">Warna</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-[#64748b] uppercase tracking-wider">Pemilik</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-[#64748b] uppercase tracking-wider">Pengguna</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-[#64748b] uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[rgba(194,198,214,0.1)]">
                        @forelse($kendaraansBelumParkir as $kendaraan)
                            <tr class="hover:bg-[#f9fafb] transition-colors">
                                <td class="px-6 py-4">
                                    <code class="text-sm font-semibold bg-[#f2f4f7] px-2 py-1 rounded text-[#0c4a6e]">{{ $kendaraan->plat_nomor }}</code>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-[#dbeafe] text-[#0c4a6e]">
                                        {{ ucfirst($kendaraan->jenis_kendaraan) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm text-[#191c1e]">{{ ucfirst($kendaraan->warna) }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-sm text-[#191c1e]">{{ $kendaraan->pemilik }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-sm text-[#191c1e]">{{ $kendaraan->user->nama_lengkap ?? 'N/A' }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-2">
                                        <a href="{{ route('admin.kendaraans.edit', $kendaraan->id_kendaraan) }}" class="px-3 py-1.5 text-xs font-semibold text-[#0058be] hover:bg-[#dbeafe] rounded-md transition-colors">
                                            Edit
                                        </a>
                                        <form method="POST" action="{{ route('admin.kendaraans.delete', $kendaraan->id_kendaraan) }}" class="inline" onsubmit="return confirm('Yakin ingin menghapus kendaraan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1.5 text-xs font-semibold text-[#dc2626] hover:bg-[#fee2e2] rounded-md transition-colors">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center">
                                    <p class="text-[#64748b]">Semua kendaraan sedang berada di area parkir.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
