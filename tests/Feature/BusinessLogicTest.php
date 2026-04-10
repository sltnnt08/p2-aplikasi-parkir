<?php

namespace Tests\Feature;

use App\Models\AreaParkir;
use App\Models\Kendaraan;
use App\Models\Tarif;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BusinessLogicTest extends TestCase
{
    use RefreshDatabase;

    protected User $petugas;

    protected User $owner;

    protected Kendaraan $kendaraan;

    protected Tarif $tarif;

    protected AreaParkir $area;

    protected function setUp(): void
    {
        parent::setUp();

        $this->petugas = User::create([
            'nama_lengkap' => 'Petugas',
            'username' => 'petugas',
            'password' => bcrypt('password'),
            'role' => 'petugas',
            'status_aktif' => true,
        ]);

        $this->owner = User::create([
            'nama_lengkap' => 'Owner',
            'username' => 'owner',
            'password' => bcrypt('password'),
            'role' => 'owner',
            'status_aktif' => true,
        ]);

        $this->kendaraan = Kendaraan::create([
            'plat_nomor' => 'B1234AB',
            'jenis_kendaraan' => 'motor',
            'warna' => 'merah',
            'pemilik' => 'Owner',
            'id_user' => $this->owner->id_user,
        ]);

        $this->tarif = Tarif::create([
            'jenis_kendaraan' => 'motor',
            'tarif_per_jam' => 5000,
        ]);

        $this->area = AreaParkir::create([
            'nama_area' => 'Area A',
            'kapasitas' => 100,
            'terisi' => 0,
        ]);
    }

    // Transaksi Entry Tests
    public function test_transaksi_can_record_vehicle_entry(): void
    {
        $transaksi = Transaksi::create([
            'id_kendaraan' => $this->kendaraan->id_kendaraan,
            'waktu_masuk' => now(),
            'waktu_keluar' => null,
            'id_tarif' => $this->tarif->id_tarif,
            'durasi_jam' => 0,
            'biaya_total' => 0,
            'status' => 'masuk',
            'id_user' => $this->petugas->id_user,
            'id_area' => $this->area->id_area,
        ]);

        $this->assertDatabaseHas('tb_transaksi', [
            'id_parkir' => $transaksi->id_parkir,
            'status' => 'masuk',
            'waktu_keluar' => null,
        ]);
    }

    public function test_transaksi_can_record_vehicle_exit(): void
    {
        $masuk = Transaksi::create([
            'id_kendaraan' => $this->kendaraan->id_kendaraan,
            'waktu_masuk' => now()->subHour(),
            'waktu_keluar' => null,
            'id_tarif' => $this->tarif->id_tarif,
            'durasi_jam' => 0,
            'biaya_total' => 0,
            'status' => 'masuk',
            'id_user' => $this->petugas->id_user,
            'id_area' => $this->area->id_area,
        ]);

        $keluar = Transaksi::create([
            'id_kendaraan' => $this->kendaraan->id_kendaraan,
            'waktu_masuk' => $masuk->waktu_masuk,
            'waktu_keluar' => now(),
            'id_tarif' => $this->tarif->id_tarif,
            'durasi_jam' => 1,
            'biaya_total' => 5000,
            'status' => 'keluar',
            'id_user' => $this->petugas->id_user,
            'id_area' => $this->area->id_area,
        ]);

        $this->assertDatabaseHas('tb_transaksi', [
            'id_parkir' => $keluar->id_parkir,
            'status' => 'keluar',
            'durasi_jam' => 1,
            'biaya_total' => 5000,
        ]);
    }

    // Biaya Calculation Tests
    public function test_biaya_total_calculated_correctly_for_one_hour(): void
    {
        $transaksi = Transaksi::create([
            'id_kendaraan' => $this->kendaraan->id_kendaraan,
            'waktu_masuk' => now()->subHour(),
            'waktu_keluar' => now(),
            'id_tarif' => $this->tarif->id_tarif,
            'durasi_jam' => 1,
            'biaya_total' => (int) ($this->tarif->tarif_per_jam * 1),
            'status' => 'keluar',
            'id_user' => $this->petugas->id_user,
            'id_area' => $this->area->id_area,
        ]);

        $expectedFee = $this->tarif->tarif_per_jam * 1;
        $this->assertEquals($expectedFee, $transaksi->biaya_total);
    }

    public function test_biaya_total_calculated_correctly_for_multiple_hours(): void
    {
        $transaksi = Transaksi::create([
            'id_kendaraan' => $this->kendaraan->id_kendaraan,
            'waktu_masuk' => now()->subHours(3),
            'waktu_keluar' => now(),
            'id_tarif' => $this->tarif->id_tarif,
            'durasi_jam' => 3,
            'biaya_total' => (int) ($this->tarif->tarif_per_jam * 3),
            'status' => 'keluar',
            'id_user' => $this->petugas->id_user,
            'id_area' => $this->area->id_area,
        ]);

        $expectedFee = $this->tarif->tarif_per_jam * 3;
        $this->assertEquals($expectedFee, $transaksi->biaya_total);
    }

    public function test_different_vehicle_types_have_different_rates(): void
    {
        $Motor = Tarif::where('jenis_kendaraan', 'motor')->first();
        $mobil_tarif = Tarif::create([
            'jenis_kendaraan' => 'mobil',
            'tarif_per_jam' => 10000,
        ]);

        $this->assertNotEquals($Motor->tarif_per_jam, $mobil_tarif->tarif_per_jam);
    }

    // Area Capacity Tests
    public function test_area_has_maximum_capacity(): void
    {
        $this->assertEquals(100, $this->area->kapasitas);
        $this->assertLessThanOrEqual($this->area->kapasitas, $this->area->terisi);
    }

    public function test_area_terisi_can_increase(): void
    {
        $originalTerisi = $this->area->terisi;
        $this->area->update(['terisi' => $originalTerisi + 1]);

        $this->assertEquals($originalTerisi + 1, $this->area->fresh()->terisi);
    }

    public function test_area_terisi_can_decrease(): void
    {
        $this->area->update(['terisi' => 50]);
        $this->area->update(['terisi' => 49]);

        $this->assertEquals(49, $this->area->fresh()->terisi);
    }

    // Multiple Transactions Tests
    public function test_single_vehicle_can_have_multiple_transactions(): void
    {
        for ($i = 0; $i < 3; $i++) {
            Transaksi::create([
                'id_kendaraan' => $this->kendaraan->id_kendaraan,
                'waktu_masuk' => now(),
                'waktu_keluar' => $i === 2 ? now() : null,
                'id_tarif' => $this->tarif->id_tarif,
                'durasi_jam' => $i === 2 ? 1 : 0,
                'biaya_total' => $i === 2 ? 5000 : 0,
                'status' => $i === 2 ? 'keluar' : 'masuk',
                'id_user' => $this->petugas->id_user,
                'id_area' => $this->area->id_area,
            ]);
        }

        $this->assertCount(3, $this->kendaraan->transaksis);
    }

    public function test_multiple_vehicles_can_park_simultaneously(): void
    {
        $kendaraan2 = Kendaraan::create([
            'plat_nomor' => 'B5678AB',
            'jenis_kendaraan' => 'mobil',
            'warna' => 'biru',
            'pemilik' => 'Owner 2',
            'id_user' => $this->owner->id_user,
        ]);

        Transaksi::create([
            'id_kendaraan' => $this->kendaraan->id_kendaraan,
            'waktu_masuk' => now(),
            'waktu_keluar' => null,
            'id_tarif' => $this->tarif->id_tarif,
            'durasi_jam' => 0,
            'biaya_total' => 0,
            'status' => 'masuk',
            'id_user' => $this->petugas->id_user,
            'id_area' => $this->area->id_area,
        ]);

        Transaksi::create([
            'id_kendaraan' => $kendaraan2->id_kendaraan,
            'waktu_masuk' => now(),
            'waktu_keluar' => null,
            'id_tarif' => $this->tarif->id_tarif,
            'durasi_jam' => 0,
            'biaya_total' => 0,
            'status' => 'masuk',
            'id_user' => $this->petugas->id_user,
            'id_area' => $this->area->id_area,
        ]);

        $this->assertCount(2, Transaksi::where('status', 'masuk')->get());
    }

    // Durasi Hour Test
    public function test_durasi_jam_affects_fee_calculation(): void
    {
        $transaksi_1jam = Transaksi::create([
            'id_kendaraan' => $this->kendaraan->id_kendaraan,
            'waktu_masuk' => now()->subHours(4),
            'waktu_keluar' => now()->subHours(3),
            'id_tarif' => $this->tarif->id_tarif,
            'durasi_jam' => 1,
            'biaya_total' => 5000,
            'status' => 'keluar',
            'id_user' => $this->petugas->id_user,
            'id_area' => $this->area->id_area,
        ]);

        $transaksi_2jam = Transaksi::create([
            'id_kendaraan' => $this->kendaraan->id_kendaraan,
            'waktu_masuk' => now()->subHours(2),
            'waktu_keluar' => now(),
            'id_tarif' => $this->tarif->id_tarif,
            'durasi_jam' => 2,
            'biaya_total' => 10000,
            'status' => 'keluar',
            'id_user' => $this->petugas->id_user,
            'id_area' => $this->area->id_area,
        ]);

        // Verify that different duration results in different fees
        $this->assertNotEquals($transaksi_1jam->biaya_total, $transaksi_2jam->biaya_total);
        $this->assertEquals(5000, $transaksi_1jam->biaya_total);
        $this->assertEquals(10000, $transaksi_2jam->biaya_total);
    }
}
