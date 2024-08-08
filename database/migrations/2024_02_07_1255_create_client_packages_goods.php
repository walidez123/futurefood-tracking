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
        Schema::create('client_packages_goods', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id');

            $table->integer('client_id');
            $table->integer('warehouse_id');
            $table->integer('good_id');
            $table->integer('packages_id');
            $table->integer('work');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_packages_goods');
    }
};
