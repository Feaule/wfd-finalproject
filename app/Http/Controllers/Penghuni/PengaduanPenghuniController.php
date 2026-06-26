<?php

namespace App\Http\Controllers\Penghuni;

use App\Http\Controllers\Controller;
use App\Models\Penghuni;
use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PengaduanPenghuniController extends Controller
{
    public function index()
    {
        $penghuni = Penghuni::where('user_id', Auth::id())->first();
        
        if (!$penghuni) {
            return redirect()->route('penghuni.dashboard')->with('error', 'Data penghuni tidak ditemukan');
        }

        $pengaduan = Pengaduan::where('penghuni_id', $penghuni->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('penghuni.pengaduan.index', compact('pengaduan', 'penghuni'));
    }

    public function create()
    {
        $penghuni = Penghuni::where('user_id', Auth::id())->first();
        
        if (!$penghuni) {
            return redirect()->route('penghuni.dashboard')->with('error', 'Data penghuni tidak ditemukan');
        }

        return view('penghuni.pengaduan.create', compact('penghuni'));
    }

    public function store(Request $request)
    {
        $penghuni = Penghuni::where('user_id', Auth::id())->first();
        
        if (!$penghuni) {
            return redirect()->route('penghuni.dashboard')->with('error', 'Data penghuni tidak ditemukan');
        }

        $validated = $request->validate([
            'kategori' => 'required|in:listrik,air,kebersihan,keamanan,fasilitas,lainnya',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $validated['penghuni_id'] = $penghuni->id;

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('pengaduan', 'public');
        }

        Pengaduan::create($validated);

        return redirect()->route('penghuni.pengaduan.index')
            ->with('success', 'Pengaduan berhasil dibuat. Akan segera ditindaklanjuti oleh admin.');
    }

    public function show(Pengaduan $pengaduan)
    {
        $penghuni = Penghuni::where('user_id', Auth::id())->first();
        
        if (!$penghuni || $pengaduan->penghuni_id !== $penghuni->id) {
            abort(403, 'Unauthorized');
        }

        return view('penghuni.pengaduan.show', compact('pengaduan', 'penghuni'));
    }

    public function destroy(Pengaduan $pengaduan)
    {
        $penghuni = Penghuni::where('user_id', Auth::id())->first();
        
        if (!$penghuni || $pengaduan->penghuni_id !== $penghuni->id) {
            abort(403, 'Unauthorized');
        }

        if ($pengaduan->status !== 'pending') {
            return redirect()->route('penghuni.pengaduan.index')
                ->with('error', 'Pengaduan yang sudah diproses tidak dapat dihapus');
        }

        if ($pengaduan->foto) {
            Storage::disk('public')->delete($pengaduan->foto);
        }

        $pengaduan->delete();

        return redirect()->route('penghuni.pengaduan.index')
            ->with('success', 'Pengaduan berhasil dihapus');
    }
}
