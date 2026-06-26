<?php

namespace App\Http\Controllers\Penghuni;

use App\Http\Controllers\Controller;
use App\Models\Penghuni;
use Illuminate\Support\Facades\Auth;

class DashboardPenghuniController extends Controller
{
    public function index()
    {
        $penghuni = Penghuni::with(['unit.lantai', 'tagihan', 'pengaduan'])
            ->where('user_id', Auth::id())
            ->first();

        if (!$penghuni) {
            return view('penghuni.dashboard', [
                'penghuni' => null,
                'stats' => [
                    'total_tagihan' => 0,
                    'belum_bayar' => 0,
                    'pengaduan_aktif' => 0
                ]
            ]);
        }

        $stats = [
            'total_tagihan' => $penghuni->tagihan()->count(),
            'belum_bayar' => $penghuni->tagihan()->where('status', 'belum_bayar')->count(),
            'pengaduan_aktif' => $penghuni->pengaduan()->whereIn('status', ['pending', 'proses'])->count()
        ];

        return view('penghuni.dashboard', compact('penghuni', 'stats'));
    }
}
