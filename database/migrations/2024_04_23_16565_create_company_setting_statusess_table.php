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
        Schema::create('company_setting_statuses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('status_pickup')->nullable();
            $table->foreign('status_pickup')->references('id')->on('statuses')->onDelete('cascade');

            $table->unsignedBigInteger('status_pickup_res')->nullable();
            $table->foreign('status_pickup_res')->references('id')->on('statuses')->onDelete('cascade');

            $table->unsignedBigInteger('status_return_shop')->nullable();
            $table->foreign('status_return_shop')->references('id')->on('statuses')->onDelete('cascade');

            $table->unsignedBigInteger('status_return_res')->nullable();
            $table->foreign('status_return_res')->references('id')->on('statuses')->onDelete('cascade');

            $table->unsignedBigInteger('status_can_return_shop')->nullable();
            $table->foreign('status_can_return_shop')->references('id')->on('statuses')->onDelete('cascade');

            $table->unsignedBigInteger('status_can_return_res')->nullable();
            $table->foreign('status_can_return_res')->references('id')->on('statuses')->onDelete('cascade');

            $table->unsignedBigInteger('status_shop')->nullable();
            $table->foreign('status_shop')->references('id')->on('statuses')->onDelete('cascade');

            $table->unsignedBigInteger('status_res')->nullable();
            $table->foreign('status_res')->references('id')->on('statuses')->onDelete('cascade');

            // 
            $table->unsignedBigInteger('cost_calc_status_Res')->nullable();
            $table->foreign('cost_calc_status_Res')->references('id')->on('statuses')->onDelete('cascade');

            $table->unsignedBigInteger('default_status_id_Res')->nullable();
            $table->foreign('default_status_id_Res')->references('id')->on('statuses')->onDelete('cascade');

            $table->unsignedBigInteger('calc_cash_delivery_status_Res')->nullable();
            $table->foreign('calc_cash_delivery_status_Res')->references('id')->on('statuses')->onDelete('cascade');

            $table->unsignedBigInteger('cost_reshipping_status_Res')->nullable();
            $table->foreign('cost_reshipping_status_Res')->references('id')->on('statuses')->onDelete('cascade');

            $table->unsignedBigInteger('cost_calc_status_inside_city')->nullable();
            $table->foreign('cost_calc_status_inside_city')->references('id')->on('statuses')->onDelete('cascade');

            $table->unsignedBigInteger('cost_calc_status_outside_city')->nullable();
            $table->foreign('cost_calc_status_outside_city')->references('id')->on('statuses')->onDelete('cascade');

            $table->unsignedBigInteger('default_status_id_store')->nullable();
            $table->foreign('default_status_id_store')->references('id')->on('statuses')->onDelete('cascade');


            $table->unsignedBigInteger('cost_reshipping_status_store')->nullable();
            $table->foreign('cost_reshipping_status_store')->references('id')->on('statuses')->onDelete('cascade');
            
            $table->unsignedBigInteger('edit_status_id_store')->nullable();
            $table->foreign('edit_status_id_store')->references('id')->on('statuses')->onDelete('cascade');

            $table->unsignedBigInteger('delete_status_id_store')->nullable();
            $table->foreign('delete_status_id_store')->references('id')->on('statuses')->onDelete('cascade');

            $table->unsignedBigInteger('overweight_status_inside_city')->nullable();
            $table->foreign('overweight_status_inside_city')->references('id')->on('statuses')->onDelete('cascade');

            $table->unsignedBigInteger('overweight_status_outside_city')->nullable();
            $table->foreign('overweight_status_outside_city')->references('id')->on('statuses')->onDelete('cascade');

            $table->unsignedBigInteger('available_collect_order_status')->nullable();
            $table->foreign('available_collect_order_status')->references('id')->on('statuses')->onDelete('cascade');

            $table->unsignedBigInteger('calc_cash_delivery_fees_status')->nullable();
            $table->foreign('calc_cash_delivery_fees_status')->references('id')->on('statuses')->onDelete('cascade');



            $table->unsignedBigInteger('cancel_order_service_provider_R')->nullable();
            $table->foreign('cancel_order_service_provider_R')->references('id')->on('statuses')->onDelete('cascade');

            $table->unsignedBigInteger('cancel_order_service_provider')->nullable();
            $table->foreign('cancel_order_service_provider')->references('id')->on('statuses')->onDelete('cascade');

            $table->unsignedBigInteger('Return_order_service_provider_R')->nullable();
            $table->foreign('Return_order_service_provider_R')->references('id')->on('statuses')->onDelete('cascade');

            $table->unsignedBigInteger('Return_order_service_provider')->nullable();
            $table->foreign('Return_order_service_provider')->references('id')->on('statuses')->onDelete('cascade');

            $table->unsignedBigInteger('send_order_service_provider_R')->nullable();
            $table->foreign('send_order_service_provider_R')->references('id')->on('statuses')->onDelete('cascade');

            $table->unsignedBigInteger('send_order_service_provider')->nullable();
            $table->foreign('send_order_service_provider')->references('id')->on('statuses')->onDelete('cascade');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_setting_statuses');
    }
};
