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
        Schema::table('user_statuses', function (Blueprint $table) {
            $table->unsignedBigInteger('restocking_order_quantity_to_stock')->nullable();
            $table->foreign('restocking_order_quantity_to_stock')->references('id')->on('statuses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_statuses', function (Blueprint $table) {
            $table->dropColumn(['restocking_order_quantity_to_stock']);

        });
    }
};
