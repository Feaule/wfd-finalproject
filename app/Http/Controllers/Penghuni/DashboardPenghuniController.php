<?php

namespace App\Http\Controllers\Penghuni;

use App\Http\Controllers\Controller;
use App\Models\Penghuni;
use App\Models\Tagihan;
use Illuminate\Support\Facades\Auth;

class DashboardPenghuniController extends Controller
{
    public function index()
    {
        $penghuni = Penghuni::with(['unit.lantai', 'tagihan.pembayaran', 'pengaduan'])
            ->where('user_id', Auth::id())
            ->where('status', 'aktif')
            ->first();

        // Cek apakah ada permohonan menunggu
        $permohonanMenunggu = null;
        if (!$penghuni) {
            $permohonanMenunggu = Penghuni::with('unit')
                ->where('user_id', Auth::id())
                ->where('status', 'menunggu')
                ->first();
        }

        if (!$penghuni) {
            return view('penghuni.dashboard', [
                'penghuni'           => null,
                'permohonanMenunggu' => $permohonanMenunggu,
                'stats'              => [
                    'total_tagihan'   => 0,
                    'belum_bayar'     => 0,
                    'pengaduan_aktif' => 0,
                    'total_belum_rp'  => 0,
                ],
                'tagihanTerbaru' => collect(),
            ]);
        }

        $stats = [
            'total_tagihan'   => $penghuni->tagihan()->count(),
            'belum_bayar'     => $penghuni->tagihan()->where('status', 'belum_bayar')->count(),
            'pengaduan_aktif' => $penghuni->pengaduan()->whereIn('status', ['pending', 'proses'])->count(),
            'total_belum_rp'  => $penghuni->tagihan()->where('status', 'belum_bayar')->sum('jumlah'),
        ];

        // Ambil 4 tagihan terbaru yang belum lunas untuk quick action
        $tagihanTerbaru = Tagihan::where('penghuni_id', $penghuni->id)
            ->whereIn('status', ['belum_bayar', 'menunggu_verifikasi'])
            ->with('pembayaran')
            ->orderBy('bulan', 'desc')
            ->orderBy('jenis')
            ->take(4)
            ->get();

        return view('penghuni.dashboard', compact('penghuni', 'stats', 'tagihanTerbaru', 'permohonanMenunggu'));
    }
}
