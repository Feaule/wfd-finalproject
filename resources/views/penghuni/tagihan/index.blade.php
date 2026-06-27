@extends('layouts.penghuni')

@section('title', 'Tagihan Saya')

@push('styles')
<style>
    @media (max-width: 640px) {
        .tagihan-item-row {
            flex-wrap: wrap !important;
            padding: 14px 16px !important;
            gap: 10px !important;
        }
        .tagihan-item-amount {
            min-width: auto !important;
            text-align: left !important;
            width: 100%;
        }
        .tagihan-item-action {
            min-width: auto !important;
            text-align: left !important;
            width: 100%;
        }
        .tagihan-month-total {
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 6px !important;
            padding: 14px 16px !important;
        }
        .filter-form {
            flex-direction: column !important;
            align-items: stretch !important;
        }
        .filter-form input,
        .filter-form button,
        .filter-form a {
            width: 100%;
        }
    }
</style>
@endpush

@section('content')
<div style="margin-bottom:28px">
    <div style="display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:16px">
        <div>
            <h1 style="font-size:1.6rem;font-weight:800;color:var(--text-primary);letter-spacing:-0.5px">
                Tagihan Saya
            </h1>
            <p style="color:var(--text-muted);font-size:0.875rem;margin-top:4px">
                Unit {{ $penghuni->unit->nomor }}
                @if($penghuni->unit->tipe) — {{ ucfirst($penghuni->unit->tipe) }} @endif
                | Bergabung sejak {{ $penghuni->tanggal_masuk->format('d M Y') }}
            </p>
        </div>

        {{-- Filter bulan --}}
        <form method="GET" action="{{ route('penghuni.tagihan.index') }}" style="display:flex;gap:10px;align-items:flex-end">
            <div>
                <label style="display:block;font-size:0.72rem;font-weight:600;text-transform:uppercase;letter-spacing:0.5px;color:var(--text-muted);margin-bottom:6px">Filter Bulan</label>
                <input type="month" name="bulan" class="form-control" value="{{ request('bulan') }}" style="min-width:170px">
            </div>
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="fa-solid fa-magnifying-glass"></i> Cari
            </button>
            @if(request('bulan'))
            <a href="{{ route('penghuni.tagihan.index') }}" class="btn btn-secondary btn-sm">
                <i class="fa-solid fa-xmark"></i>
            </a>
            @endif
        </form>
    </div>
</div>

@php
    // Hitung ringkasan total
    $totalTagihan  = 0;
    $totalBelum    = 0;
    $totalLunas    = 0;
    $totalMenunggu = 0;
    foreach($tagihanPerBulan as $bulan => $items) {
        foreach($items as $item) {
            $totalTagihan += $item->jumlah;
            if($item->status === 'belum_bayar')           $totalBelum    += $item->jumlah;
            if($item->status === 'lunas')                 $totalLunas    += $item->jumlah;
            if($item->status === 'menunggu_verifikasi')   $totalMenunggu += $item->jumlah;
        }
    }
@endphp

