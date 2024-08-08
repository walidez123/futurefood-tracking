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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id');

            $table->string('title_en', 200);
            $table->string('title_ar', 200);
            $table->text('description_en')->nullable();
            $table->text('description_ar')->nullable();
            $table->integer('num_days')->nullable();
            $table->decimal('price')->nullable();
            $table->string('area', 200)->nullable();
            $table->integer('publish')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
