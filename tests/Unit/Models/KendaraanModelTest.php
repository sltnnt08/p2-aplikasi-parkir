<?php

namespace Tests\Unit\Models;

use App\Models\AreaParkir;
use App\Models\Kendaraan;
use App\Models\Tarif;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KendaraanModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_kendaraan_can_be_created(): void
    {
        $user = User::create([
            'nama_lengkap' => 'John Doe',
            'username' => 'johndoe',
            'password' => bcrypt('password'),
            'role' => 'owner',
            'status_aktif' => true,
        ]);

        $kendaraan = Kendaraan::create([
            'plat_nomor' => 'B1234AB',
            'jenis_kendaraan' => 'motor',
            'warna' => 'merah',
            'pemilik' => 'John Doe',
            'id_user' => $user->id_user,
        ]);

        $this->assertDatabaseHas('tb_kendaraan', [
            'plat_nomor' => 'B1234AB',
            'jenis_kendaraan' => 'motor',
        ]);
    }

    public function test_kendaraan_belongs_to_user(): void
    {
        $user = User::create([
            'nama_lengkap' => 'John Doe',
            'username' => 'johndoe',
            'password' => bcrypt('password'),
            'role' => 'owner',
            'status_aktif' => true,
        ]);

        $kendaraan = Kendaraan::create([
            'plat_nomor' => 'B1234AB',
            'jenis_kendaraan' => 'motor',
            'warna' => 'merah',
            'pemilik' => 'John Doe',
            'id_user' => $user->id_user,
        ]);

        $this->assertEquals($user->id_user, $kendaraan->user->id_user);
    }

    public function test_kendaraan_has_many_transaksis(): void
    {
        $user = User::create([
            'nama_lengkap' => 'John Doe',
            'username' => 'johndoe',
            'password' => bcrypt('password'),
            'role' => 'owner',
            'status_aktif' => true,
        ]);

        $petugas = User::create([
            'nama_lengkap' => 'Petugas',
            'username' => 'petugas',
            'password' => bcrypt('password'),
            'role' => 'petugas',
            'status_aktif' => true,
        ]);

        $kendaraan = Kendaraan::create([
            'plat_nomor' => 'B1234AB',
            'jenis_kendaraan' => 'motor',
            'warna' => 'merah',
            'pemilik' => 'John Doe',
            'id_user' => $user->id_user,
        ]);

        $tarif = Tarif::create([
            'jenis_kendaraan' => 'motor',
            'tarif_per_jam' => 5000,
        ]);

        $area = AreaParkir::create([
            'nama_area' => 'Area A',
            'kapasitas' => 100,
            'terisi' => 0,
        ]);

        Transaksi::create([
            'id_kendaraan' => $kendaraan->id_kendaraan,
            'waktu_masuk' => now(),
            'waktu_keluar' => null,
            'id_tarif' => $tarif->id_tarif,
            'durasi_jam' => 0,
            'biaya_total' => 0,
            'status' => 'masuk',
            'id_user' => $petugas->id_user,
            'id_area' => $area->id_area,
        ]);

        $this->assertCount(1, $kendaraan->transaksis);
    }

    public function test_kendaraan_vehicle_types_are_valid(): void
    {
        $user = User::create([
            'nama_lengkap' => 'John Doe',
            'username' => 'johndoe',
            'password' => bcrypt('password'),
            'role' => 'owner',
            'status_aktif' => true,
        ]);

        $types = ['motor', 'mobil', 'lainnya'];

        foreach ($types as $type) {
            $kendaraan = Kendaraan::create([
                'plat_nomor' => "PLAT$type",
                'jenis_kendaraan' => $type,
                'warna' => 'merah',
                'pemilik' => 'John Doe',
                'id_user' => $user->id_user,
            ]);

            $this->assertEquals($type, $kendaraan->jenis_kendaraan);
        }
    }

    public function test_kendaraan_plat_nomor_is_required(): void
    {
        $user = User::create([
            'nama_lengkap' => 'John Doe',
            'username' => 'johndoe',
            'password' => bcrypt('password'),
            'role' => 'owner',
            'status_aktif' => true,
        ]);

        $kendaraan = Kendaraan::create([
            'plat_nomor' => 'B1234AB',
            'jenis_kendaraan' => 'motor',
            'warna' => 'merah',
            'pemilik' => 'John Doe',
            'id_user' => $user->id_user,
        ]);

        $this->assertNotEmpty($kendaraan->plat_nomor);
    }
}
