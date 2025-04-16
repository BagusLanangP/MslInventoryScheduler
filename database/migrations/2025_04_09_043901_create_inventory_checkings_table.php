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
        Schema::create('inventory_checkings', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->unsignedBigInteger('jenis_barang_id');
            $table->foreign('jenis_barang_id')->references('id')->on('jenis_barangs')->onDelete('cascade');
            $table->unsignedBigInteger('supplier_id');
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
            $table->date('tanggal');
            $table->date('expired_date')->nullable();
            $table->integer('jumlah');
            $table->integer('harga');
            $table->integer('total_harga');
            $table->string('satuan');
            $table->string('keterangan')->nullable();
            $table->string('status')->default('belum_diproses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_checkings');
    }
};
