@extends('layouts.app')

@section('title', 'Edit User - Admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-3xl font-semibold tracking-tight text-[#191c1e]">Edit User</h1>
        <p class="text-sm text-[#64748b] mt-1">Perbarui data pengguna sistem</p>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-lg shadow-[0px_12px_32px_rgba(30,41,59,0.06)] p-6 lg:p-8 max-w-2xl">
        <form method="POST" action="{{ route('admin.users.update', $user->id_user) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Nama Lengkap -->
            <div>
                <label for="nama_lengkap" class="block text-sm font-semibold text-[#191c1e] mb-2">Nama Lengkap</label>
                <input
                    type="text"
                    id="nama_lengkap"
                    name="nama_lengkap"
                    value="{{ old('nama_lengkap', $user->nama_lengkap) }}"
                    class="w-full px-4 py-2.5 rounded-lg bg-[#f2f4f7] text-[#191c1e] placeholder-[#94a3b8] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0058be] focus:ring-opacity-30 transition-all @error('nama_lengkap') focus:ring-red-300 @enderror"
                    placeholder="Masukkan nama lengkap"
                    required
                >
                @error('nama_lengkap')
                    <p class="mt-2 text-xs text-[#dc2626]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Username -->
            <div>
                <label for="username" class="block text-sm font-semibold text-[#191c1e] mb-2">Username</label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    value="{{ old('username', $user->username) }}"
                    class="w-full px-4 py-2.5 rounded-lg bg-[#f2f4f7] text-[#191c1e] placeholder-[#94a3b8] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0058be] focus:ring-opacity-30 transition-all @error('username') focus:ring-red-300 @enderror"
                    placeholder="Masukkan username"
                    required
                >
                @error('username')
                    <p class="mt-2 text-xs text-[#dc2626]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password (Optional) -->
            <div>
                <label for="password" class="block text-sm font-semibold text-[#191c1e] mb-2">Password Baru (Kosongkan jika tidak ingin diubah)</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="w-full px-4 py-2.5 rounded-lg bg-[#f2f4f7] text-[#191c1e] placeholder-[#94a3b8] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0058be] focus:ring-opacity-30 transition-all @error('password') focus:ring-red-300 @enderror"
                    placeholder="Masukkan password baru (minimal 6 karakter)"
                >
                @error('password')
                    <p class="mt-2 text-xs text-[#dc2626]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Role -->
            <div>
                <label for="role" class="block text-sm font-semibold text-[#191c1e] mb-2">Role</label>
                <select
                    id="role"
                    name="role"
                    class="w-full px-4 py-2.5 rounded-lg bg-[#f2f4f7] text-[#191c1e] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0058be] focus:ring-opacity-30 transition-all @error('role') focus:ring-red-300 @enderror"
                    required
                >
                    <option value="">Pilih Role</option>
                    <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="petugas" {{ old('role', $user->role) === 'petugas' ? 'selected' : '' }}>Petugas</option>
                    <option value="owner" {{ old('role', $user->role) === 'owner' ? 'selected' : '' }}>Owner</option>
                </select>
                @error('role')
                    <p class="mt-2 text-xs text-[#dc2626]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div>
                <label for="status_aktif" class="block text-sm font-semibold text-[#191c1e] mb-2">Status</label>
                <select
                    id="status_aktif"
                    name="status_aktif"
                    class="w-full px-4 py-2.5 rounded-lg bg-[#f2f4f7] text-[#191c1e] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0058be] focus:ring-opacity-30 transition-all @error('status_aktif') focus:ring-red-300 @enderror"
                    required
                >
                    <option value="1" {{ old('status_aktif', $user->status_aktif) == 1 ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ old('status_aktif', $user->status_aktif) == 0 ? 'selected' : '' }}>Nonaktif</option>
                </select>
                @error('status_aktif')
                    <p class="mt-2 text-xs text-[#dc2626]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex gap-3 pt-4">
                <button
                    type="submit"
                    class="flex-1 py-2.5 px-6 bg-linear-to-r from-[#0058be] to-[#3B82F6] text-white text-sm font-semibold rounded-lg hover:shadow-[0px_12px_32px_rgba(0,88,190,0.15)] active:scale-95 transition-all duration-200"
                >
                    Update User
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
