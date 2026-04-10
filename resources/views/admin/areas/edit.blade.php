@extends('layouts.app')

@section('title', 'Edit Area - Admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-3xl font-semibold tracking-tight text-[#191c1e]">Edit Area Parkir</h1>
        <p class="text-sm text-[#64748b] mt-1">Perbarui data area parkir</p>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-lg shadow-[0px_12px_32px_rgba(30,41,59,0.06)] p-6 lg:p-8 max-w-2xl">
        <form method="POST" action="{{ route('admin.areas.update', $area->id_area) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Nama Area -->
            <div>
                <label for="nama_area" class="block text-sm font-semibold text-[#191c1e] mb-2">Nama Area</label>
                <input
                    type="text"
                    id="nama_area"
                    name="nama_area"
                    value="{{ old('nama_area', $area->nama_area) }}"
                    class="w-full px-4 py-2.5 rounded-lg bg-[#f2f4f7] text-[#191c1e] placeholder-[#94a3b8] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0058be] focus:ring-opacity-30 transition-all @error('nama_area') focus:ring-red-300 @enderror"
                    placeholder="Masukkan nama area"
                    required
                >
                @error('nama_area')
                    <p class="mt-2 text-xs text-[#dc2626]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kapasitas -->
            <div>
                <label for="kapasitas" class="block text-sm font-semibold text-[#191c1e] mb-2">Kapasitas Total</label>
                <input
                    type="number"
                    id="kapasitas"
                    name="kapasitas"
                    value="{{ old('kapasitas', $area->kapasitas) }}"
                    class="w-full px-4 py-2.5 rounded-lg bg-[#f2f4f7] text-[#191c1e] placeholder-[#94a3b8] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0058be] focus:ring-opacity-30 transition-all @error('kapasitas') focus:ring-red-300 @enderror"
                    placeholder="Masukkan kapasitas area"
                    min="1"
                    required
                >
                @error('kapasitas')
                    <p class="mt-2 text-xs text-[#dc2626]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Info Terisi -->
            <div class="bg-[#ede9fe] border border-[#ddd6fe] rounded-lg p-4">
                <p class="text-sm text-[#6d28d9] font-semibold">Status Saat Ini</p>
                <div class="mt-2 grid grid-cols-2 gap-2 text-sm text-[#5b21b6]">
                    <div>Slot Terisi: <strong>{{ $area->terisi }}</strong></div>
                    <div>Slot Kosong: <strong>{{ $area->kapasitas - $area->terisi }}</strong></div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex gap-3 pt-4">
                <button
                    type="submit"
                    class="flex-1 py-2.5 px-6 bg-linear-to-r from-[#0058be] to-[#3B82F6] text-white text-sm font-semibold rounded-lg hover:shadow-[0px_12px_32px_rgba(0,88,190,0.15)] active:scale-95 transition-all duration-200"
                >
                    Update Area
                </button>
                <a
                    href="{{ route('admin.areas') }}"
                    class="flex-1 py-2.5 px-6 bg-[#f2f4f7] text-[#191c1e] text-sm font-semibold rounded-lg hover:bg-[#e2e8f0] transition-colors text-center"
                >
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
