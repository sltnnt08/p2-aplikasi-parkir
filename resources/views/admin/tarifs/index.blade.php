@extends('layouts.app')

@section('title', 'Manajemen Tarif - Admin')

@section('content')
<div class="space-y-6">
    <!-- Header with Button -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-semibold tracking-tight text-[#191c1e]">Manajemen Tarif</h1>
            <p class="text-sm text-[#64748b] mt-1">Kelola tarif parkir per jenis kendaraan</p>
        </div>
        <a href="{{ route('admin.tarifs.create') }}" class="px-6 py-2.5 bg-linear-to-r from-[#0058be] to-[#3B82F6] text-white text-sm font-semibold rounded-lg hover:shadow-[0px_12px_32px_rgba(0,88,190,0.15)] active:scale-95 transition-all duration-200">
            + Tambah Tarif
        </a>
    </div>

    <!-- Tarifs Table -->
    <div class="bg-white rounded-lg shadow-[0px_12px_32px_rgba(30,41,59,0.06)]">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-[#f2f4f7] border-b border-[rgba(194,198,214,0.15)]">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-[#64748b] uppercase tracking-wider">Area</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-[#64748b] uppercase tracking-wider">Jenis Kendaraan</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-[#64748b] uppercase tracking-wider">Tarif Per Jam</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-[#64748b] uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[rgba(194,198,214,0.1)]">
                    @forelse($tarifs as $tarif)
                        <tr class="hover:bg-[#f9fafb] transition-colors">
                            <td class="px-6 py-4">
                                <p class="text-sm text-[#191c1e]">{{ $tarif->areaParkir->nama_area ?? '-' }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-[#dbeafe] text-[#0c4a6e]">
                                    {{ ucfirst($tarif->jenis_kendaraan) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-semibold text-[#191c1e]">Rp {{ number_format($tarif->tarif_per_jam, 0, ',', '.') }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.tarifs.edit', $tarif->id_tarif) }}" class="px-3 py-1.5 text-xs font-semibold text-[#0058be] hover:bg-[#dbeafe] rounded-md transition-colors">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.tarifs.delete', $tarif->id_tarif) }}" class="inline" onsubmit="return confirm('Yakin ingin menghapus tarif ini?')">
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
                            <td colspan="4" class="px-6 py-8 text-center">
                                <p class="text-[#64748b]">Belum ada data tarif. Tambahkan tarif untuk setiap jenis kendaraan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($tarifs->hasPages())
            <div class="px-6 py-4 border-t border-[rgba(194,198,214,0.1)]">
                {{ $tarifs->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
