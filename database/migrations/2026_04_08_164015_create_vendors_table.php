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
    Schema::create('vendors', function (Blueprint $table) {
        // idvendor adalah Primary Key. Kita gunakan id() tapi kita beri nama khusus
        $table->id('idvendor'); 
        $table->string('nama_vendor'); // Nama toko/kantin
        $table->timestamps(); // Menambahkan kolom created_at & updated_at otomatis
    });
}
    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};
