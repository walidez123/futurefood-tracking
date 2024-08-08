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
        Schema::table('order_rules_details', function (Blueprint $table) {
            $table->integer('address_id')->nullable()->after('client_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_rules_details', function (Blueprint $table) {
            $table->dropColumn('address_id');

        });
    }
};
