<?php

namespace App\Http\Controllers;

use App\Models\AreaParkir;
use App\Models\Kendaraan;
use App\Models\Tarif;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class PetugasController extends Controller
{
    public function dashboard()
    {
        $todayParked = Transaksi::where('status', 'masuk')
            ->whereDate('waktu_masuk', today())
            ->count();

        $availableSlots = AreaParkir::query()
            ->selectRaw('COALESCE(SUM(kapasitas - terisi), 0) as total_available')
            ->value('total_available');

        return view('petugas.dashboard', compact('todayParked', 'availableSlots'));
    }

    public function transaksiMasuk()
    {
        $areas = AreaParkir::all();
        $tarifs = Tarif::all();

        return view('petugas.transaksi.masuk', compact('areas', 'tarifs'));
    }

    public function storeTransaksiMasuk(Request $request)
    {
        $request->merge([
            'plat_nomor' => Kendaraan::normalizePlatNomor($request->input('plat_nomor')),
        ]);

        $request->validate([
            'plat_nomor' => ['required', 'string', 'max:15', 'regex:'.Kendaraan::INDONESIA_PLATE_NUMBER_REGEX],
            'warna' => 'required|string|max:20|regex:/\S/',
            'pemilik' => 'nullable|string|max:100|regex:/\S/',
            'id_area' => 'required|exists:tb_area_parkir,id_area',
            'id_tarif' => 'required|exists:tb_tarif,id_tarif',
        ], [
            'plat_nomor.regex' => 'Format plat nomor tidak valid. Contoh: B 1234 ABC.',
        ]);

        try {
            DB::transaction(function () use ($request): void {
                $area = AreaParkir::whereKey($request->integer('id_area'))->lockForUpdate()->firstOrFail();

                if ($area->terisi >= $area->kapasitas) {
                    throw ValidationException::withMessages([
                        'id_area' => 'Area parkir penuh.',
                    ]);
                }

                $selectedTarif = Tarif::findOrFail($request->integer('id_tarif'));
                $pemilik = $request->string('pemilik')->trim()->toString();

                $kendaraan = Kendaraan::firstOrCreate(
                    ['plat_nomor' => $request->string('plat_nomor')->toString()],
                    [
                        'jenis_kendaraan' => $selectedTarif->jenis_kendaraan,
                        'warna' => $request->string('warna')->trim()->toString(),
                        'pemilik' => $pemilik !== '' ? $pemilik : 'Tidak diketahui',
                        'id_user' => Auth::id(),
                    ]
                );

                if ($pemilik !== '' && $kendaraan->pemilik !== $pemilik) {
                    $kendaraan->update([
                        'pemilik' => $pemilik,
                    ]);
                }

                $existing = Transaksi::where('id_kendaraan', $kendaraan->id_kendaraan)
                    ->where('status', 'masuk')
                    ->lockForUpdate()
                    ->exists();

                if ($existing) {
                    throw ValidationException::withMessages([
                        'plat_nomor' => 'Kendaraan sudah parkir.',
                    ]);
                }

                Transaksi::create([
                    'id_kendaraan' => $kendaraan->id_kendaraan,
                    'waktu_masuk' => now(),
                    'id_tarif' => $selectedTarif->id_tarif,
                    'status' => 'masuk',
                    'id_user' => Auth::id(),
                    'id_area' => $area->id_area,
                ]);

                $area->increment('terisi');
            });
        } catch (ValidationException $exception) {
            return back()->withErrors($exception->errors())->withInput();
        }

        return redirect()->route('petugas.transaksi.masuk')->with('success', 'Kendaraan berhasil masuk.');
    }

    public function transaksiKeluar(Request $request)
    {
        $searchPlate = Kendaraan::normalizePlatNomor($request->string('search')->toString());

        $activeParkings = Transaksi::query()
            ->with([
                'kendaraan:id_kendaraan,plat_nomor,jenis_kendaraan',
                'areaParkir:id_area,nama_area',
                'tarif:id_tarif,tarif_per_jam',
            ])
            ->where('status', 'masuk')
            ->when($searchPlate !== '', function ($query) use ($searchPlate): void {
                $query->whereHas('kendaraan', function ($kendaraanQuery) use ($searchPlate): void {
                    $kendaraanQuery->whereRaw('REPLACE(plat_nomor, " ", "") like ?', ['%'.$searchPlate.'%']);
                });
            })
            ->orderByDesc('waktu_masuk')
            ->paginate(10)
            ->withQueryString();

        return view('petugas.transaksi.keluar', compact('activeParkings', 'searchPlate'));
    }

    public function processTransaksiKeluar(Request $request)
    {
        if ($request->filled('plat_nomor')) {
            $request->merge([
                'plat_nomor' => Kendaraan::normalizePlatNomor($request->input('plat_nomor')),
            ]);
        }

        $validated = $request->validate([
            'id_parkir' => 'nullable|integer|exists:tb_transaksi,id_parkir',
            'plat_nomor' => ['nullable', 'string', 'max:15', 'regex:'.Kendaraan::INDONESIA_PLATE_NUMBER_REGEX],
        ], [
            'plat_nomor.regex' => 'Format plat nomor tidak valid. Contoh: B 1234 ABC.',
        ]);

        if (blank($validated['id_parkir'] ?? null) && blank($validated['plat_nomor'] ?? null)) {
            throw ValidationException::withMessages([
                'plat_nomor' => 'Pilih kendaraan dari tabel atau masukkan plat nomor.',
            ]);
        }

        try {
            $transaksi = $this->resolveActiveTransaction($validated);
        } catch (ValidationException $exception) {
            return back()->withErrors($exception->errors())->withInput();
        }

        $waktuKeluar = now();
        $durasiMenit = max(1, $transaksi->waktu_masuk->diffInMinutes($waktuKeluar));
        $durasi = (int) ceil($durasiMenit / 60);
        $biaya = (int) ($durasi * $transaksi->tarif->tarif_per_jam);

        $token = (string) Str::uuid();
        $pendingTransaksiKeluar = $request->session()->get('pending_transaksi_keluar', []);
        $pendingTransaksiKeluar[$token] = [
            'id_parkir' => $transaksi->id_parkir,
            'waktu_keluar' => $waktuKeluar->toIso8601String(),
            'durasi_jam' => $durasi,
            'biaya_total' => $biaya,
        ];
        $request->session()->put('pending_transaksi_keluar', $pendingTransaksiKeluar);

        return view('petugas.transaksi.keluar-cetak', [
            'transaksi' => $transaksi,
            'waktuKeluar' => $waktuKeluar,
            'durasi' => $durasi,
            'biaya' => $biaya,
            'printUrl' => route('petugas.transaksi.pending.struk', ['token' => $token]),
            'backUrl' => route('petugas.transaksi.keluar'),
        ]);
    }

    public function cetakStrukPending(Request $request, string $token)
    {
        $pendingTransaksi = $this->getPendingTransaksiKeluar($request, $token);

        if (! $pendingTransaksi) {
            abort(404);
        }

        $transaksi = Transaksi::with(['kendaraan', 'tarif', 'areaParkir'])
            ->whereKey($pendingTransaksi['id_parkir'])
            ->where('status', 'masuk')
            ->first();

        if (! $transaksi) {
            abort(404);
        }

        return view('petugas.transaksi.struk-print', [
            'transaksi' => $transaksi,
            'waktuKeluar' => Carbon::parse($pendingTransaksi['waktu_keluar']),
            'durasi' => $pendingTransaksi['durasi_jam'],
            'biaya' => $pendingTransaksi['biaya_total'],
            'finalizeUrl' => route('petugas.transaksi.finalize.keluar', ['token' => $token]),
        ]);
    }

    public function finalizeTransaksiKeluar(Request $request, string $token): Response
    {
        $pendingTransaksiKeluar = $request->session()->get('pending_transaksi_keluar', []);

        if (! isset($pendingTransaksiKeluar[$token])) {
            return response()->noContent();
        }

        $pendingTransaksi = $pendingTransaksiKeluar[$token];

        DB::transaction(function () use ($pendingTransaksi): void {
            $transaksi = Transaksi::with('areaParkir')
                ->lockForUpdate()
                ->find($pendingTransaksi['id_parkir']);

            if (! $transaksi || $transaksi->status !== 'masuk') {
                return;
            }

            $transaksi->update([
                'waktu_keluar' => Carbon::parse($pendingTransaksi['waktu_keluar']),
                'durasi_jam' => $pendingTransaksi['durasi_jam'],
                'biaya_total' => $pendingTransaksi['biaya_total'],
                'status' => 'keluar',
            ]);

            if ($transaksi->areaParkir && $transaksi->areaParkir->terisi > 0) {
                $transaksi->areaParkir->decrement('terisi');
            }
        });

        unset($pendingTransaksiKeluar[$token]);
        $request->session()->put('pending_transaksi_keluar', $pendingTransaksiKeluar);

        return response()->noContent();
    }

    public function cetakStruk(Transaksi $transaksi)
    {
        $transaksi->loadMissing(['kendaraan', 'tarif', 'areaParkir']);

        if ($transaksi->status !== 'keluar' || ! $transaksi->waktu_keluar) {
            abort(404);
        }

        return view('petugas.transaksi.struk-print', [
            'transaksi' => $transaksi,
            'waktuKeluar' => $transaksi->waktu_keluar,
            'durasi' => $transaksi->durasi_jam,
            'biaya' => $transaksi->biaya_total,
            'finalizeUrl' => null,
        ]);
    }

    private function resolveActiveTransaction(array $validated): Transaksi
    {
        $query = Transaksi::query()
            ->with(['kendaraan', 'tarif', 'areaParkir'])
            ->where('status', 'masuk');

        if (! blank($validated['id_parkir'] ?? null)) {
            $query->whereKey((int) $validated['id_parkir']);
        } else {
            $plate = Kendaraan::normalizePlatNomor((string) ($validated['plat_nomor'] ?? ''));

            $query->whereHas('kendaraan', function ($kendaraanQuery) use ($plate): void {
                $kendaraanQuery->whereRaw('REPLACE(plat_nomor, " ", "") = ?', [$plate]);
            });
        }

        $activeTransaction = $query->first();

        if (! $activeTransaction) {
            throw ValidationException::withMessages([
                'plat_nomor' => 'Kendaraan tidak sedang parkir.',
            ]);
        }

        return $activeTransaction;
    }

    private function getPendingTransaksiKeluar(Request $request, string $token): ?array
    {
        $pendingTransaksiKeluar = $request->session()->get('pending_transaksi_keluar', []);

        return $pendingTransaksiKeluar[$token] ?? null;
    }
}
