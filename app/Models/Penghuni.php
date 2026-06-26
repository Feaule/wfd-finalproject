<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penghuni extends Model
{
    protected $table = 'penghuni';

    protected $fillable = [
        'user_id', 'unit_id', 'tanggal_masuk', 'tanggal_keluar', 'status'
    ];

    protected $casts = [
        'tanggal_masuk' => 'date',
        'tanggal_keluar' => 'date',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function unit() {
        return $this->belongsTo(Unit::class);
    }

    public function tagihan() {
        return $this->hasMany(Tagihan::class);
    }

    public function pengaduan() {
        return $this->hasMany(Pengaduan::class);
    }
}
