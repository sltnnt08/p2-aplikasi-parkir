<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class LogAktivitas extends Model
{
    public $timestamps = false;

    protected $table = 'tb_log_aktivitas';

    protected $primaryKey = 'id_log';

    protected $fillable = ['id_user', 'aktivitas', 'waktu_aktivitas'];

    protected $casts = [
        'waktu_aktivitas' => 'datetime',
    ];

    public function getAktivitasLabelAttribute(): string
    {
        return self::toHumanReadableActivity($this->aktivitas);
    }

    public static function toHumanReadableActivity(string $activity): string
    {
        if ($activity === 'Login') {
            return 'Masuk ke sistem';
        }

        if ($activity === 'Logout') {
            return 'Keluar dari sistem';
        }

        if (! preg_match('/^(GET|POST|PUT|PATCH|DELETE)\s+([^\s]+)\s+\[(\d{3})\]$/', $activity, $matches)) {
            return Str::ucfirst($activity);
        }

        $method = $matches[1];
        $target = $matches[2];
        $statusCode = (int) $matches[3];

        $message = self::describeActivity($method, $target);

        if ($statusCode >= 400) {
            return $message." (gagal, kode {$statusCode})";
        }

        return $message;
    }

    private static function describeActivity(string $method, string $target): string
    {
        $normalizedTarget = $target;

        if ($target === 'admin.kendaraan' || Str::startsWith($target, 'admin.kendaraan.')) {
            $normalizedTarget = Str::replaceFirst('admin.kendaraan', 'admin.kendaraans', $target);
        }

        if (Str::startsWith($normalizedTarget, '/')) {
            return match ($method) {
                'GET' => 'Mengakses halaman '.$normalizedTarget,
                'POST' => 'Mengirim data ke '.$normalizedTarget,
                'PUT', 'PATCH' => 'Memperbarui data di '.$normalizedTarget,
                'DELETE' => 'Menghapus data di '.$normalizedTarget,
                default => 'Menjalankan aksi pada '.$normalizedTarget,
            };
        }

        $segments = explode('.', $normalizedTarget);
        if (in_array($segments[0] ?? '', ['admin', 'petugas', 'owner'], true)) {
            array_shift($segments);
        }

        if ($segments === ['dashboard']) {
            return 'Mengakses dashboard';
        }

        if (in_array('logs', $segments, true)) {
            return 'Mengakses menu log aktivitas';
        }

        $resource = self::resolveResourceLabel($segments);

        if ($method === 'GET') {
            if (in_array('create', $segments, true)) {
                return "Membuka form tambah {$resource}";
            }

            if (in_array('edit', $segments, true)) {
                return "Membuka form ubah {$resource}";
            }

            return "Mengakses menu {$resource}";
        }

        if ($method === 'POST') {
            if (in_array('store', $segments, true)) {
                if (in_array('transaksi', $segments, true) && in_array('masuk', $segments, true)) {
                    return 'Mencatat transaksi masuk';
                }

                return "Menambahkan data {$resource}";
            }

            if (in_array('process', $segments, true)) {
                return "Memproses {$resource}";
            }

            if (in_array('finalize', $segments, true)) {
                return "Menyelesaikan {$resource}";
            }

            return "Menjalankan aksi {$resource}";
        }

        if (in_array($method, ['PUT', 'PATCH'], true)) {
            return "Memperbarui data {$resource}";
        }

        if ($method === 'DELETE') {
            return "Menghapus data {$resource}";
        }

        return "Menjalankan aksi {$resource}";
    }

    private static function resolveResourceLabel(array $segments): string
    {
        $ignoredSegments = ['create', 'store', 'edit', 'update', 'delete', 'destroy', 'process', 'finalize'];

        $translated = collect($segments)
            ->reject(fn (string $segment): bool => in_array($segment, $ignoredSegments, true))
            ->map(fn (string $segment): string => self::translateSegment($segment))
            ->filter()
            ->unique()
            ->values()
            ->all();

        if ($translated === []) {
            return 'data';
        }

        return implode(' ', $translated);
    }

    private static function translateSegment(string $segment): string
    {
        return match ($segment) {
            'users', 'user' => 'pengguna',
            'tarifs', 'tarif' => 'tarif',
            'areas', 'area' => 'area parkir',
            'kendaraans', 'kendaraan' => 'kendaraan',
            'logs', 'log' => 'log aktivitas',
            'dashboard' => 'dashboard',
            'transaksi' => 'transaksi',
            'masuk' => 'masuk',
            'keluar' => 'keluar',
            'struk' => 'struk',
            'pending' => 'pending',
            'rekap' => 'rekap',
            default => str_replace(['_', '-'], ' ', Str::lower($segment)),
        };
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
