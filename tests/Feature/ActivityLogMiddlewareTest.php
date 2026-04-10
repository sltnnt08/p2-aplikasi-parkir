<?php

namespace Tests\Feature;

use App\Models\AreaParkir;
use App\Models\Tarif;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActivityLogMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected User $petugas;

    protected User $owner;

    protected AreaParkir $area;

    protected Tarif $tarif;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::create([
            'nama_lengkap' => 'Admin User',
            'username' => 'admin',
            'password' => bcrypt('password123'),
            'role' => 'admin',
            'status_aktif' => true,
        ]);

        $this->petugas = User::create([
            'nama_lengkap' => 'Petugas User',
            'username' => 'petugas',
            'password' => bcrypt('password123'),
            'role' => 'petugas',
            'status_aktif' => true,
        ]);

        $this->owner = User::create([
            'nama_lengkap' => 'Owner User',
            'username' => 'owner',
            'password' => bcrypt('password123'),
            'role' => 'owner',
            'status_aktif' => true,
        ]);

        $this->area = AreaParkir::create([
            'nama_area' => 'Area A',
            'kapasitas' => 10,
            'terisi' => 0,
        ]);

        $this->tarif = Tarif::create([
            'jenis_kendaraan' => 'motor',
            'tarif_per_jam' => 5000,
        ]);
    }

    public function test_successful_login_is_logged(): void
    {
        $this->post('/login', [
            'username' => 'admin',
            'password' => 'password123',
        ])->assertRedirect(route('admin.dashboard'));

        $this->assertDatabaseHas('tb_log_aktivitas', [
            'id_user' => $this->admin->id_user,
            'aktivitas' => 'Login',
        ]);
    }

    public function test_admin_action_is_logged(): void
    {
        $this->actingAs($this->admin)
            ->get('/admin/dashboard')
            ->assertSuccessful();

        $this->assertDatabaseHas('tb_log_aktivitas', [
            'id_user' => $this->admin->id_user,
            'aktivitas' => 'GET admin.dashboard [200]',
        ]);
    }

    public function test_petugas_action_is_logged(): void
    {
        $this->actingAs($this->petugas)
            ->post('/petugas/transaksi/masuk', [
                'plat_nomor' => 'b 1234 zz',
                'warna' => 'Hitam',
                'pemilik' => 'Pemilik Manual',
                'id_area' => $this->area->id_area,
                'id_tarif' => $this->tarif->id_tarif,
            ])
            ->assertRedirect(route('petugas.transaksi.masuk'));

        $this->assertDatabaseHas('tb_kendaraan', [
            'plat_nomor' => 'B1234ZZ',
            'id_user' => $this->petugas->id_user,
            'pemilik' => 'Pemilik Manual',
        ]);

        $this->assertDatabaseHas('tb_log_aktivitas', [
            'id_user' => $this->petugas->id_user,
            'aktivitas' => 'POST petugas.transaksi.store.masuk [302]',
        ]);
    }

    public function test_petugas_action_rejects_invalid_plate_number_format(): void
    {
        $response = $this->actingAs($this->petugas)
            ->from(route('petugas.transaksi.masuk'))
            ->post('/petugas/transaksi/masuk', [
                'plat_nomor' => 'B0000ZZ',
                'warna' => 'Hitam',
                'id_area' => $this->area->id_area,
                'id_tarif' => $this->tarif->id_tarif,
            ]);

        $response->assertRedirect(route('petugas.transaksi.masuk'));
        $response->assertSessionHasErrors('plat_nomor');

        $this->assertDatabaseMissing('tb_kendaraan', [
            'plat_nomor' => 'B0000ZZ',
        ]);
    }

    public function test_owner_action_is_logged(): void
    {
        $this->actingAs($this->owner)
            ->get('/owner/dashboard')
            ->assertSuccessful();

        $this->assertDatabaseHas('tb_log_aktivitas', [
            'id_user' => $this->owner->id_user,
            'aktivitas' => 'GET owner.dashboard [200]',
        ]);
    }

    public function test_logout_is_logged(): void
    {
        $this->actingAs($this->admin)
            ->post('/logout')
            ->assertRedirect(route('login'));

        $this->assertDatabaseHas('tb_log_aktivitas', [
            'id_user' => $this->admin->id_user,
            'aktivitas' => 'Logout',
        ]);
    }
}
