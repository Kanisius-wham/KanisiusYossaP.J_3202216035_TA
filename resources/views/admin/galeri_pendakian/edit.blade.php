@extends('layouts.admin')

@section('content')
<div class="flex min-h-screen">
    <div class="flex-1 p-8">
        <h2 class="text-xl font-bold mb-4">Edit Foto Pendakian</h2>
        <form action="{{ route('admin.galeri_pendakian.update', $item->id) }}" method="POST" enctype="multipart/form-data" class="max-w-lg bg-white rounded shadow p-6">
            @csrf @method('PUT')
            <div class="mb-3">
                <label>Nama (opsional)</label>
                <input type="text" name="nama" class="w-full border rounded p-2" value="{{ old('nama', $item->nama) }}">
            </div>
            <div class="mb-3">
                <label>Gambar (biarkan kosong jika tidak ganti)</label>
                <input type="file" name="gambar" class="w-full border rounded p-2">
                <img src="{{ asset('storage/galeri_pendakian/' . $item->gambar) }}" alt="" class="w-32 mt-2 rounded shadow">
                @error('gambar') <div class="text-red-500">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label>Deskripsi (opsional)</label>
                <textarea name="deskripsi" class="w-full border rounded p-2">{{ old('deskripsi', $item->deskripsi) }}</textarea>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update</button>
                <a href="{{ route('admin.galeri_beranda.index') }}" class="bg-gray-300 px-4 py-2 rounded">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
