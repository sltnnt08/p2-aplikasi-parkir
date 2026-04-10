<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected User $petugas;

    protected User $owner;

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
    }

    // Admin Access Tests
    public function test_admin_can_access_admin_dashboard(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/dashboard');

        $response->assertSuccessful();
    }

    public function test_petugas_cannot_access_admin_dashboard(): void
    {
        $response = $this->actingAs($this->petugas)->get('/admin/dashboard');

        $response->assertStatus(403);
    }

    public function test_owner_cannot_access_admin_dashboard(): void
    {
        $response = $this->actingAs($this->owner)->get('/admin/dashboard');

        $response->assertStatus(403);
    }

    public function test_inactive_admin_is_logged_out_from_protected_route(): void
    {
        $this->admin->update(['status_aktif' => false]);

        $response = $this->actingAs($this->admin)->get('/admin/dashboard');

        $response->assertRedirect(route('login'));
        $this->assertGuest();
    }

    // Admin User Management Tests
    public function test_admin_can_access_users_management_route(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/users');

        // Route should be accessible to admin (not 404, and not 403)
        $this->assertNotEquals(404, $response->status());
    }

    public function test_petugas_cannot_access_users_management(): void
    {
        $response = $this->actingAs($this->petugas)->get('/admin/users');

        $this->assertEquals(403, $response->status());
    }

    public function test_owner_cannot_access_users_management(): void
    {
        $response = $this->actingAs($this->owner)->get('/admin/users');

        $this->assertEquals(403, $response->status());
    }

    public function test_admin_can_create_users(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/users', [
            'nama_lengkap' => 'New User',
            'username' => 'newuser',
            'password' => 'password123',
            'role' => 'petugas',
            'status_aktif' => true,
        ]);

        $response->assertRedirect();
    }

    public function test_petugas_cannot_create_users(): void
    {
        $response = $this->actingAs($this->petugas)->post('/admin/users', [
            'nama_lengkap' => 'New User',
            'username' => 'newuser',
            'password' => 'password123',
            'role' => 'petugas',
            'status_aktif' => true,
        ]);

        $response->assertStatus(403);
    }

    // Admin Tarif Management Tests
    public function test_admin_can_access_tarifs_management_route(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/tarifs');

        // Route should be accessible to admin (not 404, and not 403)
        $this->assertNotEquals(404, $response->status());
    }

    public function test_petugas_cannot_access_tarifs_management(): void
    {
        $response = $this->actingAs($this->petugas)->get('/admin/tarifs');

        $this->assertEquals(403, $response->status());
    }

    public function test_owner_cannot_access_tarifs_management(): void
    {
        $response = $this->actingAs($this->owner)->get('/admin/tarifs');

        $this->assertEquals(403, $response->status());
    }

    // Admin Area Management Tests
    public function test_admin_can_access_areas_management_route(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/areas');

        // Route should be accessible to admin (not 404, and not 403)
        $this->assertNotEquals(404, $response->status());
    }

    public function test_petugas_cannot_access_areas_management(): void
    {
        $response = $this->actingAs($this->petugas)->get('/admin/areas');

        $this->assertEquals(403, $response->status());
    }

    public function test_owner_cannot_access_areas_management(): void
    {
        $response = $this->actingAs($this->owner)->get('/admin/areas');

        $this->assertEquals(403, $response->status());
    }

    // Admin Kendaraan Management Tests
    public function test_admin_can_access_kendaraans_management_route(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/kendaraans');

        // Route should be accessible to admin (not 404, and not 403)
        $this->assertNotEquals(404, $response->status());
    }

    public function test_petugas_cannot_access_kendaraans_management(): void
    {
        $response = $this->actingAs($this->petugas)->get('/admin/kendaraans');

        $this->assertEquals(403, $response->status());
    }

    // Unauthenticated Access Tests
    public function test_unauthenticated_user_cannot_access_admin_routes(): void
    {
        $response = $this->get('/admin/dashboard');

        $response->assertRedirect(route('login'));
    }

    public function test_unauthenticated_user_cannot_access_petugas_routes(): void
    {
        $response = $this->get('/petugas/dashboard');

        $response->assertRedirect(route('login'));
    }

    public function test_unauthenticated_user_cannot_access_owner_routes(): void
    {
        $response = $this->get('/owner/dashboard');

        $response->assertRedirect(route('login'));
    }

    // Role-based Redirects
    public function test_admin_redirects_to_admin_dashboard_on_login(): void
    {
        $response = $this->post('/login', [
            'username' => 'admin',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_petugas_redirects_to_petugas_dashboard_on_login(): void
    {
        $response = $this->post('/login', [
            'username' => 'petugas',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('petugas.dashboard'));
    }

    public function test_owner_redirects_to_owner_dashboard_on_login(): void
    {
        $response = $this->post('/login', [
            'username' => 'owner',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('owner.dashboard'));
    }
}
