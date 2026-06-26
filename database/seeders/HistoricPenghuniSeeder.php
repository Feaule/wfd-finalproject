<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HistoricPenghuniSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cleanup data seeder lama (jika ada error di run sebelumnya)
        \App\Models\User::where('email', 'like', 'penghunilama%')->delete();
        \App\Models\Unit::where('nomor', 'like', '990%')->delete();

        $units = \App\Models\Unit::where('status', 'tersedia')->take(3)->get();
        
        if ($units->count() < 3) {
            // Buat lantai dummy jika belum ada
            $lantai = \App\Models\Lantai::firstOrCreate(
                ['nomor_lantai' => 99],
                ['nama' => 'Lantai Khusus Seeder']
            );

            // Buat kekurangan unit
            $needed = 3 - $units->count();
            for ($i = 0; $i < $needed; $i++) {
                \App\Models\Unit::create([
                    'lantai_id' => $lantai->id,
                    'nomor' => '990' . ($i + 1),
                    'tipe' => 'studio',
                    'luas_m2' => 24,
                    'harga_sewa' => 2500000,
                    'status' => 'tersedia',
                ]);
            }
            // Ambil ulang unit
            $units = \App\Models\Unit::where('status', 'tersedia')->take(3)->get();
        }

        $durations = [5, 3, 6]; 

        foreach ($units as $index => $unit) {
            $monthsAgo = $durations[$index] ?? 4;
            $tanggalMasuk = \Carbon\Carbon::now()->subMonths($monthsAgo)->startOfMonth()->addDays(5);

            $user = \App\Models\User::create([
                'name' => 'Penghuni Lama ' . ($index + 1),
                'email' => 'penghunilama' . ($index + 1) . '@example.com',
                'no_ktp' => '12345678901234' . (5 + $index),
                'role' => 'penghuni',
                'status' => 'active',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
            ]);

            $penghuni = \App\Models\Penghuni::create([
                'user_id' => $user->id,
                'unit_id' => $unit->id,
                'tanggal_masuk' => $tanggalMasuk,
                'status' => 'aktif',
            ]);
            \Illuminate\Support\Facades\DB::table('penghuni')->where('id', $penghuni->id)->update(['created_at' => $tanggalMasuk]);

            $unit->update(['status' => 'terisi']);

            for ($i = $monthsAgo; $i >= 0; $i--) {
                $bulanTagihan = \Carbon\Carbon::now()->subMonths($i)->startOfMonth();
                $jatuhTempo = $bulanTagihan->copy()->addDays(10);
                
                $tagihan = \App\Models\Tagihan::create([
                    'penghuni_id' => $penghuni->id,
                    'bulan' => $bulanTagihan->format('Y-m'),
                    'jenis' => 'sewa',
                    'jumlah' => $unit->harga_sewa,
                    'jatuh_tempo' => $jatuhTempo,
                    'status' => 'lunas',
                ]);
                \Illuminate\Support\Facades\DB::table('tagihan')->where('id', $tagihan->id)->update(['created_at' => $bulanTagihan]);

                $tanggalBayar = $bulanTagihan->copy()->addDays(rand(1, 9));
                
                $pembayaran = \App\Models\Pembayaran::create([
                    'tagihan_id' => $tagihan->id,
                    'tanggal' => $tanggalBayar,
                    'bukti_foto' => 'dummy_bukti.jpg',
                    'metode' => 'transfer',
                    'verified_at' => $tanggalBayar,
                ]);
                \Illuminate\Support\Facades\DB::table('pembayaran')->where('id', $pembayaran->id)->update(['created_at' => $tanggalBayar]);
            }
        }
        
        $this->command->info('Berhasil membuat 3 penghuni lama dengan histori pembayaran (Tagihan Lunas)!');
    }
}
