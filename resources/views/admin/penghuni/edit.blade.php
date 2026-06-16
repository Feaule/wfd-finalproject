@extends('layouts.admin')

@section('title', 'Edit Penghuni')
@section('page-title', 'Edit Penghuni')
@section('breadcrumb', 'Admin / Penghuni / Edit')

@section('content')
<div style="max-width:640px">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title"><i class="fa-solid fa-user-pen" style="color:var(--accent)"></i> Edit Data Penghuni</h2>
            <a href="{{ route('admin.penghuni.index') }}" class="btn btn-secondary btn-sm">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            {{-- Info penghuni --}}
            <div style="background:var(--accent-light);border:1px solid rgba(99,102,241,0.2);border-radius:var(--radius-sm);padding:14px 18px;margin-bottom:24px;display:flex;align-items:center;gap:14px">
                <div style="width:44px;height:44px;border-radius:50%;background:linear-gradient(135deg,var(--accent),var(--teal));display:flex;align-items:center;justify-content:center;font-size:1.1rem;font-weight:700;color:white;flex-shrink:0">
                    {{ strtoupper(substr($penghuni->user->name, 0, 1)) }}
                </div>
                <div>
                    <div style="font-weight:600;color:var(--text-primary)">{{ $penghuni->user->name }}</div>
                    <div style="font-size:0.8rem;color:var(--text-muted)">{{ $penghuni->user->email }}</div>
                </div>
            </div>

            <form action="{{ route('admin.penghuni.update', $penghuni) }}" method="POST">
                @csrf @method('PUT')

                <div class="form-group">
                    <label class="form-label" for="unit_id">Unit Apartemen</label>
                    <select id="unit_id" name="unit_id" class="form-control" required>
                        @foreach($units as $unit)
                            <option value="{{ $unit->id }}" {{ $penghuni->unit_id == $unit->id ? 'selected' : '' }}>
                                Unit {{ $unit->nomor }}
                                @if($unit->tipe) ({{ ucfirst($unit->tipe) }}) @endif
                                — Rp {{ number_format($unit->harga_sewa, 0, ',', '.') }}/bln
                            </option>
                        @endforeach
                    </select>
                    @error('unit_id')
                        <p class="form-error"><i class="fa-solid fa-triangle-exclamation"></i> {{ $message }}</p>
                    @enderror
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
                    <div class="form-group">
                        <label class="form-label" for="tanggal_masuk">Tanggal Masuk</label>
                        <input id="tanggal_masuk" type="date" name="tanggal_masuk" class="form-control"
                               value="{{ old('tanggal_masuk', $penghuni->tanggal_masuk->format('Y-m-d')) }}" required>
                        @error('tanggal_masuk')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="tanggal_keluar">Tanggal Keluar <span style="color:var(--text-muted);font-weight:400">(opsional)</span></label>
                        <input id="tanggal_keluar" type="date" name="tanggal_keluar" class="form-control"
                               value="{{ old('tanggal_keluar', $penghuni->tanggal_keluar?->format('Y-m-d')) }}">
                        @error('tanggal_keluar')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="status">Status Penghuni</label>
                    <select id="status" name="status" class="form-control" required>
                        <option value="aktif"       {{ $penghuni->status === 'aktif'       ? 'selected' : '' }}>Aktif</option>
                        <option value="tidak_aktif" {{ $penghuni->status === 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                    @error('status')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                    <p class="form-text"><i class="fa-solid fa-info-circle"></i> Mengubah ke "Tidak Aktif" akan membebaskan unit secara otomatis.</p>
                </div>

                <div style="display:flex;gap:12px;margin-top:8px">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.penghuni.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
