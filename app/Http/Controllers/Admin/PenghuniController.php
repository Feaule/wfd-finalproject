<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penghuni;
use App\Models\User;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenghuniController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request)
{
    // Permohonan menunggu approve (selalu tampilkan di atas)
    $permohonan = Penghuni::with(['user', 'unit.lantai'])
        ->where('status', 'menunggu')
        ->latest()
        ->get();

    $query = Penghuni::with(['user', 'unit'])
        ->where('status', '!=', 'menunggu');

    // Search by name or email
    if ($request->filled('search')) {
        $search = $request->search;
        $query->whereHas('user', function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
        });
    }

    // Filter by status
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    $penghuni = $query->latest()->paginate(10)->withQueryString();
    return view('admin.penghuni.index', compact('penghuni', 'permohonan'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    // Ambil user yang belum jadi penghuni (role penghuni, status approved)
    $users = User::where('role', 'penghuni')
        ->whereDoesntHave('penghuni')
        ->get();
    $units = Unit::where('status', 'tersedia')->get();
    return view('admin.penghuni.create', compact('users', 'units'));
}


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'user_id' => 'required|exists:users,id|unique:penghuni,user_id',
        'unit_id' => 'required|exists:unit,id',
        'tanggal_masuk' => 'required|date',
        'tanggal_keluar' => 'nullable|date|after:tanggal_masuk',
    ]);

    DB::transaction(function () use ($validated) {
        Penghuni::create(array_merge($validated, ['status' => 'aktif']));
        // Update status unit menjadi terisi
        Unit::find($validated['unit_id'])->update(['status' => 'terisi']);
    });

    return redirect()->route('admin.penghuni.index')
        ->with('success', 'Data penghuni berhasil ditambahkan.');
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
   public function edit(Penghuni $penghuni)
{
    $units = Unit::where('status', 'tersedia')
        ->orWhere('id', $penghuni->unit_id)->get();
    return view('admin.penghuni.edit', compact('penghuni', 'units'));
}

public function update(Request $request, Penghuni $penghuni)
{
    $validated = $request->validate([
        'unit_id' => 'required|exists:unit,id',
        'tanggal_masuk' => 'required|date',
        'tanggal_keluar' => 'nullable|date|after:tanggal_masuk',
        'status' => 'required|in:aktif,tidak_aktif',
    ]);

    $oldUnitId = $penghuni->unit_id;

    DB::transaction(function () use ($validated, $penghuni, $oldUnitId) {
        $penghuni->update($validated);
        // Jika unit berubah, update status unit lama & baru
        if ($oldUnitId !== (int)$validated['unit_id']) {
            Unit::find($oldUnitId)->update(['status' => 'tersedia']);
            Unit::find($validated['unit_id'])->update(['status' => 'terisi']);
        }
        // Jika status menjadi tidak_aktif, bebaskan unit
        if ($validated['status'] === 'tidak_aktif') {
            Unit::find($validated['unit_id'])->update(['status' => 'tersedia']);
        }
    });

    return redirect()->route('admin.penghuni.index')
        ->with('success', 'Data penghuni berhasil diperbarui.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penghuni $penghuni)
{
    DB::transaction(function () use ($penghuni) {
        // Bebaskan unit hanya jika penghuni aktif (bukan sekedar menunggu)
        if ($penghuni->status === 'aktif' && $penghuni->unit_id) {
            Unit::find($penghuni->unit_id)->update(['status' => 'tersedia']);
        }
        $penghuni->delete();
    });
    return redirect()->route('admin.penghuni.index')
        ->with('success', 'Data penghuni berhasil dihapus.');
}

    /**
     * Approve permohonan unit dari penghuni (status: menunggu -> aktif)
     */
    public function approvePermohonan(Penghuni $penghuni)
    {
        if ($penghuni->status !== 'menunggu') {
            return redirect()->route('admin.penghuni.index')
                ->with('error', 'Permohonan ini tidak dalam status menunggu.');
        }

        DB::transaction(function () use ($penghuni) {
            $penghuni->update(['status' => 'aktif']);
            // Tandai unit sebagai terisi
            Unit::find($penghuni->unit_id)->update(['status' => 'terisi']);
        });

        return redirect()->route('admin.penghuni.index')
            ->with('success', 'Permohonan penghuni ' . $penghuni->user->name . ' disetujui.');
    }

    /**
     * Reject permohonan unit dari penghuni (hapus record)
     */
    public function rejectPermohonan(Penghuni $penghuni)
    {
        if ($penghuni->status !== 'menunggu') {
            return redirect()->route('admin.penghuni.index')
                ->with('error', 'Permohonan ini tidak dalam status menunggu.');
        }

        $nama = $penghuni->user->name ?? 'Penghuni';
        $penghuni->delete();

        return redirect()->route('admin.penghuni.index')
            ->with('warning', 'Permohonan ' . $nama . ' telah ditolak.');
    }

}
