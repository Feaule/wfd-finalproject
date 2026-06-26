@extends('layouts.admin')

@section('title', 'Detail Pengaduan')
@section('page-title', 'Detail Pengaduan')
@section('breadcrumb', 'Admin / Pengaduan / Detail')

@section('topbar-actions')
    <a href="{{ route('admin.pengaduan.index') }}" class="btn btn-secondary">
        <i class="fa-solid fa-arrow-left"></i> Kembali
    </a>
@endsection

@section('content')
<div style="display:grid;grid-template-columns:2fr 1fr;gap:24px">
    <!-- DETAIL PENGADUAN -->
    <div>
        <div class="card" style="margin-bottom:24px">
            <div class="card-header">
                <h2 class="card-title"><i class="fa-solid fa-info-circle" style="color:var(--accent)"></i> Detail Pengaduan</h2>
                <span class="badge badge-{{ 
                    $pengaduan->status === 'pending' ? 'tunggu' : 
                    ($pengaduan->status === 'proses' ? 'sewa' : 
                    ($pengaduan->status === 'selesai' ? 'lunas' : 'belum'))
                }}">
                    <i class="fa-solid fa-circle" style="font-size:0.5rem"></i>
                    {{ ucfirst($pengaduan->status) }}
                </span>
            </div>
            <div class="card-body">
                <div style="margin-bottom:20px">
                    <label class="form-label">Kategori</label>
                    <div>
                        <span class="badge badge-{{ 
                            $pengaduan->kategori === 'listrik' ? 'listrik' : 
                            ($pengaduan->kategori === 'air' ? 'air' : 
                            ($pengaduan->kategori === 'kebersihan' ? 'kebersihan' : 'sewa'))
                        }}" style="font-size:0.85rem;padding:6px 12px">
                            {{ ucfirst($pengaduan->kategori) }}
                        </span>
                    </div>
                </div>

                <div style="margin-bottom:20px">
                    <label class="form-label">Judul Pengaduan</label>
                    <div style="font-size:1.1rem;font-weight:700;color:var(--text-primary)">{{ $pengaduan->judul }}</div>
                </div>

                <div style="margin-bottom:20px">
                    <label class="form-label">Deskripsi</label>
                    <div style="font-size:0.9rem;color:var(--text-secondary);line-height:1.7;white-space:pre-wrap">{{ $pengaduan->deskripsi }}</div>
                </div>

                @if($pengaduan->foto)
                <div style="margin-bottom:20px">
                    <label class="form-label">Foto Pendukung</label>
                    <div>
                        <img src="{{ asset('storage/' . $pengaduan->foto) }}" alt="Foto Pengaduan"
                             style="max-width:100%;height:auto;border-radius:var(--radius);border:1px solid var(--border)">
                    </div>
                </div>
                @endif

                <div style="margin-bottom:20px">
                    <label class="form-label">Tanggal Pengaduan</label>
                    <div style="font-size:0.9rem;color:var(--text-secondary)">
                        <i class="fa-solid fa-calendar"></i> {{ $pengaduan->created_at->format('d F Y, H:i') }} WIB
                    </div>
                </div>

                @if($pengaduan->tanggapan)
                <div style="padding:16px;background:var(--emerald-light);border:1px solid var(--emerald);border-radius:var(--radius-sm)">
                    <label class="form-label" style="margin-bottom:8px;color:var(--emerald)">
                        <i class="fa-solid fa-reply"></i> Tanggapan Admin
                    </label>
                    <div style="font-size:0.9rem;color:var(--text-primary);line-height:1.7;white-space:pre-wrap">{{ $pengaduan->tanggapan }}</div>
                </div>
                @endif
            </div>
        </div>

        <!-- FORM UPDATE STATUS -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title"><i class="fa-solid fa-edit" style="color:var(--accent)"></i> Update Status & Tanggapan</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.pengaduan.update', $pengaduan) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label class="form-label">Status Pengaduan</label>
                        <select name="status" required class="form-control @error('status') border-red-500 @enderror">
                            <option value="pending" {{ $pengaduan->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="proses" {{ $pengaduan->status == 'proses' ? 'selected' : '' }}>Proses</option>
                            <option value="selesai" {{ $pengaduan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="ditolak" {{ $pengaduan->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                        @error('status')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Tanggapan</label>
                        <textarea name="tanggapan" rows="5" class="form-control @error('tanggapan') border-red-500 @enderror" 
                                  placeholder="Berikan tanggapan atau keterangan tambahan...">{{ old('tanggapan', $pengaduan->tanggapan) }}</textarea>
                        <div class="form-text">Berikan penjelasan atau update terkait pengaduan ini</div>
                        @error('tanggapan')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div style="display:flex;gap:12px">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-save"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- INFO PENGHUNI -->
    <div>
        <div class="card">
            <div class="card-header">
                <h2 class="card-title"><i class="fa-solid fa-user" style="color:var(--accent)"></i> Info Penghuni</h2>
            </div>
            <div class="card-body">
                <div style="text-align:center;margin-bottom:20px">
                    <div class="avatar" style="width:60px;height:60px;font-size:1.5rem;margin:0 auto 12px">
                        {{ strtoupper(substr($pengaduan->penghuni->user->name, 0, 1)) }}
                    </div>
                    <div style="font-weight:700;font-size:1.1rem;color:var(--text-primary)">{{ $pengaduan->penghuni->user->name }}</div>
                    <div style="font-size:0.8rem;color:var(--text-muted);margin-top:4px">{{ $pengaduan->penghuni->user->email }}</div>
                </div>

                <div style="border-top:1px solid var(--border);padding-top:16px">
                    <div style="margin-bottom:14px">
                        <div style="font-size:0.75rem;color:var(--text-muted);margin-bottom:4px;text-transform:uppercase;letter-spacing:0.5px">Unit</div>
                        <div style="font-size:0.95rem;font-weight:600;color:var(--text-primary)">
                            <i class="fa-solid fa-building" style="color:var(--accent)"></i> Unit {{ $pengaduan->penghuni->unit->nomor }}
                        </div>
                        @if($pengaduan->penghuni->unit->tipe)
                        <div style="font-size:0.8rem;color:var(--text-secondary);margin-top:2px">Tipe: {{ ucfirst($pengaduan->penghuni->unit->tipe) }}</div>
                        @endif
                    </div>

                    <div style="margin-bottom:14px">
                        <div style="font-size:0.75rem;color:var(--text-muted);margin-bottom:4px;text-transform:uppercase;letter-spacing:0.5px">Status</div>
                        <div>
                            @if($pengaduan->penghuni->status === 'aktif')
                                <span class="badge badge-aktif"><i class="fa-solid fa-circle" style="font-size:0.5rem"></i> Aktif</span>
                            @else
                                <span class="badge badge-nonaktif"><i class="fa-solid fa-circle" style="font-size:0.5rem"></i> Tidak Aktif</span>
                            @endif
                        </div>
                    </div>

                    <div>
                        <div style="font-size:0.75rem;color:var(--text-muted);margin-bottom:4px;text-transform:uppercase;letter-spacing:0.5px">Tanggal Masuk</div>
                        <div style="font-size:0.9rem;color:var(--text-secondary)">
                            <i class="fa-solid fa-calendar"></i> {{ $pengaduan->penghuni->tanggal_masuk->format('d M Y') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- QUICK STATS -->
        <div class="card" style="margin-top:20px">
            <div class="card-header">
                <h2 class="card-title"><i class="fa-solid fa-chart-simple" style="color:var(--accent)"></i> Statistik</h2>
            </div>
            <div class="card-body">
                <div style="margin-bottom:14px;display:flex;justify-content:space-between;align-items:center">
                    <span style="font-size:0.85rem;color:var(--text-secondary)">Total Pengaduan</span>
                    <span style="font-size:1.1rem;font-weight:700;color:var(--text-primary)">
                        {{ $pengaduan->penghuni->pengaduan()->count() }}
                    </span>
                </div>
                <div style="margin-bottom:14px;display:flex;justify-content:space-between;align-items:center">
                    <span style="font-size:0.85rem;color:var(--text-secondary)">Pending</span>
                    <span class="badge badge-tunggu">{{ $pengaduan->penghuni->pengaduan()->where('status', 'pending')->count() }}</span>
                </div>
                <div style="margin-bottom:14px;display:flex;justify-content:space-between;align-items:center">
                    <span style="font-size:0.85rem;color:var(--text-secondary)">Selesai</span>
                    <span class="badge badge-lunas">{{ $pengaduan->penghuni->pengaduan()->where('status', 'selesai')->count() }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
