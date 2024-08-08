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
        Schema::create('notifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('notification_from')->index('notifications_notification_from_foreign');
            $table->string('title')->nullable();
            $table->text('message');
            $table->string('notification_type')->nullable();
            $table->unsignedBigInteger('notification_to')->nullable()->index('notifications_notification_to_foreign');
            $table->string('notification_to_type')->nullable();
            $table->unsignedBigInteger('order_id')->nullable()->index('notifications_order_id_foreign');
            $table->boolean('is_readed')->default(false);
            $table->string('icon')->default('fa-shopping-bag');
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
        Schema::dropIfExists('notifications');
    }
};
