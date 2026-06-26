@extends('layouts.admin')

@section('title', 'Verifikasi Pembayaran')
@section('page-title', 'Verifikasi Pembayaran')
@section('breadcrumb', 'Admin / Pembayaran')

@section('content')
{{-- STAT CARDS --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon amber"><i class="fa-solid fa-hourglass-half"></i></div>
        <div class="stat-info">
            <p>Menunggu Verifikasi</p>
            <h3>{{ $totalMenunggu }}</h3>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon emerald"><i class="fa-solid fa-shield-check"></i></div>
        <div class="stat-info">
            <p>Sudah Diverifikasi</p>
            <h3>{{ $totalVerifikasi }}</h3>
        </div>
    </div>
</div>

{{-- FILTER --}}
<div class="card" style="margin-bottom:20px">
    <div class="card-body" style="padding:16px 24px">
        <div style="display:flex;gap:10px;align-items:center">
            <a href="{{ route('admin.pembayaran.index') }}"
               class="btn btn-sm {{ request('tampilkan') !== 'semua' ? 'btn-primary' : 'btn-secondary' }}">
                <i class="fa-solid fa-hourglass-half"></i> Menunggu Saja
            </a>
            <a href="{{ route('admin.pembayaran.index') }}?tampilkan=semua"
               class="btn btn-sm {{ request('tampilkan') === 'semua' ? 'btn-primary' : 'btn-secondary' }}">
                <i class="fa-solid fa-list"></i> Tampilkan Semua
            </a>
        </div>
    </div>
</div>

{{-- TABEL PEMBAYARAN --}}
<div class="card">
    <div class="card-header">
        <h2 class="card-title">
            <i class="fa-solid fa-receipt" style="color:var(--amber)"></i>
            {{ request('tampilkan') === 'semua' ? 'Semua Pembayaran' : 'Pembayaran Menunggu Verifikasi' }}
        </h2>
        <span style="font-size:0.8rem;color:var(--text-muted)">Total: {{ $pembayaran->total() }} item</span>
    </div>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Penghuni</th>
                    <th>Unit</th>
                    <th>Jenis Tagihan</th>
                    <th>Jumlah</th>
                    <th>Metode</th>
                    <th>Tanggal Bayar</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pembayaran as $index => $p)
                @php
                    $tagihan = $p->tagihan;
                    $penghuni = $tagihan->penghuni ?? null;
                @endphp
                <tr>
                    <td style="color:var(--text-muted)">{{ $pembayaran->firstItem() + $index }}</td>
                    <td>
                        <div style="font-weight:600;color:var(--text-primary)">{{ $penghuni->user->name ?? '-' }}</div>
                        <div style="font-size:0.75rem;color:var(--text-muted)">{{ $penghuni->user->email ?? '-' }}</div>
                    </td>
                    <td style="font-weight:500">Unit {{ $penghuni->unit->nomor ?? '-' }}</td>
                    <td>
                        @if($tagihan)
                        @php
                            $iconMap  = ['sewa'=>'fa-house','listrik'=>'fa-bolt','air'=>'fa-droplet','kebersihan'=>'fa-broom'];
                            $badgeMap = ['sewa'=>'sewa','listrik'=>'listrik','air'=>'air','kebersihan'=>'kebersihan'];
                        @endphp
                        <span class="badge badge-{{ $badgeMap[$tagihan->jenis] ?? '' }}">
                            <i class="fa-solid {{ $iconMap[$tagihan->jenis] ?? '' }}"></i>
                            {{ ucfirst($tagihan->jenis) }}
                        </span>
                        <div style="font-size:0.72rem;color:var(--text-muted);margin-top:2px">
                            {{ \Carbon\Carbon::parse($tagihan->bulan . '-01')->translatedFormat('M Y') }}
                        </div>
                        @endif
                    </td>
                    <td style="font-weight:600;color:var(--text-primary)">
                        Rp {{ number_format($tagihan->jumlah ?? 0, 0, ',', '.') }}
                    </td>
                    <td style="color:var(--text-secondary)">{{ $p->metode ?? '-' }}</td>
                    <td style="color:var(--text-secondary)">
                        {{ $p->tanggal ? \Carbon\Carbon::parse($p->tanggal)->format('d M Y') : '-' }}
                    </td>
                    <td>
                        @if($p->verified_at)
                            <span class="badge badge-lunas">
                                <i class="fa-solid fa-shield-check"></i> Terverifikasi
                            </span>
                            <div style="font-size:0.7rem;color:var(--text-muted);margin-top:2px">
                                {{ $p->verified_at->format('d M Y H:i') }}
                            </div>
                        @else
                            <span class="badge badge-tunggu">
                                <i class="fa-solid fa-hourglass-half"></i> Menunggu
                            </span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex;gap:8px;flex-wrap:wrap">
                            {{-- Link ke detail tagihan --}}
                            @if($tagihan)
                            <a href="{{ route('admin.tagihan.show', $tagihan->id) }}"
                               class="btn btn-sm btn-secondary" title="Lihat Bukti">
                                <i class="fa-solid fa-eye"></i> Lihat
                            </a>
                            @endif
                            @if(!$p->verified_at)
                            {{-- Verifikasi langsung --}}
                            <form action="{{ route('admin.pembayaran.verifikasi', $p->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success"
                                        onclick="return confirm('Verifikasi pembayaran ini?')">
                                    <i class="fa-solid fa-check"></i> Verifikasi
                                </button>
                            </form>
                            <form action="{{ route('admin.pembayaran.tolak', $p->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Tolak pembayaran ini?')">
                                    <i class="fa-solid fa-times"></i> Tolak
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" style="text-align:center;padding:48px;color:var(--text-muted)">
                        <i class="fa-solid fa-receipt" style="font-size:2.5rem;margin-bottom:12px;display:block;opacity:0.3"></i>
                        {{ request('tampilkan') === 'semua' ? 'Belum ada data pembayaran' : 'Tidak ada pembayaran yang menunggu verifikasi' }}
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($pembayaran->hasPages())
    <div class="pagination-wrapper">
        <div style="font-size:0.8rem;color:var(--text-muted)">
            Menampilkan {{ $pembayaran->firstItem() }}–{{ $pembayaran->lastItem() }} dari {{ $pembayaran->total() }}
        </div>
        {{ $pembayaran->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection
