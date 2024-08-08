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
        Schema::table('orders_rules', function (Blueprint $table) {
            $table->integer('type')->nullable()->default(1);
            $table->integer('address_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders_rules', function (Blueprint $table) {
            $table->dropColumn(['type', 'address_id']);

        });
    }
};
