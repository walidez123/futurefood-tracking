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
        Schema::create('user_costs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            // city
            $table->float('cost_inside_city', 10, 0)->nullable();
            $table->float('cost_outside_city', 10, 0)->nullable();
            $table->float('cost_reshipping', 10, 0)->nullable();
            $table->float('cost_reshipping_out_city', 10, 0)->nullable();
            $table->float('fees_cash_on_delivery', 10, 0)->nullable();
            $table->float('fees_cash_on_delivery_out_city', 10, 0)->nullable();
            $table->float('pickup_fees', 10, 0)->nullable();
            $table->float('over_weight_per_kilo', 10, 0)->nullable();
            $table->float('over_weight_per_kilo_outside', 10, 0)->nullable();
            $table->float('standard_weight', 10, 0)->nullable();
            $table->float('standard_weight_outside', 10, 0)->nullable();
            // fulfillment
            $table->float('receive_palette', 10, 0)->nullable();
            $table->enum('pallet_subscription_type',['daily','monthly'])->nullable();
            $table->float('store_palette', 10, 0)->nullable();
            $table->float('sort_by_suku', 10, 0)->nullable();
            $table->float('pick_process_package', 10, 0)->nullable();
            $table->float('print_waybill', 10, 0)->nullable();
            $table->float('sort_by_city', 10, 0)->nullable();
            $table->float('store_return_shipment', 10, 0)->nullable();
            $table->float('reprocess_return_shipment', 10, 0)->nullable();
            // resturant
            $table->float('kilos_number', 10, 0)->nullable();
            $table->float('additional_kilo_price', 10, 0)->nullable();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_costs');
    }
};
