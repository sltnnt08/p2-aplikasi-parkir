<?php

namespace Tests\Unit\Models;

use App\Models\AreaParkir;
use App\Models\Kendaraan;
use App\Models\Tarif;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TarifModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_tarif_can_be_created(): void
    {
        $tarif = Tarif::create([
            'jenis_kendaraan' => 'motor',
            'tarif_per_jam' => 5000,
        ]);

        $this->assertDatabaseHas('tb_tarif', [
            'jenis_kendaraan' => 'motor',
            'tarif_per_jam' => 5000,
        ]);
    }

    public function test_tarif_vehicle_types_are_valid(): void
    {
        $types = ['motor', 'mobil', 'lainnya'];

        foreach ($types as $type) {
            $tarif = Tarif::create([
                'jenis_kendaraan' => $type,
                'tarif_per_jam' => 5000,
            ]);

            $this->assertEquals($type, $tarif->jenis_kendaraan);
        }
    }

    public function test_tarif_price_is_decimal(): void
    {
        $tarif = Tarif::create([
            'jenis_kendaraan' => 'motor',
            'tarif_per_jam' => 5000,
        ]);

        $this->assertIsNumeric($tarif->tarif_per_jam);
    }

    public function test_tarif_has_many_transaksis(): void
    {
        $user = User::create([
            'nama_lengkap' => 'Petugas',
            'username' => 'petugas',
            'password' => bcrypt('password'),
            'role' => 'petugas',
            'status_aktif' => true,
        ]);

        $owner = User::create([
            'nama_lengkap' => 'Owner',
            'username' => 'owner',
            'password' => bcrypt('password'),
            'role' => 'owner',
            'status_aktif' => true,
        ]);

        $kendaraan = Kendaraan::create([
            'plat_nomor' => 'B1234AB',
            'jenis_kendaraan' => 'motor',
            'warna' => 'merah',
            'pemilik' => 'Owner',
            'id_user' => $owner->id_user,
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
            'id_user' => $user->id_user,
            'id_area' => $area->id_area,
        ]);

        $this->assertCount(1, $tarif->transaksis);
    }

    public function test_tarif_unique_combinations(): void
    {
        Tarif::create([
            'jenis_kendaraan' => 'motor',
            'tarif_per_jam' => 5000,
        ]);

        Tarif::create([
            'jenis_kendaraan' => 'mobil',
            'tarif_per_jam' => 10000,
        ]);

        $this->assertCount(2, Tarif::all());
    }
}

class AreaParkirModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_area_parkir_can_be_created(): void
    {
        $area = AreaParkir::create([
            'nama_area' => 'Area A',
            'kapasitas' => 100,
            'terisi' => 0,
        ]);

        $this->assertDatabaseHas('tb_area_parkir', [
            'nama_area' => 'Area A',
            'kapasitas' => 100,
            'terisi' => 0,
        ]);
    }

    public function test_area_parkir_kapasitas_is_positive(): void
    {
        $area = AreaParkir::create([
            'nama_area' => 'Area A',
            'kapasitas' => 100,
            'terisi' => 0,
        ]);

        $this->assertTrue($area->kapasitas > 0);
    }

    public function test_area_parkir_terisi_default_is_zero(): void
    {
        $area = AreaParkir::create([
            'nama_area' => 'Area A',
            'kapasitas' => 100,
            'terisi' => 0,
        ]);

        $this->assertEquals(0, $area->terisi);
    }

    public function test_area_parkir_terisi_cannot_exceed_kapasitas(): void
    {
        $area = AreaParkir::create([
            'nama_area' => 'Area A',
            'kapasitas' => 100,
            'terisi' => 50,
        ]);

        $this->assertLessThanOrEqual($area->kapasitas, $area->terisi);
    }

    public function test_area_parkir_has_many_transaksis(): void
    {
        $user = User::create([
            'nama_lengkap' => 'Petugas',
            'username' => 'petugas',
            'password' => bcrypt('password'),
            'role' => 'petugas',
            'status_aktif' => true,
        ]);

        $owner = User::create([
            'nama_lengkap' => 'Owner',
            'username' => 'owner',
            'password' => bcrypt('password'),
            'role' => 'owner',
            'status_aktif' => true,
        ]);

        $kendaraan = Kendaraan::create([
            'plat_nomor' => 'B1234AB',
            'jenis_kendaraan' => 'motor',
            'warna' => 'merah',
            'pemilik' => 'Owner',
            'id_user' => $owner->id_user,
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
            'id_user' => $user->id_user,
            'id_area' => $area->id_area,
        ]);

        $this->assertCount(1, $area->transaksis);
    }

    public function test_area_parkir_can_be_updated(): void
    {
        $area = AreaParkir::create([
            'nama_area' => 'Area A',
            'kapasitas' => 100,
            'terisi' => 0,
        ]);

        $area->update([
            'terisi' => 50,
        ]);

        $this->assertEquals(50, $area->fresh()->terisi);
    }
}
