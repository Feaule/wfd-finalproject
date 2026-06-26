@extends('layouts.penghuni')

@section('title', 'Pengaduan Saya')

@section('content')
<div style="margin-bottom:32px;display:flex;align-items:center;justify-content:space-between">
    <div>
        <h1 style="font-size:1.75rem;font-weight:800;color:var(--text-primary);margin-bottom:8px">
            <i class="fa-solid fa-headset" style="color:var(--accent)"></i> Pengaduan
        </h1>
        <p style="font-size:0.9rem;color:var(--text-secondary)">Buat dan pantau status pengaduan Anda</p>
    </div>
    <a href="{{ route('penghuni.pengaduan.create') }}" class="btn btn-primary">
        <i class="fa-solid fa-plus"></i> Buat Pengaduan
    </a>
</div>

<!-- STATS -->
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:16px;margin-bottom:24px">
    <div class="card">
        <div class="card-body">
            <div style="display:flex;align-items:center;gap:12px">
                <div style="width:44px;height:44px;background:var(--amber-light);border-radius:var(--radius-sm);display:flex;align-items:center;justify-content:center">
                    <i class="fa-solid fa-clock" style="font-size:1.2rem;color:var(--amber)"></i>
                </div>
                <div>
                    <p style="font-size:0.7rem;color:var(--text-muted);margin:0">Pending</p>
                    <p style="font-size:1.5rem;font-weight:800;color:var(--amber);margin:0">{{ $pengaduan->where('status', 'pending')->count() }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div style="display:flex;align-items:center;gap:12px">
                <div style="width:44px;height:44px;background:var(--accent-light);border-radius:var(--radius-sm);display:flex;align-items:center;justify-content:center">
                    <i class="fa-solid fa-spinner" style="font-size:1.2rem;color:var(--accent)"></i>
                </div>
                <div>
                    <p style="font-size:0.7rem;color:var(--text-muted);margin:0">Proses</p>
                    <p style="font-size:1.5rem;font-weight:800;color:var(--accent);margin:0">{{ $pengaduan->where('status', 'proses')->count() }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div style="display:flex;align-items:center;gap:12px">
                <div style="width:44px;height:44px;background:var(--emerald-light);border-radius:var(--radius-sm);display:flex;align-items:center;justify-content:center">
                    <i class="fa-solid fa-check-circle" style="font-size:1.2rem;color:var(--emerald)"></i>
                </div>
                <div>
                    <p style="font-size:0.7rem;color:var(--text-muted);margin:0">Selesai</p>
                    <p style="font-size:1.5rem;font-weight:800;color:var(--emerald);margin:0">{{ $pengaduan->where('status', 'selesai')->count() }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div style="display:flex;align-items:center;gap:12px">
                <div style="width:44px;height:44px;background:var(--rose-light);border-radius:var(--radius-sm);display:flex;align-items:center;justify-content:center">
                    <i class="fa-solid fa-xmark-circle" style="font-size:1.2rem;color:var(--rose)"></i>
                </div>
                <div>
                    <p style="font-size:0.7rem;color:var(--text-muted);margin:0">Ditolak</p>
                    <p style="font-size:1.5rem;font-weight:800;color:var(--rose);margin:0">{{ $pengaduan->where('status', 'ditolak')->count() }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- LIST PENGADUAN -->
<div class="card">
    <div class="card-header">
        <h2 class="card-title"><i class="fa-solid fa-list" style="color:var(--accent)"></i> Daftar Pengaduan</h2>
    </div>
    <div class="card-body" style="padding:0">
        @forelse($pengaduan as $p)
        <div style="padding:20px;border-bottom:1px solid var(--border);{{ $loop->last ? 'border-bottom:none' : '' }}">
            <div style="display:flex;gap:16px;align-items:start">
                @if($p->foto)
                <img src="{{ asset('storage/' . $p->foto) }}" alt="Foto" 
                     style="width:80px;height:80px;object-fit:cover;border-radius:var(--radius-sm);border:1px solid var(--border)">
                @else
                <div style="width:80px;height:80px;background:rgba(255,255,255,0.03);border-radius:var(--radius-sm);border:1px solid var(--border);display:flex;align-items:center;justify-content:center">
                    <i class="fa-solid fa-image" style="font-size:1.5rem;color:var(--text-muted);opacity:0.3"></i>
                </div>
                @endif
                <div style="flex:1">
                    <div style="display:flex;align-items:start;justify-content:space-between;margin-bottom:8px">
                        <div style="flex:1">
                            <span class="badge badge-{{ 
                                $p->kategori === 'listrik' ? 'listrik' : 
                                ($p->kategori === 'air' ? 'air' : 
                                ($p->kategori === 'kebersihan' ? 'kebersihan' : 'sewa'))
                            }}" style="margin-bottom:8px">
                                {{ ucfirst($p->kategori) }}
                            </span>
                            <h3 style="font-size:1.05rem;font-weight:700;color:var(--text-primary);margin:0 0 6px 0">{{ $p->judul }}</h3>
                            <p style="font-size:0.85rem;color:var(--text-secondary);margin:0;line-height:1.5">{{ Str::limit($p->deskripsi, 120) }}</p>
                        </div>
                        <span class="badge badge-{{ 
                            $p->status === 'pending' ? 'tunggu' : 
                            ($p->status === 'proses' ? 'sewa' : 
                            ($p->status === 'selesai' ? 'lunas' : 'belum'))
                        }}" style="margin-left:12px">
                            <i class="fa-solid fa-circle" style="font-size:0.5rem"></i>
                            {{ ucfirst($p->status) }}
                        </span>
                    </div>
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-top:12px">
                        <p style="font-size:0.75rem;color:var(--text-muted);margin:0">
                            <i class="fa-solid fa-calendar"></i> {{ $p->created_at->format('d M Y, H:i') }}
                        </p>
                        <div style="display:flex;gap:8px">
                            <a href="{{ route('penghuni.pengaduan.show', $p) }}" class="btn btn-sm btn-secondary">
                                <i class="fa-solid fa-eye"></i> Detail
                            </a>
                            @if($p->status === 'pending')
                            <form action="{{ route('penghuni.pengaduan.destroy', $p) }}" method="POST" 
                                  onsubmit="return confirm('Hapus pengaduan ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm" style="background:var(--rose-light);color:var(--rose);border:1px solid var(--rose)">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div style="text-align:center;padding:60px 20px">
            <i class="fa-solid fa-inbox" style="font-size:3rem;color:var(--text-muted);opacity:0.3;margin-bottom:16px"></i>
            <p style="font-size:1.1rem;font-weight:600;color:var(--text-secondary);margin:0">Belum ada pengaduan</p>
            <p style="font-size:0.85rem;color:var(--text-muted);margin-top:8px">Klik tombol "Buat Pengaduan" untuk membuat pengaduan baru</p>
        </div>
        @endforelse
    </div>
    @if($pengaduan->hasPages())
    <div style="padding:16px 24px;border-top:1px solid var(--border);display:flex;align-items:center;justify-content:space-between">
        <div style="font-size:0.8rem;color:var(--text-muted)">
            Menampilkan {{ $pengaduan->firstItem() }}–{{ $pengaduan->lastItem() }} dari {{ $pengaduan->total() }} pengaduan
        </div>
        {{ $pengaduan->links() }}
    </div>
    @endif
</div>
@endsection
