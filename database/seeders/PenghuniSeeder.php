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

        // 2. Buat data Lantai
        $lantai1 = Lantai::firstOrCreate(
            ['nomor_lantai' => 1],
            ['nama' => 'Ground Floor']
        );
        $lantai2 = Lantai::firstOrCreate(
            ['nomor_lantai' => 2],
            ['nama' => 'Second Floor']
        );
        $lantai3 = Lantai::firstOrCreate(
            ['nomor_lantai' => 3],
            ['nama' => 'Third Floor']
        );

        // 3. Buat unit apartemen
        $unit = Unit::firstOrCreate(
            ['nomor' => '201'],
            [
                'lantai_id' => $lantai2->id,
                'tipe' => '1BR',
                'luas_m2' => 36,
                'harga_sewa' => 4500000,
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