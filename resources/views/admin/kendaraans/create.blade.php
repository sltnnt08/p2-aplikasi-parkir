@extends('layouts.app')

@section('title', 'Tambah Kendaraan - Admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-3xl font-semibold tracking-tight text-[#191c1e]">Tambah Kendaraan</h1>
        <p class="text-sm text-[#64748b] mt-1">Daftarkan kendaraan baru</p>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-lg shadow-[0px_12px_32px_rgba(30,41,59,0.06)] p-6 lg:p-8 max-w-2xl">
        <form method="POST" action="{{ route('admin.kendaraans.store') }}" class="space-y-6">
            @csrf

            <!-- Plat Nomor -->
            <div>
                <label for="plat_nomor" class="block text-sm font-semibold text-[#191c1e] mb-2">Plat Nomor</label>
                <input
                    type="text"
                    id="plat_nomor"
                    name="plat_nomor"
                    value="{{ old('plat_nomor') }}"
                    class="w-full px-4 py-2.5 rounded-lg bg-[#f2f4f7] text-[#191c1e] placeholder-[#94a3b8] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0058be] focus:ring-opacity-30 transition-all @error('plat_nomor') focus:ring-red-300 @enderror"
                    placeholder="Contoh: B 1234 ABC"
                    required
                >
                @error('plat_nomor')
                    <p class="mt-2 text-xs text-[#dc2626]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jenis Kendaraan -->
            <div>
                <label for="jenis_kendaraan" class="block text-sm font-semibold text-[#191c1e] mb-2">Jenis Kendaraan</label>
                <input
                    type="text"
                    id="jenis_kendaraan"
                    name="jenis_kendaraan"
                    value="{{ old('jenis_kendaraan') }}"
                    class="w-full px-4 py-2.5 rounded-lg bg-[#f2f4f7] text-[#191c1e] placeholder-[#94a3b8] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0058be] focus:ring-opacity-30 transition-all @error('jenis_kendaraan') focus:ring-red-300 @enderror"
                    placeholder="Contoh: Honda Civic"
                    required
                >
                @error('jenis_kendaraan')
                    <p class="mt-2 text-xs text-[#dc2626]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Warna -->
            <div>
                <label for="warna" class="block text-sm font-semibold text-[#191c1e] mb-2">Warna</label>
                <input
                    type="text"
                    id="warna"
                    name="warna"
                    value="{{ old('warna') }}"
                    class="w-full px-4 py-2.5 rounded-lg bg-[#f2f4f7] text-[#191c1e] placeholder-[#94a3b8] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0058be] focus:ring-opacity-30 transition-all @error('warna') focus:ring-red-300 @enderror"
                    placeholder="Contoh: Merah, Putih, Hitam"
                    required
                >
                @error('warna')
                    <p class="mt-2 text-xs text-[#dc2626]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Pemilik -->
            <div>
                <label for="pemilik" class="block text-sm font-semibold text-[#191c1e] mb-2">Nama Pemilik</label>
                <input
                    type="text"
                    id="pemilik"
                    name="pemilik"
                    value="{{ old('pemilik') }}"
                    class="w-full px-4 py-2.5 rounded-lg bg-[#f2f4f7] text-[#191c1e] placeholder-[#94a3b8] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0058be] focus:ring-opacity-30 transition-all @error('pemilik') focus:ring-red-300 @enderror"
                    placeholder="Masukkan nama pemilik kendaraan"
                    required
                >
                @error('pemilik')
                    <p class="mt-2 text-xs text-[#dc2626]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Pengguna -->
            <div>
                <label for="id_user" class="block text-sm font-semibold text-[#191c1e] mb-2">Pengguna</label>
                <select
                    id="id_user"
                    name="id_user"
                    class="w-full px-4 py-2.5 rounded-lg bg-[#f2f4f7] text-[#191c1e] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0058be] focus:ring-opacity-30 transition-all @error('id_user') focus:ring-red-300 @enderror"
                    required
                >
                    <option value="">Pilih Pengguna</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id_user }}" {{ old('id_user') == $user->id_user ? 'selected' : '' }}>
                            {{ $user->nama_lengkap }} ({{ $user->username }})
                        </option>
                    @endforeach
                </select>
                @error('id_user')
                    <p class="mt-2 text-xs text-[#dc2626]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex gap-3 pt-4">
                <button
                    type="submit"
                    class="flex-1 py-2.5 px-6 bg-linear-to-r from-[#0058be] to-[#3B82F6] text-white text-sm font-semibold rounded-lg hover:shadow-[0px_12px_32px_rgba(0,88,190,0.15)] active:scale-95 transition-all duration-200"
                >
                    Simpan Kendaraan
                </button>
                <a
                    href="{{ route('admin.kendaraans') }}"
                    class="flex-1 py-2.5 px-6 bg-[#f2f4f7] text-[#191c1e] text-sm font-semibold rounded-lg hover:bg-[#e2e8f0] transition-colors text-center"
                >
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
