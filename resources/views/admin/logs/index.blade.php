@extends('layouts.app')

@section('title', 'Log Aktivitas - Admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-3xl font-semibold tracking-tight text-[#191c1e]">Log Aktivitas</h1>
        <p class="text-sm text-[#64748b] mt-1">Laporan aktivitas pengguna sistem</p>
    </div>

    <!-- Filter Card -->
    <div class="bg-white rounded-lg shadow-[0px_12px_32px_rgba(30,41,59,0.06)] p-6">
        <form method="GET" action="{{ route('admin.logs') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
            <div>
                <label for="tanggal" class="block text-sm font-semibold text-[#191c1e] mb-2">Tanggal</label>
                <input
                    type="date"
                    id="tanggal"
                    name="tanggal"
                    value="{{ request('tanggal') }}"
                    class="w-full px-4 py-2.5 rounded-lg bg-[#f2f4f7] text-[#191c1e] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0058be] focus:ring-opacity-30 transition-all"
                >
            </div>

            <div>
                <label for="jam" class="block text-sm font-semibold text-[#191c1e] mb-2">Jam</label>
                <input
                    type="number"
                    id="jam"
                    name="jam"
                    value="{{ request('jam') }}"
                    min="0"
                    max="23"
                    placeholder="0-23"
                    class="w-full px-4 py-2.5 rounded-lg bg-[#f2f4f7] text-[#191c1e] placeholder-[#94a3b8] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0058be] focus:ring-opacity-30 transition-all"
                >
            </div>

            <div>
                <label for="menit" class="block text-sm font-semibold text-[#191c1e] mb-2">Menit</label>
                <input
                    type="number"
                    id="menit"
                    name="menit"
                    value="{{ request('menit') }}"
                    min="0"
                    max="59"
                    placeholder="0-59"
                    class="w-full px-4 py-2.5 rounded-lg bg-[#f2f4f7] text-[#191c1e] placeholder-[#94a3b8] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0058be] focus:ring-opacity-30 transition-all"
                >
            </div>

            <div class="flex gap-2">
                <button
                    type="submit"
                    class="px-6 py-2.5 bg-linear-to-r from-[#0058be] to-[#3B82F6] text-white text-sm font-semibold rounded-lg hover:shadow-[0px_12px_32px_rgba(0,88,190,0.15)] active:scale-95 transition-all duration-200"
                >
                    Filter
                </button>
                @if(request()->filled('tanggal') || request()->filled('jam') || request()->filled('menit'))
                    <a
                        href="{{ route('admin.logs') }}"
                        class="px-6 py-2.5 bg-[#f2f4f7] text-[#191c1e] text-sm font-semibold rounded-lg hover:bg-[#e2e8f0] transition-colors"
                    >
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Logs Table -->
    <div class="bg-white rounded-lg shadow-[0px_12px_32px_rgba(30,41,59,0.06)]">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-[#f2f4f7] border-b border-[rgba(194,198,214,0.15)]">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-[#64748b] uppercase tracking-wider">Waktu</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-[#64748b] uppercase tracking-wider">Pengguna</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-[#64748b] uppercase tracking-wider">Aktivitas</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-[#64748b] uppercase tracking-wider">Role</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[rgba(194,198,214,0.1)]">
                    @forelse($logs as $log)
                        @php
                            $activityBadgeClass = match ($log->aktivitas) {
                                'Login' => 'bg-[#ecfdf5] text-[#065f46]',
                                'Logout' => 'bg-[#fee2e2] text-[#7f1d1d]',
                                default => 'bg-[#dbeafe] text-[#0c4a6e]',
                            };
                        @endphp
                        <tr class="hover:bg-[#f9fafb] transition-colors">
                            <td class="px-6 py-4">
                                <div class="text-sm text-[#191c1e]">{{ $log->waktu_aktivitas->format('d/m/Y H:i:s') }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-[#191c1e]">{{ $log->user->nama_lengkap ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full {{ $activityBadgeClass }}">
                                    {{ $log->aktivitas_label }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-[#f2f4f7] text-[#64748b]">
                                    {{ ucfirst($log->user->role ?? '-') }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center">
                                <p class="text-[#64748b]">Belum ada data log pada periode ini. Coba ubah filter tanggal, jam, atau menit.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($logs->hasPages())
            <div class="px-6 py-4 border-t border-[rgba(194,198,214,0.1)]">
                {{ $logs->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
