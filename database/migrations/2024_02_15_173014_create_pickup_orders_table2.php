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
        Schema::create('pickup_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('tracking_id');
            $table->string('order_id');
            $table->integer('company_id');
            $table->string('sender_city')->nullable();
            $table->unsignedBigInteger('store_branch_id')->nullable();
            $table->string('sender_phone')->nullable();
            $table->text('sender_address')->nullable();
            $table->text('sender_address_2')->nullable();
            $table->integer('warehouse_id');
            $table->integer('storage_types');
            $table->integer('size_id')->nullable();
            $table->integer('status_id')->nullable();
            $table->integer('delegate_id')->nullable();
            $table->integer('service_provider_id')->nullable();
            $table->integer('consignmentNo')->nullable();
            $table->integer('work_type')->nullable();
            $table->text('distance')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pickup_orders');
    }
};
