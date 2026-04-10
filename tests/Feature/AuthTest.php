<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_with_valid_credentials(): void
    {
        User::create([
            'nama_lengkap' => 'Admin',
            'username' => 'admin',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
            'status_aktif' => true,
        ]);

        $response = $this->post(route('login'), [
            'username' => 'admin',
            'password' => 'admin123',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_login_with_invalid_credentials(): void
    {
        User::create([
            'nama_lengkap' => 'Admin',
            'username' => 'admin',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
            'status_aktif' => true,
        ]);

        $response = $this->post(route('login'), [
            'username' => 'admin',
            'password' => 'wrongpassword',
        ]);

        $this->assertGuest();
        $response->assertStatus(302);
    }

    public function test_login_with_inactive_user(): void
    {
        User::create([
            'nama_lengkap' => 'Admin',
            'username' => 'admin',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
            'status_aktif' => false,
        ]);

        $response = $this->post(route('login'), [
            'username' => 'admin',
            'password' => 'admin123',
        ]);

        $this->assertGuest();
        $response->assertStatus(302);
    }
}
