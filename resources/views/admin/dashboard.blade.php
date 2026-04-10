@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<h2 class="text-2xl font-bold mb-6">Admin Dashboard</h2>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold">Total Users</h3>
        <p class="text-3xl font-bold text-blue-600">{{ $totalUsers }}</p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold">Total Tarifs</h3>
        <p class="text-3xl font-bold text-green-600">{{ $totalTarifs }}</p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold">Total Areas</h3>
        <p class="text-3xl font-bold text-purple-600">{{ $totalAreas }}</p>
    </div>
</div>

<div class="bg-white p-6 rounded-lg shadow">
    <h3 class="text-lg font-semibold mb-4">Menu</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <a href="{{ route('admin.users') }}" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded text-center">Manage Users</a>
        <a href="{{ route('admin.tarifs') }}" class="bg-green-500 hover:bg-green-700 text-white px-4 py-2 rounded text-center">Manage Tarifs</a>
        <a href="{{ route('admin.areas') }}" class="bg-purple-500 hover:bg-purple-700 text-white px-4 py-2 rounded text-center">Manage Areas</a>
        <a href="{{ route('admin.kendaraans') }}" class="bg-yellow-500 hover:bg-yellow-700 text-white px-4 py-2 rounded text-center">Manage Kendaraans</a>
        <a href="{{ route('admin.logs') }}" class="bg-red-500 hover:bg-red-700 text-white px-4 py-2 rounded text-center">View Logs</a>
    </div>
</div>
@endsection
