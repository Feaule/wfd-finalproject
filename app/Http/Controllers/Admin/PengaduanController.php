<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use Illuminate\Http\Request;

class PengaduanController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengaduan::with(['penghuni.user', 'penghuni.unit']);

        // Search by judul or penghuni name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%")
                  ->orWhereHas('penghuni.user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $pengaduan = $query->latest()->paginate(10)->withQueryString();
        
        return view('admin.pengaduan.index', compact('pengaduan'));
    }

    public function show(Pengaduan $pengaduan)
    {
        $pengaduan->load(['penghuni.user', 'penghuni.unit']);
        return view('admin.pengaduan.show', compact('pengaduan'));
    }

    public function update(Request $request, Pengaduan $pengaduan)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,proses,selesai,ditolak',
            'tanggapan' => 'nullable|string|max:1000',
        ]);

        $pengaduan->update($validated);

        return redirect()->route('admin.pengaduan.show', $pengaduan)
            ->with('success', 'Status pengaduan berhasil diperbarui.');
    }
}
