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