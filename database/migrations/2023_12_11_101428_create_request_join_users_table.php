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
        Schema::create('request_join_users', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 100);
            $table->string('email', 200);
            $table->string('phone', 50);
            $table->integer('city_id');
            $table->integer('region_id');
            $table->integer('work_type')->comment('1-دوام كلى 2-دوام جزئى 3-بالطلب	');
            $table->string('type', 100)->default('delegate');
            $table->integer('Residency_number');
            $table->string('type_vehicle', 100);
            $table->string('Num_vehicle', 20);
            $table->string('avatar', 200)->nullable()->default('avatar/avatar.png');
            $table->string('vehicle_photo', 200)->nullable();
            $table->string('residence_photo', 200)->nullable();
            $table->string('license_photo', 200)->nullable();
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
        Schema::dropIfExists('request_join_users');
    }
};
