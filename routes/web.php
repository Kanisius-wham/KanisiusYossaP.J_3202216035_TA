<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\AuthCustomController;
use App\Http\Controllers\Admin\AlatController;
use App\Http\Controllers\Admin\AdminKategoriController;
use App\Http\Controllers\Admin\GaleriPendakianController;
use App\Http\Controllers\Admin\RekomendasiWisataController;
use App\Http\Controllers\Admin\GaleriBerandaController;

Route::prefix('admin')->group(function() {
    //CRUD Alat
    Route::get('alat', [AlatController::class, 'index'])->name('admin.alat.index');
    Route::get('alat/create', [AlatController::class, 'create'])->name('admin.alat.create');
    Route::post('alat', [AlatController::class, 'store'])->name('admin.alat.store');
    Route::get('alat/{id}/edit', [AlatController::class, 'edit'])->name('admin.alat.edit');
    Route::put('alat/{id}', [AlatController::class, 'update'])->name('admin.alat.update');
    Route::delete('alat/{id}', [AlatController::class, 'destroy'])->name('admin.alat.destroy');

    //CRUD kategori
    Route::get('kategori', [AdminKategoriController::class, 'index'])->name('admin.kategori.index');
    Route::post('kategori', [AdminKategoriController::class, 'store'])->name('admin.kategori.store');
    Route::put('kategori/{id}', [AdminKategoriController::class, 'update'])->name('admin.kategori.update');
    Route::delete('kategori/{id}', [AdminKategoriController::class, 'destroy'])->name('admin.kategori.destroy');

    // CRUD Galeri Pendakian
    Route::get('galeri_pendakian', [GaleriPendakianController::class, 'index'])->name('admin.galeri_pendakian.index');
    Route::get('galeri_pendakian/create', [GaleriPendakianController::class, 'create'])->name('admin.galeri_pendakian.create');
    Route::post('galeri_pendakian', [GaleriPendakianController::class, 'store'])->name('admin.galeri_pendakian.store');
    Route::get('galeri_pendakian/{id}/edit', [GaleriPendakianController::class, 'edit'])->name('admin.galeri_pendakian.edit');
    Route::put('galeri_pendakian/{id}', [GaleriPendakianController::class, 'update'])->name('admin.galeri_pendakian.update');
    Route::delete('galeri_pendakian/{id}', [GaleriPendakianController::class, 'destroy'])->name('admin.galeri_pendakian.destroy');

    // CRUD Rekomendasi Wisata
    Route::get('rekomendasi_wisata', [RekomendasiWisataController::class, 'index'])->name('admin.rekomendasi_wisata.index');
    Route::get('rekomendasi_wisata/create', [RekomendasiWisataController::class, 'create'])->name('admin.rekomendasi_wisata.create');
    Route::post('rekomendasi_wisata', [RekomendasiWisataController::class, 'store'])->name('admin.rekomendasi_wisata.store');
    Route::get('rekomendasi_wisata/{id}/edit', [RekomendasiWisataController::class, 'edit'])->name('admin.rekomendasi_wisata.edit');
    Route::put('rekomendasi_wisata/{id}', [RekomendasiWisataController::class, 'update'])->name('admin.rekomendasi_wisata.update');
    Route::delete('rekomendasi_wisata/{id}', [RekomendasiWisataController::class, 'destroy'])->name('admin.rekomendasi_wisata.destroy');

    // Galeri Beranda
    Route::get('galeri_beranda', [GaleriBerandaController::class, 'index'])->name('admin.galeri_beranda.index');
});


// Form login
Route::get('/login', [AuthCustomController::class, 'showLoginForm'])->name('login');
// Proses login
Route::post('/login', [AuthCustomController::class, 'login'])->name('login.custom');

Route::get('/dashboard', [AuthCustomController::class, 'dashboard'])->name('dashboard');
// Logout
Route::post('/logout', [AuthCustomController::class, 'logout'])->name('logout');

Route::get('/kategori/{id_kategori?}', [KategoriController::class, 'index'])->name('kategori');


Route::get('/dashboard', function () {
    return redirect()->route('admin.alat.index');
})->name('dashboard');

//dummy page kategori
Route::get('/sewa/{id_alat}', function($id_alat) {
    
    return "Halaman form sewa alat dengan ID: " . $id_alat;
})->name('alat.sewa');
//dummy page kategori

// Menampilkan form sewa
Route::get('/sewa/{id_alat}', [\App\Http\Controllers\SewaController::class, 'form'])->name('alat.sewa');
// Memproses form sewa
Route::post('/sewa/{id_alat}', [\App\Http\Controllers\SewaController::class, 'proses'])->name('alat.sewa.proses');


// POST dari sidebar keranjang
Route::post('/checkout/save-cart', function(\Illuminate\Http\Request $request) {
    $cart = json_decode($request->cart, true) ?? [];
    $durasi = intval($request->durasi) ?: 1;
    session(['cart' => $cart, 'durasi' => $durasi]);
    return redirect()->route('checkout.form');
})->name('checkout.saveCart');

// Form checkout
Route::get('/checkout', [\App\Http\Controllers\CheckoutController::class, 'form'])->name('checkout.form');
// Proses checkout
Route::post('/checkout', [\App\Http\Controllers\CheckoutController::class, 'proses'])->name('checkout.proses');

//nota
Route::get('/nota/{id}', [\App\Http\Controllers\NotaController::class, 'show'])->name('nota.show');

// Cancel checkout, restore stok
Route::post('/checkout/cancel', [\App\Http\Controllers\CheckoutController::class, 'cancel'])->name('checkout.cancel');

// cancel nota
Route::post('/nota/{id}/cancel', [\App\Http\Controllers\NotaController::class, 'cancel'])->name('nota.cancel');




Route::get('/', [BerandaController::class, 'index'])->name('beranda');




//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');

//Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
//});

//require __DIR__.'/auth.php';
