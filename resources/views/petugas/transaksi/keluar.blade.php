@extends('layouts.app')

@section('title', 'Kendaraan Keluar')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-3xl font-semibold tracking-tight text-[#191c1e]">Pencatatan Kendaraan Keluar</h1>
        <p class="text-sm text-[#64748b] mt-1">Proses kendaraan yang keluar dan hitung total biaya</p>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-lg shadow-[0px_12px_32px_rgba(30,41,59,0.06)] p-6 lg:p-8 max-w-2xl">
        <form method="POST" action="{{ route('petugas.transaksi.process.keluar') }}" class="space-y-6">
            @csrf

            <!-- Plat Nomor -->
            <div>
                <label for="plat_nomor" class="block text-sm font-semibold text-[#191c1e] mb-2">Plat Nomor</label>
                <input
                    type="text"
                    id="plat_nomor"
                    name="plat_nomor"
                    value="{{ old('plat_nomor') }}"
                    class="w-full px-4 py-2.5 rounded-lg bg-[#f2f4f7] text-[#191c1e] placeholder-[#94a3b8] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0058be] focus:ring-opacity-30 transition-all"
                    placeholder="Masukkan plat nomor kendaraan"
                    required
                    autofocus
                >
                @error('plat_nomor')
                    <p class="mt-2 text-xs text-[#dc2626]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex gap-3 pt-4">
                <button
                    type="submit"
                    class="flex-1 py-2.5 px-6 bg-linear-to-r from-[#0058be] to-[#3B82F6] text-white text-sm font-semibold rounded-lg hover:shadow-[0px_12px_32px_rgba(0,88,190,0.15)] active:scale-95 transition-all duration-200"
                >
                    Cari & Proses Keluar
                </button>
                <a
                    href="{{ route('petugas.dashboard') }}"
                    class="flex-1 py-2.5 px-6 bg-[#f2f4f7] text-[#191c1e] text-sm font-semibold rounded-lg hover:bg-[#e2e8f0] transition-colors text-center"
                >
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
