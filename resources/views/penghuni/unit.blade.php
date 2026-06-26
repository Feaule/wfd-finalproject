@extends('layouts.penghuni')

@section('title', 'Info Unit Saya')

@section('content')
<div style="margin-bottom:32px">
    <h1 style="font-size:1.75rem;font-weight:800;color:var(--text-primary);margin-bottom:8px">
        <i class="fa-solid fa-door-open" style="color:var(--teal)"></i> Info Unit Saya
    </h1>
    <p style="font-size:0.9rem;color:var(--text-secondary)">Informasi lengkap tentang unit apartemen Anda</p>
</div>

{{-- =============================== --}}
{{-- STATUS: AKTIF — tampilkan detail --}}
{{-- =============================== --}}
@if($penghuni && $penghuni->status === 'aktif' && $penghuni->unit)
<div style="display:grid;grid-template-columns:1fr;gap:24px">
    <!-- UNIT INFO CARD -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title"><i class="fa-solid fa-building" style="color:var(--teal)"></i> Detail Unit</h2>
            <span class="badge badge-lunas">
                <i class="fa-solid fa-circle" style="font-size:0.5rem"></i> Aktif
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
                    <p style="font-size:1.3rem;font-weight:700;color:var(--text-primary);margin:0">Lantai {{ $penghuni->unit->lantai->nomor_lantai }}</p>
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
                        {{ $penghuni->unit->luas_m2 ?? '-' }} <span style="font-size:0.85rem;color:var(--text-secondary)">m²</span>
                    </p>
                </div>
                <div>
                    <p style="font-size:0.72rem;color:var(--text-muted);font-weight:600;text-transform:uppercase;margin-bottom:8px">
                        <i class="fa-solid fa-tag" style="font-size:0.7rem"></i> Harga Sewa
                    </p>
                    <p style="font-size:1.3rem;font-weight:700;color:var(--teal);margin:0">
                        Rp {{ number_format($penghuni->unit->harga_sewa, 0, ',', '.') }}
                        <span style="font-size:0.75rem;color:var(--text-secondary)">/bulan</span>
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

{{-- ============================================ --}}
{{-- STATUS: MENUNGGU — permohonan sedang diproses --}}
{{-- ============================================ --}}
@elseif($penghuni && $penghuni->status === 'menunggu')
<div class="card">
    <div class="card-body" style="text-align:center;padding:60px 20px">
        <i class="fa-solid fa-hourglass-half" style="font-size:3rem;color:var(--amber);margin-bottom:20px;display:block;animation: pulse 2s infinite;"></i>
        <h3 style="font-size:1.3rem;font-weight:700;color:var(--text-primary);margin:0 0 10px 0">Permohonan Sedang Diproses</h3>
        <p style="font-size:0.9rem;color:var(--text-secondary);margin:0 0 6px 0">
            Anda telah mengajukan permohonan untuk menempati
            <strong>Unit {{ $penghuni->unit->nomor ?? '-' }}</strong>.
        </p>
        <p style="font-size:0.85rem;color:var(--text-muted);margin:0 0 24px 0">
            Admin akan segera memproses permohonan Anda. Harap tunggu konfirmasi.
        </p>
        <div style="background:rgba(245,158,11,0.08);border:1px solid var(--amber);border-radius:var(--radius);padding:16px;max-width:400px;margin:0 auto 24px auto;text-align:left">
            <p style="font-size:0.78rem;color:var(--text-muted);font-weight:600;text-transform:uppercase;margin-bottom:8px">Detail Permohonan</p>
            <p style="margin:4px 0;font-size:0.9rem"><strong>Unit:</strong> {{ $penghuni->unit->nomor ?? '-' }}</p>
            @if($penghuni->unit && $penghuni->unit->lantai)
            <p style="margin:4px 0;font-size:0.9rem"><strong>Lantai:</strong> {{ $penghuni->unit->lantai->nomor_lantai }}</p>
            @endif
            <p style="margin:4px 0;font-size:0.9rem"><strong>Diajukan:</strong> {{ $penghuni->created_at->format('d M Y H:i') }}</p>
        </div>
        <form action="{{ route('penghuni.unit.batalkan') }}" method="POST"
              onsubmit="return confirm('Yakin ingin membatalkan permohonan ini?')">
            @csrf
            <button type="submit" class="btn btn-danger">
                <i class="fa-solid fa-times"></i> Batalkan Permohonan
            </button>
        </form>
    </div>
</div>

{{-- ============================================== --}}
{{-- TIDAK ADA UNIT — tampilkan daftar unit tersedia --}}
{{-- ============================================== --}}
@else
@if(session('success'))
<div class="alert alert-success" style="margin-bottom:20px">
    <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
</div>
@endif
@if(session('error'))
<div class="alert alert-danger" style="margin-bottom:20px">
    <i class="fa-solid fa-circle-xmark"></i> {{ session('error') }}
</div>
@endif

