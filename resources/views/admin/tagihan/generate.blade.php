@extends('layouts.admin')

@section('title', 'Generate Tagihan')
@section('page-title', 'Generate Tagihan Bulanan')
@section('breadcrumb', 'Admin / Tagihan / Generate')

@section('content')
<div style="display:grid;grid-template-columns:1fr 380px;gap:24px;align-items:start">

    {{-- FORM GENERATE --}}
    <div class="card">
        <div class="card-header">
            <h2 class="card-title"><i class="fa-solid fa-bolt" style="color:var(--amber)"></i> Form Generate Tagihan</h2>
        </div>
        <div class="card-body">
            {{-- Info --}}
            <div style="background:var(--teal-light);border:1px solid rgba(20,184,166,0.25);border-radius:var(--radius-sm);padding:14px 18px;margin-bottom:24px">
                <div style="display:flex;align-items:flex-start;gap:12px">
                    <i class="fa-solid fa-circle-info" style="color:var(--teal);margin-top:2px;flex-shrink:0"></i>
                    <div style="font-size:0.82rem;color:var(--teal)">
                        <strong>Cara kerja:</strong> Sistem akan membuat tagihan untuk semua penghuni aktif ({{ $penghuni->count() }} penghuni) untuk bulan yang dipilih. Penghuni yang sudah memiliki tagihan untuk bulan tersebut akan dilewati.
                    </div>
                </div>
            </div>

            <form action="{{ route('admin.tagihan.generate') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="bulan">Periode Bulan</label>
                    <input id="bulan" type="month" name="bulan" class="form-control"
                           value="{{ old('bulan', date('Y-m')) }}" required>
                    @error('bulan')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="jatuh_tempo">Tanggal Jatuh Tempo</label>
                    <input id="jatuh_tempo" type="date" name="jatuh_tempo" class="form-control"
                           value="{{ old('jatuh_tempo') }}" required>
                    @error('jatuh_tempo')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div style="border:1px solid var(--border);border-radius:var(--radius-sm);padding:20px;margin-bottom:20px">
                    <div style="font-size:0.8rem;font-weight:700;color:var(--text-secondary);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:16px">
                        <i class="fa-solid fa-sliders" style="color:var(--accent)"></i> Biaya per Penghuni
                    </div>

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
                        <div class="form-group" style="margin-bottom:0">
                            <label class="form-label" for="jumlah_listrik">
                                <i class="fa-solid fa-bolt" style="color:var(--amber)"></i> Listrik (Rp)
                            </label>
                            <input id="jumlah_listrik" type="number" name="jumlah_listrik" class="form-control"
                                   value="{{ old('jumlah_listrik', 150000) }}" min="0" step="1000" required>
                            @error('jumlah_listrik')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group" style="margin-bottom:0">
                            <label class="form-label" for="jumlah_air">
                                <i class="fa-solid fa-droplet" style="color:var(--teal)"></i> Air (Rp)
                            </label>
                            <input id="jumlah_air" type="number" name="jumlah_air" class="form-control"
                                   value="{{ old('jumlah_air', 75000) }}" min="0" step="1000" required>
                            @error('jumlah_air')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group" style="margin-bottom:0">
                            <label class="form-label" for="jumlah_kebersihan">
                                <i class="fa-solid fa-broom" style="color:var(--emerald)"></i> Kebersihan (Rp)
                            </label>
                            <input id="jumlah_kebersihan" type="number" name="jumlah_kebersihan" class="form-control"
                                   value="{{ old('jumlah_kebersihan', 50000) }}" min="0" step="1000" required>
                            @error('jumlah_kebersihan')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div style="background:var(--accent-light);border-radius:var(--radius-sm);padding:12px;display:flex;flex-direction:column;justify-content:center">
                            <div style="font-size:0.7rem;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.5px">Sewa</div>
                            <div style="font-size:0.82rem;color:var(--accent);font-weight:600;margin-top:4px">
                                <i class="fa-solid fa-house"></i> Otomatis dari harga unit masing-masing penghuni
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;padding:13px"
                        onclick="return confirm('Generate tagihan untuk {{ $penghuni->count() }} penghuni aktif bulan yang dipilih?')">
                    <i class="fa-solid fa-bolt"></i> Generate Sekarang
                </button>
            </form>
        </div>
    </div>

    {{-- DAFTAR PENGHUNI AKTIF --}}
    <div class="card">
        <div class="card-header">
            <h2 class="card-title" style="font-size:0.9rem"><i class="fa-solid fa-users" style="color:var(--emerald)"></i> Penghuni Aktif</h2>
            <span class="badge badge-aktif">{{ $penghuni->count() }} penghuni</span>
        </div>
        <div style="max-height:500px;overflow-y:auto">
            @forelse($penghuni as $p)
            <div style="display:flex;align-items:center;gap:12px;padding:14px 20px;border-bottom:1px solid var(--border)">
                <div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,var(--accent),var(--teal));display:flex;align-items:center;justify-content:center;font-size:0.8rem;font-weight:700;color:white;flex-shrink:0">
                    {{ strtoupper(substr($p->user->name, 0, 1)) }}
                </div>
                <div style="flex:1;min-width:0">
                    <div style="font-size:0.85rem;font-weight:600;color:var(--text-primary);overflow:hidden;text-overflow:ellipsis;white-space:nowrap">{{ $p->user->name }}</div>
                    <div style="font-size:0.72rem;color:var(--text-muted)">Unit {{ $p->unit->nomor }}</div>
                </div>
                <div style="text-align:right;flex-shrink:0">
                    <div style="font-size:0.72rem;color:var(--text-muted)">Sewa</div>
                    <div style="font-size:0.8rem;font-weight:600;color:var(--accent)">Rp {{ number_format($p->unit->harga_sewa, 0, ',', '.') }}</div>
                </div>
            </div>
            @empty
            <div style="text-align:center;padding:32px;color:var(--text-muted);font-size:0.875rem">
                Tidak ada penghuni aktif
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
