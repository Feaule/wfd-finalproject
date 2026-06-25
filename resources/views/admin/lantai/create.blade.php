@extends('layouts.admin')

@section('content')
<div class="py-8">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">Tambah Lantai</h1>

        <div class="bg-white shadow-md rounded-lg p-6">
            <form action="{{ route('admin.lantai.store') }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Nomor Lantai</label>
                    <input type="number" name="nomor_lantai" value="{{ old('nomor_lantai') }}" required
                        class="w-full px-3 py-2 border rounded-lg @error('nomor_lantai') border-red-500 @enderror">
                    @error('nomor_lantai')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Nama/Deskripsi</label>
                    <input type="text" name="nama" value="{{ old('nama') }}"
                        class="w-full px-3 py-2 border rounded-lg @error('nama') border-red-500 @enderror">
                    @error('nama')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex space-x-2">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Simpan</button>
                    <a href="{{ route('admin.lantai.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
