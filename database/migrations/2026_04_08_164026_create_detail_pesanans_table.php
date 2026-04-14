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
    Schema::create('detail_pesanans', function (Blueprint $table) {
        $table->id('iddetail_pesanan');
        $table->unsignedBigInteger('idpesanan');
        $table->unsignedBigInteger('idmenu');
        $table->integer('jumlah'); // Beli berapa porsi?
        $table->integer('subtotal'); // harga menu x jumlah
        $table->string('catatan')->nullable(); // Misal: "Gak pakai sambal"
        
        // Relasi ke tabel pesanan dan menu
        $table->foreign('idpesanan')->references('idpesanan')->on('pesanans')->onDelete('cascade');
        $table->foreign('idmenu')->references('idmenu')->on('menus');
        
        $table->timestamps();
    });
}
    public function down(): void
    {
        Schema::dropIfExists('detail_pesanans');
    }
};
