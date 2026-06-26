<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Penghuni;
use App\Models\Tagihan;
use Carbon\Carbon;

class TagihanSeeder extends Seeder
{
    /**
     * Generate tagihan sample untuk penghuni aktif.
     * Buat tagihan 2 bulan: bulan lalu & bulan ini.
     */
    public function run(): void
    {
        $penghuni = Penghuni::with('unit')->where('status', 'aktif')->get();

        if ($penghuni->isEmpty()) {
            $this->command->warn('Tidak ada penghuni aktif. Tagihan tidak digenerate.');
            return;
        }

        $bulanList = [
            Carbon::now()->subMonth()->format('Y-m'),  // bulan lalu
            Carbon::now()->format('Y-m'),               // bulan ini
        ];

        $totalCreated = 0;

        foreach ($penghuni as $p) {
            foreach ($bulanList as $bulan) {
                // Cek apakah tagihan sudah ada untuk bulan ini
                $sudahAda = Tagihan::where('penghuni_id', $p->id)
                    ->where('bulan', $bulan)
                    ->exists();

                if ($sudahAda) {
                    continue;
                }

                $jatuhTempo = Carbon::parse($bulan . '-20')->format('Y-m-d');

                $jenisTagihan = [
                    'sewa'       => $p->unit->harga_sewa,
                    'listrik'    => 150000,
                    'air'        => 75000,
                    'kebersihan' => 50000,
                ];

                foreach ($jenisTagihan as $jenis => $jumlah) {
                    Tagihan::create([
                        'penghuni_id' => $p->id,
                        'bulan'       => $bulan,
                        'jenis'       => $jenis,
                        'jumlah'      => $jumlah,
                        'status'      => 'belum_bayar',
                        'jatuh_tempo' => $jatuhTempo,
                    ]);
                }
                $totalCreated++;
            }
        }

        $this->command->info("Tagihan berhasil dibuat untuk {$totalCreated} penghuni-bulan ({$penghuni->count()} penghuni, " . count($bulanList) . " bulan).");
    }
}
