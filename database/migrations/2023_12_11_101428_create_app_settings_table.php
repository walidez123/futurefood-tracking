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
        Schema::create('app_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('currency')->nullable();
            $table->string('order_number_characters', 4)->default('OR');
            $table->text('terms_en')->nullable();
            $table->text('terms_ar')->nullable();
            $table->timestamps();
            $table->text('term_en_res')->nullable()->comment('client type 2');
            $table->text('term_ar_res')->nullable()->comment('client type 2');
            $table->text('term_en_d_1')->nullable()->comment('delegate type 1');
            $table->text('term_ar_d_1')->nullable()->comment('delegate type 1');
            $table->text('term_en_d_2')->nullable()->comment('delegate type 2');
            $table->text('term_ar_d_2')->nullable()->comment('delegate type 2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_settings');
    }
};
