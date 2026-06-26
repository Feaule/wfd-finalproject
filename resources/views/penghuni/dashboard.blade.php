@extends('layouts.penghuni')

@section('title', 'Dashboard Penghuni')

@section('content')
<div style="margin-bottom:32px">
    <h1 style="font-size:1.75rem;font-weight:800;color:var(--text-primary);margin-bottom:8px">
        <i class="fa-solid fa-gauge-high" style="color:var(--teal)"></i> Dashboard Penghuni
    </h1>
    <p style="font-size:0.9rem;color:var(--text-secondary)">
        Selamat datang, <strong style="color:var(--teal)">{{ auth()->user()->name }}</strong>!
    </p>
</div>

<!-- STATS CARDS -->
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:20px;margin-bottom:32px">
    <!-- Unit Info -->
    <div class="card">
        <div class="card-body">
            <div style="display:flex;align-items:center;gap:14px">
                <div style="width:52px;height:52px;background:var(--teal-light);border-radius:var(--radius-sm);display:flex;align-items:center;justify-content:center">
                    <i class="fa-solid fa-building" style="font-size:1.5rem;color:var(--teal)"></i>
                </div>
                <div style="flex:1">
                    <p style="font-size:0.72rem;color:var(--text-muted);font-weight:600;text-transform:uppercase;margin-bottom:4px">Unit Saya</p>
                    @if($penghuni && $penghuni->unit)
                        <h3 style="font-size:1.5rem;font-weight:800;color:var(--teal);margin:0">Unit {{ $penghuni->unit->nomor }}</h3>
                        <p style="font-size:0.75rem;color:var(--text-secondary);margin-top:2px">Lantai {{ $penghuni->unit->lantai->nomor }} • {{ ucfirst($penghuni->unit->tipe) }}</p>
                    @else
                        <h3 style="font-size:1.2rem;font-weight:700;color:var(--text-muted);margin:0">Belum Terdaftar</h3>
                        <p style="font-size:0.75rem;color:var(--rose);margin-top:2px">Hubungi admin</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Tagihan -->
    <div class="card">
        <div class="card-body">
            <div style="display:flex;align-items:center;gap:14px">
                <div style="width:52px;height:52px;background:var(--amber-light);border-radius:var(--radius-sm);display:flex;align-items:center;justify-content:center">
                    <i class="fa-solid fa-file-invoice-dollar" style="font-size:1.5rem;color:var(--amber)"></i>
                </div>
                <div style="flex:1">
                    <p style="font-size:0.72rem;color:var(--text-muted);font-weight:600;text-transform:uppercase;margin-bottom:4px">Tagihan Belum Bayar</p>
                    <h3 style="font-size:1.5rem;font-weight:800;color:var(--amber);margin:0">{{ $stats['belum_bayar'] ?? 0 }}</h3>
                    <p style="font-size:0.75rem;color:var(--text-secondary);margin-top:2px">Total {{ $stats['total_tagihan'] ?? 0 }} tagihan</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Pengaduan -->
    <div class="card">
        <div class="card-body">
            <div style="display:flex;align-items:center;gap:14px">
                <div style="width:52px;height:52px;background:var(--accent-light);border-radius:var(--radius-sm);display:flex;align-items:center;justify-content:center">
                    <i class="fa-solid fa-screwdriver-wrench" style="font-size:1.5rem;color:var(--accent)"></i>
                </div>
                <div style="flex:1">
                    <p style="font-size:0.72rem;color:var(--text-muted);font-weight:600;text-transform:uppercase;margin-bottom:4px">Pengaduan Aktif</p>
                    <h3 style="font-size:1.5rem;font-weight:800;color:var(--accent);margin:0">{{ $stats['pengaduan_aktif'] ?? 0 }}</h3>
                    <p style="font-size:0.75rem;color:var(--text-secondary);margin-top:2px">Dalam proses</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- QUICK ACTIONS -->
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:16px;margin-bottom:32px">
    <a href="{{ route('penghuni.unit') }}" class="card" style="text-decoration:none;transition:all 0.2s" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
        <div class="card-body" style="text-align:center;padding:28px 20px">
            <i class="fa-solid fa-door-open" style="font-size:2rem;color:var(--teal);margin-bottom:12px"></i>
            <h4 style="font-size:0.95rem;font-weight:700;color:var(--text-primary);margin:0 0 6px 0">Info Unit Saya</h4>
            <p style="font-size:0.75rem;color:var(--text-secondary);margin:0">Detail lengkap unit Anda</p>
        </div>
    </a>

    <a href="{{ route('penghuni.tagihan.index') }}" class="card" style="text-decoration:none;transition:all 0.2s" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
        <div class="card-body" style="text-align:center;padding:28px 20px">
            <i class="fa-solid fa-receipt" style="font-size:2rem;color:var(--amber);margin-bottom:12px"></i>
            <h4 style="font-size:0.95rem;font-weight:700;color:var(--text-primary);margin:0 0 6px 0">Tagihan & Pembayaran</h4>
            <p style="font-size:0.75rem;color:var(--text-secondary);margin:0">Lihat dan bayar tagihan</p>
        </div>
    </a>

    <a href="{{ route('penghuni.pengaduan.index') }}" class="card" style="text-decoration:none;transition:all 0.2s" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
        <div class="card-body" style="text-align:center;padding:28px 20px">
            <i class="fa-solid fa-headset" style="font-size:2rem;color:var(--accent);margin-bottom:12px"></i>
            <h4 style="font-size:0.95rem;font-weight:700;color:var(--text-primary);margin:0 0 6px 0">Pengaduan</h4>
            <p style="font-size:0.75rem;color:var(--text-secondary);margin:0">Buat & pantau pengaduan</p>
        </div>
    </a>
</div>

<!-- INFO STATUS -->
@if(!$penghuni || !$penghuni->unit)
<div style="background:var(--rose-light);border:1px solid var(--rose);border-radius:var(--radius);padding:20px;margin-bottom:24px">
    <div style="display:flex;align-items:start;gap:14px">
        <i class="fa-solid fa-circle-exclamation" style="font-size:1.5rem;color:var(--rose)"></i>
        <div>
            <h4 style="font-size:1rem;font-weight:700;color:var(--rose);margin:0 0 6px 0">Akun Belum Terhubung dengan Unit</h4>
            <p style="font-size:0.85rem;color:var(--text-secondary);margin:0">Silakan hubungi admin untuk mendaftarkan Anda ke unit apartemen.</p>
        </div>
    </div>
</div>
@else
<div style="background:var(--emerald-light);border:1px solid var(--emerald);border-radius:var(--radius);padding:20px">
    <div style="display:flex;align-items:start;gap:14px">
        <i class="fa-solid fa-circle-check" style="font-size:1.5rem;color:var(--emerald)"></i>
        <div>
            <h4 style="font-size:1rem;font-weight:700;color:var(--emerald);margin:0 0 6px 0">Akun Anda Sudah Aktif</h4>
            <p style="font-size:0.85rem;color:var(--text-secondary);margin:0">Anda dapat menggunakan semua fitur yang tersedia. Gunakan menu di atas untuk navigasi.</p>
        </div>
    </div>
</div>
@endif
@endsection
