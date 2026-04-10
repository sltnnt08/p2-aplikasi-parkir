@extends('layouts.app')

@section('title', 'Cetak Struk Keluar')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-semibold tracking-tight text-[#191c1e]">Kendaraan Berhasil Diidentifikasi</h1>
        <p class="text-sm text-[#64748b] mt-1">Langkah berikutnya hanya cetak struk. Status keluar akan diselesaikan setelah jendela cetak ditutup.</p>
    </div>

    <div class="bg-white rounded-lg shadow-[0px_12px_32px_rgba(30,41,59,0.06)] p-6 lg:p-8 max-w-2xl space-y-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <p class="text-xs uppercase tracking-wider font-semibold text-[#64748b]">Plat Nomor</p>
                <p class="text-lg font-bold text-[#191c1e]">{{ $transaksi->kendaraan?->plat_nomor ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs uppercase tracking-wider font-semibold text-[#64748b]">Area Parkir</p>
                <p class="text-lg font-semibold text-[#191c1e]">{{ $transaksi->areaParkir?->nama_area ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs uppercase tracking-wider font-semibold text-[#64748b]">Waktu Masuk</p>
                <p class="text-sm font-semibold text-[#191c1e]">{{ $transaksi->waktu_masuk->format('d/m/Y H:i:s') }}</p>
            </div>
            <div>
                <p class="text-xs uppercase tracking-wider font-semibold text-[#64748b]">Waktu Keluar</p>
                <p class="text-sm font-semibold text-[#191c1e]">{{ $waktuKeluar->format('d/m/Y H:i:s') }}</p>
            </div>
            <div>
                <p class="text-xs uppercase tracking-wider font-semibold text-[#64748b]">Durasi</p>
                <p class="text-sm font-semibold text-[#191c1e]">{{ $durasi }} jam</p>
            </div>
            <div>
                <p class="text-xs uppercase tracking-wider font-semibold text-[#64748b]">Total Biaya</p>
                <p class="text-lg font-bold text-[#0058be]">Rp {{ number_format($biaya, 0, ',', '.') }}</p>
            </div>
        </div>

        <button
            type="button"
            id="open-print-window"
            class="w-full py-3 px-6 bg-linear-to-r from-[#0058be] to-[#3B82F6] text-white text-sm font-semibold rounded-lg hover:shadow-[0px_12px_32px_rgba(0,88,190,0.15)] active:scale-95 transition-all duration-200"
        >
            Cetak Struk
        </button>
    </div>
</div>

<script>
    (() => {
        const printButton = document.getElementById('open-print-window');
        const printUrl = @json($printUrl);
        const backUrl = @json($backUrl);

        if (!printButton) {
            return;
        }

        printButton.addEventListener('click', () => {
            const printWindow = window.open(printUrl, 'cetak-struk', 'width=480,height=780');

            if (!printWindow) {
                alert('Popup diblokir oleh browser. Izinkan popup lalu klik Cetak Struk lagi.');
                return;
            }

            printButton.disabled = true;
            printButton.classList.add('opacity-60', 'cursor-not-allowed');

            const closeChecker = setInterval(() => {
                if (printWindow.closed) {
                    clearInterval(closeChecker);
                    window.location.href = backUrl;
                }
            }, 500);
        });
    })();
</script>
@endsection
