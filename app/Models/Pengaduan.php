<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    protected $table = 'pengaduan';

    protected $fillable = [
        'penghuni_id',
        'kategori',
        'judul',
        'deskripsi',
        'foto',
        'status',
        'tanggapan'
    ];

    public function penghuni()
    {
        return $this->belongsTo(Penghuni::class);
    }
}
