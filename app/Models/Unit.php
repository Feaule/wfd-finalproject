<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $table = 'unit';

    protected $fillable = [
        'lantai_id', 'nomor', 'tipe', 'luas_m2', 'harga_sewa', 'status'
    ];
}
