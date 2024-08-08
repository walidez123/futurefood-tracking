<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**ء
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('company_settings', function (Blueprint $table) {
            $table->integer('cost_calc_status_Res')->nullable()->after('status_shop');
            $table->integer('default_status_id_Res')->nullable()->after('cost_calc_status_Res');
            $table->integer('calc_cash_delivery_status_Res')->nullable()->after('default_status_id_Res');
            $table->integer('cost_reshipping_status_Res')->nullable()->after('calc_cash_delivery_status_Res');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company_settings', function (Blueprint $table) {
            $table->dropColumn('cost_calc_status_Res');
            $table->dropColumn('default_status_id_Res');
            $table->dropColumn('calc_cash_delivery_status_Res');
            $table->dropColumn('cost_reshipping_status_Res');

        });
    }
};
