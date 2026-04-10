<?php

namespace Tests\Unit\Models;

use App\Models\AreaParkir;
use App\Models\Kendaraan;
use App\Models\Tarif;
use App\Models\Transaksi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransaksiModelTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create required related records
        $this->user = User::create([
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

    public function test_transaksi_can_be_created(): void
    {
        $transaksi = Transaksi::create([
            'id_kendaraan' => $this->kendaraan->id_kendaraan,
            'waktu_masuk' => now(),
            'waktu_keluar' => null,
            'id_tarif' => $this->tarif->id_tarif,
            'durasi_jam' => 0,
            'biaya_total' => 0,
            'status' => 'masuk',
            'id_user' => $this->user->id_user,
            'id_area' => $this->area->id_area,
        ]);

        $this->assertDatabaseHas('tb_transaksi', [
            'id_kendaraan' => $this->kendaraan->id_kendaraan,
            'status' => 'masuk',
        ]);
    }

    public function test_transaksi_belongs_to_kendaraan(): void
    {
        $transaksi = Transaksi::create([
            'id_kendaraan' => $this->kendaraan->id_kendaraan,
            'waktu_masuk' => now(),
            'waktu_keluar' => null,
            'id_tarif' => $this->tarif->id_tarif,
            'durasi_jam' => 0,
            'biaya_total' => 0,
            'status' => 'masuk',
            'id_user' => $this->user->id_user,
            'id_area' => $this->area->id_area,
        ]);

        $this->assertEquals($this->kendaraan->id_kendaraan, $transaksi->kendaraan->id_kendaraan);
    }

    public function test_transaksi_belongs_to_tarif(): void
    {
        $transaksi = Transaksi::create([
            'id_kendaraan' => $this->kendaraan->id_kendaraan,
            'waktu_masuk' => now(),
            'waktu_keluar' => null,
            'id_tarif' => $this->tarif->id_tarif,
            'durasi_jam' => 0,
            'biaya_total' => 0,
            'status' => 'masuk',
            'id_user' => $this->user->id_user,
            'id_area' => $this->area->id_area,
        ]);

        $this->assertEquals($this->tarif->id_tarif, $transaksi->tarif->id_tarif);
    }

    public function test_transaksi_belongs_to_user(): void
    {
        $transaksi = Transaksi::create([
            'id_kendaraan' => $this->kendaraan->id_kendaraan,
            'waktu_masuk' => now(),
            'waktu_keluar' => null,
            'id_tarif' => $this->tarif->id_tarif,
            'durasi_jam' => 0,
            'biaya_total' => 0,
            'status' => 'masuk',
            'id_user' => $this->user->id_user,
            'id_area' => $this->area->id_area,
        ]);

        $this->assertEquals($this->user->id_user, $transaksi->user->id_user);
    }

    public function test_transaksi_belongs_to_area_parkir(): void
    {
        $transaksi = Transaksi::create([
            'id_kendaraan' => $this->kendaraan->id_kendaraan,
            'waktu_masuk' => now(),
            'waktu_keluar' => null,
            'id_tarif' => $this->tarif->id_tarif,
            'durasi_jam' => 0,
            'biaya_total' => 0,
            'status' => 'masuk',
            'id_user' => $this->user->id_user,
            'id_area' => $this->area->id_area,
        ]);

        $this->assertEquals($this->area->id_area, $transaksi->areaParkir->id_area);
    }

    public function test_transaksi_status_can_be_masuk_or_keluar(): void
    {
        $transaksi_masuk = Transaksi::create([
            'id_kendaraan' => $this->kendaraan->id_kendaraan,
            'waktu_masuk' => now(),
            'waktu_keluar' => null,
            'id_tarif' => $this->tarif->id_tarif,
            'durasi_jam' => 0,
            'biaya_total' => 0,
            'status' => 'masuk',
            'id_user' => $this->user->id_user,
            'id_area' => $this->area->id_area,
        ]);

        $transaksi_keluar = Transaksi::create([
            'id_kendaraan' => $this->kendaraan->id_kendaraan,
            'waktu_masuk' => now()->subHour(),
            'waktu_keluar' => now(),
            'id_tarif' => $this->tarif->id_tarif,
            'durasi_jam' => 1,
            'biaya_total' => 5000,
            'status' => 'keluar',
            'id_user' => $this->user->id_user,
            'id_area' => $this->area->id_area,
        ]);

        $this->assertEquals('masuk', $transaksi_masuk->status);
        $this->assertEquals('keluar', $transaksi_keluar->status);
    }

    public function test_transaksi_waktu_masuk_is_datetime(): void
    {
        $now = now();
        $transaksi = Transaksi::create([
            'id_kendaraan' => $this->kendaraan->id_kendaraan,
            'waktu_masuk' => $now,
            'waktu_keluar' => null,
            'id_tarif' => $this->tarif->id_tarif,
            'durasi_jam' => 0,
            'biaya_total' => 0,
            'status' => 'masuk',
            'id_user' => $this->user->id_user,
            'id_area' => $this->area->id_area,
        ]);

        $this->assertTrue($transaksi->waktu_masuk instanceof Carbon);
    }

    public function test_transaksi_biaya_total_is_decimal(): void
    {
        $transaksi = Transaksi::create([
            'id_kendaraan' => $this->kendaraan->id_kendaraan,
            'waktu_masuk' => now()->subHour(),
            'waktu_keluar' => now(),
            'id_tarif' => $this->tarif->id_tarif,
            'durasi_jam' => 1,
            'biaya_total' => 5000,
            'status' => 'keluar',
            'id_user' => $this->user->id_user,
            'id_area' => $this->area->id_area,
        ]);

        $this->assertIsNumeric($transaksi->biaya_total);
    }
}
