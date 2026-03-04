@extends('layouts.admin')

@section('content')
@if ($errors->any())
    <div class="mb-3 p-3 bg-red-100 text-red-800 rounded">
        <ul class="pl-4 list-disc">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<h2 class="text-2xl font-bold mb-6">Tambah Alat Baru</h2>
<form action="{{ route('admin.alat.store') }}" method="POST" enctype="multipart/form-data" class="max-w-lg space-y-4">
    @csrf
    <div>
        <label class="block font-semibold">Nama Alat</label>
        <input type="text" name="nama_alat" class="w-full border rounded px-3 py-2" required>
    </div>
    <div>
        <label class="block font-semibold">Kategori</label>
        <select name="id_kategori" class="w-full border rounded px-3 py-2" required>
            <option value="">-- Pilih Kategori --</option>
            @foreach($kategoris as $kategori)
                <option value="{{ $kategori->id_kategori }}">{{ $kategori->nama_kategori }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block font-semibold">Harga Sewa per Hari</label>
        <input type="number" name="harga_sewa_per_hari" class="w-full border rounded px-3 py-2" required>
    </div>
    <div>
        <label class="block font-semibold">Stok</label>
        <input type="number" name="stok" class="w-full border rounded px-3 py-2" required>
    </div>
    <div>
        <label class="block font-semibold">Deskripsi</label>
        <textarea name="deskripsi" class="w-full border rounded px-3 py-2"></textarea>
    </div>
    <div>
        <label class="block font-semibold">Foto Alat</label>
        <input type="file" name="foto" class="w-full border rounded px-3 py-2">
    </div>
    <div>
        <button type="submit" class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded font-semibold">Simpan</button>
        <a href="{{ route('admin.alat.index') }}" class="ml-2 text-gray-600 underline">Batal</a>
    </div>
</form>
@endsection
