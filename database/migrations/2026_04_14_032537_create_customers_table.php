<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id('id_customer'); // Primary Key
            $table->string('nama', 100);
            $table->text('alamat')->nullable();
            $table->string('foto')->nullable(); // Untuk simpan nama file/path foto dari webcam
            // Kalau mau simpan BLOB (data gambar langsung di DB), pakai ini:
            // $table->binary('foto_blob')->nullable(); 
            $table->timestamps(); // Ini bakal bikin created_at & updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};