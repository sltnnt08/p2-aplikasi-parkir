<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AreaParkir extends Model
{
    public $timestamps = false;

    protected $table = 'tb_area_parkir';

    protected $primaryKey = 'id_area';

    protected $fillable = ['nama_area', 'kapasitas', 'terisi'];

    // Relationships
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'id_area', 'id_area');
    }

    public function tarifs()
    {
        return $this->hasMany(Tarif::class, 'id_area', 'id_area');
    }
}
