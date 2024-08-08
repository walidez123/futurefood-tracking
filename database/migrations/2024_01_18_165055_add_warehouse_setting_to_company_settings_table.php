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
        Schema::table('company_settings', function (Blueprint $table) {
            $table->string('stand_number_characters', 100)->nullable()->after('send_order_service_provider');
            $table->string('floor_number_characters', 100)->nullable()->after('stand_number_characters');
            $table->string('package_number_characters', 100)->nullable()->after('floor_number_characters');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company_settings', function (Blueprint $table) {
            $table->dropColumn('stand_number_characters');
            $table->dropColumn('floor_number_characters');
            $table->dropColumn('package_number_characters');

        });
    }
};
