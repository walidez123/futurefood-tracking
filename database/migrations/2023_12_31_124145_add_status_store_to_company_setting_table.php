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
            $table->integer('cost_calc_status_inside_city')->nullable()->after('cost_calc_status_Res');
            $table->integer('cost_calc_status_outside_city')->nullable()->after('cost_calc_status_inside_city');
            $table->integer('default_status_id_store')->nullable()->after('cost_calc_status_outside_city');
            $table->integer('calc_cash_delivery_fees_status_store')->nullable()->after('default_status_id_store');
            $table->integer('cost_reshipping_status_store')->nullable()->after('calc_cash_delivery_fees_status_store');
            $table->integer('edit_status_id_store')->nullable()->after('cost_reshipping_status_store');

            $table->integer('delete_status_id_store')->nullable()->after('edit_status_id_store');
            $table->integer('overweight_status_inside_city')->nullable()->after('delete_status_id_store');
            $table->integer('overweight_status_outside_city')->nullable()->after('overweight_status_inside_city');
            $table->integer('available_collect_order_status')->nullable()->after('overweight_status_outside_city');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company_settings', function (Blueprint $table) {
            $table->dropColumn('cost_calc_status_Res');

            $table->dropColumn('cost_calc_status_inside_city');
            $table->dropColumn('cost_calc_status_outside_city');
            $table->dropColumn('default_status_id_store');
            $table->dropColumn('calc_cash_delivery_fees_status_store');
            $table->dropColumn('cost_reshipping_status_store');
            $table->dropColumn('edit_status_id_store');

            $table->dropColumn('delete_status_id_store');
            $table->dropColumn('overweight_status_inside_city');
            $table->dropColumn('overweight_status_outside_city');
            $table->dropColumn('available_collect_order_status');
        });
    }
};
