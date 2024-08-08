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
        Schema::table('user_costs', function (Blueprint $table) {
            $table->float('pallet_in', 10, 0)->nullable();
            $table->float('pallet_out', 10, 0)->nullable();
            $table->float('packging_pallet', 10, 0)->nullable();
            $table->float('segregation_pallet', 10, 0)->nullable();
            $table->float('palletization', 10, 0)->nullable();
            $table->float('wooden_pallet', 10, 0)->nullable();
            $table->float('return_pallet', 10, 0)->nullable();
            $table->float('pallet_shipping', 10, 0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_costs', function (Blueprint $table) {
            $table->dropColumn(['pallet_shipping','return_pallet','wooden_pallet','palletization','segregation_pallet','packging_pallet','pallet_out','pallet_in']);

            
        });
    }
};
