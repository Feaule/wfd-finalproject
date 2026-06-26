<?php

namespace App\Http\Controllers\Penghuni;

use App\Http\Controllers\Controller;
use App\Models\Penghuni;
use App\Models\Tagihan;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembayaranPenghuniController extends Controller
{
    /**
     * Tampilkan form upload bukti pembayaran
     */
    public function create(Tagihan $tagihan)
    {
        // Cari penghuni yang login dan aktif
        $penghuni = Penghuni::where('user_id', auth()->id())
            ->where('status', 'aktif')
            ->first();

        if (!$penghuni) {
            abort(403, 'Akses tidak diizinkan. Anda bukan penghuni aktif.');
        }

        // Pastikan tagihan ini milik penghuni yang login
        if ($tagihan->penghuni_id !== $penghuni->id) {
            abort(403, 'Akses tidak diizinkan. Tagihan ini bukan milik Anda.');
        }

        // Cek status tagihan — hanya bisa bayar jika belum_bayar
        if ($tagihan->status !== 'belum_bayar') {
            $pesan = match($tagihan->status) {
                'menunggu_verifikasi' => 'Bukti pembayaran sudah dikirim dan sedang menunggu verifikasi admin.',
                'lunas'               => 'Tagihan ini sudah lunas.',
                default               => 'Tagihan ini sudah diproses.',
            };
            return redirect()->route('penghuni.tagihan.index')->with('info', $pesan);
        }

        return view('penghuni.pembayaran.create', compact('tagihan'));
    }

    /**
     * Simpan bukti pembayaran yang diupload
     */
    public function store(Request $request, Tagihan $tagihan)
    {
        $penghuni = Penghuni::where('user_id', auth()->id())
            ->where('status', 'aktif')
            ->first();

        if (!$penghuni) {
            abort(403);
        }

        if ($tagihan->penghuni_id !== $penghuni->id) {
            abort(403);
        }

        if ($tagihan->status !== 'belum_bayar') {
            return redirect()->route('penghuni.tagihan.index')
                ->with('info', 'Tagihan ini sudah dalam proses atau sudah lunas.');
        }

        $request->validate([
            'bukti_foto' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'metode'     => 'required|string|max:100',
        ]);

        DB::transaction(function () use ($request, $tagihan) {
            // Simpan file bukti
            $path = $request->file('bukti_foto')
                ->store('bukti-pembayaran', 'public');

            // Buat record pembayaran
            Pembayaran::create([
                'tagihan_id' => $tagihan->id,
                'tanggal'    => now()->toDateString(),
                'bukti_foto' => $path,
                'metode'     => $request->metode,
            ]);

            // Update status tagihan ke menunggu verifikasi
            $tagihan->update(['status' => 'menunggu_verifikasi']);
        });

        return redirect()->route('penghuni.tagihan.index')
            ->with('success', 'Bukti pembayaran berhasil dikirim. Menunggu verifikasi admin.');
    }
}
