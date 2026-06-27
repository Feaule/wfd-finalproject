@extends('layouts.admin')

@push('styles')
<style>
    /* ===== ADMIN DASHBOARD RESPONSIVE ===== */
    @media (max-width: 768px) {
        /* Hero banner stack */
        .hero-banner-inner {
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 16px !important;
        }
        .hero-banner-amount {
            font-size: 1.8rem !important;
        }
        /* Approval item actions */
        .approval-actions {
            flex-direction: column !important;
            gap: 6px !important;
        }
        /* Pending items */
        .pending-item {
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 12px !important;
        }
        .pending-item-actions {
            align-self: flex-end;
        }
    }
    @media (max-width: 480px) {
        .hero-banner-amount {
            font-size: 1.5rem !important;
        }
    }
</style>
@endpush

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Hero Banner: Pendapatan -->
        <div style="background: linear-gradient(135deg, var(--emerald) 0%, var(--teal) 100%); border-radius: var(--radius); padding: 24px 28px; margin-bottom: 28px; box-shadow: 0 12px 24px -8px rgba(16,185,129,0.4); position: relative; overflow: hidden;">
            <!-- Dekorasi background -->
            <div style="position: absolute; right: -5%; top: -20%; opacity: 0.1; transform: rotate(-15deg);">
                <i class="fa-solid fa-chart-line" style="font-size: 12rem; color: #fff;"></i>
            </div>
            <div class="hero-banner-inner" style="display: flex; align-items: center; justify-content: space-between; position: relative; z-index: 1;">
                <div style="color: #fff;">
                    <p style="font-size: 0.9rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 6px; opacity: 0.9;">Pendapatan Bulan Ini</p>
                    <h2 class="hero-banner-amount" style="font-size: 2.4rem; font-weight: 800; margin: 0; line-height: 1.2; color:#fff;">
                        Rp {{ number_format($pendapatanBulanIni / 1000000, 1) }}<span style="font-size: 1.2rem; opacity: 0.8; margin-left: 4px;">Juta</span>
                    </h2>
                </div>
                <div style="background: rgba(255,255,255,0.2); width: 72px; height: 72px; border-radius: 50%; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(8px); flex-shrink:0;">
                    <i class="fa-solid fa-wallet" style="font-size: 2rem; color: #fff;"></i>
                </div>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-8 mb-8">
            
            <!-- Grup: Data Unit & Finansial -->
            <div class="flex-1 lg:border-r border-[var(--border)] lg:pr-8">
                <h4 style="font-size: 0.9rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; margin-bottom: 16px; letter-spacing: 0.5px;">
                    <i class="fa-solid fa-chart-pie" style="margin-right: 6px;"></i> Ringkasan Utama
                </h4>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 16px;">
                    <!-- Card 1 -->
                    <div class="stat-card" style="padding: 16px; background: linear-gradient(145deg, var(--bg-card) 0%, rgba(99,102,241,0.05) 100%); border-color: rgba(99,102,241,0.2);">
                        <div class="stat-icon" style="background: rgba(99,102,241,0.15); width: 44px; height: 44px; font-size: 1.1rem; color: var(--accent);"><i class="fa-solid fa-building"></i></div>
                        <div class="stat-info"><p style="font-size: 0.8rem;">Total Unit</p><h3 style="font-size: 1.3rem;">{{ $totalUnit }}</h3></div>
                    </div>
                    <!-- Card 2 -->
                    <div class="stat-card" style="padding: 16px; background: linear-gradient(145deg, var(--bg-card) 0%, rgba(16,185,129,0.05) 100%); border-color: rgba(16,185,129,0.2);">
                        <div class="stat-icon" style="background: rgba(16,185,129,0.15); width: 44px; height: 44px; font-size: 1.1rem; color: var(--emerald);"><i class="fa-solid fa-check-circle"></i></div>
                        <div class="stat-info"><p style="font-size: 0.8rem;">Unit Terisi</p><h3 style="font-size: 1.3rem;">{{ $unitTerisi }}</h3></div>
                    </div>
                    <!-- Card 3 -->
                    <div class="stat-card" style="padding: 16px; background: linear-gradient(145deg, var(--bg-card) 0%, rgba(20,184,166,0.05) 100%); border-color: rgba(20,184,166,0.2);">
                        <div class="stat-icon" style="background: rgba(20,184,166,0.15); width: 44px; height: 44px; font-size: 1.1rem; color: var(--teal);"><i class="fa-solid fa-plus-circle"></i></div>
                        <div class="stat-info"><p style="font-size: 0.8rem;">Unit Tersedia</p><h3 style="font-size: 1.3rem;">{{ $unitTersedia }}</h3></div>
                    </div>
                </div>
            </div>

            <!-- Grup: Tugas & Alert Pending -->
            <div class="flex-1">
                <h4 style="font-size: 0.9rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; margin-bottom: 16px; letter-spacing: 0.5px;">
                    <i class="fa-solid fa-bell" style="margin-right: 6px;"></i> Tugas Pending
                </h4>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 16px;">
                    <!-- Alert 1 -->
                    <div class="stat-card" style="padding: 16px; background: linear-gradient(145deg, var(--bg-card) 0%, rgba(244,63,94,0.05) 100%); border-color: rgba(244,63,94,0.2);">
                        <div class="stat-icon" style="background: rgba(244,63,94,0.15); width: 44px; height: 44px; font-size: 1.1rem; color: var(--rose);"><i class="fa-solid fa-triangle-exclamation"></i></div>
                        <div class="stat-info"><p style="font-size: 0.8rem;">Pengaduan</p><h3 style="font-size: 1.3rem; color: var(--rose);">{{ $pengaduanPendingCount }}</h3></div>
                    </div>
                    <!-- Alert 2 -->
                    <div class="stat-card" style="padding: 16px; background: linear-gradient(145deg, var(--bg-card) 0%, rgba(245,158,11,0.05) 100%); border-color: rgba(245,158,11,0.2);">
                        <div class="stat-icon" style="background: rgba(245,158,11,0.15); width: 44px; height: 44px; font-size: 1.1rem; color: var(--amber);"><i class="fa-solid fa-door-open"></i></div>
                        <div class="stat-info"><p style="font-size: 0.8rem;">Permohonan Unit</p><h3 style="font-size: 1.3rem; color: var(--amber);">{{ $permohonanUnitCount }}</h3></div>
                    </div>
                    <!-- Alert 3 -->
                    <div class="stat-card" style="padding: 16px; background: linear-gradient(145deg, var(--bg-card) 0%, rgba(20,184,166,0.05) 100%); border-color: rgba(20,184,166,0.2);">
                        <div class="stat-icon" style="background: rgba(20,184,166,0.15); width: 44px; height: 44px; font-size: 1.1rem; color: var(--teal);"><i class="fa-solid fa-receipt"></i></div>
                        <div class="stat-info"><p style="font-size: 0.8rem;">Verifikasi Bayar</p><h3 style="font-size: 1.3rem; color: var(--teal);">{{ $pembayaranPendingCount }}</h3></div>
                    </div>
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

            {{-- Tambahkan total di atas chart --}}
            @php $totalSewa = $laporanSewa->sum('total'); @endphp
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px">
                <p style="font-size:0.8rem;color:var(--text-muted);margin:0">Total 6 bulan terakhir</p>
                <p style="font-size:1.2rem;font-weight:700;color:var(--text-primary);margin:0">
                    Rp {{ number_format($totalSewa / 1000000, 1) }} jt
                </p>
            </div>

            {{-- Canvas Chart.js --}}
            <div style="position:relative;width:100%;height:260px;">
                <canvas id="chartSewa"
                    role="img"
                    aria-label="Bar chart pendapatan sewa 6 bulan terakhir">
                    Total pendapatan: Rp {{ number_format($totalSewa, 0, ',', '.') }}
                </canvas>
            </div>

            <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"></script>
            <script>
            new Chart(document.getElementById('chartSewa'), {
                type: 'bar',
                data: {
                    labels: @json($laporanSewa->map(fn($d) => \Carbon\Carbon::parse($d->bulan . '-01')->translatedFormat('M Y'))),
                    datasets: [{
                        label: 'Pendapatan sewa',
                        data: @json($laporanSewa->pluck('total')->map(fn($v) => (float)$v)),
                        backgroundColor: '#2a78d6',
                        borderRadius: { topLeft: 4, topRight: 4 },
                        borderSkipped: 'bottom',
                        maxBarThickness: 48,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: ctx => 'Rp ' + (ctx.raw / 1000000).toFixed(1) + ' jt'
                            }
                        }
                    },
                    scales: {
                        x: {
                            ticks: { font: { size: 12 }, autoSkip: false, maxRotation: 0 },
                            grid: { display: false }
                        },
                        y: {
                            ticks: {
                                font: { size: 12 },
                                callback: v => 'Rp ' + (v / 1000000).toFixed(0) + 'jt'
                            }
                        }
                    }
                }
            });
            </script>

            @else
            <p style="text-align:center;color:var(--text-muted);padding:40px 0">Belum ada data pendapatan</p>
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

