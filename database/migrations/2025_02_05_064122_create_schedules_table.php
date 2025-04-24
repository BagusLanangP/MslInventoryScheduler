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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('berulang')->default(false);
            $table->string('note')->nullable();
            $table->date('date'); // Tanggal hari libur
            $table->decimal('budget', 15, 2)->nullable();
            $table->date('reminder_date'); // Tanggal pengingat
            $table->boolean('status')->default(false); // false berarti belum selesai
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
