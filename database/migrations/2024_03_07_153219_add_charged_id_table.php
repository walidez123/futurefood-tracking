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
        Schema::table('company_salla_statuses', function (Blueprint $table) {
            $table->unsignedBigInteger('charged_id'); //تم الشحن
            $table->foreign('charged_id')->references('id')->on('statuses')->onDelete('cascade')->after('delivered_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company_salla_statuses', function (Blueprint $table) {
            $table->dropColumn(['charged_id']);

        });
    }
};
