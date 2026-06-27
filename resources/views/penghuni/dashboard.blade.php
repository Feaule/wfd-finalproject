@extends('layouts.penghuni')

@section('title', 'Dashboard Penghuni')

@push('styles')
<style>
    @media (max-width: 768px) {
        .tagihan-row {
            flex-wrap: wrap !important;
            gap: 12px !important;
        }
        .tagihan-amount {
            min-width: auto !important;
            text-align: left !important;
        }
        .penghuni-hero-title {
            font-size: 1.3rem !important;
        }
        .quick-actions-grid {
            grid-template-columns: repeat(2, 1fr) !important;
        }
    }
    @media (max-width: 480px) {
        .quick-actions-grid {
            grid-template-columns: 1fr 1fr !important;
        }
        .penghuni-hero-title {
            font-size: 1.2rem !important;
        }
    }
</style>
@endpush

@section('content')
<div style="margin-bottom:24px">
    <h1 class="penghuni-hero-title" style="font-size:1.75rem;font-weight:800;color:var(--text-primary);margin-bottom:8px">
        <i class="fa-solid fa-gauge-high" style="color:var(--teal)"></i> Dashboard Penghuni
    </h1>
    <p style="font-size:0.9rem;color:var(--text-secondary)">
        Selamat datang, <strong style="color:var(--teal)">{{ auth()->user()->name }}</strong>!
    </p>
</div>

@if(session('success'))
<div class="alert alert-success" style="margin-bottom:20px">
    <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
</div>
@endif
@if(session('info'))
<div class="alert" style="background:rgba(20,184,166,0.1);border:1px solid var(--teal);color:var(--teal);border-radius:var(--radius);padding:14px 20px;margin-bottom:20px;display:flex;align-items:center;gap:12px">
    <i class="fa-solid fa-circle-info"></i> {{ session('info') }}
</div>
@endif
@if(session('error'))
<div class="alert" style="background:rgba(244,63,94,0.1);border:1px solid var(--rose);color:var(--rose);border-radius:var(--radius);padding:14px 20px;margin-bottom:20px;display:flex;align-items:center;gap:12px">
    <i class="fa-solid fa-circle-xmark"></i> {{ session('error') }}
</div>
@endif

{{-- ======================= --}}
{{-- STATUS: PERMOHONAN UNIT MENUNGGU --}}
{{-- ======================= --}}
@if(!$penghuni && $permohonanMenunggu)
<div style="background:rgba(245,158,11,0.08);border:1px solid var(--amber);border-radius:var(--radius);padding:20px;margin-bottom:28px">
    <div style="display:flex;align-items:start;gap:14px">
        <i class="fa-solid fa-hourglass-half" style="font-size:1.5rem;color:var(--amber)"></i>
        <div>
            <h4 style="font-size:1rem;font-weight:700;color:var(--amber);margin:0 0 6px 0">Permohonan Unit Sedang Menunggu</h4>
            <p style="font-size:0.85rem;color:var(--text-secondary);margin:0">
                Anda telah mengajukan permohonan untuk <strong>Unit {{ $permohonanMenunggu->unit->nomor ?? '-' }}</strong>.
                Admin akan segera memproses permohonan Anda.
            </p>
        </div>
    </div>
</div>

{{-- ======================= --}}
{{-- STATUS: BELUM PUNYA UNIT --}}
{{-- ======================= --}}
@elseif(!$penghuni)
<div style="background:var(--rose-light);border:1px solid var(--rose);border-radius:var(--radius);padding:20px;margin-bottom:28px">
    <div style="display:flex;align-items:start;gap:14px">
        <i class="fa-solid fa-circle-exclamation" style="font-size:1.5rem;color:var(--rose)"></i>
        <div>
            <h4 style="font-size:1rem;font-weight:700;color:var(--rose);margin:0 0 6px 0">Akun Belum Terhubung dengan Unit</h4>
            <p style="font-size:0.85rem;color:var(--text-secondary);margin:0 0 12px 0">Silakan pilih unit yang tersedia untuk mulai menghuni.</p>
            <a href="{{ route('penghuni.unit') }}" class="btn btn-primary btn-sm">
                <i class="fa-solid fa-door-open"></i> Lihat Unit Tersedia
            </a>
        </div>
    </div>
