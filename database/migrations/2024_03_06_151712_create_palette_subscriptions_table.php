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
        Schema::create('palette_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_packages_goods_id')->nullable();
            $table->foreign('client_packages_goods_id')->references('id')->on('client_packages_goods')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('order_id')->nullable();
            $table->foreign('order_id')->references('id')->on('pickup_orders')->onDelete('cascade');
            $table->unsignedBigInteger('transaction_type_id');
            $table->foreign('transaction_type_id')->references('id')->on('transaction_types')->onDelete('cascade');
            $table->float('cost');
            $table->date('start_date');
            $table->enum('type',['daily', 'monthly','receive_palette']); 
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pallet_subscriptions');
    }
};