{{-- STAT CARDS --}}
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:16px;margin-bottom:28px">
    <div class="card" style="padding:20px;display:flex;align-items:center;gap:16px">
        <div style="width:46px;height:46px;border-radius:10px;background:var(--teal-light);display:flex;align-items:center;justify-content:center;font-size:1.1rem;color:var(--teal);flex-shrink:0">
            <i class="fa-solid fa-file-invoice-dollar"></i>
        </div>
        <div>
            <div style="font-size:0.72rem;text-transform:uppercase;letter-spacing:0.5px;color:var(--text-muted);font-weight:600">Total Tagihan</div>
            <div style="font-size:1.2rem;font-weight:800;color:var(--text-primary)">Rp {{ number_format($totalTagihan, 0, ',', '.') }}</div>
        </div>
    </div>
    <div class="card" style="padding:20px;display:flex;align-items:center;gap:16px">
        <div style="width:46px;height:46px;border-radius:10px;background:var(--rose-light);display:flex;align-items:center;justify-content:center;font-size:1.1rem;color:var(--rose);flex-shrink:0">
            <i class="fa-solid fa-circle-exclamation"></i>
        </div>
        <div>
            <div style="font-size:0.72rem;text-transform:uppercase;letter-spacing:0.5px;color:var(--text-muted);font-weight:600">Belum Bayar</div>
            <div style="font-size:1.2rem;font-weight:800;color:var(--rose)">Rp {{ number_format($totalBelum, 0, ',', '.') }}</div>
        </div>
    </div>
    <div class="card" style="padding:20px;display:flex;align-items:center;gap:16px">
        <div style="width:46px;height:46px;border-radius:10px;background:var(--amber-light);display:flex;align-items:center;justify-content:center;font-size:1.1rem;color:var(--amber);flex-shrink:0">
            <i class="fa-solid fa-hourglass-half"></i>
        </div>
        <div>
            <div style="font-size:0.72rem;text-transform:uppercase;letter-spacing:0.5px;color:var(--text-muted);font-weight:600">Menunggu</div>
            <div style="font-size:1.2rem;font-weight:800;color:var(--amber)">Rp {{ number_format($totalMenunggu, 0, ',', '.') }}</div>
        </div>
    </div>
    <div class="card" style="padding:20px;display:flex;align-items:center;gap:16px">
        <div style="width:46px;height:46px;border-radius:10px;background:var(--emerald-light);display:flex;align-items:center;justify-content:center;font-size:1.1rem;color:var(--emerald);flex-shrink:0">
            <i class="fa-solid fa-circle-check"></i>
        </div>
        <div>
            <div style="font-size:0.72rem;text-transform:uppercase;letter-spacing:0.5px;color:var(--text-muted);font-weight:600">Lunas</div>
            <div style="font-size:1.2rem;font-weight:800;color:var(--emerald)">Rp {{ number_format($totalLunas, 0, ',', '.') }}</div>
        </div>
    </div>
</div>

{{-- TAGIHAN PER BULAN --}}
@forelse($tagihanPerBulan as $bulan => $items)
@php
    $totalBulanIni = $items->sum('jumlah');
    $semuaLunas    = $items->every(fn($i) => $i->status === 'lunas');
    $adaBelum      = $items->contains(fn($i) => $i->status === 'belum_bayar');
@endphp