</div>

{{-- ======================= --}}
{{-- STATUS: AKTIF — DASHBOARD PENUH --}}
{{-- ======================= --}}
@else

{{-- STATS CARDS --}}
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:20px;margin-bottom:32px">
    <!-- Unit Info -->
    <div class="card">
        <div class="card-body">
            <div style="display:flex;align-items:center;gap:14px">
                <div style="width:52px;height:52px;background:var(--teal-light);border-radius:var(--radius-sm);display:flex;align-items:center;justify-content:center">
                    <i class="fa-solid fa-building" style="font-size:1.5rem;color:var(--teal)"></i>
                </div>
                <div style="flex:1">
                    <p style="font-size:0.72rem;color:var(--text-muted);font-weight:600;text-transform:uppercase;margin-bottom:4px">Unit Saya</p>
                    <h3 style="font-size:1.4rem;font-weight:800;color:var(--teal);margin:0">Unit {{ $penghuni->unit->nomor }}</h3>
                    <p style="font-size:0.75rem;color:var(--text-secondary);margin-top:2px">
                        Lantai {{ $penghuni->unit->lantai->nomor_lantai ?? '-' }} &bull; {{ ucfirst($penghuni->unit->tipe ?? '-') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tagihan Belum Bayar -->
    <div class="card" style="cursor:pointer" onclick="window.location='{{ route('penghuni.tagihan.index') }}'">
        <div class="card-body">
            <div style="display:flex;align-items:center;gap:14px">
                <div style="width:52px;height:52px;background:var(--rose-light);border-radius:var(--radius-sm);display:flex;align-items:center;justify-content:center">
                    <i class="fa-solid fa-file-invoice-dollar" style="font-size:1.5rem;color:var(--rose)"></i>
                </div>
                <div style="flex:1">
                    <p style="font-size:0.72rem;color:var(--text-muted);font-weight:600;text-transform:uppercase;margin-bottom:4px">Tagihan Belum Bayar</p>
                    <h3 style="font-size:1.4rem;font-weight:800;color:var(--rose);margin:0">{{ $stats['belum_bayar'] }}</h3>
                    @if($stats['total_belum_rp'] > 0)
                    <p style="font-size:0.75rem;color:var(--rose);margin-top:2px;font-weight:600">
                        Rp {{ number_format($stats['total_belum_rp'], 0, ',', '.') }}
                    </p>
                    @else
                    <p style="font-size:0.75rem;color:var(--emerald);margin-top:2px">Semua lunas ✓</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Sewa Bulanan -->
    <div class="card">
        <div class="card-body">
            <div style="display:flex;align-items:center;gap:14px">
                <div style="width:52px;height:52px;background:var(--accent-light);border-radius:var(--radius-sm);display:flex;align-items:center;justify-content:center">
                    <i class="fa-solid fa-house" style="font-size:1.5rem;color:var(--accent)"></i>
                </div>
                <div style="flex:1">
                    <p style="font-size:0.72rem;color:var(--text-muted);font-weight:600;text-transform:uppercase;margin-bottom:4px">Sewa / Bulan</p>
                    <h3 style="font-size:1.2rem;font-weight:800;color:var(--accent);margin:0">
                        Rp {{ number_format($penghuni->unit->harga_sewa, 0, ',', '.') }}
                    </h3>
                    <p style="font-size:0.75rem;color:var(--text-secondary);margin-top:2px">Harga sewa unit</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Pengaduan Aktif -->
    <div class="card" style="cursor:pointer" onclick="window.location='{{ route('penghuni.pengaduan.index') }}'">
        <div class="card-body">
            <div style="display:flex;align-items:center;gap:14px">
                <div style="width:52px;height:52px;background:var(--amber-light);border-radius:var(--radius-sm);display:flex;align-items:center;justify-content:center">
                    <i class="fa-solid fa-screwdriver-wrench" style="font-size:1.5rem;color:var(--amber)"></i>
                </div>
                <div style="flex:1">
                    <p style="font-size:0.72rem;color:var(--text-muted);font-weight:600;text-transform:uppercase;margin-bottom:4px">Pengaduan Aktif</p>
                    <h3 style="font-size:1.4rem;font-weight:800;color:var(--amber);margin:0">{{ $stats['pengaduan_aktif'] }}</h3>
                    <p style="font-size:0.75rem;color:var(--text-secondary);margin-top:2px">Dalam proses</p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- TAGIHAN MENUNGGU BAYAR --}}
