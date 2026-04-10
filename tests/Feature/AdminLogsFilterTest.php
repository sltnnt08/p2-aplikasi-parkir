<?php

namespace Tests\Feature;

use App\Models\LogAktivitas;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminLogsFilterTest extends TestCase
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

    public function test_admin_can_open_logs_without_filters(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/logs');

        $response->assertOk();
    }

    public function test_admin_can_filter_logs_by_hour_only(): void
    {
        LogAktivitas::create([
            'id_user' => $this->admin->id_user,
            'aktivitas' => 'Login',
            'waktu_aktivitas' => Carbon::parse('2026-04-10 13:15:00'),
        ]);

        LogAktivitas::create([
            'id_user' => $this->admin->id_user,
            'aktivitas' => 'Logout',
            'waktu_aktivitas' => Carbon::parse('2026-04-10 14:15:00'),
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/logs?jam=13');

        $response->assertOk();
        $response->assertSeeText('Masuk ke sistem');
        $response->assertDontSeeText('Keluar dari sistem');
    }

    public function test_admin_can_filter_logs_by_minute_only(): void
    {
        LogAktivitas::create([
            'id_user' => $this->admin->id_user,
            'aktivitas' => 'Login',
            'waktu_aktivitas' => Carbon::parse('2026-04-10 13:43:00'),
        ]);

        LogAktivitas::create([
            'id_user' => $this->admin->id_user,
            'aktivitas' => 'Logout',
            'waktu_aktivitas' => Carbon::parse('2026-04-10 13:44:00'),
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/logs?menit=43');

        $response->assertOk();
        $response->assertSeeText('Masuk ke sistem');
        $response->assertDontSeeText('Keluar dari sistem');
    }

    public function test_admin_can_filter_logs_by_date_and_hour_without_sql_error(): void
    {
        LogAktivitas::create([
            'id_user' => $this->admin->id_user,
            'aktivitas' => 'Login',
            'waktu_aktivitas' => Carbon::parse('2026-04-10 13:15:00'),
        ]);

        LogAktivitas::create([
            'id_user' => $this->admin->id_user,
            'aktivitas' => 'Logout',
            'waktu_aktivitas' => Carbon::parse('2026-04-11 13:15:00'),
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/logs?tanggal=2026-04-10&jam=13');

        $response->assertOk();
        $response->assertSeeText('Masuk ke sistem');
        $response->assertDontSeeText('Keluar dari sistem');
    }
}
