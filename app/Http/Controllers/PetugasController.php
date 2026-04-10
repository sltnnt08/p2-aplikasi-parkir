<?php

namespace App\Http\Controllers;

use App\Models\AreaParkir;
use App\Models\Kendaraan;
use App\Models\Tarif;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PetugasController extends Controller
{
    public function dashboard()
    {
        $todayParked = Transaksi::where('status', 'masuk')
            ->whereDate('waktu_masuk', today())
            ->count();

        return view('petugas.dashboard', compact('todayParked'));
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

        // Check if area has capacity
        $area = AreaParkir::find($request->id_area);
        if ($area->terisi >= $area->kapasitas) {
            return back()->withErrors(['id_area' => 'Area parkir penuh.']);
        }

        // Check if vehicle exists, if not create
        $kendaraan = Kendaraan::where('plat_nomor', $request->plat_nomor)->first();
        if (!$kendaraan) {
            $kendaraan = Kendaraan::create([
                'plat_nomor' => $request->plat_nomor,
                'jenis_kendaraan' => 'unknown', // or ask for more info, but for simplicity
                'warna' => 'unknown',
                'pemilik' => 'unknown',
                'id_user' => Auth::id(),
            ]);
        }

        // Check if vehicle is already parked
        $existing = Transaksi::where('id_kendaraan', $kendaraan->id_kendaraan)
            ->where('status', 'masuk')
            ->first();
        if ($existing) {
            return back()->withErrors(['plat_nomor' => 'Kendaraan sudah parkir.']);
        }

        // Create transaction
        Transaksi::create([
            'id_kendaraan' => $kendaraan->id_kendaraan,
            'waktu_masuk' => now(),
            'id_tarif' => $request->id_tarif,
            'status' => 'masuk',
            'id_user' => Auth::id(),
            'id_area' => $request->id_area,
        ]);

        // Update area terisi
        $area->increment('terisi');

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
        if (!$kendaraan) {
            return back()->withErrors(['plat_nomor' => 'Kendaraan tidak ditemukan.']);
        }

        $transaksi = Transaksi::where('id_kendaraan', $kendaraan->id_kendaraan)
            ->where('status', 'masuk')
            ->first();
        if (!$transaksi) {
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
