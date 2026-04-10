@extends('layouts.app')

@section('title', 'Petugas Dashboard')

@section('content')
<h2 class="text-2xl font-bold mb-6">Petugas Dashboard</h2>

<div class="bg-white p-6 rounded-lg shadow mb-8">
    <h3 class="text-lg font-semibold">Kendaraan Parkir Hari Ini</h3>
    <p class="text-3xl font-bold text-blue-600">{{ $todayParked }}</p>
</div>

<div class="bg-white p-6 rounded-lg shadow">
    <h3 class="text-lg font-semibold mb-4">Menu</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <a href="{{ route('petugas.transaksi.masuk') }}" class="bg-green-500 hover:bg-green-700 text-white px-4 py-2 rounded text-center">Kendaraan Masuk</a>
        <a href="{{ route('petugas.transaksi.keluar') }}" class="bg-red-500 hover:bg-red-700 text-white px-4 py-2 rounded text-center">Kendaraan Keluar</a>
    </div>
</div>
@endsection
