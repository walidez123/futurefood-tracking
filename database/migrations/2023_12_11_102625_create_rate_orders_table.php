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
        Schema::create('rate_orders', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('company_id')->nullable();
            $table->string('name', 255)->nullable();
            $table->string('mobile', 255)->nullable();
            $table->float('rate', 10, 0)->nullable();
            $table->integer('is_publish')->nullable();
            $table->text('review')->nullable();
            $table->integer('type')->nullable();
            $table->integer('order_id')->nullable();
            $table->string('order_no', 255)->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rate_orders');
    }
};
