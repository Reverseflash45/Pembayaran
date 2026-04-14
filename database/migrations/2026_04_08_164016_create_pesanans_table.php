<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up(): void
{
    Schema::create('pesanans', function (Blueprint $table) {
        $table->id('idpesanan');
        $table->string('nama_customer'); // Tempat menyimpan nama "Guest_0000001"
        $table->timestamp('timestamp')->useCurrent(); // Waktu order otomatis terisi
        $table->integer('total'); // Total harga yang harus dibayar
        $table->string('metode_bayar')->nullable(); // QRIS / Virtual Account
        
        // Status bayar kita gunakan string agar mudah dibaca: 'pending', 'lunas', 'expired'
        $table->string('status_bayar')->default('pending'); 
        
        // snap_token didapat dari Midtrans untuk memunculkan popup pembayaran
        $table->string('snap_token')->nullable(); 
        
        $table->timestamps();
    });
}
    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};
