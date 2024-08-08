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
        Schema::create('testimoinals', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('title', 200)->nullable();
            $table->string('title_ar', 200)->nullable();
            $table->text('description_ar')->nullable();
            $table->text('description')->nullable();
            $table->string('image', 200)->nullable();
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
        Schema::dropIfExists('testimoinals');
    }
};
