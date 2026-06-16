<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
// Wajib tambahkan import model di bawah ini:
use App\Models\User;
use App\Models\Unit;
use App\Models\Penghuni;
use App\Models\Lantai; 

class PenghuniSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buat user penghuni dummy
        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'penghuni@test.com',
            'password' => bcrypt('password'),
            'role' => 'penghuni',
        ]);

        // 2. Buat data Lantai dummy terlebih dahulu agar 'lantai_id' tidak error
        $lantai = Lantai::firstOrCreate(
            ['id' => 1],
            ['nomor_lantai' => 1, 'nama' => 'Lantai Dasar']
        );

        // 3. Buat unit dummy jika belum ada (lantai_id kini sudah aman)
        $unit = Unit::firstOrCreate(
            ['nomor' => '101'],
            [
                'lantai_id' => $lantai->id, 
                'tipe' => 'studio', 
                'luas_m2' => 25,
                'harga_sewa' => 2500000, 
                'status' => 'terisi'
            ]
        );

        // 4. Buat penghuni
        Penghuni::create([
            'user_id' => $user->id,
            'unit_id' => $unit->id,
            'tanggal_masuk' => '2026-01-01',
            'status' => 'aktif',
        ]);
    }
}