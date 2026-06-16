<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PembayaranController extends Controller
{
    public function verifikasi(Pembayaran $pembayaran)
{
    DB::transaction(function () use ($pembayaran) {
        // Tandai waktu verifikasi
        $pembayaran->update(['verified_at' => now()]);

        // Update status tagihan menjadi lunas
        $pembayaran->tagihan->update(['status' => 'lunas']);
    });

    return redirect()->back()
        ->with('success', 'Pembayaran telah diverifikasi dan tagihan ditandai lunas.');
}
    public function tolak(Pembayaran $pembayaran)
{
    DB::transaction(function () use ($pembayaran) {
        $tagihan = $pembayaran->tagihan;

        // Hapus bukti pembayaran dari storage
        Storage::disk('public')->delete($pembayaran->bukti_foto);

        // Hapus record pembayaran
        $pembayaran->delete();

        // Kembalikan status tagihan ke belum bayar
        $tagihan->update(['status' => 'belum_bayar']);
    });

    return redirect()->back()
        ->with('warning', 'Pembayaran ditolak. Penghuni perlu mengupload ulang bukti.');
}

}
