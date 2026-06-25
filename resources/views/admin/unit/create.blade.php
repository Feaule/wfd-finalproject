@extends('layouts.admin')

@section('content')
<div class="py-8">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">Tambah Unit</h1>

        <div class="bg-white shadow-md rounded-lg p-6">
            <form action="{{ route('admin.unit.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Lantai</label>
                    <select name="lantai_id" required class="w-full px-3 py-2 border rounded-lg @error('lantai_id') border-red-500 @enderror">
                        <option value="">Pilih Lantai</option>
                        @foreach($lantai as $item)
                        <option value="{{ $item->id }}" {{ old('lantai_id') == $item->id ? 'selected' : '' }}>
                            Lantai {{ $item->nomor_lantai }} - {{ $item->nama }}
                        </option>
                        @endforeach
                    </select>
                    @error('lantai_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Nomor Unit</label>
                    <input type="text" name="nomor" value="{{ old('nomor') }}" required
                        class="w-full px-3 py-2 border rounded-lg @error('nomor') border-red-500 @enderror">
                    @error('nomor')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Tipe</label>
                    <select name="tipe" required class="w-full px-3 py-2 border rounded-lg @error('tipe') border-red-500 @enderror">
                        <option value="">Pilih Tipe</option>
                        <option value="studio" {{ old('tipe') == 'studio' ? 'selected' : '' }}>Studio</option>
                        <option value="1BR" {{ old('tipe') == '1BR' ? 'selected' : '' }}>1BR</option>
                        <option value="2BR" {{ old('tipe') == '2BR' ? 'selected' : '' }}>2BR</option>
                    </select>
                    @error('tipe')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Luas (m²)</label>
                    <input type="number" name="luas_m2" value="{{ old('luas_m2') }}" required
                        class="w-full px-3 py-2 border rounded-lg @error('luas_m2') border-red-500 @enderror">
                    @error('luas_m2')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Harga Sewa (Rp)</label>
                    <input type="number" name="harga_sewa" value="{{ old('harga_sewa') }}" required
                        class="w-full px-3 py-2 border rounded-lg @error('harga_sewa') border-red-500 @enderror">
                    @error('harga_sewa')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Status</label>
                    <select name="status" required class="w-full px-3 py-2 border rounded-lg @error('status') border-red-500 @enderror">
                        <option value="tersedia" {{ old('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="terisi" {{ old('status') == 'terisi' ? 'selected' : '' }}>Terisi</option>
                    </select>
                    @error('status')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Foto Unit</label>
                    <input type="file" name="foto" accept="image/*"
                        class="w-full px-3 py-2 border rounded-lg @error('foto') border-red-500 @enderror">
                    @error('foto')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex space-x-2">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Simpan</button>
                    <a href="{{ route('admin.unit.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
