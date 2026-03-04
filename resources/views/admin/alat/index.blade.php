@extends('layouts.admin')

@section('content')
<div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-blue-900 text-white flex flex-col py-8 px-4">
        <div class="mb-8">
            <img src="{{ asset('images/logosenentang.png') }}" class="h-10 mx-auto mb-2">
            <h1 class="text-lg font-bold text-center">Admin</h1>
        </div>
        <nav class="flex-1 flex flex-col space-y-4">
            <a href="#" class="hover:bg-blue-800 rounded px-3 py-2">Dashboard</a>
            <a href="{{ route('admin.alat.index') }}" class="hover:bg-blue-800 rounded px-3 py-2 bg-blue-800">Alat</a>
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
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Daftar Alat</h2>
            <a href="{{ route('admin.alat.create') }}"
   class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded font-semibold shadow">
   + Tambah Alat
</a>
        </div>
        <div class="bg-white rounded-lg shadow overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-blue-100">
                    
                    <tr>
                        <th class="px-4 py-2">No.</th>
                        <th class="px-4 py-2">Nama Alat</th>
                        <th class="px-4 py-2">Kategori</th>
                        <th class="px-4 py-2">Harga/Hari</th>
                        <th class="px-4 py-2">Stok</th>
                        <th class="px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($alats as $alat)
                    <tr>
                        <td class="px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2">{{ $alat->nama_alat }}</td>
                        <td class="px-4 py-2">{{ $alat->kategori->nama_kategori ?? '-' }}</td>
                        <td class="px-4 py-2">Rp{{ number_format($alat->harga_sewa_per_hari, 0, ',', '.') }}</td>
                        <td class="px-4 py-2">{{ $alat->stok }}</td>
                        <td class="px-4 py-2"><td class="px-4 py-2 flex space-x-2">
    <a href="{{ route('admin.alat.edit', $alat->id_alat) }}"
       class="text-blue-600 hover:underline font-semibold">Edit</a>
    <form action="{{ route('admin.alat.destroy', $alat->id_alat) }}"
          method="POST"
          onsubmit="return confirm('Yakin hapus alat ini?')" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="text-red-600 hover:underline font-semibold">Hapus</button>
    </form>
</td>
</td>
                    </tr>
                    @endforeach
                    @if($alats->isEmpty())
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-gray-400">Belum ada data alat</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </main>
</div>
@endsection
