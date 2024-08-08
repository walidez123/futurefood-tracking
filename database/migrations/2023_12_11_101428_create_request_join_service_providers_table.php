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
        Schema::create('request_join_service_providers', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 200);
            $table->integer('city_id');
            $table->integer('num_employees')->default(1);
            $table->integer('num_cars')->default(1);
            $table->string('email', 200);
            $table->string('manger_phone', 200);
            $table->integer('is_transport')->default(0);
            $table->integer('is_read')->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
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
        Schema::dropIfExists('request_join_service_providers');
    }
};
