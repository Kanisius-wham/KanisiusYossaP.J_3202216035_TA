@extends('layouts.app')
@section('content')

@if ($errors->any())
<div class="bg-red-100 text-red-700 p-2 rounded mb-3">
    {{ $errors->first() }}
</div>
@endif

<div class="max-w-lg mx-auto bg-white p-6 rounded shadow">
    <form action="{{ route('checkout.proses') }}" method="POST">
        @csrf
        <label>Nama</label>
        <input name="nama" class="border rounded px-2 py-1 w-full mb-2" required>

        <label>Email</label>
        <input name="email" class="border rounded px-2 py-1 w-full mb-2" type="email" required>

        <label>Alamat</label>
        <input name="alamat" class="border rounded px-2 py-1 w-full mb-2" required>

        <label>No Telepon</label>
        <input name="no_telepon" class="border rounded px-2 py-1 w-full mb-2" required>

        <label>Review Pesanan:</label>
        <ul class="list-disc pl-5 mb-2">
            @foreach($cart as $item)
                <li>{{ $item['nama_alat'] }} x {{ $item['jumlah'] }} ({{ number_format($item['harga']) }}/hari)</li>
            @endforeach
        </ul>

        <label class="block mb-4">
    <input type="checkbox" name="agreement" required class="mr-2 align-middle">
    <span class="font-semibold">Saya sudah membaca dan menyetujui syarat & ketentuan di bawah ini:</span>
    <div class="mt-3 bg-gray-100 border rounded p-3 text-sm leading-relaxed text-gray-700">
        <ul class="list-disc pl-6 space-y-1">
            <li>Konsumen wajib meninggalkan kartu identitas (KTP, SIM, atau Kartu Pelajar) sebagai jaminan.</li>
            <li>Segala kerusakan atau kehilangan barang sewaan menjadi tanggung jawab konsumen.</li>  
            <li>Konsumen wajib mengembalikan barang sewaan tepat waktu. Apabila terjadi keterlambatan pengembalian, akan dikenakan denda sebesar 50% dari harga sewa.</li>
        </ul>
    </div>
</label>


        <button class="w-full bg-blue-700 hover:bg-blue-800 text-white rounded py-2 mt-3 font-bold">Proses Checkout</button>
    </form>
    <div class="max-w-6xl mx-auto mt-2">
   <form action="{{ route('checkout.cancel') }}" method="POST">
    @csrf
    <button type="submit" class="w-full px-4 py-2 bg-gray-200 rounded font-bold hover:bg-gray-300 text-gray-800 mt-2">Kembali</button>
</form>


    <div class="mt-3 text-sm">
        <b>Tanggal sewa:</b> {{ $tanggal_sewa }}<br>
        <b>Tanggal kembali:</b> {{ $tanggal_kembali }}
    </div>
</div>
@endsection
