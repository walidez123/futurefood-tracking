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
        Schema::create('packages_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('Client_packages_good');
            $table->integer('number');
            $table->integer('type')->default(1);
            $table->integer('order_id')->nullable();
            $table->integer('user_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages_histories');
    }
};
