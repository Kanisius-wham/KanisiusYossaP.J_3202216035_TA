<?php

namespace App\Http\Controllers;

use App\Models\Penyewaan;

class NotaController extends Controller
{
    public function show($id)
    {
        $penyewaan = Penyewaan::with(['pelanggan', 'detailPenyewaan.alat'])->findOrFail($id);

        return view('nota.show', compact('penyewaan'));
    }
    
    public function cancelNota($id)
{
    // Temukan penyewaan & detail
    $penyewaan = \App\Models\Penyewaan::findOrFail($id);
    $details = $penyewaan->detailPenyewaan; // pastikan relasi sudah dibuat

    foreach ($details as $detail) {
        $alat = \App\Models\Alat::find($detail->id_alat);
        if ($alat) {
            $alat->increment('stok', $detail->jumlah_alat);
        }
    }

    // Ubah status penyewaan jadi batal/canceled
    $penyewaan->update(['status_penyewaan' => 'canceled']);

    // Kosongkan keranjang di browser (optional, jika ada session)
    session()->forget(['cart', 'durasi']);

    return redirect()->route('kategori')->with('msg', 'Penyewaan dibatalkan, stok sudah dikembalikan.');
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
public function cancel($id)
{
    $penyewaan = \App\Models\Penyewaan::findOrFail($id);

    // Ambil semua detail penyewaan untuk balikin stok
    foreach ($penyewaan->detailPenyewaan as $detail) {
        $alat = \App\Models\Alat::find($detail->id_alat);
        if ($alat) {
            $alat->increment('stok', $detail->jumlah_alat);
        }
    }

    // Hapus detail penyewaan
    $penyewaan->detailPenyewaan()->delete();
    // Hapus penyewaan (bisa juga softDelete jika butuh histori)
    $penyewaan->delete();

    // Keranjang tetap kosong, karena session sudah dibersihkan pada checkout

    return redirect()->route('kategori')->with('msg', 'Pesanan dibatalkan dan stok telah dikembalikan.');
}

}

