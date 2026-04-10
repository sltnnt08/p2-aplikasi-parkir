<?php

namespace Tests\Unit\Models;

use App\Models\LogAktivitas;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogAktivitasModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_log_aktivitas_can_be_created(): void
    {
        $user = User::create([
            'nama_lengkap' => 'Admin',
            'username' => 'admin',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'status_aktif' => true,
        ]);

        $log = LogAktivitas::create([
            'id_user' => $user->id_user,
            'aktivitas' => 'Login',
            'waktu_aktivitas' => now(),
        ]);

        $this->assertDatabaseHas('tb_log_aktivitas', [
            'id_user' => $user->id_user,
            'aktivitas' => 'Login',
        ]);
    }

    public function test_log_aktivitas_belongs_to_user(): void
    {
        $user = User::create([
            'nama_lengkap' => 'Admin',
            'username' => 'admin',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'status_aktif' => true,
        ]);

        $log = LogAktivitas::create([
            'id_user' => $user->id_user,
            'aktivitas' => 'Login',
            'waktu_aktivitas' => now(),
        ]);

        $this->assertEquals($user->id_user, $log->user->id_user);
    }

    public function test_log_aktivitas_waktu_aktivitas_is_datetime(): void
    {
        $user = User::create([
            'nama_lengkap' => 'Admin',
            'username' => 'admin',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'status_aktif' => true,
        ]);

        $now = now();
        $log = LogAktivitas::create([
            'id_user' => $user->id_user,
            'aktivitas' => 'Login',
            'waktu_aktivitas' => $now,
        ]);

        $this->assertTrue($log->waktu_aktivitas instanceof Carbon);
    }

    public function test_log_aktivitas_tracks_multiple_activities(): void
    {
        $user = User::create([
            'nama_lengkap' => 'Admin',
            'username' => 'admin',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'status_aktif' => true,
        ]);

        $activities = ['Login', 'Create User', 'Update Tarif', 'Delete Area', 'Logout'];

        foreach ($activities as $activity) {
            LogAktivitas::create([
                'id_user' => $user->id_user,
                'aktivitas' => $activity,
                'waktu_aktivitas' => now(),
            ]);
        }

        $this->assertCount(5, LogAktivitas::where('id_user', $user->id_user)->get());
    }

    public function test_log_aktivitas_records_different_activities(): void
    {
        $user = User::create([
            'nama_lengkap' => 'Admin',
            'username' => 'admin',
            'password' => bcrypt('password'),
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
            'aktivitas' => 'Create',
            'waktu_aktivitas' => now(),
        ]);

        LogAktivitas::create([
            'id_user' => $user->id_user,
            'aktivitas' => 'Logout',
            'waktu_aktivitas' => now(),
        ]);

        $logs = LogAktivitas::where('id_user', $user->id_user)->get();

        $this->assertCount(3, $logs);
        $this->assertTrue($logs->pluck('aktivitas')->contains('Login'));
        $this->assertTrue($logs->pluck('aktivitas')->contains('Create'));
        $this->assertTrue($logs->pluck('aktivitas')->contains('Logout'));
    }
}
