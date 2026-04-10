@extends('layouts.app')

@section('title', 'Manajemen User - Admin')

@section('content')
<div class="space-y-6">
    <!-- Header with Button -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-semibold tracking-tight text-[#191c1e]">Manajemen User</h1>
            <p class="text-sm text-[#64748b] mt-1">Kelola data pengguna sistem parkir</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="px-6 py-2.5 bg-linear-to-r from-[#0058be] to-[#3B82F6] text-white text-sm font-semibold rounded-lg hover:shadow-[0px_12px_32px_rgba(0,88,190,0.15)] active:scale-95 transition-all duration-200">
            + Tambah User
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="p-4 bg-[#ecfdf5] border border-[#d1fae5] rounded-lg flex items-center gap-3">
            <svg class="w-5 h-5 text-[#059669] shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
            <p class="text-sm font-medium text-[#065f46]">{{ session('success') }}</p>
        </div>
    @endif

    <!-- Users Table -->
    <div class="bg-white rounded-lg shadow-[0px_12px_32px_rgba(30,41,59,0.06)]">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-[#f2f4f7] border-b border-[rgba(194,198,214,0.15)]">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-[#64748b] uppercase tracking-wider">Nama Lengkap</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-[#64748b] uppercase tracking-wider">Username</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-[#64748b] uppercase tracking-wider">Role</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-[#64748b] uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-[#64748b] uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[rgba(194,198,214,0.1)]">
                    @forelse($users as $user)
                        @php
                            $roleBadgeClasses = match ($user->role) {
                                'admin' => 'bg-[#ede9fe] text-[#6d28d9]',
                                'petugas' => 'bg-[#dbeafe] text-[#0c4a6e]',
                                default => 'bg-[#fef3c7] text-[#92400e]',
                            };
                            $statusBadgeClasses = $user->status_aktif
                                ? 'bg-[#ecfdf5] text-[#065f46]'
                                : 'bg-[#fee2e2] text-[#7f1d1d]';
                        @endphp

                        <tr class="hover:bg-[#f9fafb] transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-medium text-[#191c1e]">{{ $user->nama_lengkap }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <code class="text-sm bg-[#f2f4f7] px-2 py-1 rounded text-[#0f766e]">{{ $user->username }}</code>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full {{ $roleBadgeClasses }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full {{ $statusBadgeClasses }}">
                                    {{ $user->status_aktif ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.users.edit', $user->id_user) }}" class="px-3 py-1.5 text-xs font-semibold text-[#0058be] hover:bg-[#dbeafe] rounded-md transition-colors">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.users.delete', $user->id_user) }}" class="inline" onsubmit="return confirm('Yakin ingin menonaktifkan user ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 text-xs font-semibold text-[#dc2626] hover:bg-[#fee2e2] rounded-md transition-colors">
                                            Nonaktifkan
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center">
                                <p class="text-[#64748b]">Belum ada data user. Tambahkan user pertama untuk mulai menggunakan sistem.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="px-6 py-4 border-t border-[rgba(194,198,214,0.1)]">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
