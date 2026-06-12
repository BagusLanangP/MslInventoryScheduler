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
        Schema::table('inventory_checkings', function (Blueprint $table) {
            $table->string('sku')->nullable()->unique()->after('id');
            $table->integer('min_stock')->default(10)->after('jumlah');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventory_checkings', function (Blueprint $table) {
            $table->dropColumn(['sku', 'min_stock']);
        });
    }
};
