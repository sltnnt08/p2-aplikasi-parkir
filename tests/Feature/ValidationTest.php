<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ValidationTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::create([
            'nama_lengkap' => 'Admin',
            'username' => 'admin',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'status_aktif' => true,
        ]);
    }

    // User Validation Tests
    public function test_user_nama_lengkap_is_required(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/users', [
            'username' => 'newuser',
            'password' => 'password123',
            'role' => 'petugas',
            'status_aktif' => true,
        ]);

        $response->assertSessionHasErrors('nama_lengkap');
    }

    public function test_user_nama_lengkap_max_length_is_50(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/users', [
            'nama_lengkap' => str_repeat('a', 51),
            'username' => 'newuser',
            'password' => 'password123',
            'role' => 'petugas',
            'status_aktif' => true,
        ]);

        $response->assertSessionHasErrors('nama_lengkap');
    }

    public function test_user_username_is_required(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/users', [
            'nama_lengkap' => 'New User',
            'password' => 'password123',
            'role' => 'petugas',
            'status_aktif' => true,
        ]);

        $response->assertSessionHasErrors('username');
    }

    public function test_user_username_must_be_unique(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/users', [
            'nama_lengkap' => 'Duplicate',
            'username' => 'admin',
            'password' => 'password123',
            'role' => 'petugas',
            'status_aktif' => true,
        ]);

        $response->assertSessionHasErrors('username');
    }

    public function test_user_password_is_required_on_create(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/users', [
            'nama_lengkap' => 'New User',
            'username' => 'newuser',
            'role' => 'petugas',
            'status_aktif' => true,
        ]);

        $response->assertSessionHasErrors('password');
    }

    public function test_user_password_minimum_length_is_6(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/users', [
            'nama_lengkap' => 'New User',
            'username' => 'newuser',
            'password' => '12345',
            'role' => 'petugas',
            'status_aktif' => true,
        ]);

        $response->assertSessionHasErrors('password');
    }

    public function test_user_role_is_required(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/users', [
            'nama_lengkap' => 'New User',
            'username' => 'newuser',
            'password' => 'password123',
            'status_aktif' => true,
        ]);

        $response->assertSessionHasErrors('role');
    }

    public function test_user_role_must_be_valid(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/users', [
            'nama_lengkap' => 'New User',
            'username' => 'newuser',
            'password' => 'password123',
            'role' => 'invalid_role',
            'status_aktif' => true,
        ]);

        $response->assertSessionHasErrors('role');
    }

    // Tarif Validation Tests
    public function test_tarif_jenis_kendaraan_is_required(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/tarifs', [
            'tarif_per_jam' => 5000,
        ]);

        $response->assertSessionHasErrors('jenis_kendaraan');
    }

    public function test_tarif_jenis_kendaraan_must_be_valid(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/tarifs', [
            'jenis_kendaraan' => 'invalid',
            'tarif_per_jam' => 5000,
        ]);

        $response->assertSessionHasErrors('jenis_kendaraan');
    }

    public function test_tarif_tarif_per_jam_is_required(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/tarifs', [
            'jenis_kendaraan' => 'motor',
        ]);

        $response->assertSessionHasErrors('tarif_per_jam');
    }

    public function test_tarif_tarif_per_jam_must_be_numeric(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/tarifs', [
            'jenis_kendaraan' => 'motor',
            'tarif_per_jam' => 'abc',
        ]);

        $response->assertSessionHasErrors('tarif_per_jam');
    }

    public function test_tarif_tarif_per_jam_cannot_be_negative(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/tarifs', [
            'jenis_kendaraan' => 'motor',
            'tarif_per_jam' => -5000,
        ]);

        $response->assertSessionHasErrors('tarif_per_jam');
    }

    // Area Parkir Validation Tests
    public function test_area_nama_area_is_required(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/areas', [
            'kapasitas' => 100,
        ]);

        $response->assertSessionHasErrors('nama_area');
    }

    public function test_area_nama_area_max_length_is_50(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/areas', [
            'nama_area' => str_repeat('a', 51),
            'kapasitas' => 100,
        ]);

        $response->assertSessionHasErrors('nama_area');
    }

    public function test_area_kapasitas_is_required(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/areas', [
            'nama_area' => 'Area A',
        ]);

        $response->assertSessionHasErrors('kapasitas');
    }

    public function test_area_kapasitas_must_be_integer(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/areas', [
            'nama_area' => 'Area A',
            'kapasitas' => 'abc',
        ]);

        $response->assertSessionHasErrors('kapasitas');
    }

    public function test_area_kapasitas_must_be_at_least_1(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/areas', [
            'nama_area' => 'Area A',
            'kapasitas' => 0,
        ]);

        $response->assertSessionHasErrors('kapasitas');
    }

    // Kendaraan Validation Tests
    public function test_kendaraan_plat_nomor_is_required(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/kendaraans', [
            'jenis_kendaraan' => 'motor',
            'warna' => 'merah',
            'pemilik' => 'Owner',
            'id_user' => 1,
        ]);

        $response->assertSessionHasErrors('plat_nomor');
    }

    public function test_kendaraan_plat_nomor_must_follow_indonesian_format(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/kendaraans', [
            'plat_nomor' => 'INVALID-PLAT',
            'jenis_kendaraan' => 'motor',
            'warna' => 'merah',
            'pemilik' => 'Owner',
            'id_user' => $this->admin->id_user,
        ]);

        $response->assertSessionHasErrors('plat_nomor');
    }

    public function test_kendaraan_jenis_kendaraan_is_required(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/kendaraans', [
            'plat_nomor' => 'B1234AB',
            'warna' => 'merah',
            'pemilik' => 'Owner',
            'id_user' => 1,
        ]);

        $response->assertSessionHasErrors('jenis_kendaraan');
    }

    public function test_kendaraan_jenis_kendaraan_max_length(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/kendaraans', [
            'plat_nomor' => 'B1234AB',
            'jenis_kendaraan' => str_repeat('a', 21),
            'warna' => 'merah',
            'pemilik' => 'Owner',
            'id_user' => 1,
        ]);

        $response->assertSessionHasErrors('jenis_kendaraan');
    }

    public function test_kendaraan_warna_is_required(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/kendaraans', [
            'plat_nomor' => 'B1234AB',
            'jenis_kendaraan' => 'motor',
            'pemilik' => 'Owner',
            'id_user' => 1,
        ]);

        $response->assertSessionHasErrors('warna');
    }

    public function test_kendaraan_warna_max_length(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/kendaraans', [
            'plat_nomor' => 'B1234AB',
            'jenis_kendaraan' => 'motor',
            'warna' => str_repeat('a', 21),
            'pemilik' => 'Owner',
            'id_user' => 1,
        ]);

        $response->assertSessionHasErrors('warna');
    }

    public function test_kendaraan_pemilik_is_required(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/kendaraans', [
            'plat_nomor' => 'B1234AB',
            'jenis_kendaraan' => 'motor',
            'warna' => 'merah',
            'id_user' => 1,
        ]);

        $response->assertSessionHasErrors('pemilik');
    }

    public function test_kendaraan_pemilik_max_length(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/kendaraans', [
            'plat_nomor' => 'B1234AB',
            'jenis_kendaraan' => 'motor',
            'warna' => 'merah',
            'pemilik' => str_repeat('a', 101),
            'id_user' => 1,
        ]);

        $response->assertSessionHasErrors('pemilik');
    }

    public function test_kendaraan_id_user_is_required(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/kendaraans', [
            'plat_nomor' => 'B1234AB',
            'jenis_kendaraan' => 'motor',
            'warna' => 'merah',
            'pemilik' => 'Owner',
        ]);

        $response->assertSessionHasErrors('id_user');
    }
}
