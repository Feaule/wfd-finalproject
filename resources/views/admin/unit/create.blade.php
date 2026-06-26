@extends('layouts.admin')

@section('title', 'Tambah Unit')
@section('page-title', 'Tambah Unit')
@section('breadcrumb', 'Admin / Unit / Tambah')

@section('content')
<div class="card" style="max-width:800px">
    <div class="card-body">
        <form action="{{ route('admin.unit.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group">
                <label class="form-label">Lantai</label>
                <select name="lantai_id" required class="form-control @error('lantai_id') border-red-500 @enderror">
                    <option value="">Pilih Lantai</option>
                    @foreach($lantai as $item)
                    <option value="{{ $item->id }}" {{ old('lantai_id') == $item->id ? 'selected' : '' }}>
                        Lantai {{ $item->nomor_lantai }} - {{ $item->nama }}
                    </option>
                    @endforeach
                </select>
                @error('lantai_id')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Nomor Unit</label>
                <input type="text" name="nomor" value="{{ old('nomor') }}" required placeholder="Contoh: 201"
                    class="form-control @error('nomor') border-red-500 @enderror">
                @error('nomor')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Tipe</label>
                <select name="tipe" required class="form-control @error('tipe') border-red-500 @enderror">
                    <option value="">Pilih Tipe</option>
                    <option value="studio" {{ old('tipe') == 'studio' ? 'selected' : '' }}>Studio</option>
                    <option value="1BR" {{ old('tipe') == '1BR' ? 'selected' : '' }}>1BR</option>
                    <option value="2BR" {{ old('tipe') == '2BR' ? 'selected' : '' }}>2BR</option>
                </select>
                @error('tipe')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Luas (m²)</label>
                <input type="number" name="luas_m2" value="{{ old('luas_m2') }}" required placeholder="Contoh: 36"
                    class="form-control @error('luas_m2') border-red-500 @enderror">
                @error('luas_m2')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Harga Sewa (Rp)</label>
                <input type="number" name="harga_sewa" value="{{ old('harga_sewa') }}" required placeholder="Contoh: 4500000"
                    class="form-control @error('harga_sewa') border-red-500 @enderror">
                @error('harga_sewa')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Status</label>
                <select name="status" required class="form-control @error('status') border-red-500 @enderror">
                    <option value="tersedia" {{ old('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="terisi" {{ old('status') == 'terisi' ? 'selected' : '' }}>Terisi</option>
                </select>
                @error('status')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Foto Unit</label>
                <input type="file" name="foto" accept="image/*"
                    class="form-control @error('foto') border-red-500 @enderror">
                <div class="form-text">Format: JPG, PNG, max 2MB</div>
                @error('foto')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div style="display:flex;gap:12px;margin-top:28px">
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save"></i> Simpan</button>
                <a href="{{ route('admin.unit.index') }}" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i> Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
