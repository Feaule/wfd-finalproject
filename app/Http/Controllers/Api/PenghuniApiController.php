<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Penghuni;
use App\Models\Tagihan;
use App\Models\Pengaduan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PenghuniApiController extends Controller
{
    /**
     * GET /api/penghuni/stats
     * Statistik ringkasan untuk dashboard penghuni
     */
    public function stats()
    {
        $penghuni = Penghuni::with(['unit.lantai'])
            ->where('user_id', Auth::id())
            ->where('status', 'aktif')
            ->first();

        if (!$penghuni) {
            return response()->json([
                'status'  => 'success',
                'message' => 'No active unit found',
                'data'    => [
                    'has_unit'  => false,
                    'unit'      => null,
                    'tagihan'   => null,
                    'pengaduan' => null,
                ],
                'timestamp' => Carbon::now()->toIso8601String(),
            ]);
        }

        $tagihanStats = [
            'total'          => $penghuni->tagihan()->count(),
            'belum_bayar'    => $penghuni->tagihan()->where('status', 'belum_bayar')->count(),
            'menunggu'       => $penghuni->tagihan()->where('status', 'menunggu_verifikasi')->count(),
            'lunas'          => $penghuni->tagihan()->where('status', 'lunas')->count(),
            'total_tunggakan'=> $penghuni->tagihan()->where('status', 'belum_bayar')->sum('jumlah'),
        ];

        $pengaduanStats = [
            'total'   => $penghuni->pengaduan()->count(),
            'pending' => $penghuni->pengaduan()->where('status', 'pending')->count(),
            'proses'  => $penghuni->pengaduan()->where('status', 'proses')->count(),
            'selesai' => $penghuni->pengaduan()->where('status', 'selesai')->count(),
        ];

        return response()->json([
            'status'  => 'success',
            'message' => 'Stats retrieved successfully',
            'data'    => [
                'has_unit' => true,
                'user'     => [
                    'name'  => Auth::user()->name,
                    'email' => Auth::user()->email,
                ],
                'unit' => [
                    'nomor'       => $penghuni->unit->nomor,
                    'lantai'      => $penghuni->unit->lantai->nomor_lantai ?? '-',
                    'tipe'        => $penghuni->unit->tipe ?? '-',
                    'luas'        => $penghuni->unit->luas_m2 ?? '-',
                    'harga_sewa'  => $penghuni->unit->harga_sewa,
                    'harga_formatted' => 'Rp ' . number_format($penghuni->unit->harga_sewa, 0, ',', '.'),
                    'status'      => $penghuni->unit->status,
                ],
                'penghuni' => [
                    'tanggal_masuk'  => $penghuni->tanggal_masuk?->format('d M Y'),
                    'tanggal_keluar' => $penghuni->tanggal_keluar?->format('d M Y'),
                    'status'         => $penghuni->status,
                    'durasi'         => $penghuni->tanggal_masuk?->diffForHumans(null, true),
                ],
                'tagihan'   => $tagihanStats,
                'pengaduan' => $pengaduanStats,
            ],
            'timestamp' => Carbon::now()->toIso8601String(),
        ]);
    }

    /**
     * GET /api/penghuni/tagihan
     * Daftar tagihan terbaru yang belum lunas
     */
    public function tagihan()
    {
        $penghuni = Penghuni::where('user_id', Auth::id())
            ->where('status', 'aktif')
            ->first();

        if (!$penghuni) {
            return response()->json([
                'status'  => 'success',
                'message' => 'No active unit',
                'data'    => [],
                'total'   => 0,
                'timestamp' => Carbon::now()->toIso8601String(),
            ]);
        }

        $tagihan = Tagihan::where('penghuni_id', $penghuni->id)
            ->with('pembayaran')
            ->orderBy('bulan', 'desc')
            ->take(10)
            ->get()
            ->map(function ($t) {
                return [
                    'id'         => $t->id,
                    'jenis'      => $t->jenis,
                    'bulan'      => $t->bulan,
                    'bulan_label'=> Carbon::parse($t->bulan . '-01')->translatedFormat('F Y'),
                    'jumlah'     => $t->jumlah,
                    'jumlah_formatted' => 'Rp ' . number_format($t->jumlah, 0, ',', '.'),
                    'status'     => $t->status,
                    'jatuh_tempo'=> $t->jatuh_tempo?->format('d M Y'),
                    'is_overdue' => $t->status !== 'lunas' && $t->jatuh_tempo?->isPast(),
                    'pembayaran' => $t->pembayaran ? [
                        'tanggal'     => $t->pembayaran->tanggal?->format('d M Y'),
                        'verified_at' => $t->pembayaran->verified_at?->format('d M Y'),
                    ] : null,
                ];
            });

        return response()->json([
            'status'  => 'success',
            'message' => 'Tagihan retrieved successfully',
            'data'    => $tagihan,
            'total'   => $tagihan->count(),
            'timestamp' => Carbon::now()->toIso8601String(),
        ]);
    }

    /**
     * GET /api/penghuni/pengaduan
     * Riwayat pengaduan penghuni
     */
    public function pengaduan()
    {
        $penghuni = Penghuni::where('user_id', Auth::id())
            ->where('status', 'aktif')
            ->first();

        if (!$penghuni) {
            return response()->json([
                'status'  => 'success',
                'message' => 'No active unit',
                'data'    => [],
                'total'   => 0,
                'timestamp' => Carbon::now()->toIso8601String(),
            ]);
        }

        $pengaduan = Pengaduan::where('penghuni_id', $penghuni->id)
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($p) {
                return [
                    'id'          => $p->id,
                    'judul'       => $p->judul,
                    'deskripsi'   => $p->deskripsi,
                    'status'      => $p->status,
                    'created_at'  => $p->created_at->format('d M Y'),
                    'time_ago'    => $p->created_at->diffForHumans(),
                    'updated_at'  => $p->updated_at->format('d M Y H:i'),
                ];
            });

        return response()->json([
            'status'  => 'success',
            'message' => 'Pengaduan retrieved successfully',
            'data'    => $pengaduan,
            'total'   => $pengaduan->count(),
            'timestamp' => Carbon::now()->toIso8601String(),
        ]);
    }
}
