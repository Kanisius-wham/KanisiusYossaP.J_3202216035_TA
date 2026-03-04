@extends('layouts.admin')

@if(session('success'))
  <div class="bg-green-200 text-green-800 p-2 mb-4 rounded">
    {{ session('success') }}
  </div>
@endif


@section('content')
<div class="flex min-h-screen">
    
    <aside class="w-64 bg-blue-900 text-white flex flex-col py-8 px-4">
        <div class="mb-8">
            <img src="{{ asset('images/logosenentang.png') }}" class="h-10 mx-auto mb-2">
            <h1 class="text-lg font-bold text-center">Admin</h1>
        </div>
        <nav class="flex-1 flex flex-col space-y-4">
            <a href="#" class="hover:bg-blue-800 rounded px-3 py-2">Dashboard</a>
            <a href="{{ route('admin.alat.index') }}" class="hover:bg-blue-800 rounded px-3 py-2">Alat</a>
            <a href="{{ route('admin.kategori.index') }}"class="hover:bg-blue-800 rounded px-3 py-2 {{ request()->routeIs('admin.kategori.index') ? 'bg-blue-800' : '' }}">Kategori</a>
            <a href="{{ route('admin.galeri_beranda.index') }}"
            class="hover:bg-blue-800 rounded px-3 py-2 {{ request()->routeIs('admin.galeri_beranda.index') ? 'bg-blue-800' : '' }}">Galeri Beranda</a>
            <a href="#" class="hover:bg-blue-800 rounded px-3 py-2">Penyewaan</a>
            <a href="#" class="hover:bg-blue-800 rounded px-3 py-2">User</a>
            <a href="#" class="hover:bg-blue-800 rounded px-3 py-2">Laporan Keuangan</a>
            <a href="{{ url('/') }}" class="hover:bg-blue-800 rounded px-3 py-2 mt-auto text-red-400">Logout</a>
        </nav>
    </aside>
    <div class="flex-1 p-8">
    {{-- Section Galeri Pendakian --}}
    <div class="mb-8">
        <div class="flex justify-between mb-2">
            <h2 class="text-lg font-bold">Galeri Pendakian </h2>
            <a href="{{ route('admin.galeri_pendakian.create') }}" class="bg-blue-500 text-white px-2 py-1 rounded">+ Tambah Foto Pendakian</a>
        </div>
        <table class="min-w-full bg-white rounded shadow">
            <thead>
                <tr>
                    <th class="p-2">No</th>
                    <th class="p-2">Nama</th>
                    <th class="p-2">Gambar</th>
                    <th class="p-2">Deskripsi</th>
                    <th class="p-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pendakian as $item)
                <tr class="border-t">
                    <td class="p-2">{{ $loop->iteration }}</td>
                    <td class="p-2">{{ $item->nama }}</td>
                    <td class="p-2">
                        <img src="{{ asset('storage/galeri_pendakian/' . $item->gambar) }}" class="w-24 rounded shadow" alt="">
                    </td>
                    <td class="p-2">{{ $item->deskripsi }}</td>
                    <td class="p-2 flex gap-2">
                        <a href="{{ route('admin.galeri_pendakian.edit', $item->id) }}" class="bg-yellow-400 px-2 py-1 rounded text-white hover:bg-yellow-600">Edit</a>
                        <form method="POST" action="{{ route('admin.galeri_pendakian.destroy', $item->id) }}" onsubmit="return confirm('Yakin hapus?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="bg-red-500 px-2 py-1 rounded text-white hover:bg-red-700">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center p-4">Belum ada data</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Section Rekomendasi Wisata --}}
    <div>
        <div class="flex justify-between mb-2">
            <h2 class="text-lg font-bold">Rekomendasi Wisata </h2>
            <a href="{{ route('admin.rekomendasi_wisata.create') }}" class="bg-blue-500 text-white px-2 py-1 rounded">+ Tambah Rekomendasi Wisata</a>
        </div>
        <table class="min-w-full bg-white rounded shadow">
            <thead>
                <tr>
                    <th class="p-2">No</th>
                    <th class="p-2">Nama Tempat</th>
                    <th class="p-2">Gambar</th>
                    <th class="p-2">Link Sosmed</th>
                    <th class="p-2">Deskripsi</th>
                    <th class="p-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($wisata as $item)
                <tr class="border-t">
                    <td class="p-2">{{ $loop->iteration }}</td>
                    <td class="p-2">{{ $item->nama_tempat }}</td>
                    <td class="p-2">
                        <img src="{{ asset('storage/rekomendasi_wisata/' . $item->gambar) }}" class="w-24 rounded shadow" alt="">
                    </td>
                    <td class="p-2">
                        @if($item->link_sosmed)
                            <a href="{{ $item->link_sosmed }}" target="_blank" class="text-blue-600 underline">Sosmed</a>
                        @endif
                    </td>
                    <td class="p-2">{{ $item->deskripsi }}</td>
                    <td class="p-2 flex gap-2">
                        <a href="{{ route('admin.rekomendasi_wisata.edit', $item->id) }}" class="bg-yellow-400 px-2 py-1 rounded text-white hover:bg-yellow-600">Edit</a>
                        <form method="POST" action="{{ route('admin.rekomendasi_wisata.destroy', $item->id) }}" onsubmit="return confirm('Yakin hapus?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="bg-red-500 px-2 py-1 rounded text-white hover:bg-red-700">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center p-4">Belum ada data</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
