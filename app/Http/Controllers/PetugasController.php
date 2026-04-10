<?php

namespace App\Http\Controllers;

use App\Models\AreaParkir;
use App\Models\Kendaraan;
use App\Models\Tarif;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $request->validate([
            'plat_nomor' => 'required|string|max:15',
            'id_area' => 'required|exists:tb_area_parkir,id_area',
            'id_tarif' => 'required|exists:tb_tarif,id_tarif',
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

                $kendaraan = Kendaraan::firstOrCreate(
                    ['plat_nomor' => $request->string('plat_nomor')->upper()->toString()],
                    [
                        'jenis_kendaraan' => $selectedTarif->jenis_kendaraan,
                        'warna' => 'Tidak diketahui',
                        'pemilik' => 'Tidak diketahui',
                        'id_user' => Auth::id(),
                    ]
                );

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

    public function transaksiKeluar()
    {
        return view('petugas.transaksi.keluar');
    }

    public function processTransaksiKeluar(Request $request)
    {
        $request->validate([
            'plat_nomor' => 'required|string|max:15',
        ]);

        $kendaraan = Kendaraan::where('plat_nomor', $request->plat_nomor)->first();
        if (! $kendaraan) {
            return back()->withErrors(['plat_nomor' => 'Kendaraan tidak ditemukan.']);
        }

        $transaksi = Transaksi::where('id_kendaraan', $kendaraan->id_kendaraan)
            ->where('status', 'masuk')
            ->first();
        if (! $transaksi) {
            return back()->withErrors(['plat_nomor' => 'Kendaraan tidak sedang parkir.']);
        }

        // Calculate duration and cost
        $waktuKeluar = now();
        $durasi = $transaksi->waktu_masuk->diffInHours($waktuKeluar, true); // ceil to next hour
        $durasi = ceil($durasi);
        $biaya = $durasi * $transaksi->tarif->tarif_per_jam;

        // Update transaction
        $transaksi->update([
            'waktu_keluar' => $waktuKeluar,
            'durasi_jam' => $durasi,
            'biaya_total' => $biaya,
            'status' => 'keluar',
        ]);

        // Update area terisi
        $transaksi->areaParkir->decrement('terisi');

        return view('petugas.transaksi.struk', compact('transaksi'));
    }

    public function cetakStruk(Transaksi $transaksi)
    {
        return view('petugas.transaksi.struk', compact('transaksi'));
    }
}