@push('scripts')
<script>
// ============================================================
//  ApartIn — Admin Dashboard Fetch API
//  Semua request ini dapat dilihat di:
//  DevTools → Network → Fetch/XHR
// ============================================================

const API = {
    stats:         '/api/admin/stats',
    notifications: '/api/admin/notifications',
    chart:         '/api/admin/chart',
};

const HEADERS = {
    'Accept': 'application/json',
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? '',
};

// ── Utility ──────────────────────────────────────────────────
function formatRupiah(num) {
    return 'Rp ' + Number(num).toLocaleString('id-ID');
}

function updateBadge(id, value, color) {
    const el = document.getElementById(id);
    if (el) {
        el.textContent = value;
        if (color) el.style.color = `var(--${color})`;
    }
}

// ── 1. Fetch Stats ───────────────────────────────────────────
async function fetchAdminStats() {
    try {
        const res  = await fetch(API.stats, { headers: HEADERS });
        const json = await res.json();

        console.group('%c📊 [API] Admin Stats', 'color:#14B8A6;font-weight:bold');
        console.log('Status :', json.status);
        console.log('Timestamp:', json.timestamp);
        console.table({
            'Total Unit'     : json.data.unit.total,
            'Unit Terisi'    : json.data.unit.terisi,
            'Unit Tersedia'  : json.data.unit.tersedia,
            'Okupansi (%)'   : json.data.unit.okupansi,
            'Pendapatan'     : json.data.pendapatan.formatted,
            'Pengaduan Pending'  : json.data.pending.pengaduan,
            'Permohonan Pending' : json.data.pending.permohonan,
            'Pembayaran Pending' : json.data.pending.pembayaran,
        });
        console.groupEnd();

        // Update live badge di sidebar jika ada
        updateBadge('api-live-ocupancy', json.data.unit.okupansi + '%', 'teal');
        updateBadge('api-live-pendapatan', json.data.pendapatan.formatted, 'emerald');

    } catch (err) {
        console.error('%c❌ [API] Stats Error:', 'color:red', err.message);
    }
}

