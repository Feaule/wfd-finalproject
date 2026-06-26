@extends('layouts.admin')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Statistik Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon indigo">
                    <i class="fa-solid fa-building"></i>
                </div>
                <div class="stat-info">
                    <p>Total Unit</p>
                    <h3>{{ $totalUnit }}</h3>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon emerald">
                    <i class="fa-solid fa-check-circle"></i>
                </div>
                <div class="stat-info">
                    <p>Unit Terisi</p>
                    <h3>{{ $unitTerisi }}</h3>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon teal">
                    <i class="fa-solid fa-plus-circle"></i>
                </div>
                <div class="stat-info">
                    <p>Unit Tersedia</p>
                    <h3>{{ $unitTersedia }}</h3>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon emerald">
                    <i class="fa-solid fa-money-bill-wave"></i>
                </div>
                <div class="stat-info">
                    <p>Pendapatan Bulan Ini</p>
                    <h3 style="font-size: 1.3rem;">Rp {{ number_format($pendapatanBulanIni / 1000000, 1) }}jt</h3>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(239,68,68,0.12);">
                    <i class="fa-solid fa-triangle-exclamation" style="color: var(--rose);"></i>
                </div>
                <div class="stat-info">
                    <p>Pengaduan Pending</p>
                    <h3 style="color: var(--rose);">{{ $pengaduanPendingCount }}</h3>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(245,158,11,0.12);">
                    <i class="fa-solid fa-door-open" style="color: var(--amber);"></i>
                </div>
                <div class="stat-info">
                    <p>Permohonan Unit</p>
                    <h3 style="color: var(--amber);">{{ $permohonanUnitCount }}</h3>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(20,184,166,0.12);">
                    <i class="fa-solid fa-receipt" style="color: var(--teal);"></i>
                </div>
                <div class="stat-info">
                    <p>Verifikasi Pembayaran</p>
                    <h3 style="color: var(--teal);">{{ $pembayaranPendingCount }}</h3>
                </div>
            </div>
        </div>

        <!-- Pending Approval -->
        @if($pendingApproval > 0)
        <div class="alert alert-warning" style="margin-bottom: 28px;">
            <i class="fa-solid fa-exclamation-triangle"></i>
            <span>
                Ada <strong>{{ $pendingApproval }} pengguna</strong> menunggu persetujuan akun.
                <a href="#approval-section" style="text-decoration: underline; font-weight: 600;">Lihat daftar</a>
            </span>
        </div>
        @endif

        @if($permohonanUnitCount > 0)
        <div class="alert" style="background: rgba(245,158,11,0.1); border: 1px solid var(--amber); color: var(--text-primary); margin-bottom: 28px; border-radius: var(--radius); padding: 14px 20px; display: flex; align-items: center; gap: 12px;">
            <i class="fa-solid fa-door-open" style="color: var(--amber);"></i>
            <span>
                Ada <strong>{{ $permohonanUnitCount }} permohonan unit</strong> menunggu persetujuan.
                <a href="#permohonan-section" style="text-decoration: underline; font-weight: 600;">Lihat daftar</a>
            </span>
        </div>
        @endif

        @if($pembayaranPendingCount > 0)
        <div class="alert" style="background: rgba(20,184,166,0.1); border: 1px solid var(--teal); color: var(--text-primary); margin-bottom: 28px; border-radius: var(--radius); padding: 14px 20px; display: flex; align-items: center; gap: 12px;">
            <i class="fa-solid fa-receipt" style="color: var(--teal);"></i>
            <span>
                Ada <strong>{{ $pembayaranPendingCount }} pembayaran tagihan</strong> menunggu verifikasi.
                <a href="#pembayaran-section" style="text-decoration: underline; font-weight: 600;">Lihat daftar</a>
            </span>
        </div>
        @endif

        <!-- Laporan Sewa Chart -->
        <div class="card" style="margin-bottom: 28px;">
            <div class="card-header">
                <h2 class="card-title">Laporan Pendapatan Sewa (6 Bulan Terakhir)</h2>
            </div>
            <div class="card-body">
                @if($laporanSewa->count() > 0)
                <div style="display: flex; align-items: flex-end; gap: 16px; height: 250px;">
                    @foreach($laporanSewa as $data)
                    <div style="flex: 1; display: flex; flex-direction: column; align-items: center; gap: 8px;">
                        <div style="width: 100%; background: var(--accent); border-radius: 8px 8px 0 0; height: {{ ($data->total / $laporanSewa->max('total')) * 100 }}%;"></div>
                        <p style="font-size: 0.75rem; color: var(--text-muted);">{{ \Carbon\Carbon::parse($data->bulan)->format('M Y') }}</p>
                        <p style="font-size: 0.75rem; font-weight: 600; color: var(--text-primary);">{{ number_format($data->total / 1000000, 1) }}jt</p>
                    </div>
                    @endforeach
                </div>
                @else
                <p style="text-align: center; color: var(--text-muted); padding: 40px 0;">Belum ada data pendapatan</p>
                @endif
            </div>
        </div>

        <!-- Timeline Ketersediaan Unit -->
        <div class="card" style="margin-bottom: 28px;">
            <div class="card-header">
                <h2 class="card-title">Timeline Ketersediaan Unit</h2>
            </div>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Unit</th>
                            <th>Penghuni</th>
                            <th>Tanggal Masuk</th>
                            <th>Tanggal Keluar</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($timeline as $item)
                        <tr>
                            <td><strong>{{ $item->unit->nomor ?? '-' }}</strong></td>
                            <td>{{ $item->user->name ?? '-' }}</td>
                            <td>{{ $item->tanggal_masuk ? $item->tanggal_masuk->format('d M Y') : '-' }}</td>
                            <td>{{ $item->tanggal_keluar ? $item->tanggal_keluar->format('d M Y') : 'Belum ditentukan' }}</td>
                            <td>
                                <span class="badge badge-{{ $item->status === 'aktif' ? 'aktif' : 'nonaktif' }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" style="text-align: center; color: var(--text-muted); padding: 40px 0;">Belum ada data penghuni</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Approval Penghuni -->
        <div id="approval-section" class="card" style="margin-bottom: 28px;">
            <div class="card-header">
                <h2 class="card-title">Persetujuan Akun Pengguna Baru</h2>
            </div>
            <div class="card-body">
                @forelse($usersNeedApproval as $user)
                <div style="display: flex; align-items: center; justify-content: space-between; padding: 16px 0; border-bottom: 1px solid var(--border);">
                    <div>
                        <p style="font-weight: 600; color: var(--text-primary); margin-bottom: 4px;">{{ $user->name }}</p>
                        <p style="font-size: 0.875rem; color: var(--text-secondary);">{{ $user->email }}</p>
                        <p style="font-size: 0.875rem; color: var(--text-muted);">KTP: {{ $user->no_ktp }}</p>
                    </div>
                    <div style="display: flex; gap: 10px;">
                        <form action="{{ route('admin.users.approve', $user->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="fa-solid fa-check"></i> Setujui
                            </button>
                        </form>
                        <form action="{{ route('admin.users.reject', $user->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fa-solid fa-times"></i> Tolak
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <p style="text-align: center; color: var(--text-muted); padding: 40px 0;">Tidak ada pengguna yang menunggu persetujuan akun</p>
                @endforelse
            </div>
        </div>

        <!-- Permohonan Unit -->
        <div id="permohonan-section" class="card" style="margin-bottom: 28px;">
            <div class="card-header">
                <h2 class="card-title"><i class="fa-solid fa-door-open" style="color: var(--amber);"></i> Permohonan Menempati Unit</h2>
                <a href="{{ route('admin.penghuni.index') }}" style="font-size:0.8rem; color: var(--accent);">Lihat semua →</a>
            </div>
            <div class="card-body">
                @forelse($permohonan ?? [] as $p)
                <div style="display: flex; align-items: center; justify-content: space-between; padding: 16px 0; border-bottom: 1px solid var(--border);">
                    <div>
                        <p style="font-weight: 600; color: var(--text-primary); margin-bottom: 4px;">
                            {{ $p->user->name ?? '-' }}
                        </p>
                        <p style="font-size: 0.875rem; color: var(--text-secondary);">
                            Mengajukan: <strong>Unit {{ $p->unit->nomor ?? '-' }}</strong>
                            @if($p->unit && $p->unit->lantai)
                                — Lantai {{ $p->unit->lantai->nomor_lantai }}
                            @endif
                        </p>
                        <p style="font-size: 0.8rem; color: var(--text-muted);">
                            <i class="fa-solid fa-clock"></i> {{ $p->created_at->diffForHumans() }}
                        </p>
                    </div>
                    <div style="display: flex; gap: 10px;">
                        <form action="{{ route('admin.penghuni.approve-permohonan', $p->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm"
                                    onclick="return confirm('Setujui permohonan ini?')">
                                <i class="fa-solid fa-check"></i> Setujui
                            </button>
                        </form>
                        <form action="{{ route('admin.penghuni.reject-permohonan', $p->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Tolak permohonan ini?')">
                                <i class="fa-solid fa-times"></i> Tolak
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <p style="text-align: center; color: var(--text-muted); padding: 32px 0;">Tidak ada permohonan unit yang menunggu</p>
                @endforelse
            </div>
        </div>

        <!-- Pembayaran Menunggu Verifikasi -->
        <div id="pembayaran-section" class="card" style="margin-bottom: 28px;">
            <div class="card-header">
                <h2 class="card-title"><i class="fa-solid fa-receipt" style="color: var(--teal);"></i> Pembayaran Menunggu Verifikasi</h2>
                <a href="{{ route('admin.pembayaran.index') }}" style="font-size:0.8rem; color: var(--accent);">Lihat semua →</a>
            </div>
            <div class="card-body">
                @forelse($pembayaranPending as $pembayaran)
                <div style="display: flex; align-items: center; justify-content: space-between; padding: 16px 0; border-bottom: 1px solid var(--border);">
                    <div style="flex: 1;">
                        <p style="font-weight: 600; color: var(--text-primary); margin-bottom: 4px;">
                            {{ $pembayaran->tagihan->penghuni->user->name ?? '-' }} 
                            <span style="color: var(--text-muted); font-size: 0.8rem; font-weight: normal;">(Unit {{ $pembayaran->tagihan->penghuni->unit->nomor ?? '-' }})</span>
                        </p>
                        <p style="font-size: 0.875rem; color: var(--text-secondary);">
                            {{ ucfirst($pembayaran->tagihan->jenis ?? '-') }} — Rp {{ number_format($pembayaran->tagihan->jumlah ?? 0, 0, ',', '.') }}
                        </p>
                        <p style="font-size: 0.8rem; color: var(--text-muted);">
                            <i class="fa-solid fa-wallet"></i> {{ $pembayaran->metode }}
                            &bull; {{ $pembayaran->created_at->diffForHumans() }}
                        </p>
                    </div>
                    <div style="display: flex; gap: 10px;">
                        <form action="{{ route('admin.pembayaran.verifikasi', $pembayaran->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm"
                                    onclick="return confirm('Verifikasi pembayaran ini?')">
                                <i class="fa-solid fa-check"></i> Verifikasi
                            </button>
                        </form>
                        <form action="{{ route('admin.pembayaran.tolak', $pembayaran->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Tolak pembayaran ini?')">
                                <i class="fa-solid fa-times"></i> Tolak
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <p style="text-align: center; color: var(--text-muted); padding: 32px 0;">Tidak ada pembayaran menunggu verifikasi</p>
                @endforelse
            </div>
        </div>

        <!-- Pengaduan Pending -->
        <div id="pengaduan-section" class="card">
            <div class="card-header">
                <h2 class="card-title"><i class="fa-solid fa-triangle-exclamation" style="color: var(--rose);"></i> Pengaduan Pending</h2>
                <a href="{{ route('admin.pengaduan.index') }}?status=pending" style="font-size:0.8rem; color: var(--accent);">Lihat semua →</a>
            </div>
            <div class="card-body">
                @forelse($pengaduanPending as $aduan)
                <div style="display: flex; align-items: center; justify-content: space-between; padding: 16px 0; border-bottom: 1px solid var(--border);">
                    <div style="flex: 1;">
                        <p style="font-weight: 600; color: var(--text-primary); margin-bottom: 4px;">
                            {{ $aduan->judul }}
                        </p>
                        <p style="font-size: 0.875rem; color: var(--text-secondary);">
                            {{ $aduan->penghuni->user->name ?? '-' }}
                            @if($aduan->penghuni && $aduan->penghuni->unit)
                                — Unit {{ $aduan->penghuni->unit->nomor }}
                            @endif
                        </p>
                        <p style="font-size: 0.8rem; color: var(--text-muted);">
                            <i class="fa-solid fa-tag"></i> {{ ucfirst($aduan->kategori) }}
                            &bull; {{ $aduan->created_at->diffForHumans() }}
                        </p>
                    </div>
                    <a href="{{ route('admin.pengaduan.show', $aduan->id) }}" class="btn btn-secondary btn-sm">
                        <i class="fa-solid fa-eye"></i> Detail
                    </a>
                </div>
                @empty
                <p style="text-align: center; color: var(--text-muted); padding: 32px 0;">Tidak ada pengaduan pending</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
