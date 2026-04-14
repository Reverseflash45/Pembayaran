<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PembayaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
public function run(): void
{
    // Masukkan Vendor/Toko
    $idToko = DB::table('vendors')->insertGetId([
        'nama_vendor' => 'Toko Serba Ada',
        'created_at' => now(),
    ]);

    // Masukkan Menu/Produk
    DB::table('menus')->insert([
        [
            'nama_menu' => 'Produk Digital A',
            'harga' => 50000,
            'idvendor' => $idToko,
            'created_at' => now(),
        ],
        [
            'nama_menu' => 'Produk Digital B',
            'harga' => 75000,
            'idvendor' => $idToko,
            'created_at' => now(),
        ],
    ]);
}
}
