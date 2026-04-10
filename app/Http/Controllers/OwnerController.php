<?php

namespace App\Http\Controllers;

use App\Models\AreaParkir;
use App\Models\Transaksi;
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
        $query = Transaksi::with(['kendaraan', 'areaParkir', 'tarif'])
            ->where('status', 'keluar');

        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('waktu_keluar', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('waktu_keluar', '<=', $request->end_date);
        }

        $totalIncome = (clone $query)->sum('biaya_total');
        $totalTransactions = (clone $query)->count();

        $transaksis = $query->orderBy('waktu_keluar', 'desc')->paginate(20)->withQueryString();

        return view('owner.rekap', compact('transaksis', 'totalIncome', 'totalTransactions'));
    }
}
