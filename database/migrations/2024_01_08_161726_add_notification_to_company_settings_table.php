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
            $table->text('notification')->nullable()->after('term_ar_warehouse');
            $table->text('notification_ar')->nullable()->after('notification');
            $table->text('notification_title')->nullable()->after('notification_ar');
            $table->text('notification_title_ar')->nullable()->after('notification_title');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company_settings', function (Blueprint $table) {
            $table->dropColumn('notification');
            $table->dropColumn('notification_ar');
            $table->dropColumn('notification_title');
            $table->dropColumn('notification_title_ar');

        });
    }
};
