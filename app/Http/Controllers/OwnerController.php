<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    public function dashboard()
    {
        $todayIncome = Transaksi::where('status', 'keluar')
            ->whereDate('waktu_keluar', today())
            ->sum('biaya_total');

        $monthIncome = Transaksi::where('status', 'keluar')
            ->whereMonth('waktu_keluar', now()->month)
            ->whereYear('waktu_keluar', now()->year)
            ->sum('biaya_total');

        return view('owner.dashboard', compact('todayIncome', 'monthIncome'));
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

        $transaksis = $query->orderBy('waktu_keluar', 'desc')->get();

        $totalIncome = $transaksis->sum('biaya_total');

        return view('owner.rekap', compact('transaksis', 'totalIncome'));
    }
}
