@extends('layouts.admin')

@section('title', 'Edit Lantai')
@section('page-title', 'Edit Lantai')
@section('breadcrumb', 'Admin / Lantai / Edit')

@section('content')
<div class="card" style="max-width:800px">
    <div class="card-body">
        <form action="{{ route('admin.lantai.update', $lantai) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label class="form-label">Nomor Lantai</label>
                <input type="number" name="nomor_lantai" value="{{ old('nomor_lantai', $lantai->nomor_lantai) }}" required placeholder="Contoh: 1"
                    class="form-control @error('nomor_lantai') border-red-500 @enderror">
                <div class="form-text">Masukkan nomor lantai (1, 2, 3, dst)</div>
                @error('nomor_lantai')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Nama/Deskripsi</label>
                <input type="text" name="nama" value="{{ old('nama', $lantai->nama) }}" placeholder="Contoh: Ground Floor, Second Floor"
                    class="form-control @error('nama') border-red-500 @enderror">
                <div class="form-text">Nama atau deskripsi lantai (opsional)</div>
                @error('nama')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div style="display:flex;gap:12px;margin-top:28px">
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save"></i> Update</button>
                <a href="{{ route('admin.lantai.index') }}" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i> Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
