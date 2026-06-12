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
        Schema::create('monthly_budgets', function (Blueprint $table) {
            $table->id();
            $table->string('periode'); // Format: Y-m (e.g. 2026-05)
            $table->decimal('total_kas', 15, 2); // Saldo kas saat pembuatan budget
            $table->decimal('alokasi_anggaran', 15, 2); // Batas anggaran yang ditarik untuk bulan tersebut
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monthly_budgets');
    }
};