@if($tagihanTerbaru->count() > 0)
<div class="card" style="margin-bottom:28px">
    <div class="card-header">
        <h2 class="card-title">
            <i class="fa-solid fa-receipt" style="color:var(--rose)"></i> Tagihan Perlu Dibayar
        </h2>
        <a href="{{ route('penghuni.tagihan.index') }}" style="font-size:0.8rem;color:var(--accent)">
            Lihat semua &rarr;
        </a>
    </div>
    @php
        $iconMap  = ['sewa'=>'fa-house','listrik'=>'fa-bolt','air'=>'fa-droplet','kebersihan'=>'fa-broom'];
        $colorMap = ['sewa'=>'var(--accent)','listrik'=>'var(--amber)','air'=>'var(--teal)','kebersihan'=>'var(--emerald)'];
        $bgMap    = ['sewa'=>'var(--accent-light)','listrik'=>'var(--amber-light)','air'=>'var(--teal-light)','kebersihan'=>'var(--emerald-light)'];
    @endphp
    @foreach($tagihanTerbaru as $t)
    <div class="tagihan-row" style="display:flex;align-items:center;gap:16px;padding:14px 20px;border-bottom:1px solid var(--border)">
        <div style="width:40px;height:40px;border-radius:10px;background:{{ $bgMap[$t->jenis] }};display:flex;align-items:center;justify-content:center;flex-shrink:0">
            <i class="fa-solid {{ $iconMap[$t->jenis] }}" style="color:{{ $colorMap[$t->jenis] }}"></i>
        </div>
        <div style="flex:1;min-width:0">
            <div style="font-weight:600;color:var(--text-primary)">{{ ucfirst($t->jenis) }}</div>
            <div style="font-size:0.78rem;color:var(--text-muted)">
                {{ \Carbon\Carbon::parse($t->bulan . '-01')->translatedFormat('F Y') }}
                &bull; Jatuh tempo: {{ $t->jatuh_tempo->format('d M Y') }}
                @if($t->status !== 'lunas' && $t->jatuh_tempo->isPast())
                    <span style="color:var(--rose);font-weight:600"> — Terlambat!</span>
                @endif
            </div>
        </div>
        <div class="tagihan-amount" style="font-weight:700;color:var(--text-primary);min-width:120px;text-align:right;flex-shrink:0">
            Rp {{ number_format($t->jumlah, 0, ',', '.') }}
        </div>
        <div style="flex-shrink:0">
            @if($t->status === 'belum_bayar')
                <a href="{{ route('penghuni.pembayaran.create', $t->id) }}" class="btn btn-primary btn-sm">
                    <i class="fa-solid fa-upload"></i> Bayar
                </a>
            @elseif($t->status === 'menunggu_verifikasi')
                <span class="badge badge-tunggu"><i class="fa-solid fa-hourglass-half"></i> Menunggu</span>
            @endif
        </div>
    </div>
    @endforeach
