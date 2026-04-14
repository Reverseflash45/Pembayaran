<?php

namespace App\Http\Controllers; // <--- INI HARUS ADA DAN BENER

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    // Submenu 2: Data Customer
    public function index() {
        $customers = DB::table('customers')->orderBy('id_customer', 'desc')->get();
        return view('customer.index', compact('customers'));
    }

    // Submenu 3: Tambah Blob
    public function create1() { 
        return view('customer.create_blob'); 
    }

    // Submenu 4: Tambah Path
    public function create2() { 
        return view('customer.create_path'); 
    }

    // Proses Simpan Blob
    public function store1(Request $request) {
        $image_base64 = base64_decode(explode(";base64,", $request->image)[1]);
        DB::table('customers')->insert([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'foto_blob' => $image_base64,
            'created_at' => now()
        ]);
        return response()->json(['success' => 'Berhasil simpan BLOB!']);
    }

    // Proses Simpan Path
    public function store2(Request $request) {
        $image_base64 = base64_decode(explode(";base64,", $request->image)[1]);
        $fileName = uniqid() . '.png';
        Storage::put("public/customers/" . $fileName, $image_base64);

        DB::table('customers')->insert([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'foto' => $fileName,
            'created_at' => now()
        ]);
        return response()->json(['success' => 'Berhasil simpan PATH!']);
    }
}