@extends('layouts.penghuni')

@section('title', 'Detail Pengaduan')

@section('content')
<div style="margin-bottom:32px">
    <a href="{{ route('penghuni.pengaduan.index') }}" class="btn btn-secondary" style="margin-bottom:16px">
        <i class="fa-solid fa-arrow-left"></i> Kembali
    </a>
    <h1 style="font-size:1.75rem;font-weight:800;color:var(--text-primary);margin-bottom:8px">
        <i class="fa-solid fa-file-lines" style="color:var(--accent)"></i> Detail Pengaduan
    </h1>
    <p style="font-size:0.9rem;color:var(--text-secondary)">Informasi lengkap pengaduan Anda</p>
</div>

<div style="max-width:900px">
    <!-- STATUS CARD -->
    <div class="card" style="margin-bottom:20px">
        <div class="card-body">
            <div style="display:flex;align-items:center;gap:16px">
                <div style="width:60px;height:60px;background:var(--{{ 
                    $pengaduan->status === 'pending' ? 'amber' : 
                    ($pengaduan->status === 'proses' ? 'accent' : 
                    ($pengaduan->status === 'selesai' ? 'emerald' : 'rose'))
                }}-light);border-radius:50%;display:flex;align-items:center;justify-content:center">
                    <i class="fa-solid fa-{{ 
                        $pengaduan->status === 'pending' ? 'clock' : 
                        ($pengaduan->status === 'proses' ? 'spinner' : 
                        ($pengaduan->status === 'selesai' ? 'check-circle' : 'xmark-circle'))
                    }}" style="font-size:1.8rem;color:var(--{{ 
                        $pengaduan->status === 'pending' ? 'amber' : 
                        ($pengaduan->status === 'proses' ? 'accent' : 
                        ($pengaduan->status === 'selesai' ? 'emerald' : 'rose'))
                    }})"></i>
                </div>
                <div style="flex:1">
                    <p style="font-size:0.75rem;color:var(--text-muted);margin:0">Status Pengaduan</p>
                    <h2 style="font-size:1.5rem;font-weight:800;color:var(--text-primary);margin:4px 0">
                        {{ 
                            $pengaduan->status === 'pending' ? 'Menunggu Ditinjau' : 
                            ($pengaduan->status === 'proses' ? 'Sedang Diproses' : 
                            ($pengaduan->status === 'selesai' ? 'Sudah Selesai' : 'Ditolak'))
                        }}
                    </h2>
                    <p style="font-size:0.8rem;color:var(--text-secondary);margin:0">
                        Dikirim pada {{ $pengaduan->created_at->format('d M Y, H:i') }}
                    </p>
                </div>
                <span class="badge badge-{{ 
                    $pengaduan->status === 'pending' ? 'tunggu' : 
                    ($pengaduan->status === 'proses' ? 'sewa' : 
                    ($pengaduan->status === 'selesai' ? 'lunas' : 'belum'))
                }}" style="font-size:0.85rem;padding:8px 16px">
                    {{ ucfirst($pengaduan->status) }}
                </span>
            </div>
        </div>
    </div>

    <!-- INFO PENGADUAN -->
    <div class="card" style="margin-bottom:20px">
        <div class="card-header">
            <h2 class="card-title"><i class="fa-solid fa-info-circle" style="color:var(--accent)"></i> Informasi Pengaduan</h2>
        </div>
        <div class="card-body">
            <div style="margin-bottom:24px">
                <p style="font-size:0.72rem;color:var(--text-muted);font-weight:600;text-transform:uppercase;margin-bottom:8px">
                    <i class="fa-solid fa-tag"></i> Kategori
                </p>
                <span class="badge badge-{{ 
                    $pengaduan->kategori === 'listrik' ? 'listrik' : 
                    ($pengaduan->kategori === 'air' ? 'air' : 
                    ($pengaduan->kategori === 'kebersihan' ? 'kebersihan' : 'sewa'))
                }}" style="font-size:0.85rem;padding:6px 14px">
                    {{ ucfirst($pengaduan->kategori) }}
                </span>
            </div>

            <div style="margin-bottom:24px">
                <p style="font-size:0.72rem;color:var(--text-muted);font-weight:600;text-transform:uppercase;margin-bottom:8px">
                    <i class="fa-solid fa-heading"></i> Judul
                </p>
                <h3 style="font-size:1.3rem;font-weight:700;color:var(--text-primary);margin:0">{{ $pengaduan->judul }}</h3>
            </div>

            <div style="margin-bottom:24px">
                <p style="font-size:0.72rem;color:var(--text-muted);font-weight:600;text-transform:uppercase;margin-bottom:8px">
                    <i class="fa-solid fa-align-left"></i> Deskripsi
                </p>
                <p style="font-size:0.95rem;color:var(--text-secondary);line-height:1.7;margin:0">{{ $pengaduan->deskripsi }}</p>
            </div>

            @if($pengaduan->foto)
            <div>
                <p style="font-size:0.72rem;color:var(--text-muted);font-weight:600;text-transform:uppercase;margin-bottom:12px">
                    <i class="fa-solid fa-image"></i> Foto Pendukung
                </p>
                <img src="{{ asset('storage/' . $pengaduan->foto) }}" alt="Foto Pengaduan" 
                     style="max-width:100%;height:auto;border-radius:var(--radius);border:1px solid var(--border)">
            </div>
            @endif
        </div>
    </div>

    <!-- TANGGAPAN ADMIN -->
    @if($pengaduan->tanggapan)
    <div class="card" style="border-color:var(--{{ $pengaduan->status === 'selesai' ? 'emerald' : 'rose' }})">
        <div class="card-header" style="background:var(--{{ $pengaduan->status === 'selesai' ? 'emerald' : 'rose' }}-light)">
            <h2 class="card-title">
                <i class="fa-solid fa-reply" style="color:var(--{{ $pengaduan->status === 'selesai' ? 'emerald' : 'rose' }})"></i> 
                Tanggapan Admin
            </h2>
        </div>
        <div class="card-body">
            <p style="font-size:0.95rem;color:var(--text-primary);line-height:1.7;margin:0">{{ $pengaduan->tanggapan }}</p>
            <p style="font-size:0.75rem;color:var(--text-muted);margin-top:12px;padding-top:12px;border-top:1px solid var(--border)">
                <i class="fa-solid fa-clock"></i> Dibalas pada {{ $pengaduan->updated_at->format('d M Y, H:i') }}
            </p>
        </div>
    </div>
    @else
    <div style="background:var(--amber-light);border:1px solid var(--amber);border-radius:var(--radius);padding:16px">
        <div style="display:flex;align-items:center;gap:12px">
            <i class="fa-solid fa-hourglass-half" style="font-size:1.2rem;color:var(--amber)"></i>
            <p style="font-size:0.85rem;color:var(--text-secondary);margin:0">
                Pengaduan Anda sedang {{ $pengaduan->status === 'pending' ? 'menunggu tinjauan' : 'diproses' }} oleh tim kami. Harap bersabar.
            </p>
        </div>
    </div>
    @endif
</div>
@endsection
