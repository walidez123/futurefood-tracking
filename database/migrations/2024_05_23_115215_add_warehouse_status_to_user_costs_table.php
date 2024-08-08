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
            $table->unsignedBigInteger('pallet_in_status_id')->nullable();
            $table->foreign('pallet_in_status_id')->references('id')->on('statuses')->onDelete('cascade');

            // Foreign key references the available delete status
            $table->unsignedBigInteger('pallet_out_status_id')->nullable();
            $table->foreign('pallet_out_status_id')->references('id')->on('statuses')->onDelete('cascade');

            // Foreign key references the available collect order status
            $table->unsignedBigInteger('packging_pallet_status_id')->nullable();
            $table->foreign('packging_pallet_status_id')->references('id')->on('statuses')->onDelete('cascade');

            // Foreign key references the available overweight status
            $table->unsignedBigInteger('segregation_pallet_status_id')->nullable();
            $table->foreign('segregation_pallet_status_id')->references('id')->on('statuses')->onDelete('cascade');

            // Foreign key references the available overweight status outside
            $table->unsignedBigInteger('palletization_status_id')->nullable();
            $table->foreign('palletization_status_id')->references('id')->on('statuses')->onDelete('cascade');

            $table->unsignedBigInteger('wooden_pallet_status_id')->nullable();
            $table->foreign('wooden_pallet_status_id')->references('id')->on('statuses')->onDelete('cascade');

            $table->unsignedBigInteger('return_pallet_status_id')->nullable();
            $table->foreign('return_pallet_status_id')->references('id')->on('statuses')->onDelete('cascade');

            $table->unsignedBigInteger('pallet_shipping_status_id')->nullable();
            $table->foreign('pallet_shipping_status_id')->references('id')->on('statuses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_statuses', function (Blueprint $table) {
            $table->dropColumn(['pallet_shipping_status_id','return_pallet_status_id','wooden_pallet_status_id','palletization_status_id','segregation_pallet_status_id','packging_pallet_status_id','pallet_out_status_id','pallet_in_status_id']);

        });
    }
};
