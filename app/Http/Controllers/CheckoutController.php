<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penyewaan;
use App\Models\Pelanggan;
use App\Models\Alat;
use App\Models\DetailPenyewaan;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function form(Request $request)
    {
        // Ambil cart & durasi dari session
        $cart = session('cart', []);
        $durasi = session('durasi', 1);

        if (empty($cart)) {
            return redirect()->route('kategori')->with('msg', 'Keranjang kosong.');
        }

        $tanggal_sewa = now()->toDateString();
        $tanggal_kembali = now()->addDays($durasi)->toDateString();

        return view('checkout.form', compact('cart', 'durasi', 'tanggal_sewa', 'tanggal_kembali'));
    }

    public function proses(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email',
            'alamat' => 'required|string|max:255',
            'no_telepon' => 'required|string|max:30',
            'agreement' => 'accepted',
        ]);

        $cart = session('cart', []);
        $durasi = session('durasi', 1);

        if (empty($cart)) {
            return redirect()->route('kategori')->with('msg', 'Keranjang kosong.');
        }
        $tanggal_sewa = now();

        DB::beginTransaction();
        try {
            // 1. Pastikan stok alat cukup
            foreach ($cart as $item) {
                $alat = Alat::find($item['id_alat']);
                if (!$alat || $alat->stok < $item['jumlah']) {
                    DB::rollBack();
                    return back()->withErrors(['msg' => "Stok untuk {$item['nama_alat']} tidak cukup, silakan periksa kembali."]);
                }
            }

            // 2. Simpan/Update pelanggan
            $pelanggan = Pelanggan::where('email', $request->email)->first();
            if ($pelanggan) {
                $pelanggan->update([
                    'nama' => $request->nama,
                    'alamat' => $request->alamat,
                    'no_telepon' => $request->no_telepon,
                ]);
            } else {
                $pelanggan = Pelanggan::create([
                    'email' => $request->email,
                    'nama' => $request->nama,
                    'alamat' => $request->alamat,
                    'no_telepon' => $request->no_telepon,
                ]);
            }

            // 3. Buat penyewaan baru (id_admin NULL, karena user bukan admin)
            $penyewaan = Penyewaan::create([
                'id_pelanggan' => $pelanggan->id_pelanggan,
                'id_admin' => null,
                'tanggal_sewa' => $tanggal_sewa,
                'status_penyewaan' => 'pending',
            ]);

            // 4. Simpan detail penyewaan & update stok alat
            foreach ($cart as $item) {
                DetailPenyewaan::create([
                    'id_penyewaan'   => $penyewaan->id_penyewaan,
                    'id_alat'        => $item['id_alat'],
                    'jumlah_alat'    => $item['jumlah'],          
                    'jumlah_hari'    => $durasi,                   
                    'subtotal'       => $item['jumlah'] * $item['harga'] * $durasi,
                ]);
                $alat = Alat::find($item['id_alat']);
                $alat->decrement('stok', $item['jumlah']);
            }

            DB::commit();

            // Kosongkan session setelah transaksi sukses
            session()->forget(['cart', 'durasi']);

            // Redirect ke halaman nota
            return redirect()->route('nota.show', $penyewaan->id_penyewaan);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['msg' => 'Transaksi gagal: ' . $e->getMessage()]);
        }
    }

    // reset stok
    public function cancel(Request $request)
{

    session()->forget(['cart', 'durasi']);
    return redirect()->route('kategori')->with('msg', 'Checkout dibatalkan.');
}


}
