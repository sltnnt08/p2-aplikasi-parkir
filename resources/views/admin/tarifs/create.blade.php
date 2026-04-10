@extends('layouts.app')

@section('title', 'Tambah Tarif - Admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-3xl font-semibold tracking-tight text-[#191c1e]">Tambah Tarif</h1>
        <p class="text-sm text-[#64748b] mt-1">Buat data tarif parkir baru</p>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-lg shadow-[0px_12px_32px_rgba(30,41,59,0.06)] p-6 lg:p-8 max-w-2xl">
        <form method="POST" action="{{ route('admin.tarifs.store') }}" class="space-y-6">
            @csrf

            <!-- Area Parkir -->
            <div>
                <label for="id_area" class="block text-sm font-semibold text-[#191c1e] mb-2">Berlaku di Area</label>
                <select
                    id="id_area"
                    name="id_area"
                    class="w-full px-4 py-2.5 rounded-lg bg-[#f2f4f7] text-[#191c1e] focus:bg-white focus:outline-none focus:ring-2 focus:ring-opacity-30 transition-all {{ $errors->has('id_area') ? 'focus:ring-red-300' : 'focus:ring-[#0058be]' }}"
                    required
                >
                    <option value="">Pilih Area Parkir</option>
                    @foreach($areas as $area)
                        <option value="{{ $area->id_area }}" {{ (string) old('id_area') === (string) $area->id_area ? 'selected' : '' }}>
                            {{ $area->nama_area }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Jenis Kendaraan -->
            <div>
                <label for="jenis_kendaraan" class="block text-sm font-semibold text-[#191c1e] mb-2">Jenis Kendaraan</label>
                <select
                    id="jenis_kendaraan"
                    name="jenis_kendaraan"
                    class="w-full px-4 py-2.5 rounded-lg bg-[#f2f4f7] text-[#191c1e] focus:bg-white focus:outline-none focus:ring-2 focus:ring-opacity-30 transition-all {{ $errors->has('jenis_kendaraan') ? 'focus:ring-red-300' : 'focus:ring-[#0058be]' }}"
                    required
                >
                    <option value="">Pilih Jenis Kendaraan</option>
                    <option value="motor" {{ old('jenis_kendaraan') === 'motor' ? 'selected' : '' }}>Motor</option>
                    <option value="mobil" {{ old('jenis_kendaraan') === 'mobil' ? 'selected' : '' }}>Mobil</option>
                    <option value="lainnya" {{ old('jenis_kendaraan') === 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
            </div>

            <!-- Tarif Per Jam -->
            <div>
                <label for="tarif_per_jam" class="block text-sm font-semibold text-[#191c1e] mb-2">Tarif Per Jam (Rp)</label>
                <input
                    type="number"
                    id="tarif_per_jam"
                    name="tarif_per_jam"
                    value="{{ old('tarif_per_jam') }}"
                    class="w-full px-4 py-2.5 rounded-lg bg-[#f2f4f7] text-[#191c1e] placeholder-[#94a3b8] focus:bg-white focus:outline-none focus:ring-2 focus:ring-opacity-30 transition-all {{ $errors->has('tarif_per_jam') ? 'focus:ring-red-300' : 'focus:ring-[#0058be]' }}"
                    placeholder="Masukkan tarif per jam"
                    min="0"
                    step="1000"
                    required
                >
            </div>

            <!-- Buttons -->
            <div class="flex gap-3 pt-4">
                <button
                    type="submit"
                    class="flex-1 py-2.5 px-6 bg-linear-to-r from-[#0058be] to-[#3B82F6] text-white text-sm font-semibold rounded-lg hover:shadow-[0px_12px_32px_rgba(0,88,190,0.15)] active:scale-95 transition-all duration-200"
                >
                    Simpan Tarif
                </button>
                <a
                    href="{{ route('admin.tarifs') }}"
                    class="flex-1 py-2.5 px-6 bg-[#f2f4f7] text-[#191c1e] text-sm font-semibold rounded-lg hover:bg-[#e2e8f0] transition-colors text-center"
                >
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

