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
        Schema::create('client_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index('client_transactions_user_id_foreign');
            $table->string('description');
            $table->decimal('debtor')->default(0);
            $table->decimal('creditor')->default(0);
            $table->integer('transaction_status')->nullable();
            $table->unsignedBigInteger('order_id')->nullable()->index('client_transactions_order_id_foreign');
            $table->integer('type_id')->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('client_transactions');
    }
};
