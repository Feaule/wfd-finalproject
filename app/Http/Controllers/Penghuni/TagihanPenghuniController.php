<?php

namespace App\Http\Controllers\Penghuni;

use App\Http\Controllers\Controller;
use App\Models\Penghuni;
use App\Models\Tagihan;
use Illuminate\Http\Request;

class TagihanPenghuniController extends Controller
{
    public function index(Request $request)
    {
        // Dapatkan data penghuni yang sedang login (harus aktif)
        $penghuni = Penghuni::with(['unit.lantai'])
            ->where('user_id', auth()->id())
            ->where('status', 'aktif')
            ->first();

        // Jika belum punya unit aktif, redirect ke halaman unit
        if (!$penghuni) {
            // Cek apakah ada permohonan menunggu
            $menunggu = Penghuni::where('user_id', auth()->id())
                ->where('status', 'menunggu')
                ->exists();

            if ($menunggu) {
                return redirect()->route('penghuni.unit')
                    ->with('info', 'Permohonan unit Anda masih menunggu persetujuan admin. Tagihan akan tersedia setelah unit disetujui.');
            }

            return redirect()->route('penghuni.unit')
                ->with('info', 'Anda belum memiliki unit. Silakan ajukan permohonan unit terlebih dahulu.');
        }

        $query = Tagihan::where('penghuni_id', $penghuni->id)
            ->with('pembayaran');

        if ($request->filled('bulan')) {
            $query->where('bulan', $request->bulan);
        }

        // Grup tagihan per bulan, urutkan dari terbaru
        $tagihan         = $query->orderBy('bulan', 'desc')->orderBy('jenis')->get();
        $tagihanPerBulan = $tagihan->groupBy('bulan');

        return view('penghuni.tagihan.index', compact('tagihanPerBulan', 'penghuni'));
    }
}
