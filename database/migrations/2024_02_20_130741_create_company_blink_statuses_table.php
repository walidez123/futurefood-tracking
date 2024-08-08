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
        Schema::create('company_blink_statuses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('new_order_id'); // طلب جديد
            $table->foreign('new_order_id')->references('id')->on('statuses')->onDelete('cascade');
            $table->unsignedBigInteger('assigned_id'); //تم استلام طلبك
            $table->foreign('assigned_id')->references('id')->on('statuses')->onDelete('cascade');
            $table->unsignedBigInteger('en_route_id'); //خارج للتوصيل
            $table->foreign('en_route_id')->references('id')->on('statuses')->onDelete('cascade');
            $table->unsignedBigInteger('delivered_id'); //تم التوصيل
            $table->foreign('delivered_id')->references('id')->on('statuses')->onDelete('cascade');
            $table->unsignedBigInteger('closed_id'); // ملغى
            $table->foreign('closed_id')->references('id')->on('statuses')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_blink_statuses');
    }
};
