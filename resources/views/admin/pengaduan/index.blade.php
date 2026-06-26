@extends('layouts.admin')

@section('title', 'Data Pengaduan')
@section('page-title', 'Data Pengaduan')
@section('breadcrumb', 'Admin / Pengaduan')

@section('content')
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon amber"><i class="fa-solid fa-clock"></i></div>
        <div class="stat-info">
            <p>Pending</p>
            <h3>{{ $pengaduan->where('status', 'pending')->count() }}</h3>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon indigo"><i class="fa-solid fa-spinner"></i></div>
        <div class="stat-info">
            <p>Proses</p>
            <h3>{{ $pengaduan->where('status', 'proses')->count() }}</h3>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon emerald"><i class="fa-solid fa-check-circle"></i></div>
        <div class="stat-info">
            <p>Selesai</p>
            <h3>{{ $pengaduan->where('status', 'selesai')->count() }}</h3>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon rose"><i class="fa-solid fa-xmark-circle"></i></div>
        <div class="stat-info">
            <p>Ditolak</p>
            <h3>{{ $pengaduan->where('status', 'ditolak')->count() }}</h3>
        </div>
    </div>
</div>

<div class="card" style="margin-bottom:20px">
    <div class="card-body" style="padding:20px 24px">
        <form method="GET" action="{{ route('admin.pengaduan.index') }}" class="filter-bar">
            <div class="form-group">
                <label class="form-label" style="font-size:0.75rem">Cari Pengaduan</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul, deskripsi, atau nama penghuni..."
                    class="form-control" style="min-width:280px">
            </div>
            <div class="form-group">
                <label class="form-label" style="font-size:0.75rem">Kategori</label>
                <select name="kategori" class="form-control" style="min-width:150px">
                    <option value="">Semua Kategori</option>
                    <option value="listrik" {{ request('kategori') == 'listrik' ? 'selected' : '' }}>Listrik</option>
                    <option value="air" {{ request('kategori') == 'air' ? 'selected' : '' }}>Air</option>
                    <option value="kebersihan" {{ request('kategori') == 'kebersihan' ? 'selected' : '' }}>Kebersihan</option>
                    <option value="keamanan" {{ request('kategori') == 'keamanan' ? 'selected' : '' }}>Keamanan</option>
                    <option value="fasilitas" {{ request('kategori') == 'fasilitas' ? 'selected' : '' }}>Fasilitas</option>
                    <option value="lainnya" {{ request('kategori') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label" style="font-size:0.75rem">Status</label>
                <select name="status" class="form-control" style="min-width:150px">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="proses" {{ request('status') == 'proses' ? 'selected' : '' }}>Proses</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>
            <div style="display:flex;gap:8px;align-items:flex-end">
                <button type="submit" class="btn btn-primary btn-sm"><i class="fa-solid fa-search"></i> Filter</button>
                @if(request('search') || request('status') || request('kategori'))
                    <a href="{{ route('admin.pengaduan.index') }}" class="btn btn-secondary btn-sm"><i class="fa-solid fa-rotate-right"></i> Reset</a>
                @endif
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2 class="card-title"><i class="fa-solid fa-headset" style="color:var(--accent)"></i> Daftar Pengaduan</h2>
        <span style="font-size:0.8rem;color:var(--text-muted)">Total: {{ $pengaduan->total() }} pengaduan</span>
    </div>
    <div class="card-body" style="padding:0">
        @forelse($pengaduan as $p)
        <div style="padding:20px;border-bottom:1px solid var(--border);{{ $loop->last ? 'border-bottom:none' : '' }}">
            <div style="display:flex;gap:16px;align-items:start">
                @if($p->foto)
                <img src="{{ asset('storage/' . $p->foto) }}" alt="Foto Pengaduan" 
                     style="width:100px;height:100px;object-fit:cover;border-radius:var(--radius-sm);border:1px solid var(--border)">
                @else
                <div style="width:100px;height:100px;background:rgba(255,255,255,0.03);border-radius:var(--radius-sm);border:1px solid var(--border);display:flex;align-items:center;justify-content:center">
                    <i class="fa-solid fa-image" style="font-size:2rem;color:var(--text-muted);opacity:0.3"></i>
                </div>
                @endif
                
                <div style="flex:1">
                    <div style="display:flex;align-items:start;justify-content:space-between;margin-bottom:10px">
                        <div style="flex:1">
                            <div style="display:flex;align-items:center;gap:8px;margin-bottom:8px;flex-wrap:wrap">
                                <span class="badge badge-{{ 
                                    $p->kategori === 'listrik' ? 'listrik' : 
                                    ($p->kategori === 'air' ? 'air' : 
                                    ($p->kategori === 'kebersihan' ? 'kebersihan' : 'sewa'))
                                }}">
                                    {{ ucfirst($p->kategori) }}
                                </span>
                                <span class="badge badge-{{ 
                                    $p->status === 'pending' ? 'tunggu' : 
                                    ($p->status === 'proses' ? 'sewa' : 
                                    ($p->status === 'selesai' ? 'lunas' : 'belum'))
                                }}">
                                    <i class="fa-solid fa-circle" style="font-size:0.5rem"></i>
                                    {{ ucfirst($p->status) }}
                                </span>
                            </div>
                            <h3 style="font-size:1.05rem;font-weight:700;color:var(--text-primary);margin:0 0 6px 0">{{ $p->judul }}</h3>
                            <p style="font-size:0.85rem;color:var(--text-secondary);margin:0 0 10px 0;line-height:1.5">{{ Str::limit($p->deskripsi, 150) }}</p>
                            
                            <div style="display:flex;align-items:center;gap:16px;font-size:0.75rem;color:var(--text-muted)">
                                <span><i class="fa-solid fa-user"></i> {{ $p->penghuni->user->name }}</span>
                                <span><i class="fa-solid fa-building"></i> Unit {{ $p->penghuni->unit->nomor }}</span>
                                <span><i class="fa-solid fa-calendar"></i> {{ $p->created_at->format('d M Y, H:i') }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div style="display:flex;gap:8px;margin-top:12px">
                        <a href="{{ route('admin.pengaduan.show', $p) }}" class="btn btn-sm btn-primary">
                            <i class="fa-solid fa-eye"></i> Detail & Tanggapi
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div style="text-align:center;padding:60px 20px;color:var(--text-muted)">
            <i class="fa-solid fa-inbox" style="font-size:3rem;margin-bottom:16px;display:block;opacity:0.3"></i>
            <p style="font-size:1.1rem;font-weight:600;color:var(--text-secondary);margin:0">
                @if(request('search') || request('status') || request('kategori'))
                    Tidak ada pengaduan yang sesuai dengan filter
                @else
                    Belum ada pengaduan
                @endif
            </p>
        </div>
        @endforelse
    </div>
    
    @if($pengaduan->hasPages())
    <div class="pagination-wrapper">
        <div style="font-size:0.8rem;color:var(--text-muted)">
            Menampilkan {{ $pengaduan->firstItem() }}–{{ $pengaduan->lastItem() }} dari {{ $pengaduan->total() }} pengaduan
        </div>
        {{ $pengaduan->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection
