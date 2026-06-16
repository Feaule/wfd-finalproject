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
    public function create(Tagihan $tagihan)
{
    // Pastikan tagihan ini milik penghuni yang login
    $penghuni = Penghuni::where('user_id', auth()->id())->firstOrFail();
    if ($tagihan->penghuni_id !== $penghuni->id) {
        abort(403, 'Akses tidak diizinkan.');
    }
    if ($tagihan->status !== 'belum_bayar') {
        return redirect()->route('penghuni.tagihan.index')
            ->with('info', 'Tagihan ini sudah dalam proses atau sudah lunas.');
    }
    return view('penghuni.pembayaran.create', compact('tagihan'));
}
    public function store(Request $request, Tagihan $tagihan)
{
    $penghuni = Penghuni::where('user_id', auth()->id())->firstOrFail();
    if ($tagihan->penghuni_id !== $penghuni->id) {
        abort(403);
    }

    $validated = $request->validate([
        'bukti_foto' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        'metode' => 'required|string|max:100',
    ]);

    DB::transaction(function () use ($request, $tagihan, $validated) {
        // Simpan file
        $path = $request->file('bukti_foto')
            ->store('bukti-pembayaran', 'public');

        // Buat record pembayaran
        Pembayaran::create([
            'tagihan_id' => $tagihan->id,
            'tanggal' => now()->toDateString(),
            'bukti_foto' => $path,
            'metode' => $validated['metode'],
        ]);

        // Update status tagihan
        $tagihan->update(['status' => 'menunggu_verifikasi']);
    });

    return redirect()->route('penghuni.tagihan.index')
        ->with('success', 'Bukti pembayaran berhasil dikirim. Menunggu verifikasi admin.');
}

}
