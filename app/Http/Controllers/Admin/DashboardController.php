<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use App\Models\Penghuni;
use App\Models\User;
use App\Models\Pembayaran;
use App\Models\Pengaduan;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik Unit
        $totalUnit = Unit::count();
        $unitTerisi = Unit::where('status', 'terisi')->count();
        $unitTersedia = Unit::where('status', 'tersedia')->count();
        
        // Pendapatan bulan ini
        $pendapatanBulanIni = Pembayaran::whereNotNull('verified_at')
            ->whereMonth('pembayaran.created_at', Carbon::now()->month)
            ->whereYear('pembayaran.created_at', Carbon::now()->year)
            ->join('tagihan', 'pembayaran.tagihan_id', '=', 'tagihan.id')
            ->sum('tagihan.jumlah');
        
        // Pending approval penghuni
        $pendingApproval = User::where('role', 'penghuni')
            ->where('status', 'pending')
            ->count();
        
        // Laporan sewa per bulan (6 bulan terakhir)
        $laporanSewa = Pembayaran::whereNotNull('verified_at')
            ->where('pembayaran.created_at', '>=', Carbon::now()->subMonths(6))
            ->join('tagihan', 'pembayaran.tagihan_id', '=', 'tagihan.id')
            ->where('tagihan.jenis', 'sewa')
            ->select(
                DB::raw('DATE_FORMAT(pembayaran.created_at, "%Y-%m") as bulan'),
                DB::raw('SUM(tagihan.jumlah) as total')
            )
            ->groupBy(DB::raw('DATE_FORMAT(pembayaran.created_at, "%Y-%m")'))
            ->orderBy('bulan')
            ->get();
        
        // Timeline ketersediaan unit
        $timeline = Penghuni::with(['unit', 'user'])
            ->where('status', 'aktif')
            ->orderBy('tanggal_masuk')
            ->get();
        
        // Pending approval list
        $usersNeedApproval = User::where('role', 'penghuni')
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        // Pengaduan pending
        $pengaduanPendingCount = Pengaduan::where('status', 'pending')->count();
        $pengaduanPending = Pengaduan::with(['penghuni.user', 'penghuni.unit'])
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        // Permohonan unit menunggu
        $permohonanUnitCount = Penghuni::where('status', 'menunggu')->count();
        $permohonan = Penghuni::with(['unit.lantai', 'user'])
            ->where('status', 'menunggu')
            ->latest()
            ->take(5)
            ->get();

        // Pembayaran menunggu verifikasi
        $pembayaranPendingCount = Pembayaran::whereNull('verified_at')->count();
        $pembayaranPending = Pembayaran::with(['tagihan.penghuni.user', 'tagihan.penghuni.unit'])
            ->whereNull('verified_at')
            ->latest()
            ->take(5)
            ->get();
        
        return view('admin.dashboard', compact(
            'totalUnit',
            'unitTerisi',
            'unitTersedia',
            'pendapatanBulanIni',
            'pendingApproval',
            'laporanSewa',
            'timeline',
            'usersNeedApproval',
            'pengaduanPendingCount',
            'pengaduanPending',
            'permohonanUnitCount',
            'permohonan',
            'pembayaranPendingCount',
            'pembayaranPending'
        ));
    }

    public function approveUser(int $id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'active']);
        return back()->with('success', 'Pengguna berhasil disetujui');
    }

    public function rejectUser(int $id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'rejected']);
        return back()->with('success', 'Pengguna ditolak');
    }
}
