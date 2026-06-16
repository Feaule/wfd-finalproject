<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';

    protected $fillable = [
        'tagihan_id', 'tanggal', 'bukti_foto', 'metode', 'verified_at'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'verified_at' => 'datetime',
    ];

    public function tagihan() {
        return $this->belongsTo(Tagihan::class);
    }
}

