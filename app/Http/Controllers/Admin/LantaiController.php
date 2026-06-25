<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lantai;
use Illuminate\Http\Request;

class LantaiController extends Controller
{
    public function index()
    {
        $lantai = Lantai::withCount('units')->orderBy('nomor_lantai')->get();
        return view('admin.lantai.index', compact('lantai'));
    }

    public function create()
    {
        return view('admin.lantai.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_lantai' => 'required|integer|unique:lantai',
            'nama' => 'nullable|string|max:255',
        ]);

        Lantai::create($request->all());
        return redirect()->route('admin.lantai.index')->with('success', 'Lantai berhasil ditambahkan');
    }

    public function edit(Lantai $lantai)
    {
        return view('admin.lantai.edit', compact('lantai'));
    }

    public function update(Request $request, Lantai $lantai)
    {
        $request->validate([
            'nomor_lantai' => 'required|integer|unique:lantai,nomor_lantai,' . $lantai->id,
            'nama' => 'nullable|string|max:255',
        ]);

        $lantai->update($request->all());
        return redirect()->route('admin.lantai.index')->with('success', 'Lantai berhasil diupdate');
    }

    public function destroy(Lantai $lantai)
    {
        $lantai->delete();
        return redirect()->route('admin.lantai.index')->with('success', 'Lantai berhasil dihapus');
    }
}
