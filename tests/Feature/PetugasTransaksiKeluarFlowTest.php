<?php

namespace Tests\Feature;

use App\Models\AreaParkir;
use App\Models\Kendaraan;
use App\Models\Tarif;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PetugasTransaksiKeluarFlowTest extends TestCase
{
    use RefreshDatabase;

    protected User $petugas;

    protected AreaParkir $area;

    protected Tarif $tarif;

    protected Kendaraan $kendaraan;

    protected function setUp(): void
    {
        parent::setUp();

        $this->petugas = User::create([
            'nama_lengkap' => 'Petugas 1',
            'username' => 'petugas_flow',
            'password' => bcrypt('password123'),
            'role' => 'petugas',
            'status_aktif' => true,
        ]);

        $this->area = AreaParkir::create([
            'nama_area' => 'Area Keluar',
            'kapasitas' => 10,
            'terisi' => 1,
        ]);

        $this->tarif = Tarif::create([
            'jenis_kendaraan' => 'motor',
            'tarif_per_jam' => 5000,
        ]);

        $this->kendaraan = Kendaraan::create([
            'plat_nomor' => 'B1234ABC',
            'jenis_kendaraan' => 'motor',
            'warna' => 'hitam',
            'pemilik' => 'Pengguna Test',
            'id_user' => $this->petugas->id_user,
        ]);
    }

    public function test_status_kendaraan_belum_keluar_sampai_struk_selesai_dicetak(): void
    {
        $transaksi = Transaksi::create([
            'id_kendaraan' => $this->kendaraan->id_kendaraan,
            'waktu_masuk' => now()->subMinutes(30),
            'waktu_keluar' => null,
            'id_tarif' => $this->tarif->id_tarif,
            'durasi_jam' => 0,
            'biaya_total' => 0,
            'status' => 'masuk',
            'id_user' => $this->petugas->id_user,
            'id_area' => $this->area->id_area,
        ]);

        $this->actingAs($this->petugas)
            ->post(route('petugas.transaksi.process.keluar'), [
                'id_parkir' => $transaksi->id_parkir,
            ])
            ->assertSuccessful()
            ->assertViewIs('petugas.transaksi.keluar-cetak')
            ->assertSeeText('Cetak Struk');

        $this->assertDatabaseHas('tb_transaksi', [
            'id_parkir' => $transaksi->id_parkir,
            'status' => 'masuk',
            'waktu_keluar' => null,
        ]);

        $this->assertEquals(1, $this->area->fresh()->terisi);
        $this->assertNotEmpty(session('pending_transaksi_keluar'));
    }

    public function test_status_kendaraan_menjadi_keluar_setelah_window_cetak_ditutup(): void
    {
        $transaksi = Transaksi::create([
            'id_kendaraan' => $this->kendaraan->id_kendaraan,
            'waktu_masuk' => now()->subMinutes(30),
            'waktu_keluar' => null,
            'id_tarif' => $this->tarif->id_tarif,
            'durasi_jam' => 0,
            'biaya_total' => 0,
            'status' => 'masuk',
            'id_user' => $this->petugas->id_user,
            'id_area' => $this->area->id_area,
        ]);

        $this->actingAs($this->petugas)
            ->post(route('petugas.transaksi.process.keluar'), [
                'id_parkir' => $transaksi->id_parkir,
            ])
            ->assertSuccessful();

        $pending = session('pending_transaksi_keluar', []);
        $token = array_key_first($pending);

        $this->assertNotNull($token);

        $this->actingAs($this->petugas)
            ->post(route('petugas.transaksi.finalize.keluar', ['token' => $token]))
            ->assertNoContent();

        $this->actingAs($this->petugas)
            ->post(route('petugas.transaksi.finalize.keluar', ['token' => $token]))
            ->assertNoContent();

        $this->assertDatabaseHas('tb_transaksi', [
            'id_parkir' => $transaksi->id_parkir,
            'status' => 'keluar',
            'durasi_jam' => 1,
            'biaya_total' => 5000,
        ]);

        $this->assertEquals(0, $this->area->fresh()->terisi);
        $this->assertSame([], session('pending_transaksi_keluar', []));
    }
}
