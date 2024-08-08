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
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('company_id')->nullable();
            $table->string('order_id')->nullable()->unique();
            $table->unsignedBigInteger('user_id')->nullable()->index('orders_user_id_foreign');
            $table->integer('store_address_id')->nullable();
            $table->string('tracking_id')->nullable()->unique();
            $table->integer('number_count')->default(1);
            $table->unsignedBigInteger('sender_city')->nullable()->index('orders_sender_city_foreign');
            $table->string('sender_phone')->nullable();
            $table->string('sender_address')->nullable();
            $table->text('sender_address_2')->nullable();
            $table->date('pickup_date')->nullable();
            $table->text('sender_notes')->nullable();
            $table->string('receved_name')->nullable();
            $table->string('receved_phone')->nullable();
            $table->string('receved_email')->nullable();
            $table->unsignedBigInteger('receved_city')->nullable()->index('orders_receved_city_foreign');
            $table->string('receved_address')->nullable();
            $table->text('receved_address_2')->nullable();
            $table->text('receved_notes')->nullable();
            $table->text('order_contents')->nullable();
            $table->decimal('amount')->nullable();
            $table->string('reference_number', 255)->nullable();
            $table->float('order_weight', 10, 0)->nullable();
            $table->float('over_weight_price', 10, 0)->nullable();
            $table->smallInteger('call_count')->nullable()->default(0);
            $table->smallInteger('whatApp_count')->nullable()->default(0);
            $table->unsignedBigInteger('status_id')->nullable()->index('orders_status_id_foreign');
            $table->integer('type')->default(1)->comment('1-طرود 2- طلبات الشحن السريع');
            $table->unsignedBigInteger('delegate_id')->nullable()->index('orders_delegate_id_foreign');
            $table->integer('assign_pickup')->nullable();
            $table->boolean('is_finished')->default(false);
            $table->boolean('amount_paid')->default(false);
            $table->string('provider', 50);
            $table->string('provider_order_id', 50);
            $table->timestamps();
            $table->softDeletes();
            $table->date('receipt_date_store')->nullable();
            $table->string('sender_email')->nullable();
            $table->string('sender_name');
            $table->boolean('is_returned')->default(false);
            $table->integer('return_order_id')->nullable();
            $table->integer('region_id')->nullable();
            $table->integer('work_type')->nullable()->default(1)->comment('1-طرود - متاجر 
2 - طلبات -مطاعم ');
            $table->integer('branch_id')->nullable();
            $table->text('real_image_confirm')->nullable();
            $table->string('longitude', 200)->nullable();
            $table->string('latitude', 200)->nullable();
            $table->integer('payment_method')->nullable()->comment('1-cash
2-network');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
