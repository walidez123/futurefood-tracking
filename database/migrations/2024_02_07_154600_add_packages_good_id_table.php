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
        Schema::table('client_packages_goods', function (Blueprint $table) {
            $table->integer('packages_good_id')->after('company_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('client_packages_goods', function (Blueprint $table) {

            $table->dropColumn(['packages_good_id']);

        });
    }
};
