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
        Schema::create('packages_goods', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id');
            $table->integer('client_id');
            $table->integer('warehouse_id');
            $table->integer('total_goods');
            $table->integer('total_packages');
            $table->integer('work')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages_goods');
    }
};
