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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nomor_whatsapp');
            $table->string('email')->nullable();
            $table->text('catatan')->nullable();
            $table->date('dari_tanggal');
            $table->boolean('status_aktif')->default(true);
            $table->unsignedBigInteger('jenis_barang_id');
            $table->foreign('jenis_barang_id')->references('id')->on('jenis_barangs')->onDelete('cascade');
            $table->timestamps();



            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
