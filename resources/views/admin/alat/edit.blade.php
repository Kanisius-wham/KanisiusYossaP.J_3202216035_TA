@extends('layouts.admin')

@section('content')
<h2 class="text-2xl font-bold mb-6">Edit Alat</h2>
<form action="{{ route('admin.alat.update', $alat->id_alat) }}" method="POST" enctype="multipart/form-data" class="max-w-lg space-y-4">
    @csrf
    @method('PUT')
    <div>
        <label class="block font-semibold">Nama Alat</label>
        <input type="text" name="nama_alat" value="{{ old('nama_alat', $alat->nama_alat) }}" class="w-full border rounded px-3 py-2" required>
    </div>
    <div>
        <label class="block font-semibold">Kategori</label>
        <select name="id_kategori" class="w-full border rounded px-3 py-2" required>
            <option value="">-- Pilih Kategori --</option>
            @foreach($kategoris as $kategori)
                <option value="{{ $kategori->id_kategori }}" {{ $alat->id_kategori == $kategori->id_kategori ? 'selected' : '' }}>
                    {{ $kategori->nama_kategori }}
                </option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block font-semibold">Harga Sewa per Hari</label>
        <input type="number" name="harga_sewa_per_hari" value="{{ old('harga_sewa_per_hari', $alat->harga_sewa_per_hari) }}" class="w-full border rounded px-3 py-2" required>
    </div>
    <div>
        <label class="block font-semibold">Stok</label>
        <input type="number" name="stok" value="{{ old('stok', $alat->stok) }}" class="w-full border rounded px-3 py-2" required>
    </div>
    <div>
        <label class="block font-semibold">Deskripsi</label>
        <textarea name="deskripsi" class="w-full border rounded px-3 py-2">{{ old('deskripsi', $alat->deskripsi) }}</textarea>
    </div>
    <div>
        <label class="block font-semibold">Foto Alat</label>
        @if($alat->foto)
            <img src="{{ asset('storage/alats/' . $alat->foto) }}" alt="Foto alat" class="h-16 mb-2">
        @endif
        <input type="file" name="foto" class="w-full border rounded px-3 py-2">
    </div>
    <div>
        <button type="submit" class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded font-semibold">Update</button>
        <a href="{{ route('admin.alat.index') }}" class="ml-2 text-gray-600 underline">Batal</a>
    </div>
</form>
@endsection
