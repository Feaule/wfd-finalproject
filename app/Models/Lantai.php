<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lantai extends Model
{
    protected $table = 'lantai';

    protected $fillable = [
        'nomor_lantai', 'nama'
    ];

    public function units()
    {
        return $this->hasMany(Unit::class);
    }
}
