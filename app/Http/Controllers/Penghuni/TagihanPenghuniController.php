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
    // Dapatkan data penghuni yang sedang login
    $penghuni = Penghuni::where('user_id', auth()->id())->firstOrFail();

    $query = Tagihan::where('penghuni_id', $penghuni->id)
        ->with('pembayaran');

    if ($request->filled('bulan')) {
        $query->where('bulan', $request->bulan);
    }

    // Grup tagihan per bulan
    $tagihan = $query->orderBy('bulan', 'desc')->get();
    $tagihanPerBulan = $tagihan->groupBy('bulan');

    return view('penghuni.tagihan.index', compact('tagihanPerBulan', 'penghuni'));
}

}
