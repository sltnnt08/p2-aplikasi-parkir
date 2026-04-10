<?php

namespace Tests\Feature;

use App\Models\AreaParkir;
use App\Models\Kendaraan;
use App\Models\Tarif;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OwnerRekapCsvDownloadTest extends TestCase
{
    use RefreshDatabase;

    public function test_owner_can_download_rekap_csv_based_on_active_date_filter(): void
    {
        $owner = User::create([
            'nama_lengkap' => 'Owner Laporan',
            'username' => 'owner-laporan',
            'password' => bcrypt('password123'),
            'role' => 'owner',
            'status_aktif' => true,
        ]);

        $petugas = User::create([
            'nama_lengkap' => 'Petugas Export',
            'username' => 'petugas-export',
            'password' => bcrypt('password123'),
            'role' => 'petugas',
            'status_aktif' => true,
        ]);

        $area = AreaParkir::create([
            'nama_area' => 'Area Owner',
            'kapasitas' => 20,
            'terisi' => 3,
        ]);

        $tarif = Tarif::create([
            'id_area' => $area->id_area,
            'jenis_kendaraan' => 'motor',
            'tarif_per_jam' => 5000,
        ]);

        $kendaraanInRange = Kendaraan::create([
            'plat_nomor' => 'B 1234 ABC',
            'jenis_kendaraan' => 'motor',
            'warna' => 'hitam',
            'pemilik' => 'Pemilik A',
            'id_user' => $owner->id_user,
        ]);

        $kendaraanOutOfRange = Kendaraan::create([
            'plat_nomor' => 'B 5678 XYZ',
            'jenis_kendaraan' => 'motor',
            'warna' => 'putih',
            'pemilik' => 'Pemilik B',
            'id_user' => $owner->id_user,
        ]);

        Transaksi::create([
            'id_kendaraan' => $kendaraanInRange->id_kendaraan,
            'waktu_masuk' => now()->subHours(3),
            'waktu_keluar' => now()->subHours(1),
            'id_tarif' => $tarif->id_tarif,
            'durasi_jam' => 2,
            'biaya_total' => 10000,
            'status' => 'keluar',
            'id_user' => $petugas->id_user,
            'id_area' => $area->id_area,
        ]);

        Transaksi::create([
            'id_kendaraan' => $kendaraanOutOfRange->id_kendaraan,
            'waktu_masuk' => now()->subDays(10)->subHours(2),
            'waktu_keluar' => now()->subDays(10),
            'id_tarif' => $tarif->id_tarif,
            'durasi_jam' => 2,
            'biaya_total' => 10000,
            'status' => 'keluar',
            'id_user' => $petugas->id_user,
            'id_area' => $area->id_area,
        ]);

        Transaksi::create([
            'id_kendaraan' => $kendaraanInRange->id_kendaraan,
            'waktu_masuk' => now()->subMinutes(20),
            'waktu_keluar' => null,
            'id_tarif' => $tarif->id_tarif,
            'durasi_jam' => null,
            'biaya_total' => null,
            'status' => 'masuk',
            'id_user' => $petugas->id_user,
            'id_area' => $area->id_area,
        ]);

        $response = $this->actingAs($owner)->get(route('owner.rekap.download-csv', [
            'start_date' => now()->subDays(2)->toDateString(),
            'end_date' => now()->toDateString(),
        ]));

        $response->assertSuccessful();
        $response->assertHeader('content-type', 'text/csv; charset=UTF-8');
        $response->assertHeader('content-disposition');

        $csvContent = $response->streamedContent();

        $this->assertStringContainsString('"ID Parkir","Plat Nomor","Jenis Kendaraan","Area Parkir"', $csvContent);
        $this->assertStringContainsString('B1234ABC', $csvContent);
        $this->assertStringNotContainsString('B5678XYZ', $csvContent);
        $this->assertStringNotContainsString(',masuk,', $csvContent);
    }

    public function test_non_owner_cannot_download_owner_rekap_csv(): void
    {
        $petugas = User::create([
            'nama_lengkap' => 'Petugas Biasa',
            'username' => 'petugas-biasa',
            'password' => bcrypt('password123'),
            'role' => 'petugas',
            'status_aktif' => true,
        ]);

        $response = $this->actingAs($petugas)->get(route('owner.rekap.download-csv'));

        $response->assertForbidden();
    }
}
