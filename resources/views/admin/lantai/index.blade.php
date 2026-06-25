@extends('layouts.admin')

@section('title', 'Data Lantai')
@section('page-title', 'Data Lantai')
@section('breadcrumb', 'Admin / Lantai')

@section('topbar-actions')
    <a href="{{ route('admin.lantai.create') }}" class="btn btn-primary">
        <i class="fa-solid fa-plus"></i> Tambah Lantai
    </a>
@endsection

@section('content')
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon indigo"><i class="fa-solid fa-layer-group"></i></div>
        <div class="stat-info">
            <p>Total Lantai</p>
            <h3>{{ $lantai->count() }}</h3>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon teal"><i class="fa-solid fa-building"></i></div>
        <div class="stat-info">
            <p>Total Unit</p>
            <h3>{{ $lantai->sum('units_count') }}</h3>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon amber"><i class="fa-solid fa-door-open"></i></div>
        <div class="stat-info">
            <p>Rata-rata Unit</p>
            <h3>{{ $lantai->count() ? number_format($lantai->sum('units_count') / $lantai->count(), 1) : 0 }}</h3>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2 class="card-title"><i class="fa-solid fa-layer-group" style="color:var(--accent)"></i> Daftar Lantai</h2>
        <span style="font-size:0.8rem;color:var(--text-muted)">Total: {{ $lantai->count() }} lantai</span>
    </div>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>No. Lantai</th>
                    <th>Nama / Deskripsi</th>
                    <th>Jumlah Unit</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($lantai as $item)
                <tr>
                    <td style="font-weight:700;color:var(--text-primary)">Lantai {{ $item->nomor_lantai }}</td>
                    <td>
                        <div style="font-weight:600;color:var(--text-primary)">{{ $item->nama ?? 'Tanpa nama' }}</div>
                        @if(!$item->nama)
                            <div style="font-size:0.75rem;color:var(--text-muted)">Belum ada deskripsi</div>
                        @endif
                    </td>
                    <td>
                        <span class="badge badge-sewa">
                            <i class="fa-solid fa-building"></i> {{ $item->units_count }} unit
                        </span>
                    </td>
                    <td>
                        <div style="display:flex;gap:8px;align-items:center">
                            <a href="{{ route('admin.lantai.edit', $item) }}" class="btn btn-sm btn-secondary" title="Edit">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <form action="{{ route('admin.lantai.destroy', $item) }}" method="POST"
                                  onsubmit="return confirm('Yakin hapus lantai {{ $item->nomor_lantai }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align:center;padding:48px;color:var(--text-muted)">
                        <i class="fa-solid fa-layer-group" style="font-size:2.5rem;margin-bottom:12px;display:block;opacity:0.35"></i>
                        Belum ada data lantai
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
