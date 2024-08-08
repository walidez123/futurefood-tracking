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
        Schema::table('company_costs', function (Blueprint $table) {
            $table->float('zid_cost', 10, 0)->default(0)->after('foodics_cost');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company_costs', function (Blueprint $table) {
            $table->dropColumn(['zid_cost']);

        });
    }
};
