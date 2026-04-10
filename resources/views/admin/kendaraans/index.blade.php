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

    <!-- Success Message -->
    @if(session('success'))
        <div class="p-4 bg-[#ecfdf5] border border-[#d1fae5] rounded-lg flex items-center gap-3">
            <svg class="w-5 h-5 text-[#059669] shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
            <p class="text-sm font-medium text-[#065f46]">{{ session('success') }}</p>
        </div>
    @endif

    <!-- Kendaraans Table -->
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
                    @forelse($kendaraans as $kendaraan)
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
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded border-2 border-gray-300" style="background-color: {{ strtoupper($kendaraan->warna) === strtoupper($kendaraan->warna) ? 'gray' : $kendaraan->warna }}"></div>
                                    <span class="text-sm text-[#191c1e]">{{ ucfirst($kendaraan->warna) }}</span>
                                </div>
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
                                <p class="text-[#64748b]">Belum ada data kendaraan. Tambahkan kendaraan untuk mempermudah proses transaksi.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($kendaraans->hasPages())
            <div class="px-6 py-4 border-t border-[rgba(194,198,214,0.1)]">
                {{ $kendaraans->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
