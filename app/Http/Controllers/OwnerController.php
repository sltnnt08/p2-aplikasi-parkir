<?php

namespace App\Http\Controllers;

use App\Models\AreaParkir;
use App\Models\Transaksi;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    public function dashboard()
    {
        $todayIncome = Transaksi::where('status', 'keluar')
            ->whereDate('waktu_keluar', today())
            ->sum('biaya_total');

        $todayTransactions = Transaksi::where('status', 'keluar')
            ->whereDate('waktu_keluar', today())
            ->count();

        $monthIncome = Transaksi::where('status', 'keluar')
            ->whereMonth('waktu_keluar', now()->month)
            ->whereYear('waktu_keluar', now()->year)
            ->sum('biaya_total');

        $monthTransactions = Transaksi::where('status', 'keluar')
            ->whereMonth('waktu_keluar', now()->month)
            ->whereYear('waktu_keluar', now()->year)
            ->count();

        $totalCapacity = AreaParkir::sum('kapasitas');
        $totalFilled = AreaParkir::sum('terisi');
        $occupancyRate = $totalCapacity > 0 ? (int) round(($totalFilled / $totalCapacity) * 100) : 0;

        return view('owner.dashboard', compact('todayIncome', 'todayTransactions', 'monthIncome', 'monthTransactions', 'occupancyRate'));
    }

    public function rekapTransaksi(Request $request)
    {
        $filters = $this->validateRekapFilters($request);
        $query = $this->buildRekapQuery($filters);

        $totalIncome = (clone $query)->sum('biaya_total');
        $totalTransactions = (clone $query)->count();

        $transaksis = $query->orderBy('waktu_keluar', 'desc')->paginate(20)->withQueryString();

        return view('owner.rekap', compact('transaksis', 'totalIncome', 'totalTransactions'));
    }

    public function downloadRekapCsv(Request $request)
    {
        $filters = $this->validateRekapFilters($request);
        $transaksis = $this->buildRekapQuery($filters)
            ->with('user')
            ->orderBy('waktu_keluar', 'desc')
            ->get();

        $fileName = 'rekap-transaksi-'.now()->format('Ymd-His').'.csv';

        return response()->streamDownload(function () use ($transaksis) {
            $output = fopen('php://output', 'w');

            if ($output === false) {
                return;
            }

            fwrite($output, "\xEF\xBB\xBF");

            fputcsv($output, [
                'ID Parkir',
                'Plat Nomor',
                'Jenis Kendaraan',
                'Area Parkir',
                'Waktu Masuk',
                'Waktu Keluar',
                'Durasi (Jam)',
                'Tarif per Jam',
                'Biaya Total',
                'Petugas',
            ]);

            foreach ($transaksis as $transaksi) {
                fputcsv($output, [
                    $transaksi->id_parkir,
                    $transaksi->kendaraan?->plat_nomor ?? '-',
                    $transaksi->kendaraan?->jenis_kendaraan ?? '-',
                    $transaksi->areaParkir?->nama_area ?? '-',
                    $transaksi->waktu_masuk?->format('Y-m-d H:i:s') ?? '-',
                    $transaksi->waktu_keluar?->format('Y-m-d H:i:s') ?? '-',
                    $transaksi->durasi_jam ?? 0,
                    $transaksi->tarif?->tarif_per_jam ?? 0,
                    $transaksi->biaya_total ?? 0,
                    $transaksi->user?->nama_lengkap ?? '-',
                ]);
            }

            fclose($output);
        }, $fileName, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    private function validateRekapFilters(Request $request): array
    {
        return $request->validate([
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
        ]);
    }

    private function buildRekapQuery(array $filters): Builder
    {
        $query = Transaksi::with(['kendaraan', 'areaParkir', 'tarif'])
            ->where('status', 'keluar');

        if (! empty($filters['start_date'])) {
            $query->whereDate('waktu_keluar', '>=', $filters['start_date']);
        }

        if (! empty($filters['end_date'])) {
            $query->whereDate('waktu_keluar', '<=', $filters['end_date']);
        }

        return $query;
    }
}
