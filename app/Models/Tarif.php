<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarif extends Model
{
    public $timestamps = false;

    protected $table = 'tb_tarif';

    protected $primaryKey = 'id_tarif';

    protected $fillable = ['id_area', 'jenis_kendaraan', 'tarif_per_jam'];

    protected $casts = [
        'tarif_per_jam' => 'decimal:0',
    ];

    // Relationships
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'id_tarif', 'id_tarif');
    }

    public function areaParkir()
    {
        return $this->belongsTo(AreaParkir::class, 'id_area', 'id_area');
    }
}
