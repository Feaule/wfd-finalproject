@extends('layouts.penghuni')

@section('title', 'Info Unit Saya')

@section('content')
<div style="margin-bottom:32px">
    <h1 style="font-size:1.75rem;font-weight:800;color:var(--text-primary);margin-bottom:8px">
        <i class="fa-solid fa-door-open" style="color:var(--teal)"></i> Info Unit Saya
    </h1>
    <p style="font-size:0.9rem;color:var(--text-secondary)">Informasi lengkap tentang unit apartemen Anda</p>
</div>

@if(!$penghuni || !$penghuni->unit)
<div class="card">
    <div class="card-body" style="text-align:center;padding:60px 20px">
        <i class="fa-solid fa-building-slash" style="font-size:3rem;color:var(--text-muted);opacity:0.3;margin-bottom:20px"></i>
        <h3 style="font-size:1.2rem;font-weight:700;color:var(--text-primary);margin:0 0 10px 0">Belum Terdaftar di Unit</h3>
        <p style="font-size:0.9rem;color:var(--text-secondary);margin:0">Akun Anda belum terhubung dengan unit apartemen. Silakan hubungi admin untuk pendaftaran.</p>
    </div>
</div>
@else
<div style="display:grid;grid-template-columns:1fr;gap:24px">
    <!-- UNIT INFO CARD -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title"><i class="fa-solid fa-building" style="color:var(--teal)"></i> Detail Unit</h2>
            <span class="badge badge-{{ $penghuni->status === 'aktif' ? 'lunas' : 'belum' }}">
                <i class="fa-solid fa-circle" style="font-size:0.5rem"></i>
                {{ ucfirst($penghuni->status) }}
            </span>
        </div>
        <div class="card-body">
            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:24px">
                <div>
                    <p style="font-size:0.72rem;color:var(--text-muted);font-weight:600;text-transform:uppercase;margin-bottom:8px">
                        <i class="fa-solid fa-hashtag" style="font-size:0.7rem"></i> Nomor Unit
                    </p>
                    <p style="font-size:1.75rem;font-weight:800;color:var(--teal);margin:0">{{ $penghuni->unit->nomor }}</p>
                </div>
                <div>
                    <p style="font-size:0.72rem;color:var(--text-muted);font-weight:600;text-transform:uppercase;margin-bottom:8px">
                        <i class="fa-solid fa-layer-group" style="font-size:0.7rem"></i> Lantai
                    </p>
                    <p style="font-size:1.3rem;font-weight:700;color:var(--text-primary);margin:0">Lantai {{ $penghuni->unit->lantai->nomor }}</p>
                    <p style="font-size:0.75rem;color:var(--text-secondary);margin-top:4px">{{ $penghuni->unit->lantai->nama }}</p>
                </div>
                <div>
                    <p style="font-size:0.72rem;color:var(--text-muted);font-weight:600;text-transform:uppercase;margin-bottom:8px">
                        <i class="fa-solid fa-shapes" style="font-size:0.7rem"></i> Tipe Unit
                    </p>
                    <p style="font-size:1.3rem;font-weight:700;color:var(--text-primary);margin:0;text-transform:capitalize">{{ $penghuni->unit->tipe ?? '-' }}</p>
                </div>
                <div>
                    <p style="font-size:0.72rem;color:var(--text-muted);font-weight:600;text-transform:uppercase;margin-bottom:8px">
                        <i class="fa-solid fa-ruler-combined" style="font-size:0.7rem"></i> Luas Unit
                    </p>
                    <p style="font-size:1.3rem;font-weight:700;color:var(--text-primary);margin:0">
                        {{ $penghuni->unit->luas ?? '-' }} <span style="font-size:0.85rem;color:var(--text-secondary)">m²</span>
                    </p>
                </div>
            </div>

            @if($penghuni->unit->foto)
            <div style="margin-top:24px;border-top:1px solid var(--border);padding-top:24px">
                <p style="font-size:0.72rem;color:var(--text-muted);font-weight:600;text-transform:uppercase;margin-bottom:12px">
                    <i class="fa-solid fa-image"></i> Foto Unit
                </p>
                <img src="{{ asset('storage/' . $penghuni->unit->foto) }}" alt="Foto Unit {{ $penghuni->unit->nomor }}" 
                     style="max-width:100%;height:auto;border-radius:var(--radius);border:1px solid var(--border)">
            </div>
            @endif

            @if($penghuni->unit->deskripsi)
            <div style="margin-top:24px;border-top:1px solid var(--border);padding-top:24px">
                <p style="font-size:0.72rem;color:var(--text-muted);font-weight:600;text-transform:uppercase;margin-bottom:12px">
                    <i class="fa-solid fa-align-left"></i> Deskripsi
                </p>
                <p style="font-size:0.9rem;color:var(--text-secondary);line-height:1.6;margin:0">{{ $penghuni->unit->deskripsi }}</p>
            </div>
            @endif
        </div>
    </div>

    <!-- INFORMASI PENGHUNI -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title"><i class="fa-solid fa-user" style="color:var(--accent)"></i> Informasi Penghuni</h2>
        </div>
        <div class="card-body">
            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:24px">
                <div>
                    <p style="font-size:0.72rem;color:var(--text-muted);font-weight:600;text-transform:uppercase;margin-bottom:8px">
                        <i class="fa-solid fa-user" style="font-size:0.7rem"></i> Nama Lengkap
                    </p>
                    <p style="font-size:1.1rem;font-weight:700;color:var(--text-primary);margin:0">{{ $penghuni->user->name }}</p>
                </div>
                <div>
                    <p style="font-size:0.72rem;color:var(--text-muted);font-weight:600;text-transform:uppercase;margin-bottom:8px">
                        <i class="fa-solid fa-envelope" style="font-size:0.7rem"></i> Email
                    </p>
                    <p style="font-size:0.95rem;font-weight:600;color:var(--text-secondary);margin:0">{{ $penghuni->user->email }}</p>
                </div>
                <div>
                    <p style="font-size:0.72rem;color:var(--text-muted);font-weight:600;text-transform:uppercase;margin-bottom:8px">
                        <i class="fa-solid fa-calendar-days" style="font-size:0.7rem"></i> Tanggal Masuk
                    </p>
                    <p style="font-size:0.95rem;font-weight:600;color:var(--text-primary);margin:0">{{ $penghuni->tanggal_masuk->format('d M Y') }}</p>
                </div>
                @if($penghuni->tanggal_keluar)
                <div>
                    <p style="font-size:0.72rem;color:var(--text-muted);font-weight:600;text-transform:uppercase;margin-bottom:8px">
                        <i class="fa-solid fa-calendar-xmark" style="font-size:0.7rem"></i> Tanggal Keluar
                    </p>
                    <p style="font-size:0.95rem;font-weight:600;color:var(--rose);margin:0">{{ $penghuni->tanggal_keluar->format('d M Y') }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endif
@endsection
