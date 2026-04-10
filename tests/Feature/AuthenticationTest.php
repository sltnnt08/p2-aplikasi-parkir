<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_can_be_viewed(): void
    {
        $response = $this->get('/login');

        $response->assertSuccessful();
    }

    public function test_user_can_login_with_valid_credentials(): void
    {
        $user = User::create([
            'nama_lengkap' => 'Admin User',
            'username' => 'admin',
            'password' => bcrypt('password123'),
            'role' => 'admin',
            'status_aktif' => true,
        ]);

        $response = $this->post('/login', [
            'username' => 'admin',
            'password' => 'password123',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_user_cannot_login_with_invalid_password(): void
    {
        User::create([
            'nama_lengkap' => 'Admin User',
            'username' => 'admin',
            'password' => bcrypt('password123'),
            'role' => 'admin',
            'status_aktif' => true,
        ]);

        $response = $this->post('/login', [
            'username' => 'admin',
            'password' => 'wrongpassword',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors();
    }

    public function test_user_cannot_login_with_nonexistent_username(): void
    {
        $response = $this->post('/login', [
            'username' => 'nonexistent',
            'password' => 'password123',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors();
    }

    public function test_inactive_user_cannot_login(): void
    {
        User::create([
            'nama_lengkap' => 'Inactive User',
            'username' => 'inactive',
            'password' => bcrypt('password123'),
            'role' => 'petugas',
            'status_aktif' => false,
        ]);

        $response = $this->post('/login', [
            'username' => 'inactive',
            'password' => 'password123',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors(['username' => 'Akun tidak aktif.']);
    }

    public function test_admin_is_redirected_to_admin_dashboard(): void
    {
        $admin = User::create([
            'nama_lengkap' => 'Admin User',
            'username' => 'admin',
            'password' => bcrypt('password123'),
            'role' => 'admin',
            'status_aktif' => true,
        ]);

        $response = $this->post('/login', [
            'username' => 'admin',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_petugas_is_redirected_to_petugas_dashboard(): void
    {
        $petugas = User::create([
            'nama_lengkap' => 'Petugas User',
            'username' => 'petugas',
            'password' => bcrypt('password123'),
            'role' => 'petugas',
            'status_aktif' => true,
        ]);

        $response = $this->post('/login', [
            'username' => 'petugas',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('petugas.dashboard'));
    }

    public function test_owner_is_redirected_to_owner_dashboard(): void
    {
        $owner = User::create([
            'nama_lengkap' => 'Owner User',
            'username' => 'owner',
            'password' => bcrypt('password123'),
            'role' => 'owner',
            'status_aktif' => true,
        ]);

        $response = $this->post('/login', [
            'username' => 'owner',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('owner.dashboard'));
    }

    public function test_login_creates_log_aktivitas(): void
    {
        $user = User::create([
            'nama_lengkap' => 'Admin User',
            'username' => 'admin',
            'password' => bcrypt('password123'),
            'role' => 'admin',
            'status_aktif' => true,
        ]);

        $this->post('/login', [
            'username' => 'admin',
            'password' => 'password123',
        ]);

        $this->assertDatabaseHas('tb_log_aktivitas', [
            'id_user' => $user->id_user,
            'aktivitas' => 'Login',
        ]);
    }

    public function test_user_can_logout(): void
    {
        $user = User::create([
            'nama_lengkap' => 'Admin User',
            'username' => 'admin',
            'password' => bcrypt('password123'),
            'role' => 'admin',
            'status_aktif' => true,
        ]);

        $this->actingAs($user);
        $this->assertAuthenticated();

        $response = $this->post('/logout');

        $this->assertGuest();
        $response->assertRedirect(route('login'));
    }

    public function test_logout_creates_log_aktivitas(): void
    {
        $user = User::create([
            'nama_lengkap' => 'Admin User',
            'username' => 'admin',
            'password' => bcrypt('password123'),
            'role' => 'admin',
            'status_aktif' => true,
        ]);

        $this->actingAs($user);
        $this->post('/logout');

        $this->assertDatabaseHas('tb_log_aktivitas', [
            'id_user' => $user->id_user,
            'aktivitas' => 'Logout',
        ]);
    }

    public function test_login_requires_username(): void
    {
        $response = $this->post('/login', [
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors('username');
    }

    public function test_login_requires_password(): void
    {
        $response = $this->post('/login', [
            'username' => 'admin',
        ]);

        $response->assertSessionHasErrors('password');
    }
}
