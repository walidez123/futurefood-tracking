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
        Schema::create('web_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title_en')->nullable();
            $table->string('title_ar')->nullable();
            $table->string('logo')->nullable();
            $table->text('description_en')->nullable();
            $table->text('description_ar')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->text('address_en')->nullable();
            $table->text('address_ar')->nullable();
            $table->string('about_title_en')->nullable();
            $table->string('about_title_ar')->nullable();
            $table->text('about_description_en')->nullable();
            $table->text('about_description_ar')->nullable();
            $table->string('image')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('instgram')->nullable();
            $table->string('linked_in', 200)->nullable();
            $table->float('standard_weight', 10, 0)->nullable();
            $table->float('overweight_price', 10, 0)->nullable();
            $table->string('youtube')->nullable();
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
            $table->string('google_analytics_id')->nullable();
            $table->string('image_vision', 200)->nullable();
            $table->string('title_vision_ar', 200)->nullable();
            $table->text('des_vision_ar')->nullable();
            $table->string('image_Objectives', 200)->nullable();
            $table->string('title_Objectives_ar', 200)->nullable();
            $table->text('des_Objectives_ar')->nullable();
            $table->string('title_vision_en', 200)->nullable();
            $table->text('des_vision_en')->nullable();
            $table->string('title_Objectives_en', 200)->nullable();
            $table->text('des_Objectives_en')->nullable();
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
        Schema::dropIfExists('web_settings');
    }
};
