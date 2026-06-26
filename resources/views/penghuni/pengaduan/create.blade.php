@extends('layouts.penghuni')

@section('title', 'Buat Pengaduan')

@section('content')
<div style="margin-bottom:32px">
    <h1 style="font-size:1.75rem;font-weight:800;color:var(--text-primary);margin-bottom:8px">
        <i class="fa-solid fa-plus-circle" style="color:var(--accent)"></i> Buat Pengaduan Baru
    </h1>
    <p style="font-size:0.9rem;color:var(--text-secondary)">Laporkan masalah atau keluhan Anda kepada pengelola</p>
</div>

<div style="max-width:800px">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title"><i class="fa-solid fa-edit" style="color:var(--accent)"></i> Form Pengaduan</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('penghuni.pengaduan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="kategori">
                        <i class="fa-solid fa-tag"></i> Kategori
                    </label>
                    <select name="kategori" id="kategori" class="form-control" required>
                        <option value="">-- Pilih Kategori --</option>
                        <option value="listrik" {{ old('kategori') == 'listrik' ? 'selected' : '' }}>Listrik</option>
                        <option value="air" {{ old('kategori') == 'air' ? 'selected' : '' }}>Air</option>
                        <option value="kebersihan" {{ old('kategori') == 'kebersihan' ? 'selected' : '' }}>Kebersihan</option>
                        <option value="keamanan" {{ old('kategori') == 'keamanan' ? 'selected' : '' }}>Keamanan</option>
                        <option value="fasilitas" {{ old('kategori') == 'fasilitas' ? 'selected' : '' }}>Fasilitas</option>
                        <option value="lainnya" {{ old('kategori') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('kategori')
                        <p class="form-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="judul">
                        <i class="fa-solid fa-heading"></i> Judul Pengaduan
                    </label>
                    <input type="text" name="judul" id="judul" class="form-control" 
                           placeholder="Contoh: AC Unit tidak dingin" 
                           value="{{ old('judul') }}" required>
                    @error('judul')
                        <p class="form-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
                    @enderror
                    <p class="form-text">Masukkan judul singkat yang menggambarkan masalah</p>
                </div>

                <div class="form-group">
                    <label class="form-label" for="deskripsi">
                        <i class="fa-solid fa-align-left"></i> Deskripsi Lengkap
                    </label>
                    <textarea name="deskripsi" id="deskripsi" rows="6" class="form-control" 
                              placeholder="Jelaskan masalah secara detail..." required>{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <p class="form-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
                    @enderror
                    <p class="form-text">Berikan informasi selengkap mungkin untuk mempercepat penanganan</p>
                </div>

                <div class="form-group">
                    <label class="form-label" for="foto">
                        <i class="fa-solid fa-camera"></i> Foto Pendukung (Opsional)
                    </label>
                    <input type="file" name="foto" id="foto" class="form-control" accept="image/*" onchange="previewImage(event)">
                    @error('foto')
                        <p class="form-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
                    @enderror
                    <p class="form-text">Format: JPG, PNG. Maksimal 2MB</p>
                    <div id="preview" style="margin-top:12px;display:none">
                        <img id="preview-img" style="max-width:300px;border-radius:var(--radius-sm);border:1px solid var(--border)">
                    </div>
                </div>

                <div style="display:flex;gap:12px;padding-top:8px">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-paper-plane"></i> Kirim Pengaduan
                    </button>
                    <a href="{{ route('penghuni.pengaduan.index') }}" class="btn btn-secondary">
                        <i class="fa-solid fa-arrow-left"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function previewImage(event) {
    const preview = document.getElementById('preview');
    const previewImg = document.getElementById('preview-img');
    const file = event.target.files[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(file);
    } else {
        preview.style.display = 'none';
    }
}
</script>
@endpush
@endsection
