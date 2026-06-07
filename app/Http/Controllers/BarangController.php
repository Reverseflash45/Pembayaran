<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Picqer\Barcode\BarcodeGeneratorPNG;

class BarangController extends Controller
{
    public function cetakLabel(Request $request)
    {
        // Ambil data dari form
        $ids = $request->input('ids', []); 
        $startX = $request->input('x', 1);
        $startY = $request->input('y', 1);

        // Query ke tabel menus (sesuai DB lu)
        $barangs = DB::table('menus')->whereIn('idmenu', $ids)->get();

        // Hitung kotak yang dilewati
        $skip = (($startY - 1) * 5) + ($startX - 1);

        return view('barang.pdf_label', compact('barangs', 'skip'));
    }
    public function getScannedData($id)
{
    // Ingat, kita pake tabel menus dan idmenu sesuai database lu
    $barang = DB::table('menus')->where('idmenu', $id)->first();

    if ($barang) {
        return response()->json(['success' => true, 'data' => $barang]);
    } else {
        return response()->json(['success' => false, 'message' => 'Barang tidak ditemukan!']);
    }
}
}

