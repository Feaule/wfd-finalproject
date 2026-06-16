@extends('layouts.penghuni')

@section('title', 'Upload Bukti Pembayaran')

@section('content')
<div style="max-width:640px;margin:0 auto">

    {{-- Breadcrumb --}}
    <div style="display:flex;align-items:center;gap:10px;margin-bottom:24px">
        <a href="{{ route('penghuni.tagihan.index') }}" class="btn btn-secondary btn-sm">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
        <span style="color:var(--text-muted);font-size:0.875rem">Upload Bukti Pembayaran</span>
    </div>

    {{-- Info tagihan --}}
    <div class="card" style="margin-bottom:20px">
        <div class="card-header">
            <h2 class="card-title"><i class="fa-solid fa-file-invoice" style="color:var(--teal)"></i> Detail Tagihan</h2>
        </div>
        <div class="card-body">
            @php
                $iconMap  = ['sewa'=>'fa-house','listrik'=>'fa-bolt','air'=>'fa-droplet','kebersihan'=>'fa-broom'];
                $colorMap = ['sewa'=>'var(--accent)','listrik'=>'var(--amber)','air'=>'var(--teal)','kebersihan'=>'var(--emerald)'];
                $bgMap    = ['sewa'=>'var(--accent-light)','listrik'=>'var(--amber-light)','air'=>'var(--teal-light)','kebersihan'=>'var(--emerald-light)'];
            @endphp

            <div style="display:flex;align-items:center;gap:20px;margin-bottom:20px">
                <div style="width:64px;height:64px;border-radius:14px;background:{{ $bgMap[$tagihan->jenis] }};display:flex;align-items:center;justify-content:center;font-size:1.6rem;color:{{ $colorMap[$tagihan->jenis] }};flex-shrink:0">
                    <i class="fa-solid {{ $iconMap[$tagihan->jenis] }}"></i>
                </div>
                <div>
                    <div style="font-size:1.4rem;font-weight:800;color:var(--text-primary)">
                        Rp {{ number_format($tagihan->jumlah, 0, ',', '.') }}
                    </div>
                    <div style="font-size:0.9rem;color:var(--text-secondary);font-weight:500">
                        Tagihan {{ ucfirst($tagihan->jenis) }} — {{ \Carbon\Carbon::parse($tagihan->bulan . '-01')->translatedFormat('F Y') }}
                    </div>
                </div>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;background:rgba(255,255,255,0.03);border-radius:var(--radius-sm);padding:14px 18px">
                <div>
                    <div style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.5px;color:var(--text-muted);margin-bottom:2px">Jatuh Tempo</div>
                    @php $isOverdue = $tagihan->jatuh_tempo->isPast(); @endphp
                    <div style="font-weight:600;color:{{ $isOverdue ? 'var(--rose)' : 'var(--text-primary)' }}">
                        {{ $tagihan->jatuh_tempo->format('d M Y') }}
                        @if($isOverdue) <span style="font-size:0.75rem">(Terlambat)</span> @endif
                    </div>
                </div>
                <div>
                    <div style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.5px;color:var(--text-muted);margin-bottom:2px">Status</div>
                    <span class="badge badge-belum"><i class="fa-solid fa-clock"></i> Belum Dibayar</span>
                </div>
            </div>
        </div>
    </div>

    {{-- FORM UPLOAD --}}
    <div class="card">
        <div class="card-header">
            <h2 class="card-title"><i class="fa-solid fa-upload" style="color:var(--teal)"></i> Upload Bukti Pembayaran</h2>
        </div>
        <div class="card-body">
            @if($errors->any())
            <div class="alert alert-danger" style="margin-bottom:20px">
                <div>
                    <i class="fa-solid fa-circle-xmark"></i>
                    <strong>Terdapat kesalahan:</strong>
                    <ul style="margin-top:8px;margin-left:16px">
                        @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif

            <form action="{{ route('penghuni.pembayaran.store', $tagihan) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="metode">Metode Pembayaran</label>
                    <select id="metode" name="metode" class="form-control" required>
                        <option value="">-- Pilih Metode --</option>
                        <option value="Transfer Bank BCA"     {{ old('metode') === 'Transfer Bank BCA'     ? 'selected' : '' }}>Transfer Bank BCA</option>
                        <option value="Transfer Bank BRI"     {{ old('metode') === 'Transfer Bank BRI'     ? 'selected' : '' }}>Transfer Bank BRI</option>
                        <option value="Transfer Bank Mandiri" {{ old('metode') === 'Transfer Bank Mandiri' ? 'selected' : '' }}>Transfer Bank Mandiri</option>
                        <option value="GoPay"                 {{ old('metode') === 'GoPay'                 ? 'selected' : '' }}>GoPay</option>
                        <option value="OVO"                   {{ old('metode') === 'OVO'                   ? 'selected' : '' }}>OVO</option>
                        <option value="QRIS"                  {{ old('metode') === 'QRIS'                  ? 'selected' : '' }}>QRIS</option>
                        <option value="Tunai"                 {{ old('metode') === 'Tunai'                 ? 'selected' : '' }}>Tunai (Ke Kantor)</option>
                    </select>
                    @error('metode') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="bukti_foto">Foto Bukti Pembayaran</label>

                    {{-- Drop zone --}}
                    <div id="drop-zone" style="border:2px dashed var(--border);border-radius:var(--radius-sm);padding:32px 24px;text-align:center;cursor:pointer;transition:all 0.2s;position:relative"
                         onclick="document.getElementById('bukti_foto').click()"
                         ondragover="event.preventDefault();this.style.borderColor='var(--teal)';this.style.background='var(--teal-light)'"
                         ondragleave="this.style.borderColor='var(--border)';this.style.background='transparent'"
                         ondrop="handleDrop(event)">
                        <div id="drop-content">
                            <i class="fa-solid fa-cloud-arrow-up" style="font-size:2.5rem;color:var(--teal);margin-bottom:12px;display:block"></i>
                            <div style="font-size:0.9rem;font-weight:600;color:var(--text-secondary);margin-bottom:4px">Klik atau drag & drop foto di sini</div>
                            <div style="font-size:0.75rem;color:var(--text-muted)">Format: JPG, JPEG, PNG — Maksimum 2MB</div>
                        </div>
                        <div id="preview-container" style="display:none">
                            <img id="preview-img" src="" alt="Preview" style="max-height:200px;max-width:100%;border-radius:8px;margin-bottom:10px">
                            <div id="preview-name" style="font-size:0.8rem;color:var(--text-secondary)"></div>
                            <div style="font-size:0.75rem;color:var(--teal);margin-top:6px">Klik untuk ganti foto</div>
                        </div>
                    </div>

                    <input type="file" id="bukti_foto" name="bukti_foto" accept="image/jpg,image/jpeg,image/png"
                           style="display:none" onchange="previewImage(this)">

                    @error('bukti_foto') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div style="background:var(--teal-light);border:1px solid rgba(20,184,166,0.2);border-radius:var(--radius-sm);padding:12px 16px;margin-bottom:20px;font-size:0.8rem;color:var(--teal)">
                    <i class="fa-solid fa-circle-info"></i>
                    <strong>Catatan:</strong> Setelah mengirim bukti, pembayaran akan diverifikasi oleh admin. Status tagihan akan berubah menjadi "Lunas" setelah verifikasi.
                </div>

                <div style="display:flex;gap:12px">
                    <button type="submit" class="btn btn-primary" id="btn-submit">
                        <i class="fa-solid fa-paper-plane"></i> Kirim Bukti Pembayaran
                    </button>
                    <a href="{{ route('penghuni.tagihan.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran file terlalu besar. Maksimum 2MB.');
            input.value = '';
            return;
        }
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview-img').src = e.target.result;
            document.getElementById('preview-name').textContent = file.name + ' (' + (file.size / 1024).toFixed(1) + ' KB)';
            document.getElementById('drop-content').style.display = 'none';
            document.getElementById('preview-container').style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
}

function handleDrop(event) {
    event.preventDefault();
    const zone = document.getElementById('drop-zone');
    zone.style.borderColor = 'var(--border)';
    zone.style.background = 'transparent';
    const file = event.dataTransfer.files[0];
    if (file) {
        const input = document.getElementById('bukti_foto');
        const dt = new DataTransfer();
        dt.items.add(file);
        input.files = dt.files;
        previewImage(input);
    }
}
</script>
@endpush
