@extends('layouts.admin')

@section('title', 'Daftar Tagihan')
@section('page-title', 'Daftar Tagihan')
@section('breadcrumb', 'Admin / Tagihan')

@section('topbar-actions')
    <a href="{{ route('admin.tagihan.generate.form') }}" class="btn btn-teal">
        <i class="fa-solid fa-bolt"></i> Generate Tagihan
    </a>
@endsection

@section('content')
{{-- STAT CARDS --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon rose"><i class="fa-solid fa-clock"></i></div>
        <div class="stat-info">
            <p>Belum Bayar</p>
            <h3>{{ $totalBelumBayar }}</h3>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon amber"><i class="fa-solid fa-hourglass-half"></i></div>
        <div class="stat-info">
            <p>Menunggu Verifikasi</p>
            <h3>{{ $totalMenunggu }}</h3>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon emerald"><i class="fa-solid fa-circle-check"></i></div>
        <div class="stat-info">
            <p>Lunas</p>
            <h3>{{ $totalLunas }}</h3>
        </div>
    </div>
</div>

{{-- FILTER --}}
<div class="card" style="margin-bottom:24px">
    <div class="card-body" style="padding:20px 24px">
        <form method="GET" action="{{ route('admin.tagihan.index') }}" class="filter-bar">
            <div class="form-group">
                <label class="form-label">Filter Bulan</label>
                <input type="month" name="bulan" class="form-control"
                       value="{{ request('bulan') }}">
            </div>
            <div class="form-group">
                <label class="form-label">Filter Status</label>
                <select name="status" class="form-control">
                    <option value="">Semua Status</option>
                    <option value="belum_bayar"          {{ request('status') === 'belum_bayar'          ? 'selected' : '' }}>Belum Bayar</option>
                    <option value="menunggu_verifikasi"  {{ request('status') === 'menunggu_verifikasi'  ? 'selected' : '' }}>Menunggu Verifikasi</option>
                    <option value="lunas"                {{ request('status') === 'lunas'                ? 'selected' : '' }}>Lunas</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Filter Jenis</label>
                <select name="jenis" class="form-control">
                    <option value="">Semua Jenis</option>
                    <option value="sewa"       {{ request('jenis') === 'sewa'       ? 'selected' : '' }}>Sewa</option>
                    <option value="listrik"    {{ request('jenis') === 'listrik'    ? 'selected' : '' }}>Listrik</option>
                    <option value="air"        {{ request('jenis') === 'air'        ? 'selected' : '' }}>Air</option>
                    <option value="kebersihan" {{ request('jenis') === 'kebersihan' ? 'selected' : '' }}>Kebersihan</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">&nbsp;</label>
                <div style="display:flex;gap:8px">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-magnifying-glass"></i> Filter
                    </button>
                    @if(request()->hasAny(['bulan','status','jenis']))
                    <a href="{{ route('admin.tagihan.index') }}" class="btn btn-secondary">
                        <i class="fa-solid fa-xmark"></i> Reset
                    </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

{{-- TABEL --}}
<div class="card">
    <div class="card-header">
        <h2 class="card-title"><i class="fa-solid fa-file-invoice-dollar" style="color:var(--accent)"></i> Daftar Tagihan</h2>
        <span style="font-size:0.8rem;color:var(--text-muted)">Total: {{ $tagihan->total() }} tagihan</span>
    </div>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Penghuni</th>
                    <th>Unit</th>
                    <th>Bulan</th>
                    <th>Jenis</th>
                    <th>Jumlah</th>
                    <th>Jatuh Tempo</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tagihan as $index => $t)
                <tr>
                    <td style="color:var(--text-muted)">{{ $tagihan->firstItem() + $index }}</td>
                    <td>
                        <div style="font-weight:600;color:var(--text-primary)">{{ $t->penghuni->user->name }}</div>
                    </td>
                    <td style="font-weight:500">Unit {{ $t->penghuni->unit->nomor }}</td>
                    <td>
                        <span style="font-weight:600">
                            {{ \Carbon\Carbon::parse($t->bulan . '-01')->translatedFormat('M Y') }}
                        </span>
                    </td>
                    <td>
                        @php
                            $badgeMap = ['sewa'=>'sewa','listrik'=>'listrik','air'=>'air','kebersihan'=>'kebersihan'];
                            $iconMap  = ['sewa'=>'fa-house','listrik'=>'fa-bolt','air'=>'fa-droplet','kebersihan'=>'fa-broom'];
                        @endphp
                        <span class="badge badge-{{ $badgeMap[$t->jenis] ?? '' }}">
                            <i class="fa-solid {{ $iconMap[$t->jenis] ?? '' }}"></i>
                            {{ ucfirst($t->jenis) }}
                        </span>
                    </td>
                    <td style="font-weight:600;color:var(--text-primary)">
                        Rp {{ number_format($t->jumlah, 0, ',', '.') }}
                    </td>
                    <td>
                        @php $isOverdue = $t->status !== 'lunas' && $t->jatuh_tempo->isPast(); @endphp
                        <span style="color:{{ $isOverdue ? 'var(--rose)' : 'var(--text-secondary)' }}">
                            {{ $t->jatuh_tempo->format('d M Y') }}
                        </span>
                        @if($isOverdue)
                            <span style="font-size:0.68rem;color:var(--rose);display:block">Lewat jatuh tempo</span>
                        @endif
                    </td>
                    <td>
                        @if($t->status === 'belum_bayar')
                            <span class="badge badge-belum"><i class="fa-solid fa-circle" style="font-size:0.45rem"></i> Belum Bayar</span>
                        @elseif($t->status === 'menunggu_verifikasi')
                            <span class="badge badge-tunggu"><i class="fa-solid fa-circle" style="font-size:0.45rem"></i> Menunggu</span>
                        @else
                            <span class="badge badge-lunas"><i class="fa-solid fa-circle" style="font-size:0.45rem"></i> Lunas</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.tagihan.show', $t) }}" class="btn btn-sm btn-secondary">
                            <i class="fa-solid fa-eye"></i> Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" style="text-align:center;padding:48px;color:var(--text-muted)">
                        <i class="fa-solid fa-file-circle-xmark" style="font-size:2.5rem;margin-bottom:12px;display:block;opacity:0.35"></i>
                        Tidak ada tagihan ditemukan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($tagihan->hasPages())
    <div class="pagination-wrapper">
        <div style="font-size:0.8rem;color:var(--text-muted)">
            Menampilkan {{ $tagihan->firstItem() }}–{{ $tagihan->lastItem() }} dari {{ $tagihan->total() }} tagihan
        </div>
        {{ $tagihan->links() }}
    </div>
    @endif
</div>
@endsection
