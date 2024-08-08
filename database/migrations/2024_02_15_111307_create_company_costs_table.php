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
        Schema::create('company_costs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->float('lastmile_cost', 10, 0)->default(0);
            $table->float('food_delivery_cost', 10, 0)->default(0);
            $table->float('warehouse_cost', 10, 0)->default(0);
            $table->float('fulfillment_cost', 10, 0)->default(0);
            $table->float('salla_cost', 10, 0)->default(0);
            $table->float('foodics_cost', 10, 0)->default(0);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_costs');
    }
};
