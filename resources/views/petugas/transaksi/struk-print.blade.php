@php
    $paperSize = request()->string('paper')->toString() === '80' ? '80' : '58';
    $paperWidth = $paperSize.'mm';
@endphp

<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Struk Parkir</title>
    <style>
        * {
            box-sizing: border-box;
        }

        @page {
            size: {{ $paperWidth }} auto;
            margin: 4mm;
        }

        body {
            margin: 0;
            padding: 12px;
            font-family: 'Courier New', Courier, monospace;
            background: #f3f4f6;
            color: #000000;
            font-size: 12px;
            line-height: 1.25;
        }

        .receipt {
            width: {{ $paperWidth }};
            margin: 0 auto;
            background: #ffffff;
            padding: 0;
        }

        p {
            margin: 0;
        }

        .line {
            border-top: 1px dashed #000000;
            margin: 3px 0;
        }

        .title {
            margin-top: 2px;
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 0;
        }

        .block {
            margin-top: 6px;
        }

        .row {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            gap: 8px;
            margin-top: 1px;
        }

        .label {
            white-space: nowrap;
        }

        .value {
            text-align: right;
            word-break: break-word;
        }

        .center {
            text-align: center;
        }

        .spacer {
            height: 4px;
        }

        @media print {
            body {
                background: #ffffff;
                padding: 0;
            }

            .receipt {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    @php
        $durasiDetik = max(1, $transaksi->waktu_masuk->diffInSeconds($waktuKeluar));
        $lamaJam = intdiv($durasiDetik, 3600);
        $lamaMenit = intdiv($durasiDetik % 3600, 60);
        $lamaDetik = $durasiDetik % 60;
        $lamaFormatted = str_pad((string) $lamaJam, 2, '0', STR_PAD_LEFT).':'.str_pad((string) $lamaMenit, 2, '0', STR_PAD_LEFT).':'.str_pad((string) $lamaDetik, 2, '0', STR_PAD_LEFT);
    @endphp

    <article class="receipt">
        <p>Tarif parkir sudah termasuk pajak</p>
        <p>Terimakasih</p>

        <div class="spacer"></div>
        <p class="title">PARKIRIN</p>
        <p>AREA PARKIR {{ strtoupper((string) ($transaksi->areaParkir?->nama_area ?? '-')) }}</p>

        <div class="line"></div>

        <div class="block">
            <p class="row"><span class="label">Jenis Transaksi :</span><span class="value">CASH</span></p>
            <p class="row"><span class="label">ID Card</span><span class="value">: {{ $transaksi->id_parkir }}</span></p>
            <p class="row"><span class="label">Jenis Kendaraan</span><span class="value">: {{ strtoupper((string) ($transaksi->kendaraan?->jenis_kendaraan ?? '-')) }}</span></p>
            <p class="row"><span class="label">Masuk</span><span class="value">: {{ $transaksi->waktu_masuk->format('d/m/Y H:i:s') }}</span></p>
            <p class="row"><span class="label">Keluar</span><span class="value">: {{ $waktuKeluar->format('d/m/Y H:i:s') }}</span></p>
            <p class="row"><span class="label">Plat Nomor</span><span class="value">: {{ strtoupper((string) ($transaksi->kendaraan?->plat_nomor ?? '-')) }}</span></p>
            <p class="row"><span class="label">Lama</span><span class="value">: {{ $lamaFormatted }}</span></p>
            <p class="row"><span class="label">Biaya</span><span class="value">: {{ number_format($biaya, 0, ',', '') }}</span></p>
        </div>

        <div class="line"></div>

        <div class="block">
            <p class="row"><span class="label">Operator</span><span class="value">: {{ strtoupper((string) auth()->user()?->username) }}</span></p>
            <p class="row"><span class="label">Pos Keluar</span><span class="value">: {{ strtoupper((string) ($transaksi->areaParkir?->nama_area ?? '-')) }}</span></p>
        </div>

        <div class="line"></div>

        <p>Tarif parkir sudah termasuk pajak</p>
        <p>Hati hati di jalan</p>
        <p>Terimakasih</p>
    </article>

    <script>
        (() => {
            const finalizeUrl = @json($finalizeUrl);
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? '';
            let isFinalizing = false;
            let isFinalized = false;

            const finalizeExit = () => {
                if (!finalizeUrl || isFinalizing || isFinalized) {
                    return Promise.resolve();
                }

                isFinalizing = true;

                return fetch(finalizeUrl, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({}),
                }).then(() => {
                    isFinalized = true;
                }).catch(() => {
                    // Keep silent: finalization fallback is handled by sendBeacon on unload.
                }).finally(() => {
                    isFinalizing = false;
                });
            };

            if (finalizeUrl) {
                window.addEventListener('afterprint', () => {
                    finalizeExit().finally(() => {
                        window.close();
                    });
                });

                window.addEventListener('beforeunload', () => {
                    if (isFinalized || isFinalizing) {
                        return;
                    }

                    const payload = new FormData();
                    payload.append('_token', csrfToken);
                    navigator.sendBeacon(finalizeUrl, payload);
                });
            }

            window.addEventListener('load', () => {
                window.print();

                if (!finalizeUrl) {
                    setTimeout(() => {
                        window.close();
                    }, 350);
                }
            });
        })();
    </script>
</body>
</html>
