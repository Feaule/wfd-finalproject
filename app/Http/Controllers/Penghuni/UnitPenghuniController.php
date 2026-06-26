<?php

namespace App\Http\Controllers\Penghuni;

use App\Http\Controllers\Controller;
use App\Models\Penghuni;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UnitPenghuniController extends Controller
{
    /**
     * Tampilkan halaman unit:
     * - Jika penghuni aktif: tampilkan detail unit
     * - Jika penghuni menunggu: tampilkan status menunggu
     * - Jika belum punya unit: tampilkan daftar unit tersedia untuk pengajuan
     */
    public function index()
    {
        $penghuni = Penghuni::with(['unit.lantai'])
            ->where('user_id', Auth::id())
            ->whereIn('status', ['aktif', 'menunggu'])
            ->first();

        // Jika belum ada record penghuni atau sudah tidak aktif, tampilkan daftar unit tersedia
        $unitTersedia = null;
        if (!$penghuni) {
            $unitTersedia = Unit::with('lantai')
                ->where('status', 'tersedia')
                ->orderBy('lantai_id')
                ->orderBy('nomor')
                ->get();
        }

        return view('penghuni.unit', compact('penghuni', 'unitTersedia'));
    }

    /**
     * Proses pengajuan permohonan menempati unit
     */
    public function ajukan(Request $request, Unit $unit)
    {
        $user = Auth::user();

        // Pastikan unit masih tersedia
        if ($unit->status !== 'tersedia') {
            return redirect()->route('penghuni.unit')
                ->with('error', 'Maaf, unit tersebut sudah tidak tersedia.');
        }

        // Cek apakah penghuni sudah punya permohonan aktif atau sudah menghuni unit
        $existing = Penghuni::where('user_id', $user->id)
            ->whereIn('status', ['aktif', 'menunggu'])
            ->first();

        if ($existing) {
            return redirect()->route('penghuni.unit')
                ->with('error', 'Anda sudah memiliki permohonan atau sudah menempati unit.');
        }

        // Buat record penghuni dengan status menunggu
        Penghuni::create([
            'user_id'       => $user->id,
            'unit_id'       => $unit->id,
            'tanggal_masuk' => now()->toDateString(),
            'status'        => 'menunggu',
        ]);

        return redirect()->route('penghuni.unit')
            ->with('success', 'Permohonan menempati Unit ' . $unit->nomor . ' berhasil diajukan. Menunggu persetujuan admin.');
    }

    /**
     * Batalkan permohonan yang masih menunggu
     */
    public function batalkan()
    {
        $penghuni = Penghuni::where('user_id', Auth::id())
            ->where('status', 'menunggu')
            ->first();

        if (!$penghuni) {
            return redirect()->route('penghuni.unit')
                ->with('error', 'Tidak ada permohonan yang bisa dibatalkan.');
        }

        $penghuni->delete();

        return redirect()->route('penghuni.unit')
            ->with('success', 'Permohonan berhasil dibatalkan.');
    }
}
