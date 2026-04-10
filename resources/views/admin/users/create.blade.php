@extends('layouts.app')

@section('title', 'Tambah User - Admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-3xl font-semibold tracking-tight text-[#191c1e]">Tambah User</h1>
        <p class="text-sm text-[#64748b] mt-1">Buat akun pengguna baru untuk sistem parkir</p>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-lg shadow-[0px_12px_32px_rgba(30,41,59,0.06)] p-6 lg:p-8 max-w-2xl">
        <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-6">
            @csrf

            <!-- Nama Lengkap -->
            <div>
                <label for="nama_lengkap" class="block text-sm font-semibold text-[#191c1e] mb-2">Nama Lengkap</label>
                <input
                    type="text"
                    id="nama_lengkap"
                    name="nama_lengkap"
                    value="{{ old('nama_lengkap') }}"
                    class="w-full px-4 py-2.5 rounded-lg bg-[#f2f4f7] text-[#191c1e] placeholder-[#94a3b8] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0058be] focus:ring-opacity-30 transition-all"
                    placeholder="Masukkan nama lengkap"
                    required
                >
            </div>

            <!-- Username -->
            <div>
                <label for="username" class="block text-sm font-semibold text-[#191c1e] mb-2">Username</label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    value="{{ old('username') }}"
                    class="w-full px-4 py-2.5 rounded-lg bg-[#f2f4f7] text-[#191c1e] placeholder-[#94a3b8] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0058be] focus:ring-opacity-30 transition-all"
                    placeholder="Masukkan username"
                    required
                >
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-semibold text-[#191c1e] mb-2">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="w-full px-4 py-2.5 rounded-lg bg-[#f2f4f7] text-[#191c1e] placeholder-[#94a3b8] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0058be] focus:ring-opacity-30 transition-all"
                    placeholder="Masukkan password minimal 6 karakter"
                    required
                >
            </div>

            <!-- Role -->
            <div>
                <label for="role" class="block text-sm font-semibold text-[#191c1e] mb-2">Role</label>
                <select
                    id="role"
                    name="role"
                    class="w-full px-4 py-2.5 rounded-lg bg-[#f2f4f7] text-[#191c1e] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0058be] focus:ring-opacity-30 transition-all"
                    required
                >
                    <option value="">Pilih Role</option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="petugas" {{ old('role') === 'petugas' ? 'selected' : '' }}>Petugas</option>
                    <option value="owner" {{ old('role') === 'owner' ? 'selected' : '' }}>Owner</option>
                </select>
            </div>

            <!-- Status -->
            <div>
                <label for="status_aktif" class="block text-sm font-semibold text-[#191c1e] mb-2">Status</label>
                <select
                    id="status_aktif"
                    name="status_aktif"
                    class="w-full px-4 py-2.5 rounded-lg bg-[#f2f4f7] text-[#191c1e] focus:bg-white focus:outline-none focus:ring-2 focus:ring-opacity-30 transition-all {{ $errors->has('status_aktif') ? 'focus:ring-red-300' : 'focus:ring-[#0058be]' }}"
                    required
                >
                    <option value="1" {{ old('status_aktif', '1') == 1 ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ old('status_aktif', '1') == 0 ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            <!-- Buttons -->
            <div class="flex gap-3 pt-4">
                <button
                    type="submit"
                    class="flex-1 py-2.5 px-6 bg-linear-to-r from-[#0058be] to-[#3B82F6] text-white text-sm font-semibold rounded-lg hover:shadow-[0px_12px_32px_rgba(0,88,190,0.15)] active:scale-95 transition-all duration-200"
                >
                    Simpan User
                </button>
                <a
                    href="{{ route('admin.users') }}"
                    class="flex-1 py-2.5 px-6 bg-[#f2f4f7] text-[#191c1e] text-sm font-semibold rounded-lg hover:bg-[#e2e8f0] transition-colors text-center"
                >
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

