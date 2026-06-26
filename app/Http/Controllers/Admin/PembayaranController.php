<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PembayaranController extends Controller
{
    /**
     * Daftar semua pembayaran yang menunggu verifikasi
     */
    public function index(Request $request)
    {
        $query = Pembayaran::with(['tagihan.penghuni.user', 'tagihan.penghuni.unit'])
            ->whereNull('verified_at'); // Hanya yang belum diverifikasi

        // Filter: tampilkan semua atau termasuk yang sudah diverifikasi
        if ($request->get('tampilkan') === 'semua') {
            $query = Pembayaran::with(['tagihan.penghuni.user', 'tagihan.penghuni.unit']);
        }

        $pembayaran = $query->latest()->paginate(20)->withQueryString();

        $totalMenunggu  = Pembayaran::whereNull('verified_at')->count();
        $totalVerifikasi = Pembayaran::whereNotNull('verified_at')->count();

        return view('admin.pembayaran.index', compact(
            'pembayaran',
            'totalMenunggu',
            'totalVerifikasi'
        ));
    }

    /**
     * Verifikasi pembayaran → tandai tagihan lunas
     */
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

    /**
     * Tolak pembayaran → hapus bukti, kembalikan status tagihan
     */
    public function tolak(Pembayaran $pembayaran)
    {
        DB::transaction(function () use ($pembayaran) {
            $tagihan = $pembayaran->tagihan;

            // Hapus bukti pembayaran dari storage
            if ($pembayaran->bukti_foto) {
                Storage::disk('public')->delete($pembayaran->bukti_foto);
            }

            // Hapus record pembayaran
            $pembayaran->delete();

            // Kembalikan status tagihan ke belum bayar
            $tagihan->update(['status' => 'belum_bayar']);
        });

        return redirect()->back()
            ->with('warning', 'Pembayaran ditolak. Penghuni perlu mengupload ulang bukti.');
    }
}
