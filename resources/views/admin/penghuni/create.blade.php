@extends('layouts.admin')

@section('title', 'Tambah Penghuni')
@section('page-title', 'Tambah Penghuni')
@section('breadcrumb', 'Admin / Penghuni / Tambah')

@section('content')
<div style="max-width:640px">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title"><i class="fa-solid fa-user-plus" style="color:var(--accent)"></i> Form Tambah Penghuni</h2>
            <a href="{{ route('admin.penghuni.index') }}" class="btn btn-secondary btn-sm">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.penghuni.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="user_id">Akun Penghuni</label>
                    <select id="user_id" name="user_id" class="form-control" required>
                        <option value="">-- Pilih Akun --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <p class="form-error"><i class="fa-solid fa-triangle-exclamation"></i> {{ $message }}</p>
                    @enderror
                    @if($users->isEmpty())
                        <p class="form-text" style="color:var(--amber)">
                            <i class="fa-solid fa-info-circle"></i>
                            Semua user dengan role 'penghuni' sudah menjadi penghuni terdaftar.
                        </p>
                    @endif
                </div>

                <div class="form-group">
                    <label class="form-label" for="unit_id">Unit Apartemen</label>
                    <select id="unit_id" name="unit_id" class="form-control" required>
                        <option value="">-- Pilih Unit --</option>
                        @foreach($units as $unit)
                            <option value="{{ $unit->id }}" {{ old('unit_id') == $unit->id ? 'selected' : '' }}>
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
                               value="{{ old('tanggal_masuk') }}" required>
                        @error('tanggal_masuk')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="tanggal_keluar">Tanggal Keluar <span style="color:var(--text-muted);font-weight:400">(opsional)</span></label>
                        <input id="tanggal_keluar" type="date" name="tanggal_keluar" class="form-control"
                               value="{{ old('tanggal_keluar') }}">
                        @error('tanggal_keluar')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div style="display:flex;gap:12px;margin-top:8px">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Penghuni
                    </button>
                    <a href="{{ route('admin.penghuni.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
