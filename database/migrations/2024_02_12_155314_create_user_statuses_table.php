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
        Schema::create('user_statuses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // Foreign key references the default status
            $table->unsignedBigInteger('default_status_id')->nullable();
            $table->foreign('default_status_id')->references('id')->on('statuses')->onDelete('cascade');

            // Foreign key references the available edit status
            $table->unsignedBigInteger('available_edit_status')->nullable();
            $table->foreign('available_edit_status')->references('id')->on('statuses')->onDelete('cascade');

            // Foreign key references the available delete status
            $table->unsignedBigInteger('available_delete_status')->nullable();
            $table->foreign('available_delete_status')->references('id')->on('statuses')->onDelete('cascade');

            // Foreign key references the available collect order status
            $table->unsignedBigInteger('available_collect_order_status')->nullable();
            $table->foreign('available_collect_order_status')->references('id')->on('statuses')->onDelete('cascade');

            // Foreign key references the available overweight status
            $table->unsignedBigInteger('available_overweight_status')->nullable();
            $table->foreign('available_overweight_status')->references('id')->on('statuses')->onDelete('cascade');

            // Foreign key references the available overweight status outside
            $table->unsignedBigInteger('available_overweight_status_outside')->nullable();
            $table->foreign('available_overweight_status_outside')->references('id')->on('statuses')->onDelete('cascade');

            // Foreign key references the calculation cash on delivery status
            $table->unsignedBigInteger('calc_cash_on_delivery_status_id')->nullable();
            $table->foreign('calc_cash_on_delivery_status_id')->references('id')->on('statuses')->onDelete('cascade');

            // Foreign key references the cost calculation status outside
            $table->unsignedBigInteger('cost_calc_status_id_outside')->nullable();
            $table->foreign('cost_calc_status_id_outside')->references('id')->on('statuses')->onDelete('cascade');

            // Foreign key references the cost calculation status
            $table->unsignedBigInteger('cost_calc_status_id')->nullable();
            $table->foreign('cost_calc_status_id')->references('id')->on('statuses')->onDelete('cascade');

            // Foreign key references the cost reshipping calculation status
            $table->unsignedBigInteger('cost_reshipping_calc_status_id');
            $table->foreign('cost_reshipping_calc_status_id')->references('id')->on('statuses')->onDelete('cascade');

            // Foreign key references the receive palette status
            $table->unsignedBigInteger('receive_palette_status_id')->nullable();
            $table->foreign('receive_palette_status_id')->references('id')->on('statuses')->onDelete('cascade');

            // Foreign key references the store palette status
            $table->unsignedBigInteger('store_palette_status_id')->nullable();
            $table->foreign('store_palette_status_id')->references('id')->on('statuses')->onDelete('cascade');

            // Foreign key references the sort by SKUs status
            $table->unsignedBigInteger('sort_by_skus_status_id')->nullable();
            $table->foreign('sort_by_skus_status_id')->references('id')->on('statuses')->onDelete('cascade');

            // Foreign key references the pick process package status
            $table->unsignedBigInteger('pick_process_package_status_id')->nullable();
            $table->foreign('pick_process_package_status_id')->references('id')->on('statuses')->onDelete('cascade');

            // Foreign key references the print waybill status
            $table->unsignedBigInteger('print_waybill_status_id')->nullable();
            $table->foreign('print_waybill_status_id')->references('id')->on('statuses')->onDelete('cascade');

            // Foreign key references the sort by city status
            $table->unsignedBigInteger('sort_by_city_status_id')->nullable();
            $table->foreign('sort_by_city_status_id')->references('id')->on('statuses')->onDelete('cascade');

            // Foreign key references the store return shipment status
            $table->unsignedBigInteger('store_return_shipment_status_id')->nullable();
            $table->foreign('store_return_shipment_status_id')->references('id')->on('statuses')->onDelete('cascade');

            // Foreign key references the reprocess return shipment status
            $table->unsignedBigInteger('reprocess_return_shipment_status_id')->nullable();
            $table->foreign('reprocess_return_shipment_status_id')->references('id')->on('statuses')->onDelete('cascade');

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_statuses');
    }
};
