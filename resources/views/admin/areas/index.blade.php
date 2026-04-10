@extends('layouts.app')

@section('title', 'Manajemen Area - Admin')

@section('content')
<div class="space-y-6">
    <!-- Header with Button -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-semibold tracking-tight text-[#191c1e]">Manajemen Area Parkir</h1>
            <p class="text-sm text-[#64748b] mt-1">Kelola area lokasi parkir tersedia</p>
        </div>
        <a href="{{ route('admin.areas.create') }}" class="px-6 py-2.5 bg-linear-to-r from-[#0058be] to-[#3B82F6] text-white text-sm font-semibold rounded-lg hover:shadow-[0px_12px_32px_rgba(0,88,190,0.15)] active:scale-95 transition-all duration-200">
            + Tambah Area
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="p-4 bg-[#ecfdf5] border border-[#d1fae5] rounded-lg flex items-center gap-3">
            <svg class="w-5 h-5 text-[#059669] shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
            <p class="text-sm font-medium text-[#065f46]">{{ session('success') }}</p>
        </div>
    @endif

    <!-- Areas Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($areas as $area)
            <div class="bg-white rounded-lg shadow-[0px_12px_32px_rgba(30,41,59,0.06)] p-6 hover:shadow-[0px_20px_40px_rgba(30,41,59,0.12)] transition-shadow">
                <!-- Header -->
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-[#191c1e]">{{ $area->nama_area }}</h3>
                        <p class="text-sm text-[#64748b] mt-1">Area {{ $area->id_area }}</p>
                    </div>
                    <svg class="w-8 h-8 text-[#3B82F6]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>

                <!-- Capacity Info -->
                <div class="space-y-3 mb-6">
                    <div class="bg-[#f2f4f7] rounded-lg p-3">
                        <p class="text-xs text-[#64748b] uppercase tracking-wider font-semibold mb-1">Kapasitas Total</p>
                        <p class="text-2xl font-bold text-[#191c1e]">{{ $area->kapasitas }}</p>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="bg-[#ecfdf5] rounded-lg p-3">
                            <p class="text-xs text-[#065f46] uppercase tracking-wider font-semibold mb-1">Terisi</p>
                            <p class="text-xl font-bold text-[#059669]">{{ $area->terisi }}</p>
                        </div>
                        <div class="bg-[#dbeafe] rounded-lg p-3">
                            <p class="text-xs text-[#0c4a6e] uppercase tracking-wider font-semibold mb-1">Kosong</p>
                            <p class="text-xl font-bold text-[#0369a1]">{{ $area->kapasitas - $area->terisi }}</p>
                        </div>
                    </div>
                </div>

                <!-- Progress Bar -->
                <div class="mb-6">
                    <div class="w-full bg-[#e2e8f0] rounded-full h-2 overflow-hidden">
                        <div
                            class="bg-linear-to-r from-[#0058be] to-[#3B82F6] h-full rounded-full transition-all"
                            style="width: {{ ($area->terisi / max($area->kapasitas, 1)) * 100 }}%"
                        ></div>
                    </div>
                    <p class="text-xs text-[#64748b] mt-2">{{ round(($area->terisi / max($area->kapasitas, 1)) * 100) }}% Terisi</p>
                </div>

                <!-- Actions -->
                <div class="flex gap-2 pt-4 border-t border-[rgba(194,198,214,0.1)]">
                    <a href="{{ route('admin.areas.edit', $area->id_area) }}" class="flex-1 py-2 px-3 text-xs font-semibold text-[#0058be] hover:bg-[#dbeafe] rounded-md transition-colors text-center">
                        Edit
                    </a>
                    <form method="POST" action="{{ route('admin.areas.delete', $area->id_area) }}" class="flex-1" onsubmit="return confirm('Yakin ingin menghapus area ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full py-2 px-3 text-xs font-semibold text-[#dc2626] hover:bg-[#fee2e2] rounded-md transition-colors">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="bg-white rounded-lg shadow-[0px_12px_32px_rgba(30,41,59,0.06)] p-8 text-center">
                    <p class="text-[#64748b]">Belum ada data area. Tambahkan area parkir untuk mulai menerima kendaraan.</p>
                </div>
            </div>
        @endforelse
    </div>

    @if($areas->hasPages())
        <div class="bg-white rounded-lg shadow-[0px_12px_32px_rgba(30,41,59,0.06)] px-6 py-4">
            {{ $areas->links() }}
        </div>
    @endif
</div>
@endsection
