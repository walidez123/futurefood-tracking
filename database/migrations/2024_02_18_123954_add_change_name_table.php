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
        Schema::table('pickup_orders', function (Blueprint $table) {
            $table->renameColumn('store_branch_id', 'store_address_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pickup_orders', function (Blueprint $table) {
            $table->renameColumn('store_branch_id', 'store_address_id');

        });
    }
};
