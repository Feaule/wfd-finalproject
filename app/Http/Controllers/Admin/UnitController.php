<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use App\Models\Lantai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UnitController extends Controller
{
    public function index()
    {
        $lantai = Lantai::with(['units' => function($q) {
            $q->orderBy('nomor');
        }])->orderBy('nomor_lantai')->get();
        
        return view('admin.unit.index', compact('lantai'));
    }

    public function create()
    {
        $lantai = Lantai::orderBy('nomor_lantai')->get();
        return view('admin.unit.create', compact('lantai'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'lantai_id' => 'required|exists:lantai,id',
            'nomor' => 'required|string|max:10',
            'tipe' => 'required|in:studio,1BR,2BR',
            'luas_m2' => 'required|integer',
            'harga_sewa' => 'required|numeric',
            'status' => 'required|in:tersedia,terisi',
            'foto' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();
        
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('units', 'public');
        }

        Unit::create($data);
        return redirect()->route('admin.unit.index')->with('success', 'Unit berhasil ditambahkan');
    }

    public function edit(Unit $unit)
    {
        $lantai = Lantai::orderBy('nomor_lantai')->get();
        return view('admin.unit.edit', compact('unit', 'lantai'));
    }

    public function update(Request $request, Unit $unit)
    {
        $request->validate([
            'lantai_id' => 'required|exists:lantai,id',
            'nomor' => 'required|string|max:10',
            'tipe' => 'required|in:studio,1BR,2BR',
            'luas_m2' => 'required|integer',
            'harga_sewa' => 'required|numeric',
            'status' => 'required|in:tersedia,terisi',
            'foto' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            if ($unit->foto) {
                Storage::disk('public')->delete($unit->foto);
            }
            $data['foto'] = $request->file('foto')->store('units', 'public');
        }

        $unit->update($data);
        return redirect()->route('admin.unit.index')->with('success', 'Unit berhasil diupdate');
    }

    public function destroy(Unit $unit)
    {
        if ($unit->status === 'terisi' || $unit->penghuni()->count() > 0) {
            return redirect()->route('admin.unit.index')->with('error', 'Unit tidak dapat dihapus karena berstatus terisi atau memiliki riwayat penghuni.');
        }

        if ($unit->foto) {
            Storage::disk('public')->delete($unit->foto);
        }
        $unit->delete();
        return redirect()->route('admin.unit.index')->with('success', 'Unit berhasil dihapus');
    }
}
