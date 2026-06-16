<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tagihan;
use App\Models\Penghuni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TagihanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $query = Tagihan::with(['penghuni.user', 'penghuni.unit', 'pembayaran']);

    // Filter bulan
    if ($request->filled('bulan')) {
        $query->where('bulan', $request->bulan);
    }

    // Filter status
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    // Filter jenis
    if ($request->filled('jenis')) {
        $query->where('jenis', $request->jenis);
    }

    $tagihan = $query->latest()->paginate(20)->withQueryString();

    // Statistik ringkasan
    $totalBelumBayar = Tagihan::where('status', 'belum_bayar')->count();
    $totalMenunggu = Tagihan::where('status', 'menunggu_verifikasi')->count();
    $totalLunas = Tagihan::where('status', 'lunas')->count();

    return view('admin.tagihan.index', compact(
        'tagihan', 'totalBelumBayar', 'totalMenunggu', 'totalLunas'
    ));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Tagihan $tagihan)
{
    $tagihan->load(['penghuni.user', 'penghuni.unit', 'pembayaran']);
    return view('admin.tagihan.show', compact('tagihan'));
}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function showGenerate()
    {
        $penghuni = Penghuni::with(['user', 'unit'])->where('status', 'aktif')->get();
        return view('admin.tagihan.generate', compact('penghuni'));
    }

public function generate(Request $request)
{
    $validated = $request->validate([
        'bulan' => 'required|date_format:Y-m',
        'jumlah_listrik' => 'required|numeric|min:0',
        'jumlah_air' => 'required|numeric|min:0',
        'jumlah_kebersihan' => 'required|numeric|min:0',
        'jatuh_tempo' => 'required|date',
    ]);

    $penghuni = Penghuni::with('unit')->where('status', 'aktif')->get();
    $bulan = $validated['bulan'];
    $created = 0;
    $skipped = 0;

    DB::transaction(function () use ($penghuni, $bulan, $validated, &$created, &$skipped) {
        foreach ($penghuni as $p) {
            // Cek apakah tagihan bulan ini sudah dibuat
            $sudahAda = Tagihan::where('penghuni_id', $p->id)
                ->where('bulan', $bulan)->exists();

            if ($sudahAda) {
                $skipped++;
                continue;
            }

            $jenisTagihan = [
                'sewa' => $p->unit->harga_sewa,
                'listrik' => $validated['jumlah_listrik'],
                'air' => $validated['jumlah_air'],
                'kebersihan' => $validated['jumlah_kebersihan'],
            ];

            foreach ($jenisTagihan as $jenis => $jumlah) {
                Tagihan::create([
                    'penghuni_id' => $p->id,
                    'bulan' => $bulan,
                    'jenis' => $jenis,
                    'jumlah' => $jumlah,
                    'status' => 'belum_bayar',
                    'jatuh_tempo' => $validated['jatuh_tempo'],
                ]);
            }
            $created++;
        }
    });

    return redirect()->route('admin.tagihan.index')
        ->with('success', "Tagihan berhasil digenerate untuk {$created} penghuni. {$skipped} penghuni dilewati (sudah ada).");
}

}
