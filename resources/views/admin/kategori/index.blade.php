@extends('layouts.admin')

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
    <!-- Konten Utama -->
    <main class="flex-1 p-8 bg-gray-50">
        <h1 class="text-2xl font-bold mb-4">Manajemen Kategori</h1>
        {{-- Form Tambah Kategori --}}
        <form action="{{ route('admin.kategori.store') }}" method="POST" class="mb-6 flex gap-2">
            @csrf
            <input name="nama_kategori" required class="border rounded px-2 py-1" placeholder="Nama kategori">
            <button class="bg-blue-600 text-white rounded px-4 py-1">Tambah</button>
        </form>
        {{-- Tabel Kategori --}}
        <div class="bg-white rounded-lg shadow overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="px-4 py-2">No.</th>
                        <th class="px-4 py-2">Nama Kategori</th>
                        <th class="px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($kategoris as $kategori)
                    <tr>
                        <td class="px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2">
                            <form action="{{ route('admin.kategori.update', $kategori->id_kategori) }}" method="POST" class="flex gap-2">
                                @csrf
                                @method('PUT')
                                <input name="nama_kategori" value="{{ $kategori->nama_kategori }}" class="border rounded px-2 py-1">
                                <button class="bg-yellow-400 rounded px-2 py-1">Update</button>
                            </form>
                        </td>
                        <td class="px-4 py-2">
                            <form action="{{ route('admin.kategori.destroy', $kategori->id_kategori) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-600 text-white rounded px-2 py-1">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    @if($kategoris->isEmpty())
                    <tr>
                        <td colspan="3" class="px-4 py-6 text-center text-gray-400">Belum ada kategori</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </main>
</div>
@endsection
