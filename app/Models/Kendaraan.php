<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    public $timestamps = false;

    public const INDONESIA_PLATE_NUMBER_REGEX = '/^[A-Z]{1,2}[1-9][0-9]{0,3}[A-Z]{0,3}$/';

    protected $table = 'tb_kendaraan';

    protected $primaryKey = 'id_kendaraan';

    protected $fillable = ['plat_nomor', 'jenis_kendaraan', 'warna', 'pemilik', 'id_user'];

    public static function normalizePlatNomor(?string $platNomor): string
    {
        $normalizedPlatNomor = mb_strtoupper(trim((string) $platNomor));

        return preg_replace('/\s+/', '', $normalizedPlatNomor) ?? '';
    }

    public function setPlatNomorAttribute(string $value): void
    {
        $this->attributes['plat_nomor'] = self::normalizePlatNomor($value);
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'id_kendaraan', 'id_kendaraan');
    }
}
