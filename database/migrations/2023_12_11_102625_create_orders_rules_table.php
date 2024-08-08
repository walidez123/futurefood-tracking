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
        Schema::create('orders_rules', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('company_id')->default(2);
            $table->string('title', 200);
            $table->text('details');
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('work_type')->nullable();
            $table->integer('status_id');
            $table->integer('max');
            $table->integer('delegate_id');
            $table->integer('city_from')->nullable();
            $table->integer('city_to')->nullable();
            $table->integer('cod')->nullable();
            $table->date('created_date')->nullable();
            $table->integer('region_from')->nullable();
            $table->integer('region_to')->nullable();
            $table->integer('payment_method')->nullable();
            $table->integer('client_id')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->timestamp('deleated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders_rules');
    }
};