<div class="card" style="margin-bottom:20px">
    {{-- Header bulan --}}
    <div class="card-header" style="background:rgba(255,255,255,0.02)">
        <div style="display:flex;align-items:center;gap:14px">
            <div style="width:42px;height:42px;border-radius:10px;background:var(--teal-light);display:flex;align-items:center;justify-content:center;font-size:1rem;color:var(--teal)">
                <i class="fa-solid fa-calendar-days"></i>
            </div>
            <div>
                <div style="font-size:1.05rem;font-weight:700;color:var(--text-primary)">
                    {{ \Carbon\Carbon::parse($bulan . '-01')->translatedFormat('F Y') }}
                </div>
                <div style="font-size:0.78rem;color:var(--text-muted)">{{ $items->count() }} tagihan</div>
            </div>
        </div>
        <div style="text-align:right">
            <div style="font-size:0.72rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.5px">Total</div>
            <div style="font-size:1.2rem;font-weight:800;color:var(--text-primary)">Rp {{ number_format($totalBulanIni, 0, ',', '.') }}</div>
            @if($semuaLunas)
                <span class="badge badge-lunas" style="margin-top:4px">Semua Lunas</span>
            @elseif($adaBelum)
                <span class="badge badge-belum" style="margin-top:4px">Ada yang Belum Bayar</span>
            @else
                <span class="badge badge-tunggu" style="margin-top:4px">Menunggu Verifikasi</span>
            @endif
        </div>
    </div>

    {{-- Item tagihan --}}
    @php
        $iconMap  = ['sewa'=>'fa-house','listrik'=>'fa-bolt','air'=>'fa-droplet','kebersihan'=>'fa-broom'];
        $colorMap = ['sewa'=>'var(--accent)','listrik'=>'var(--amber)','air'=>'var(--teal)','kebersihan'=>'var(--emerald)'];
        $bgMap    = ['sewa'=>'var(--accent-light)','listrik'=>'var(--amber-light)','air'=>'var(--teal-light)','kebersihan'=>'var(--emerald-light)'];
    @endphp

    @foreach($items as $item)
    <div class="tagihan-item-row" style="display:flex;align-items:center;gap:16px;padding:16px 20px;border-bottom:1px solid var(--border);transition:background 0.2s" onmouseover="this.style.background='rgba(255,255,255,0.02)'" onmouseout="this.style.background='transparent'">

        {{-- Ikon jenis --}}
        <div style="width:42px;height:42px;border-radius:10px;background:{{ $bgMap[$item->jenis] }};display:flex;align-items:center;justify-content:center;font-size:1rem;color:{{ $colorMap[$item->jenis] }};flex-shrink:0">
            <i class="fa-solid {{ $iconMap[$item->jenis] }}"></i>
        </div>

        {{-- Info --}}
        <div style="flex:1;min-width:0">
            <div style="font-weight:600;color:var(--text-primary)">{{ ucfirst($item->jenis) }}</div>
            <div style="font-size:0.78rem;color:var(--text-muted)">
                Jatuh tempo: {{ $item->jatuh_tempo->format('d M Y') }}
                @if($item->status !== 'lunas' && $item->jatuh_tempo->isPast())
                    <span style="color:var(--rose);font-weight:600"> — Terlambat!</span>
                @endif
            </div>
        </div>

        {{-- Jumlah --}}
        <div class="tagihan-item-amount" style="font-size:1.1rem;font-weight:700;color:var(--text-primary);min-width:130px;text-align:right;flex-shrink:0">
            Rp {{ number_format($item->jumlah, 0, ',', '.') }}
        </div>

        {{-- Status + Aksi --}}
        <div class="tagihan-item-action" style="min-width:150px;text-align:right;flex-shrink:0">
            @if($item->status === 'belum_bayar')
                <div>
                    <span class="badge badge-belum" style="margin-bottom:8px"><i class="fa-solid fa-clock"></i> Belum Bayar</span>
                    <br>
                    <a href="{{ route('penghuni.pembayaran.create', $item) }}" class="btn btn-primary btn-sm">
                        <i class="fa-solid fa-upload"></i> Bayar
                    </a>
                </div>
            @elseif($item->status === 'menunggu_verifikasi')
                <div>
                    <span class="badge badge-tunggu"><i class="fa-solid fa-hourglass-half"></i> Menunggu Verifikasi</span>
                    @if($item->pembayaran)
                        <div style="font-size:0.72rem;color:var(--text-muted);margin-top:4px">
                            Dibayar: {{ $item->pembayaran->tanggal->format('d M Y') }}
                        </div>
                    @endif
                </div>
            @else
                <div>
                    <span class="badge badge-lunas"><i class="fa-solid fa-circle-check"></i> Lunas</span>
                    @if($item->pembayaran?->verified_at)
                        <div style="font-size:0.72rem;color:var(--text-muted);margin-top:4px">
                            Diverif: {{ $item->pembayaran->verified_at->format('d M Y') }}
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
    @endforeach

    {{-- Total bulan --}}
    <div class="tagihan-month-total" style="padding:14px 20px;background:rgba(255,255,255,0.02);display:flex;justify-content:space-between;align-items:center">
        <span style="font-size:0.8rem;color:var(--text-muted)">Total Tagihan Bulan Ini</span>
        <span style="font-size:1.1rem;font-weight:800;color:var(--text-primary)">Rp {{ number_format($totalBulanIni, 0, ',', '.') }}</span>
    </div>
</div>
@empty
<div class="card">
    <div style="text-align:center;padding:60px 24px">
        <i class="fa-solid fa-file-circle-check" style="font-size:3rem;color:var(--text-muted);opacity:0.3;margin-bottom:16px;display:block"></i>
        <div style="font-size:1rem;font-weight:600;color:var(--text-secondary);margin-bottom:6px">Tidak Ada Tagihan</div>
        <div style="font-size:0.875rem;color:var(--text-muted)">
            @if(request('bulan'))
                Tidak ada tagihan untuk bulan yang dipilih.
            @else
                Belum ada tagihan yang dibuat untuk akun Anda.
            @endif
        </div>
    </div>
</div>
@endforelse
@endsection
