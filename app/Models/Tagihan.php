<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    protected $table = 'tagihan';

    protected $fillable = [
        'penghuni_id', 'bulan', 'jenis', 'jumlah', 'status', 'jatuh_tempo'
    ];

    protected $casts = [
        'jatuh_tempo' => 'date',
        'jumlah' => 'decimal:2',
    ];

    public function penghuni() {
        return $this->belongsTo(Penghuni::class);
    }

    public function pembayaran() {
        return $this->hasOne(Pembayaran::class);
    }
}