<div class="card" style="margin-bottom:24px">
    <div class="card-body" style="padding:20px 24px">
        <div style="display:flex;align-items:center;gap:14px">
            <div style="width:48px;height:48px;background:var(--teal-light);border-radius:var(--radius-sm);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                <i class="fa-solid fa-building-slash" style="font-size:1.5rem;color:var(--teal)"></i>
            </div>
            <div>
                <h3 style="font-size:1rem;font-weight:700;color:var(--text-primary);margin:0 0 4px 0">Anda Belum Menempati Unit</h3>
                <p style="font-size:0.85rem;color:var(--text-secondary);margin:0">Pilih unit yang tersedia di bawah ini dan ajukan permohonan untuk menempatinya.</p>
            </div>
        </div>
    </div>
</div>

@if($unitTersedia && $unitTersedia->count() > 0)
<div class="card">
    <div class="card-header">
        <h2 class="card-title">
            <i class="fa-solid fa-list-check" style="color:var(--teal);margin-right:8px"></i>
            Unit Tersedia untuk Disewa
        </h2>
        <span class="badge badge-tunggu" style="padding:6px 12px">
            <i class="fa-solid fa-building" style="font-size:0.7rem"></i>
            {{ $unitTersedia->count() }} unit
        </span>
    </div>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th style="width:15%">Unit</th>
                    <th style="width:20%">Lantai</th>
                    <th style="width:15%">Tipe</th>
                    <th style="width:12%">Luas</th>
                    <th style="width:23%">Harga Sewa</th>
                    <th style="width:15%;text-align:center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($unitTersedia as $unit)
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px">
                            <div style="width:36px;height:36px;background:var(--teal-light);border-radius:var(--radius-sm);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                                <i class="fa-solid fa-door-open" style="color:var(--teal);font-size:0.9rem"></i>
                            </div>
                            <strong style="color:var(--teal);font-size:1.05rem;font-weight:700">{{ $unit->nomor }}</strong>
                        </div>
                    </td>
                    <td>
                        <div style="display:flex;flex-direction:column;gap:3px">
                            <span style="font-weight:600;color:var(--text-primary);font-size:0.9rem">
                                <i class="fa-solid fa-layer-group" style="font-size:0.75rem;color:var(--text-muted);margin-right:6px"></i>
                                Lantai {{ $unit->lantai->nomor_lantai ?? '-' }}
                            </span>
                            @if($unit->lantai && $unit->lantai->nama)
                            <span style="font-size:0.75rem;color:var(--text-muted);padding-left:22px">{{ $unit->lantai->nama }}</span>
                            @endif
                        </div>
                    </td>
                    <td>
                        <span class="badge badge-sewa" style="padding:6px 12px;text-transform:capitalize;font-size:0.78rem">
                            <i class="fa-solid fa-shapes" style="font-size:0.7rem"></i>
                            {{ $unit->tipe ?? '-' }}
                        </span>
                    </td>
                    <td>
                        <div style="display:flex;align-items:baseline;gap:4px">
                            <strong style="color:var(--text-primary);font-size:1rem;font-weight:700">{{ $unit->luas_m2 ?? '-' }}</strong>
                            <span style="font-size:0.75rem;color:var(--text-muted)">m²</span>
                        </div>
                    </td>
                    <td>
                        <div style="display:flex;flex-direction:column;gap:2px">
                            <strong style="color:var(--teal);font-size:1rem;font-weight:700">
                                Rp {{ number_format($unit->harga_sewa, 0, ',', '.') }}
                            </strong>
                            <span style="font-size:0.7rem;color:var(--text-muted)">
                                <i class="fa-solid fa-calendar" style="font-size:0.65rem;margin-right:4px"></i>
                                per bulan
                            </span>
                        </div>
                    </td>
                    <td style="text-align:center">
                        <form action="{{ route('penghuni.unit.ajukan', $unit->id) }}" method="POST" style="display:inline-block"
                              onsubmit="return confirm('Apakah Anda yakin ingin mengajukan permohonan untuk Unit {{ $unit->nomor }}?\n\nHarga sewa: Rp {{ number_format($unit->harga_sewa, 0, ',', '.') }}/bulan')">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-sm" style="box-shadow:0 2px 8px rgba(20,184,166,0.25)">
                                <i class="fa-solid fa-paper-plane"></i>
                                Ajukan
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div style="padding:16px 24px;border-top:1px solid var(--border);background:rgba(255,255,255,0.02)">
        <p style="font-size:0.8rem;color:var(--text-muted);margin:0">
            <i class="fa-solid fa-circle-info" style="color:var(--teal);margin-right:6px"></i>
            Pilih unit yang sesuai dengan kebutuhan Anda dan ajukan permohonan. Admin akan memproses permohonan Anda segera.
        </p>
    </div>
</div>
@else
<div class="card">
    <div class="card-body" style="text-align:center;padding:60px 20px">
        <i class="fa-solid fa-building-slash" style="font-size:3rem;color:var(--text-muted);opacity:0.3;margin-bottom:20px;display:block"></i>
        <h3 style="font-size:1.2rem;font-weight:700;color:var(--text-primary);margin:0 0 10px 0">Tidak Ada Unit Tersedia</h3>
        <p style="font-size:0.9rem;color:var(--text-secondary);margin:0">Saat ini semua unit sedang terisi. Silakan hubungi admin untuk informasi lebih lanjut.</p>
    </div>
</div>
@endif
@endif

<style>
@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}
</style>
@endsection
