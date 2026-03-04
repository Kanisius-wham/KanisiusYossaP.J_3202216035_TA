@extends('layouts.app')
@section('content')
<div class="max-w-xl mx-auto bg-white shadow rounded p-6 mt-8">
    <h2 class="text-2xl font-bold mb-2">Struk Penyewaan</h2>
    <div class="mb-4">
        <b>Nama:</b> {{ $penyewaan->pelanggan->nama }} <br>
        <b>Email:</b> {{ $penyewaan->pelanggan->email }} <br>
        <b>No Telp:</b> {{ $penyewaan->pelanggan->no_telepon }} <br>
        <b>Alamat:</b> {{ $penyewaan->pelanggan->alamat }} <br>
        <b>Tanggal Sewa:</b> {{ $penyewaan->tanggal_sewa }} <br>
        <b>Status:</b> {{ ucfirst($penyewaan->status_penyewaan) }}
    </div>
    <div class="mb-4">
        <b>Daftar Alat Disewa:</b>
        <table class="w-full border mb-2 text-sm">
            <thead>
                <tr>
                    <th class="border px-2">Nama Alat</th>
                    <th class="border px-2">Jumlah</th>
                    <th class="border px-2">Hari</th>
                    <th class="border px-2">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @php $grandTotal = 0; @endphp
                @foreach ($penyewaan->detailPenyewaan as $item)
                    @php $grandTotal += $item->subtotal; @endphp
                    <tr>
                        <td class="border px-2">{{ $item->alat->nama_alat }}</td>
                        <td class="border px-2 text-center">{{ $item->jumlah_alat }}</td>
                        <td class="border px-2 text-center">{{ $item->jumlah_hari }}</td>
                        <td class="border px-2 text-right">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" class="text-right px-2">Grand Total</th>
                    <th class="text-right px-2">Rp{{ number_format($grandTotal, 0, ',', '.') }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="flex flex-col items-center gap-3">
        <a href="#" class="w-full text-center px-4 py-2 bg-blue-700 text-white rounded font-bold hover:bg-blue-800">Bayar Sekarang</a>
        <form action="{{ route('nota.cancel', $penyewaan->id_penyewaan) }}" method="POST" class="w-full" onsubmit="return confirm('Batalkan pesanan ini dan kembalikan stok?')">
            @csrf
            <button type="submit" class="w-full px-4 py-2 bg-gray-200 rounded font-bold hover:bg-gray-300 text-gray-800 mt-2">Kembali</button>
        </form>
    </div>
</div>
@endsection
