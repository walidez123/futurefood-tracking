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
        Schema::create('warehouse_contents', function (Blueprint $table) {
            $table->id();
            $table->integer('warehouse_id');
            $table->string('title', 200);
            $table->enum('type', ['stand', 'floor', 'package'])->default('stand');
            $table->integer('stand_id')->nullable();
            $table->integer('floor_id')->nullable();
            $table->integer('is_busy')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warehouse_contents');
    }
};