// ── 2. Fetch Notifications ───────────────────────────────────
async function fetchAdminNotifications() {
    try {
        const res  = await fetch(API.notifications, { headers: HEADERS });
        const json = await res.json();

        console.group('%c🔔 [API] Admin Notifications', 'color:#F59E0B;font-weight:bold');
        console.log('Status  :', json.status);
        console.log('Total   :', json.data.total, 'item pending');
        console.log('Timestamp:', json.timestamp);
        if (json.data.notifications.length > 0) {
            console.table(json.data.notifications.map(n => ({
                'Type'    : n.type,
                'Title'   : n.title,
                'Subtitle': n.subtitle,
                'Time'    : n.time,
            })));
        } else {
            console.log('✅ Tidak ada notifikasi pending.');
        }
        console.groupEnd();

        // Update notif badge di topbar
        const badge = document.getElementById('api-notif-badge');
        if (badge && json.data.total > 0) {
            badge.textContent = json.data.total;
            badge.style.display = 'inline-flex';
        }

    } catch (err) {
        console.error('%c❌ [API] Notifications Error:', 'color:red', err.message);
    }
}

// ── 3. Fetch Chart Data ──────────────────────────────────────
async function fetchAdminChart() {
    try {
        const res  = await fetch(API.chart, { headers: HEADERS });
        const json = await res.json();

        console.group('%c📈 [API] Admin Chart Data — Pendapatan 6 Bulan', 'color:#6366F1;font-weight:bold');
        console.log('Status  :', json.status);
        console.log('Periode :', json.data.period);
        console.log('Total   :', formatRupiah(json.data.total_period));
        console.log('Timestamp:', json.timestamp);

        const tableData = {};
        json.data.labels.forEach((label, i) => {
            tableData[label] = {
                'Pendapatan'  : formatRupiah(json.data.pendapatan[i]),
                'Transaksi'   : json.data.transaksi[i] + 'x',
            };
        });
        console.table(tableData);
        console.groupEnd();

    } catch (err) {
        console.error('%c❌ [API] Chart Error:', 'color:red', err.message);
    }
}

// ── Run all fetches on page load ─────────────────────────────
document.addEventListener('DOMContentLoaded', function () {
    console.log('%c🚀 ApartIn Admin — Fetch API Initialized', 'color:#14B8A6;font-size:13px;font-weight:bold;background:#0F172A;padding:4px 8px;border-radius:4px');

    // Panggil semua sekarang
    fetchAdminStats();
    fetchAdminNotifications();
    fetchAdminChart();

    // Auto-refresh setiap 60 detik
    setInterval(() => {
        console.log('%c♻️ [API] Auto-refresh stats...', 'color:#64748B');
        fetchAdminStats();
        fetchAdminNotifications();
    }, 60000);
});
</script>
@endpush
