<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; // Pastikan cuma satu dan bener kayak gini
use Illuminate\Support\Facades\DB;
use App\Models\Pesanan;
use App\Models\Menu;
use App\Models\Vendor;

class PembayaranController extends Controller
{
    public function index() {
        $menus = Menu::all();
        $vendors = Vendor::all();
        return view('pembayaran_index', compact('menus', 'vendors'));
    }

    public function riwayat() {
        $pesanans = Pesanan::orderBy('idpesanan', 'desc')->get();
        return view('riwayat_index', compact('pesanans'));
    }

    public function checkout(Request $request) {
        try {
            // 1. Simpan ke Database
            $pesanan = Pesanan::create([
                'nama_customer' => 'Guest_' . sprintf("%07d", rand(1, 999999)),
                'total' => $request->total_bayar,
                'status_bayar' => 'pending',
            ]);

            // 2. Setting Midtrans
            \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
            \Midtrans\Config::$isProduction = false;
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;

            $params = [
                'transaction_details' => [
                    'order_id' => $pesanan->idpesanan . '-' . time(),
                    'gross_amount' => (int) $request->total_bayar,
                ],
            ];

            // 3. Ambil Token
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            
            // Simpan token ke database biar gak ilang
            $pesanan->update(['snap_token' => $snapToken]);

            return response()->json(['token' => $snapToken]);

        } catch (\Exception $e) {
            // Balikin error asli biar kita tau rusaknya di mana
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function callback(Request $request) {
        $orderId = explode('-', $request->order_id)[0];
        DB::table('pesanans')->where('idpesanan', $orderId)->update([
            'status_bayar' => 'Lunas',
            'metode_bayar' => $request->payment_type ?? 'midtrans'
        ]);
        return response()->json(['status' => 'success']);
    }
    public function cetakStruk($id) {
    $pesanan = Pesanan::find($id);
    return view('pembayaran.struk', compact('pesanan'));
}
}