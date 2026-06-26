<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengaduan;
use App\Models\Penghuni;

class PengaduanSeeder extends Seeder
{
    public function run(): void
    {
        $penghuni = Penghuni::first();
        
        if ($penghuni) {
            Pengaduan::create([
                'penghuni_id' => $penghuni->id,
                'kategori' => 'listrik',
                'judul' => 'Lampu koridor lantai 2 mati',
                'deskripsi' => 'Lampu di koridor lantai 2 dekat unit 201 sudah mati sejak 3 hari yang lalu. Mohon segera diperbaiki karena sangat gelap di malam hari.',
                'status' => 'pending',
            ]);

            Pengaduan::create([
                'penghuni_id' => $penghuni->id,
                'kategori' => 'kebersihan',
                'judul' => 'Sampah di area parkir menumpuk',
                'deskripsi' => 'Area parkir basement kotor dan sampah menumpuk. Mohon ditingkatkan kebersihan area parkir.',
                'status' => 'proses',
                'tanggapan' => 'Terima kasih atas laporannya. Tim kebersihan sudah dijadwalkan untuk membersihkan area parkir hari ini.',
            ]);

            Pengaduan::create([
                'penghuni_id' => $penghuni->id,
                'kategori' => 'air',
                'judul' => 'Air sering mati di pagi hari',
                'deskripsi' => 'Beberapa hari terakhir air sering mati di pagi hari antara jam 6-8 pagi. Mohon diperiksa sistem distribusi airnya.',
                'status' => 'selesai',
                'tanggapan' => 'Permasalahan sudah diselesaikan. Kami telah memperbaiki pompa air utama dan menambah kapasitas tangki air. Air seharusnya sudah lancar kembali.',
            ]);
        }
    }
}
