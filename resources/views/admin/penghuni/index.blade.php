@extends('layouts.admin')

@section('title', 'Data Penghuni')
@section('page-title', 'Data Penghuni')
@section('breadcrumb', 'Admin / Penghuni')

@section('topbar-actions')
    <a href="{{ route('admin.penghuni.create') }}" class="btn btn-primary">
        <i class="fa-solid fa-plus"></i> Tambah Penghuni
    </a>
@endsection

@section('content')
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon emerald"><i class="fa-solid fa-users"></i></div>
        <div class="stat-info">
            <p>Total Penghuni Aktif</p>
            <h3>{{ $penghuni->total() }}</h3>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon teal"><i class="fa-solid fa-user-check"></i></div>
        <div class="stat-info">
            <p>Aktif</p>
            <h3>{{ $penghuni->where('status', 'aktif')->count() }}</h3>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon amber"><i class="fa-solid fa-user-xmark"></i></div>
        <div class="stat-info">
            <p>Tidak Aktif</p>
            <h3>{{ $penghuni->where('status', 'tidak_aktif')->count() }}</h3>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(245,158,11,0.12)">
            <i class="fa-solid fa-door-open" style="color:var(--amber)"></i>
        </div>
        <div class="stat-info">
            <p>Menunggu Persetujuan</p>
            <h3 style="color:var(--amber)">{{ $permohonan->count() }}</h3>
        </div>
    </div>
</div>

{{-- SECTION: PERMOHONAN MENUNGGU --}}
@if($permohonan->count() > 0)
<div class="card" style="margin-bottom:20px; border: 1px solid var(--amber);">
    <div class="card-header" style="background: rgba(245,158,11,0.08);">
        <h2 class="card-title">
            <i class="fa-solid fa-door-open" style="color:var(--amber)"></i>
            Permohonan Unit Menunggu Persetujuan
            <span style="background:var(--amber);color:#fff;font-size:0.7rem;padding:2px 8px;border-radius:20px;margin-left:8px">
                {{ $permohonan->count() }}
            </span>
        </h2>
    </div>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Pemohon</th>
                    <th>Unit Diajukan</th>
                    <th>Tanggal Ajukan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($permohonan as $p)
                <tr>
                    <td>
                        <div style="font-weight:600;color:var(--text-primary)">{{ $p->user->name ?? '-' }}</div>
                        <div style="font-size:0.75rem;color:var(--text-muted)">{{ $p->user->email ?? '-' }}</div>
                    </td>
                    <td>
                        <span style="font-weight:600">Unit {{ $p->unit->nomor ?? '-' }}</span>
                        @if($p->unit && $p->unit->lantai)
                            <span style="font-size:0.75rem;color:var(--text-muted);display:block">
                                Lantai {{ $p->unit->lantai->nomor_lantai }}
                                &mdash; {{ ucfirst($p->unit->tipe ?? '') }}
                            </span>
                        @endif
                    </td>
                    <td style="color:var(--text-muted);font-size:0.85rem">
                        {{ $p->created_at->format('d M Y') }}<br>
                        <span style="font-size:0.75rem">{{ $p->created_at->diffForHumans() }}</span>
                    </td>
                    <td>
                        <div style="display:flex;gap:8px">
                            <form action="{{ route('admin.penghuni.approve-permohonan', $p->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm"
                                        onclick="return confirm('Setujui permohonan {{ $p->user->name ?? '' }}?')">
                                    <i class="fa-solid fa-check"></i> Setujui
                                </button>
                            </form>
                            <form action="{{ route('admin.penghuni.reject-permohonan', $p->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Tolak permohonan {{ $p->user->name ?? '' }}?')">
                                    <i class="fa-solid fa-times"></i> Tolak
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

<div class="card" style="margin-bottom:20px">
    <div class="card-body" style="padding:20px 24px">
        <form method="GET" action="{{ route('admin.penghuni.index') }}" class="filter-bar">
            <div class="form-group">
                <label class="form-label" style="font-size:0.75rem">Cari Penghuni</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..."
                    class="form-control" style="min-width:250px">
            </div>
            <div class="form-group">
                <label class="form-label" style="font-size:0.75rem">Status</label>
                <select name="status" class="form-control" style="min-width:150px">
                    <option value="">Semua Status</option>
                    <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="tidak_aktif" {{ request('status') == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
            </div>
            <div style="display:flex;gap:8px;align-items:flex-end">
                <button type="submit" class="btn btn-primary btn-sm"><i class="fa-solid fa-search"></i> Filter</button>
                @if(request('search') || request('status'))
                    <a href="{{ route('admin.penghuni.index') }}" class="btn btn-secondary btn-sm"><i class="fa-solid fa-rotate-right"></i> Reset</a>
                @endif
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2 class="card-title"><i class="fa-solid fa-users" style="color:var(--accent)"></i> Daftar Penghuni</h2>
    </div>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama / Email</th>
                    <th>Unit</th>
                    <th>Tanggal Masuk</th>
                    <th>Tanggal Keluar</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($penghuni as $index => $p)
                <tr>
                    <td style="color:var(--text-muted)">{{ $penghuni->firstItem() + $index }}</td>
                    <td>
                        <div style="font-weight:600;color:var(--text-primary)">{{ $p->user->name }}</div>
                        <div style="font-size:0.75rem;color:var(--text-muted)">{{ $p->user->email }}</div>
                    </td>
                    <td>
                        <span style="font-weight:600">Unit {{ $p->unit->nomor }}</span>
                        @if($p->unit->tipe)
                            <span style="font-size:0.75rem;color:var(--text-muted);display:block">{{ ucfirst($p->unit->tipe) }}</span>
                        @endif
                    </td>
                    <td>{{ $p->tanggal_masuk->format('d M Y') }}</td>
                    <td>{!! $p->tanggal_keluar ? $p->tanggal_keluar->format('d M Y') : '<span style="color:var(--text-muted)">-</span>' !!}</td>
                    <td>
                        @if($p->status === 'aktif')
                            <span class="badge badge-aktif"><i class="fa-solid fa-circle" style="font-size:0.5rem"></i> Aktif</span>
                        @elseif($p->status === 'menunggu')
                            <span class="badge" style="background:rgba(245,158,11,0.15);color:var(--amber);border:1px solid var(--amber)">
                                <i class="fa-solid fa-clock" style="font-size:0.7rem"></i> Menunggu
                            </span>
                        @else
                            <span class="badge badge-nonaktif"><i class="fa-solid fa-circle" style="font-size:0.5rem"></i> Tidak Aktif</span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex;gap:8px">
                            <a href="{{ route('admin.penghuni.edit', $p) }}" class="btn btn-sm btn-secondary" title="Edit">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <form action="{{ route('admin.penghuni.destroy', $p) }}" method="POST"
                                  onsubmit="return confirm('Yakin hapus penghuni {{ $p->user->name }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center;padding:40px;color:var(--text-muted)">
                        <i class="fa-solid fa-users-slash" style="font-size:2rem;margin-bottom:10px;display:block;opacity:0.4"></i>
                        Belum ada data penghuni
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($penghuni->hasPages())
    <div class="pagination-wrapper">
        <div style="font-size:0.8rem;color:var(--text-muted)">
            Menampilkan {{ $penghuni->firstItem() }}–{{ $penghuni->lastItem() }} dari {{ $penghuni->total() }} data
        </div>
        {{ $penghuni->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection
