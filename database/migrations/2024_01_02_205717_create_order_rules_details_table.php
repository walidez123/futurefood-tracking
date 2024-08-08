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
        Schema::create('order_rules_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_rules_id')->constrained('orders_rules');
            $table->integer('cod')->nullable();
            $table->foreignId('client_id')->nullable()->constrained();
            $table->foreignId('city_from')->nullable()->constrained();
            $table->foreignId('city_to')->nullable()->constrained();
            $table->foreignId('region_from')->nullable()->constrained();
            $table->foreignId('region_to')->nullable()->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_rules_details');
    }
};
