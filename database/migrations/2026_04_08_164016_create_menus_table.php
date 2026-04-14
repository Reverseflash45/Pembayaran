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
    Schema::create('menus', function (Blueprint $table) {
        $table->id('idmenu');
        $table->string('nama_menu');
        $table->integer('harga');
        $table->string('path_gambar')->nullable(); // nullable artinya boleh kosong (misal belum ada foto)
        
        // Menghubungkan ke tabel vendors
        $table->unsignedBigInteger('idvendor'); 
        $table->foreign('idvendor')->references('idvendor')->on('vendors')->onDelete('cascade');
        
        $table->timestamps();
    });
}
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
