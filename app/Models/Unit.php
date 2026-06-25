<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $table = 'unit';

    protected $fillable = [
        'lantai_id', 'nomor', 'tipe', 'luas_m2', 'harga_sewa', 'status', 'foto'
    ];

    public function lantai()
    {
        return $this->belongsTo(Lantai::class);
    }

    public function penghuni()
    {
        return $this->hasMany(Penghuni::class);
    }
}
