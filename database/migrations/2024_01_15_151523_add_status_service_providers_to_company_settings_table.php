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
            $table->integer('cancel_order_service_provider_R')->nullable()->after('term_en_warehouse');
            $table->integer('cancel_order_service_provider')->nullable()->after('cancel_order_service_provider_R');
            $table->integer('Return_order_service_provider_R')->nullable()->after('cancel_order_service_provider');
            $table->integer('Return_order_service_provider')->nullable()->after('Return_order_service_provider_R');
            $table->integer('send_order_service_provider_R')->nullable()->after('Return_order_service_provider');
            $table->integer('send_order_service_provider')->nullable()->after('send_order_service_provider_R');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company_settings', function (Blueprint $table) {
            $table->dropColumn('cancel_order_service_provider_R');
            $table->dropColumn('cancel_order_service_provider');
            $table->dropColumn('Return_order_service_provider_R');
            $table->dropColumn('Return_order_service_provider');
            $table->dropColumn('send_order_service_provider_R');
            $table->dropColumn('send_order_service_provider');

        });
    }
};
