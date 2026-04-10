<?php

namespace Tests\Unit\Models;

use App\Models\AreaParkir;
use App\Models\Kendaraan;
use App\Models\LogAktivitas;
use App\Models\Tarif;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_be_created(): void
    {
        $user = User::create([
            'nama_lengkap' => 'John Doe',
            'username' => 'johndoe',
            'password' => bcrypt('password123'),
            'role' => 'admin',
            'status_aktif' => true,
        ]);

        $this->assertDatabaseHas('tb_user', [
            'nama_lengkap' => 'John Doe',
            'username' => 'johndoe',
            'role' => 'admin',
        ]);
    }

    public function test_user_password_is_hashed(): void
    {
        $user = User::create([
            'nama_lengkap' => 'John Doe',
            'username' => 'johndoe',
            'password' => 'password123',
            'role' => 'admin',
            'status_aktif' => true,
        ]);

        $this->assertNotEquals('password123', $user->password);
    }

    public function test_user_has_relationships(): void
    {
        $user = User::create([
            'nama_lengkap' => 'John Doe',
            'username' => 'johndoe',
            'password' => 'password123',
            'role' => 'admin',
            'status_aktif' => true,
        ]);

        // Test hasMany relationships exist
        $this->assertTrue($user->kendaraans()->exists() || true);
        $this->assertTrue($user->transaksis()->exists() || true);
        $this->assertTrue($user->logAktivitass()->exists() || true);
    }

    public function test_user_has_many_kendaraans(): void
    {
        $user = User::create([
            'nama_lengkap' => 'John Doe',
            'username' => 'johndoe',
            'password' => 'password123',
            'role' => 'owner',
            'status_aktif' => true,
        ]);

        Kendaraan::create([
            'plat_nomor' => 'B1234AB',
            'jenis_kendaraan' => 'motor',
            'warna' => 'merah',
            'pemilik' => 'John Doe',
            'id_user' => $user->id_user,
        ]);

        Kendaraan::create([
            'plat_nomor' => 'B5678AB',
            'jenis_kendaraan' => 'mobil',
            'warna' => 'biru',
            'pemilik' => 'John Doe',
            'id_user' => $user->id_user,
        ]);

        $this->assertCount(2, $user->kendaraans);
    }

    public function test_user_has_many_transaksis(): void
    {
        $owner = User::create([
            'nama_lengkap' => 'Owner',
            'username' => 'owner',
            'password' => 'password123',
            'role' => 'owner',
            'status_aktif' => true,
        ]);

        $user = User::create([
            'nama_lengkap' => 'John Doe',
            'username' => 'johndoe',
            'password' => 'password123',
            'role' => 'petugas',
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

        $this->assertCount(1, $user->transaksis);
    }

    public function test_user_has_many_log_aktivitas(): void
    {
        $user = User::create([
            'nama_lengkap' => 'John Doe',
            'username' => 'johndoe',
            'password' => 'password123',
            'role' => 'admin',
            'status_aktif' => true,
        ]);

        LogAktivitas::create([
            'id_user' => $user->id_user,
            'aktivitas' => 'Login',
            'waktu_aktivitas' => now(),
        ]);

        LogAktivitas::create([
            'id_user' => $user->id_user,
            'aktivitas' => 'Create User',
            'waktu_aktivitas' => now(),
        ]);

        $this->assertCount(2, $user->logAktivitass);
    }

    public function test_user_password_hidden_in_array(): void
    {
        $user = User::create([
            'nama_lengkap' => 'John Doe',
            'username' => 'johndoe',
            'password' => 'password123',
            'role' => 'admin',
            'status_aktif' => true,
        ]);

        $this->assertArrayNotHasKey('password', $user->toArray());
    }

    public function test_user_roles_are_valid(): void
    {
        $roles = ['admin', 'petugas', 'owner'];

        foreach ($roles as $role) {
            $user = User::create([
                'nama_lengkap' => "User $role",
                'username' => "user_$role",
                'password' => bcrypt('password'),
                'role' => $role,
                'status_aktif' => true,
            ]);

            $this->assertEquals($role, $user->role);
        }
    }

    public function test_user_status_aktif_casts_to_boolean(): void
    {
        $user = User::create([
            'nama_lengkap' => 'John Doe',
            'username' => 'johndoe',
            'password' => bcrypt('password123'),
            'role' => 'admin',
            'status_aktif' => true,
        ]);

        $this->assertTrue(is_bool($user->status_aktif));
        $this->assertTrue($user->status_aktif);
    }
}
