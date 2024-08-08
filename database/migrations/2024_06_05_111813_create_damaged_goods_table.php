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
        Schema::create('damaged_goods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('company_id')->constrained('users')->onDelete('cascade');

            $table->foreignId('warehouse_branche_id')->constrained('warehouse_branches')->onDelete('cascade');
            $table->foreignId('good_id')->constrained('goods')->onDelete('cascade');
            $table->foreignId('warehouse_content_id')->constrained('warehouse_contents')->onDelete('cascade');
            $table->foreignId('goods_status_id')->constrained('goods_statuses')->onDelete('cascade');
            $table->integer('number');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('damaged_goods');
    }
};
