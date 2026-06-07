<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\PembayaranController;

// Halaman Utama
Route::get('/', [PembayaranController::class, 'index'])->name('home');

// Halaman Riwayat
Route::get('/riwayat', [PembayaranController::class, 'riwayat'])->name('riwayat');

// PROSES CHECKOUT (TAMBAHKAN NAME DI SINI)
Route::post('/checkout', [PembayaranController::class, 'checkout'])->name('checkout');

// CALLBACK MIDTRANS (Yang tadi kita buat)
Route::post('/notification-manual', function (Request $request) {
    $orderIdRaw = $request->input('order_id');
    $idAsli = explode('-', $orderIdRaw)[0];

    DB::table('pesanans')->where('idpesanan', $idAsli)->update([
        'status_bayar' => 'Lunas',
        'metode_bayar' => $request->input('payment_type') ?? 'midtrans'
    ]);

    return response()->json(['message' => 'DB UPDATED']);
});

use App\Http\Controllers\CustomerController; // <--- TARUH DI PALING ATAS WEB.PHP

Route::get('/customer', [CustomerController::class, 'index'])->name('customer.index');
Route::get('/customer/create1', [CustomerController::class, 'create1'])->name('customer.create1');
Route::get('/customer/create2', [CustomerController::class, 'create2'])->name('customer.create2');
Route::post('/customer/store1', [CustomerController::class, 'store1'])->name('customer.store1');
Route::post('/customer/store2', [CustomerController::class, 'store2'])->name('customer.store2');

Route::post('/notification-manual', function (Request $request) {
    $orderIdRaw = $request->input('order_id');
    $idAsli = explode('-', $orderIdRaw)[0];

    DB::table('pesanans')->where('idpesanan', $idAsli)->update([
        'status_bayar' => 'Lunas',
        'metode_bayar' => $request->input('payment_type') ?? 'midtrans'
    ]);

    return response()->json(['message' => 'DB UPDATED']);
});

use App\Http\Controllers\BarangController;

Route::post('/barang/cetak', [BarangController::class, 'cetakLabel'])->name('barang.cetak');

Route::get('/barang', function() {
    // Kalo di database nama tabelnya 'menus', pake 'menus'
    $barangs = DB::table('menus')->get(); 
    return view('barang.index', compact('barangs'));
})->name('barang.index');

// Route buat nampilin halaman scanner
Route::get('/scan-barcode', function () {
    return view('barang.scan');
})->name('scan.barcode');

// Route buat ngambil data barang via AJAX pas discan
Route::get('/scan-barcode/get/{id}', [App\Http\Controllers\BarangController::class, 'getScannedData']);

use App\Http\Controllers\TokoController;

Route::get('/toko', [TokoController::class, 'index'])->name('toko.index');
Route::post('/toko', [TokoController::class, 'store'])->name('toko.store');

use App\Http\Controllers\AntrianController;

Route::get('/antrian/guest', [AntrianController::class, 'guest'])->name('antrian.guest');
Route::post('/antrian/guest', [AntrianController::class, 'guestStore'])->name('antrian.guest.store');
Route::get('/antrian/admin', [AntrianController::class, 'admin'])->name('antrian.admin');
Route::post('/antrian/panggil/{id}', [AntrianController::class, 'panggil'])->name('antrian.panggil');
Route::get('/antrian/papan', [AntrianController::class, 'papan'])->name('antrian.papan');
Route::get('/sse/antrian', [AntrianController::class, 'stream'])->name('sse.antrian');