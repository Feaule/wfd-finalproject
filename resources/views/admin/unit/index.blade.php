@extends('layouts.admin')

@section('title', 'Data Unit')
@section('page-title', 'Data Unit')
@section('breadcrumb', 'Admin / Unit')

@section('topbar-actions')
    <a href="{{ route('admin.unit.create') }}" class="btn btn-primary">
        <i class="fa-solid fa-plus"></i> Tambah Unit
    </a>
@endsection

@section('content')
@php
    $units = $lantai->flatMap->units;
    $totalUnit = $units->count();
    $unitTersedia = $units->where('status', 'tersedia')->count();
    $unitTerisi = $units->where('status', 'terisi')->count();
@endphp

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon indigo"><i class="fa-solid fa-building"></i></div>
        <div class="stat-info">
            <p>Total Unit</p>
            <h3>{{ $totalUnit }}</h3>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon emerald"><i class="fa-solid fa-door-open"></i></div>
        <div class="stat-info">
            <p>Tersedia</p>
            <h3>{{ $unitTersedia }}</h3>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon rose"><i class="fa-solid fa-door-closed"></i></div>
        <div class="stat-info">
            <p>Terisi</p>
            <h3>{{ $unitTerisi }}</h3>
        </div>
    </div>
</div>

<div class="card" style="margin-bottom:24px">
    <div class="card-body" style="padding:18px 24px">
        <div style="display:flex;gap:18px;flex-wrap:wrap;align-items:center">
            <span style="font-size:0.8rem;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.5px">Keterangan</span>
            <span class="badge badge-aktif"><i class="fa-solid fa-circle" style="font-size:0.5rem"></i> Tersedia</span>
            <span class="badge badge-belum"><i class="fa-solid fa-circle" style="font-size:0.5rem"></i> Terisi</span>
        </div>
    </div>
</div>

@forelse($lantai as $floor)
<div class="card" style="margin-bottom:24px">
    <div class="card-header">
        <div>
            <h2 class="card-title"><i class="fa-solid fa-layer-group" style="color:var(--accent)"></i> Lantai {{ $floor->nomor_lantai }}</h2>
            <div style="font-size:0.8rem;color:var(--text-muted);margin-top:4px">{{ $floor->nama ?? 'Tanpa nama lantai' }}</div>
        </div>
        <span style="font-size:0.8rem;color:var(--text-muted)">{{ $floor->units->count() }} unit</span>
    </div>
    <div class="card-body">
        @if($floor->units->count())
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:16px">
            @foreach($floor->units as $unit)
            <div style="border:1px solid {{ $unit->status === 'tersedia' ? 'var(--emerald)' : 'var(--rose)' }};border-radius:var(--radius-sm);overflow:hidden;background:{{ $unit->status === 'tersedia' ? 'var(--emerald-light)' : 'var(--rose-light)' }}">
                @if($unit->foto)
                    <img src="{{ asset('storage/' . $unit->foto) }}" alt="Unit {{ $unit->nomor }}" style="width:100%;height:110px;object-fit:cover;border-bottom:1px solid var(--border)">
                @else
                    <div style="height:110px;display:flex;align-items:center;justify-content:center;background:rgba(255,255,255,0.04);border-bottom:1px solid var(--border);color:var(--text-muted)">
                        <i class="fa-solid fa-building" style="font-size:2rem;opacity:0.45"></i>
                    </div>
                @endif
                <div style="padding:14px">
                    <div style="display:flex;justify-content:space-between;gap:10px;align-items:flex-start;margin-bottom:10px">
                        <div>
                            <div style="font-size:1rem;font-weight:800;color:var(--text-primary)">Unit {{ $unit->nomor }}</div>
                            <div style="font-size:0.75rem;color:var(--text-muted);margin-top:2px">{{ $unit->tipe }} | {{ $unit->luas_m2 }} m&sup2;</div>
                        </div>
                        @if($unit->status === 'tersedia')
                            <span class="badge badge-aktif"><i class="fa-solid fa-circle" style="font-size:0.45rem"></i> Tersedia</span>
                        @else
                            <span class="badge badge-belum"><i class="fa-solid fa-circle" style="font-size:0.45rem"></i> Terisi</span>
                        @endif
                    </div>

                    <div style="font-weight:700;color:var(--text-primary);margin-bottom:12px">
                        Rp {{ number_format($unit->harga_sewa, 0, ',', '.') }}
                    </div>

                    <div style="display:flex;gap:8px">
                        <a href="{{ route('admin.unit.edit', $unit) }}" class="btn btn-sm btn-secondary" title="Edit">
                            <i class="fa-solid fa-pen"></i>
                        </a>
                        @if($unit->status === 'terisi' || $unit->penghuni()->count() > 0)
                            <button type="button" class="btn btn-sm" style="background: var(--text-muted); color: white; cursor: not-allowed; opacity: 0.6; border: none;" title="Unit tidak bisa dihapus karena sedang terisi atau memiliki riwayat penghuni">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        @else
                            <form action="{{ route('admin.unit.destroy', $unit) }}" method="POST"
                                  onsubmit="return confirm('Yakin hapus unit {{ $unit->nomor }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div style="text-align:center;padding:36px;color:var(--text-muted)">
            <i class="fa-solid fa-door-open" style="font-size:2rem;margin-bottom:10px;display:block;opacity:0.35"></i>
            Belum ada unit di lantai ini
        </div>
        @endif
    </div>
</div>
@empty
<div class="card">
    <div class="card-body" style="text-align:center;padding:48px;color:var(--text-muted)">
        <i class="fa-solid fa-layer-group" style="font-size:2.5rem;margin-bottom:12px;display:block;opacity:0.35"></i>
        Belum ada data lantai.
        <a href="{{ route('admin.lantai.create') }}" style="color:var(--accent);font-weight:600;text-decoration:underline">Tambah lantai dulu</a>
    </div>
</div>
@endforelse
@endsection
