@extends('layouts.admin')

@section('title', 'Detail Tagihan')
@section('page-title', 'Detail Tagihan')
@section('breadcrumb', 'Admin / Tagihan / Detail')

@section('content')
<div style="max-width:800px">

    {{-- BACK + HEADER --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px">
        <a href="{{ route('admin.tagihan.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
        @if($tagihan->status === 'belum_bayar')
            <span class="badge badge-belum" style="font-size:0.85rem;padding:8px 16px"><i class="fa-solid fa-clock"></i> Belum Bayar</span>
        @elseif($tagihan->status === 'menunggu_verifikasi')
            <span class="badge badge-tunggu" style="font-size:0.85rem;padding:8px 16px"><i class="fa-solid fa-hourglass-half"></i> Menunggu Verifikasi</span>
        @else
            <span class="badge badge-lunas" style="font-size:0.85rem;padding:8px 16px"><i class="fa-solid fa-circle-check"></i> Lunas</span>
        @endif
    </div>

    {{-- INFO TAGIHAN --}}
    <div class="card" style="margin-bottom:20px">
        <div class="card-header">
            <h2 class="card-title"><i class="fa-solid fa-file-invoice" style="color:var(--accent)"></i> Informasi Tagihan</h2>
        </div>
        <div class="card-body">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px">
                <div>
                    <div style="font-size:0.72rem;font-weight:600;text-transform:uppercase;letter-spacing:0.6px;color:var(--text-muted);margin-bottom:4px">Penghuni</div>
                    <div style="font-size:1rem;font-weight:700;color:var(--text-primary)">{{ $tagihan->penghuni->user->name }}</div>
                    <div style="font-size:0.8rem;color:var(--text-muted)">{{ $tagihan->penghuni->user->email }}</div>
                </div>
                <div>
                    <div style="font-size:0.72rem;font-weight:600;text-transform:uppercase;letter-spacing:0.6px;color:var(--text-muted);margin-bottom:4px">Unit</div>
                    <div style="font-size:1rem;font-weight:700;color:var(--text-primary)">Unit {{ $tagihan->penghuni->unit->nomor }}</div>
                    @if($tagihan->penghuni->unit->tipe)
                        <div style="font-size:0.8rem;color:var(--text-muted)">{{ ucfirst($tagihan->penghuni->unit->tipe) }} — {{ $tagihan->penghuni->unit->luas_m2 }} m²</div>
                    @endif
                </div>
                <div>
                    <div style="font-size:0.72rem;font-weight:600;text-transform:uppercase;letter-spacing:0.6px;color:var(--text-muted);margin-bottom:4px">Periode</div>
                    <div style="font-size:1rem;font-weight:700;color:var(--text-primary)">
                        {{ \Carbon\Carbon::parse($tagihan->bulan . '-01')->translatedFormat('F Y') }}
                    </div>
                </div>
                <div>
                    <div style="font-size:0.72rem;font-weight:600;text-transform:uppercase;letter-spacing:0.6px;color:var(--text-muted);margin-bottom:4px">Jenis Tagihan</div>
                    @php
                        $iconMap = ['sewa'=>'fa-house','listrik'=>'fa-bolt','air'=>'fa-droplet','kebersihan'=>'fa-broom'];
                        $badgeMap= ['sewa'=>'sewa','listrik'=>'listrik','air'=>'air','kebersihan'=>'kebersihan'];
                    @endphp
                    <span class="badge badge-{{ $badgeMap[$tagihan->jenis] }}" style="font-size:0.85rem;padding:6px 14px">
                        <i class="fa-solid {{ $iconMap[$tagihan->jenis] }}"></i>
                        {{ ucfirst($tagihan->jenis) }}
                    </span>
                </div>
                <div>
                    <div style="font-size:0.72rem;font-weight:600;text-transform:uppercase;letter-spacing:0.6px;color:var(--text-muted);margin-bottom:4px">Jumlah Tagihan</div>
                    <div style="font-size:1.5rem;font-weight:800;color:var(--text-primary)">
                        Rp {{ number_format($tagihan->jumlah, 0, ',', '.') }}
                    </div>
                </div>
                <div>
                    <div style="font-size:0.72rem;font-weight:600;text-transform:uppercase;letter-spacing:0.6px;color:var(--text-muted);margin-bottom:4px">Jatuh Tempo</div>
                    @php $isOverdue = $tagihan->status !== 'lunas' && $tagihan->jatuh_tempo->isPast(); @endphp
                    <div style="font-size:1rem;font-weight:700;color:{{ $isOverdue ? 'var(--rose)' : 'var(--text-primary)' }}">
                        {{ $tagihan->jatuh_tempo->format('d F Y') }}
                        @if($isOverdue) <span style="font-size:0.72rem">(Terlambat)</span> @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- BUKTI PEMBAYARAN --}}
    @if($tagihan->pembayaran)
    <div class="card" style="margin-bottom:20px">
        <div class="card-header">
            <h2 class="card-title"><i class="fa-solid fa-receipt" style="color:var(--teal)"></i> Bukti Pembayaran</h2>
        </div>
        <div class="card-body">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px">
                <div>
                    <div style="font-size:0.72rem;font-weight:600;text-transform:uppercase;letter-spacing:0.6px;color:var(--text-muted);margin-bottom:4px">Tanggal Bayar</div>
                    <div style="font-weight:600;color:var(--text-primary)">{{ $tagihan->pembayaran->tanggal->format('d F Y') }}</div>
                </div>
                <div>
                    <div style="font-size:0.72rem;font-weight:600;text-transform:uppercase;letter-spacing:0.6px;color:var(--text-muted);margin-bottom:4px">Metode</div>
                    <div style="font-weight:600;color:var(--text-primary)">{{ $tagihan->pembayaran->metode ?? '-' }}</div>
                </div>
                <div>
                    <div style="font-size:0.72rem;font-weight:600;text-transform:uppercase;letter-spacing:0.6px;color:var(--text-muted);margin-bottom:4px">Status Verifikasi</div>
                    @if($tagihan->pembayaran->verified_at)
                        <span class="badge badge-lunas">
                            <i class="fa-solid fa-shield-check"></i>
                            Terverifikasi — {{ $tagihan->pembayaran->verified_at->format('d M Y H:i') }}
                        </span>
                    @else
                        <span class="badge badge-tunggu">
                            <i class="fa-solid fa-hourglass-half"></i>
                            Belum Diverifikasi
                        </span>
                    @endif
                </div>
            </div>

            {{-- Gambar bukti --}}
            <div style="margin-bottom:20px">
                <div style="font-size:0.72rem;font-weight:600;text-transform:uppercase;letter-spacing:0.6px;color:var(--text-muted);margin-bottom:10px">Foto Bukti Transfer</div>
                <a href="{{ asset('storage/' . $tagihan->pembayaran->bukti_foto) }}" target="_blank">
                    <img src="{{ asset('storage/' . $tagihan->pembayaran->bukti_foto) }}"
                         alt="Bukti Pembayaran"
                         style="max-width:400px;width:100%;border-radius:10px;border:1px solid var(--border);cursor:zoom-in;transition:opacity 0.2s"
                         onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'">
                </a>
                <p style="font-size:0.75rem;color:var(--text-muted);margin-top:6px">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i> Klik gambar untuk lihat ukuran penuh
                </p>
            </div>

            {{-- Tombol verifikasi --}}
            @if(!$tagihan->pembayaran->verified_at)
            <div style="display:flex;gap:12px;padding-top:16px;border-top:1px solid var(--border)">
                <form action="{{ route('admin.pembayaran.verifikasi', $tagihan->pembayaran) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success"
                            onclick="return confirm('Verifikasi pembayaran ini dan tandai tagihan sebagai lunas?')">
                        <i class="fa-solid fa-shield-check"></i> Verifikasi & Lunas
                    </button>
                </form>
                <form action="{{ route('admin.pembayaran.tolak', $tagihan->pembayaran) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger"
                            onclick="return confirm('Tolak pembayaran ini? Bukti akan dihapus dan status kembali ke Belum Bayar.')">
                        <i class="fa-solid fa-xmark"></i> Tolak Pembayaran
                    </button>
                </form>
            </div>
            @else
            <div class="alert alert-success" style="margin-bottom:0">
                <i class="fa-solid fa-circle-check"></i>
                Pembayaran sudah diverifikasi pada {{ $tagihan->pembayaran->verified_at->format('d M Y H:i') }}
            </div>
            @endif
        </div>
    </div>
    @else
    <div class="card">
        <div class="card-body" style="text-align:center;padding:40px">
            <i class="fa-solid fa-file-circle-question" style="font-size:2.5rem;color:var(--text-muted);opacity:0.4;margin-bottom:12px;display:block"></i>
            <div style="color:var(--text-muted);font-size:0.9rem">Belum ada bukti pembayaran yang dikirimkan</div>
        </div>
    </div>
    @endif
</div>
@endsection
