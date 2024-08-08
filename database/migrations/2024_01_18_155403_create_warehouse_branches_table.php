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
        Schema::create('warehouse_branches', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id');
            $table->string('title', 200);
            $table->string('title_ar', 200);
            $table->integer('city_id');
            $table->string('longitude', 200)->nullable();
            $table->string('latitude', 200)->nullable();
            $table->string('area', 200)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warehouse_branches');
    }
};
