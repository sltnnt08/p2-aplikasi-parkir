<?php

namespace Database\Seeders;

use App\Models\AreaParkir;
use App\Models\Tarif;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'nama_lengkap' => 'Administrator',
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'status_aktif' => true,
        ]);

        // Create petugas user
        User::create([
            'nama_lengkap' => 'Petugas Parkir',
            'username' => 'petugas',
            'password' => Hash::make('petugas123'),
            'role' => 'petugas',
            'status_aktif' => true,
        ]);

        // Create owner user
        User::create([
            'nama_lengkap' => 'Owner Parkir',
            'username' => 'owner',
            'password' => Hash::make('owner123'),
            'role' => 'owner',
            'status_aktif' => true,
        ]);

        // Create tarifs
        Tarif::create([
            'jenis_kendaraan' => 'motor',
            'tarif_per_jam' => 2000,
        ]);

        Tarif::create([
            'jenis_kendaraan' => 'mobil',
            'tarif_per_jam' => 5000,
        ]);

        Tarif::create([
            'jenis_kendaraan' => 'lainnya',
            'tarif_per_jam' => 10000,
        ]);

        // Create areas
        AreaParkir::create([
            'nama_area' => 'Area A',
            'kapasitas' => 50,
            'terisi' => 0,
        ]);

        AreaParkir::create([
            'nama_area' => 'Area B',
            'kapasitas' => 30,
            'terisi' => 0,
        ]);
    }
}
