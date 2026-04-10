@extends('layouts.app')

@section('title', 'Owner Dashboard')

@section('content')
<h2 class="text-2xl font-bold mb-6">Owner Dashboard</h2>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold">Pendapatan Hari Ini</h3>
        <p class="text-3xl font-bold text-green-600">Rp {{ number_format($todayIncome, 0, ',', '.') }}</p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold">Pendapatan Bulan Ini</h3>
        <p class="text-3xl font-bold text-blue-600">Rp {{ number_format($monthIncome, 0, ',', '.') }}</p>
    </div>
</div>

<div class="bg-white p-6 rounded-lg shadow">
    <h3 class="text-lg font-semibold mb-4">Menu</h3>
    <a href="{{ route('owner.rekap') }}" class="bg-purple-500 hover:bg-purple-700 text-white px-4 py-2 rounded inline-block">Rekap Transaksi</a>
</div>
@endsection
