<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use App\Models\Penghuni;
use App\Models\User;
use App\Models\Pembayaran;
use App\Models\Pengaduan;
use App\Models\Tagihan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminApiController extends Controller
{
    /**
     * GET /api/admin/stats
     * Statistik ringkasan untuk dashboard admin
     */
    public function stats()
    {
        $totalUnit     = Unit::count();
        $unitTerisi    = Unit::where('status', 'terisi')->count();
        $unitTersedia  = Unit::where('status', 'tersedia')->count();
        $okupansi      = $totalUnit > 0 ? round(($unitTerisi / $totalUnit) * 100, 1) : 0;

        $pendapatanBulanIni = Pembayaran::whereNotNull('verified_at')
            ->whereMonth('pembayaran.created_at', Carbon::now()->month)
            ->whereYear('pembayaran.created_at',  Carbon::now()->year)
            ->join('tagihan', 'pembayaran.tagihan_id', '=', 'tagihan.id')
            ->sum('tagihan.jumlah');

        $pendapatanBulanLalu = Pembayaran::whereNotNull('verified_at')
            ->whereMonth('pembayaran.created_at', Carbon::now()->subMonth()->month)
            ->whereYear('pembayaran.created_at',  Carbon::now()->subMonth()->year)
            ->join('tagihan', 'pembayaran.tagihan_id', '=', 'tagihan.id')
            ->sum('tagihan.jumlah');

        return response()->json([
            'status'  => 'success',
            'message' => 'Dashboard stats retrieved successfully',
            'data'    => [
                'unit' => [
                    'total'    => $totalUnit,
                    'terisi'   => $unitTerisi,
                    'tersedia' => $unitTersedia,
                    'okupansi' => $okupansi,
                ],
                'pendapatan' => [
                    'bulan_ini'  => $pendapatanBulanIni,
                    'bulan_lalu' => $pendapatanBulanLalu,
                    'formatted'  => 'Rp ' . number_format($pendapatanBulanIni, 0, ',', '.'),
                ],
                'pending' => [
                    'pengaduan'   => Pengaduan::where('status', 'pending')->count(),
                    'permohonan'  => Penghuni::where('status', 'menunggu')->count(),
                    'pembayaran'  => Pembayaran::whereNull('verified_at')->whereHas('tagihan')->count(),
                    'user_approval' => User::where('role', 'penghuni')->where('status', 'pending')->count(),
                ],
            ],
            'timestamp' => Carbon::now()->toIso8601String(),
        ]);
    }

    /**
     * GET /api/admin/notifications
     * Notifikasi & item pending untuk admin
     */
    public function notifications()
    {
        $items = [];

        // Pengaduan pending
        $pengaduan = Pengaduan::with(['penghuni.user', 'penghuni.unit'])
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        foreach ($pengaduan as $p) {
            $items[] = [
                'type'    => 'pengaduan',
                'icon'    => 'fa-headset',
                'color'   => 'rose',
                'title'   => 'Pengaduan baru: ' . ($p->judul ?? 'Tanpa judul'),
                'subtitle'=> 'Dari ' . ($p->penghuni->user->name ?? '-') . ' · Unit ' . ($p->penghuni->unit->nomor ?? '-'),
                'time'    => $p->created_at->diffForHumans(),
                'url'     => '/admin/pengaduan/' . $p->id,
            ];
        }

        // Permohonan unit menunggu
        $permohonan = Penghuni::with(['unit.lantai', 'user'])
            ->where('status', 'menunggu')
            ->latest()
            ->take(5)
            ->get();

        foreach ($permohonan as $p) {
            $items[] = [
                'type'    => 'permohonan',
                'icon'    => 'fa-door-open',
                'color'   => 'amber',
                'title'   => 'Permohonan unit: ' . ($p->user->name ?? '-'),
                'subtitle'=> 'Unit ' . ($p->unit->nomor ?? '-') . ' · ' . ucfirst($p->unit->tipe ?? '-'),
                'time'    => $p->created_at->diffForHumans(),
                'url'     => '/admin/penghuni',
            ];
        }

        // Pembayaran menunggu verifikasi
        $pembayaran = Pembayaran::with(['tagihan.penghuni.user'])
            ->whereNull('verified_at')
            ->latest()
            ->take(5)
            ->get();

        foreach ($pembayaran as $p) {
            $items[] = [
                'type'    => 'pembayaran',
                'icon'    => 'fa-receipt',
                'color'   => 'teal',
                'title'   => 'Pembayaran menunggu verifikasi',
                'subtitle'=> 'Dari ' . ($p->tagihan->penghuni->user->name ?? '-') . ' · ' . ucfirst($p->tagihan->jenis ?? '-'),
                'time'    => $p->created_at->diffForHumans(),
                'url'     => '/admin/pembayaran',
            ];
        }

        // Sort by time (most recent first)
        usort($items, fn($a, $b) => strcmp($b['time'], $a['time']));

        return response()->json([
            'status'  => 'success',
            'message' => 'Notifications retrieved successfully',
            'data'    => [
                'total'         => count($items),
                'notifications' => $items,
            ],
            'timestamp' => Carbon::now()->toIso8601String(),
        ]);
    }

    /**
     * GET /api/admin/chart
     * Data grafik pendapatan 6 bulan terakhir
     */
    public function chart()
    {
        $months = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months[] = $date->format('Y-m');
        }

        $rawData = Pembayaran::whereNotNull('verified_at')
            ->where('pembayaran.created_at', '>=', Carbon::now()->subMonths(6)->startOfMonth())
            ->join('tagihan', 'pembayaran.tagihan_id', '=', 'tagihan.id')
            ->select(
                DB::raw('DATE_FORMAT(pembayaran.created_at, "%Y-%m") as bulan'),
                DB::raw('SUM(tagihan.jumlah) as total'),
                DB::raw('COUNT(pembayaran.id) as jumlah_transaksi')
            )
            ->groupBy(DB::raw('DATE_FORMAT(pembayaran.created_at, "%Y-%m")'))
            ->orderBy('bulan')
            ->get()
            ->keyBy('bulan');

        $labels = [];
        $values = [];
        $transactions = [];

        foreach ($months as $month) {
            $date = Carbon::createFromFormat('Y-m', $month);
            $labels[]       = $date->translatedFormat('M Y');
            $values[]       = (int) ($rawData[$month]->total ?? 0);
            $transactions[] = (int) ($rawData[$month]->jumlah_transaksi ?? 0);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Chart data retrieved successfully',
            'data'    => [
                'labels'       => $labels,
                'pendapatan'   => $values,
                'transaksi'    => $transactions,
                'period'       => '6 bulan terakhir',
                'total_period' => array_sum($values),
            ],
            'timestamp' => Carbon::now()->toIso8601String(),
        ]);
    }
}
