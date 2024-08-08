<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provider_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('provider_order_id');
            $table->string('reference_id');
            $table->string('shipping_id');
            $table->string('status_id');
            $table->string('status_name');
            $table->string('provider_name');
            $table->unsignedBigInteger('order_id')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('provider_orders');
    }
};
