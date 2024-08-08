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
        Schema::create('statuses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('company_id')->nullable();
            $table->string('title');
            $table->string('title_ar', '200');
            $table->text('description')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->integer('delegate_appear')->default(1);
            $table->integer('client_appear')->default(1);
            $table->integer('restaurant_appear')->default(1);
            $table->integer('storehouse_appear')->default(0);
            $table->integer('shop_appear')->default(1);
            $table->string('salla_status_code', 50)->nullable();
            $table->integer('otp_send_code')->default(0);
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('statuses');
    }
};
