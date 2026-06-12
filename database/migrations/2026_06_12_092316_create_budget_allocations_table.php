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
        Schema::create('budget_allocations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('monthly_budget_id');
            $table->unsignedBigInteger('jenis_schedule_id');
            $table->decimal('nominal_limit', 15, 2);
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->foreign('monthly_budget_id')->references('id')->on('monthly_budgets')->onDelete('cascade');
            $table->foreign('jenis_schedule_id')->references('id')->on('jenis_schedules')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budget_allocations');
    }
};