</div>
@else
<div class="card" style="margin-bottom:28px">
    <div class="card-body" style="text-align:center;padding:32px 20px">
        <i class="fa-solid fa-circle-check" style="font-size:2.5rem;color:var(--emerald);margin-bottom:12px;display:block"></i>
        <h4 style="font-size:1rem;font-weight:700;color:var(--text-primary);margin:0 0 6px 0">Semua Tagihan Lunas</h4>
        <p style="font-size:0.85rem;color:var(--text-secondary);margin:0">
            @if($stats['total_tagihan'] === 0)
                Belum ada tagihan yang dibuat oleh admin untuk akun Anda.
            @else
                Tidak ada tagihan yang perlu dibayar saat ini.
            @endif
        </p>
        <a href="{{ route('penghuni.tagihan.index') }}" class="btn btn-secondary btn-sm" style="margin-top:16px">
            <i class="fa-solid fa-receipt"></i> Lihat Riwayat Tagihan
        </a>
    </div>
</div>
@endif

{{-- QUICK ACTIONS --}}
<div class="quick-actions-grid" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:14px;margin-bottom:24px">
    <a href="{{ route('penghuni.unit') }}" class="card" style="text-decoration:none;transition:all 0.2s" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
        <div class="card-body" style="text-align:center;padding:24px 16px">
            <i class="fa-solid fa-door-open" style="font-size:1.8rem;color:var(--teal);margin-bottom:10px"></i>
            <h4 style="font-size:0.9rem;font-weight:700;color:var(--text-primary);margin:0 0 4px 0">Info Unit Saya</h4>
            <p style="font-size:0.75rem;color:var(--text-secondary);margin:0">Detail lengkap unit Anda</p>
        </div>
    </a>
    <a href="{{ route('penghuni.tagihan.index') }}" class="card" style="text-decoration:none;transition:all 0.2s" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
        <div class="card-body" style="text-align:center;padding:24px 16px">
            <i class="fa-solid fa-receipt" style="font-size:1.8rem;color:var(--rose);margin-bottom:10px"></i>
            <h4 style="font-size:0.9rem;font-weight:700;color:var(--text-primary);margin:0 0 4px 0">Tagihan & Pembayaran</h4>
            <p style="font-size:0.75rem;color:var(--text-secondary);margin:0">Lihat dan bayar tagihan</p>
        </div>
    </a>
    <a href="{{ route('penghuni.pengaduan.create') }}" class="card" style="text-decoration:none;transition:all 0.2s" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
        <div class="card-body" style="text-align:center;padding:24px 16px">
            <i class="fa-solid fa-headset" style="font-size:1.8rem;color:var(--accent);margin-bottom:10px"></i>
            <h4 style="font-size:0.9rem;font-weight:700;color:var(--text-primary);margin:0 0 4px 0">Buat Pengaduan</h4>
            <p style="font-size:0.75rem;color:var(--text-secondary);margin:0">Laporkan kerusakan / masalah</p>
        </div>
    </a>
    <a href="{{ route('penghuni.pengaduan.index') }}" class="card" style="text-decoration:none;transition:all 0.2s" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
        <div class="card-body" style="text-align:center;padding:24px 16px">
            <i class="fa-solid fa-list-check" style="font-size:1.8rem;color:var(--amber);margin-bottom:10px"></i>
            <h4 style="font-size:0.9rem;font-weight:700;color:var(--text-primary);margin:0 0 4px 0">Pantau Pengaduan</h4>
            <p style="font-size:0.75rem;color:var(--text-secondary);margin:0">Status pengaduan Anda</p>
        </div>
    </a>
</div>

{{-- INFO UNIT RINGKASAN --}}
<div class="card">
    <div class="card-body" style="display:flex;align-items:center;gap:16px;padding:20px 24px">
        <i class="fa-solid fa-circle-check" style="font-size:1.5rem;color:var(--emerald)"></i>
        <div>
            <h4 style="font-size:0.95rem;font-weight:700;color:var(--text-primary);margin:0 0 4px 0">Akun Anda Aktif</h4>
            <p style="font-size:0.82rem;color:var(--text-secondary);margin:0">
                Bergabung sejak {{ $penghuni->tanggal_masuk->format('d M Y') }}
                @if($penghuni->tanggal_keluar)
                    &bull; Keluar: {{ $penghuni->tanggal_keluar->format('d M Y') }}
                @endif
            </p>
        </div>
    </div>
</div>

@endif
@endsection
